<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Turns a Devicon class into the matching inline SVG.
 *
 * Skills used to be stored as `<i class="devicon-php-plain"></i>`, which needs
 * Devicon's stylesheet and its 1.5 MB icon font at runtime. Resolving the class
 * to real SVG markup once, when the skill is saved, drops both: the icon ships
 * inside the HTML and costs no extra request.
 */
class DeviconResolver
{
    /**
     * Pinned so a Devicon release cannot silently change an existing icon.
     */
    private const VERSION = '2.17.0';

    private const BASE_URL = 'https://cdn.jsdelivr.net/gh/devicons/devicon@'.self::VERSION.'/icons';

    /**
     * Variants ordered longest first, so `plain-wordmark` is matched before `plain`.
     *
     * @var array<string>
     */
    private const VARIANTS = [
        'original-wordmark',
        'plain-wordmark',
        'line-wordmark',
        'original',
        'plain',
        'line',
    ];

    /**
     * Devicon ships one glyph for variants that share a drawing, so a class may
     * have no file of its own. These are the fallbacks worth trying.
     *
     * @var array<string, array<string>>
     */
    private const FALLBACKS = [
        'plain' => ['original', 'line'],
        'original' => ['plain', 'line'],
        'line' => ['original', 'plain'],
        'plain-wordmark' => ['original-wordmark', 'line-wordmark'],
        'original-wordmark' => ['plain-wordmark', 'line-wordmark'],
        'line-wordmark' => ['original-wordmark', 'plain-wordmark'],
    ];

    /**
     * Resolve stored icon markup to inline SVG.
     *
     * Returns null when the value needs no work: already an SVG, empty, or not
     * a Devicon class.
     */
    public function resolve(?string $icon): ?string
    {
        if (blank($icon) || Str::contains($icon, '<svg')) {
            return null;
        }

        if (! preg_match('/devicon-([a-z0-9-]+)/i', $icon, $matches)) {
            return null;
        }

        $svg = $this->fetchSvg(strtolower($matches[1]));

        return $svg === null ? null : $this->normalize($svg);
    }

    /**
     * Download the SVG for a Devicon class name, trying the variants that share
     * the same glyph when the exact file does not exist.
     */
    private function fetchSvg(string $class): ?string
    {
        [$name, $variant] = $this->split($class);

        if ($name === null) {
            return null;
        }

        foreach ([$variant, ...(self::FALLBACKS[$variant] ?? [])] as $candidate) {
            $response = Http::timeout(10)->get(self::BASE_URL."/{$name}/{$name}-{$candidate}.svg");

            if ($response->successful() && Str::contains($response->body(), '<svg')) {
                return $response->body();
            }
        }

        return null;
    }

    /**
     * Split `php-plain` into its icon name and variant.
     *
     * @return array{0: string|null, 1: string}
     */
    private function split(string $class): array
    {
        foreach (self::VARIANTS as $variant) {
            if (str_ends_with($class, '-'.$variant)) {
                return [Str::beforeLast($class, '-'.$variant), $variant];
            }
        }

        return [null, ''];
    }

    /**
     * Match how the icon font rendered: sized by the surrounding font-size and
     * painted in the inherited text colour, rather than Devicon's brand fills.
     */
    private function normalize(string $svg): string
    {
        // Drop anything before the root element (XML prolog, comments).
        $svg = Str::substr($svg, (int) strpos($svg, '<svg'));

        // Brand colours are baked into fill attributes; currentColor keeps the
        // icons monochrome, as the font rendered them.
        $svg = preg_replace('/\s(fill|stroke)="(?!none)[^"]*"/i', '', $svg);
        $svg = preg_replace('/\s(fill|stroke):\s*(?!none)[^;"]*;?/i', '', $svg);

        // The markup ships inside every page, so drop the formatting whitespace.
        $svg = preg_replace('/>\s+</', '><', trim($svg));
        $svg = preg_replace('/\s{2,}/', ' ', $svg);

        $attributes = ' height="1em" fill="currentColor" aria-hidden="true" focusable="false"';

        return preg_replace('/^<svg/', '<svg'.$attributes, $svg, 1);
    }
}
