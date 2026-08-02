<?php

namespace App\Console\Commands;

use App\Models\Skill;
use App\Services\DeviconResolver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One-off data conversion: rewrite the Devicon classes stored in `skills.icon`
 * as inline SVG.
 *
 * Deliberately not a migration. It touches data rather than schema, it reaches
 * out to a CDN, and it should run when someone decides to, not on every deploy.
 * Re-running it is safe: rows already holding SVG are skipped.
 */
class ConvertSkillIcons extends Command
{
    protected $signature = 'skills:convert-icons {--dry-run : Report what would change without writing}';

    protected $description = 'Convert Devicon classes stored on skills into inline SVG';

    public function handle(DeviconResolver $devicons): int
    {
        $skills = Skill::orderBy('id')->get();
        $pending = $skills->filter(fn (Skill $skill) => Str::contains($skill->icon ?? '', 'devicon-'));

        if ($pending->isEmpty()) {
            $this->info("Nothing to do: none of the {$skills->count()} skills store a Devicon class.");

            return self::SUCCESS;
        }

        $dryRun = $this->option('dry-run');

        if (! $dryRun) {
            $this->line('Backup written to '.$this->backup($skills));
        }

        $rows = [];
        $failed = 0;

        foreach ($pending as $skill) {
            $class = Str::match('/devicon-[a-z0-9-]+/i', $skill->icon);

            try {
                $svg = $devicons->resolve($skill->icon);
            } catch (\Throwable $e) {
                $svg = null;
                $this->error("  {$skill->name}: {$e->getMessage()}");
            }

            if ($svg === null) {
                $failed++;
                $rows[] = [$skill->id, $skill->name, $class, 'UNRESOLVED'];

                continue;
            }

            if (! $dryRun) {
                // The observer would resolve this again on save; writing the
                // resolved value directly keeps it to one request per icon.
                $skill->forceFill(['icon' => $svg])->saveQuietly();
            }

            $rows[] = [$skill->id, $skill->name, $class, strlen($svg).' bytes of SVG'];
        }

        $this->table(['ID', 'Skill', 'Devicon class', $dryRun ? 'Would become' : 'Now'], $rows);

        if ($failed > 0) {
            $this->warn("{$failed} icon(s) could not be resolved and were left untouched; they will render blank.");

            return self::FAILURE;
        }

        $this->info($dryRun
            ? $pending->count().' icon(s) ready to convert. Re-run without --dry-run to apply.'
            : $pending->count().' icon(s) converted.');

        return self::SUCCESS;
    }

    /**
     * Save every current icon value so the change can be undone by hand.
     */
    private function backup(iterable $skills): string
    {
        $path = 'backups/skill-icons-'.now()->format('Y-m-d-His').'.json';

        Storage::disk('local')->put($path, collect($skills)
            ->mapWithKeys(fn (Skill $skill) => [$skill->id => $skill->icon])
            ->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return Storage::disk('local')->path($path);
    }
}
