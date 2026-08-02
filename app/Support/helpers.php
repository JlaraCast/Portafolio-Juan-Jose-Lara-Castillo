<?php

use Illuminate\Support\Facades\App;

if (! function_exists('localized')) {
    /**
     * Read a translated field in the active locale, falling back to Spanish.
     *
     * Content fields are stored as {"es": "...", "en": "..."}. Rendering the
     * active locale server-side matters beyond correctness: lang.js rewrites
     * these nodes once the page loads, and if the markup started out in the
     * wrong language the text changes width and the layout shifts.
     *
     * @param  array<string, string>|null  $field
     */
    function localized(?array $field): string
    {
        if ($field === null) {
            return '';
        }

        return $field[App::getLocale()] ?? $field['es'] ?? '';
    }
}
