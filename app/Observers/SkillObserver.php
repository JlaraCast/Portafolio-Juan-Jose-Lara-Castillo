<?php

namespace App\Observers;

use App\Models\Skill;
use App\Services\DeviconResolver;
use Illuminate\Support\Facades\Log;

class SkillObserver
{
    public function __construct(private DeviconResolver $devicons) {}

    /**
     * Store Devicon classes as inline SVG.
     *
     * Doing it on save means the admin can keep pasting `<i class="devicon-x">`
     * while the site never has to load Devicon's stylesheet or icon font.
     */
    public function saving(Skill $skill): void
    {
        if (! $skill->isDirty('icon')) {
            return;
        }

        try {
            $svg = $this->devicons->resolve($skill->icon);
        } catch (\Throwable $e) {
            // A CDN hiccup should not cost the admin their edit; the icon keeps
            // its current markup and the next save retries.
            Log::warning('Could not resolve Devicon icon', [
                'skill' => $skill->name,
                'icon' => $skill->icon,
                'error' => $e->getMessage(),
            ]);

            return;
        }

        if ($svg !== null) {
            $skill->icon = $svg;
        }
    }
}
