<?php

namespace App\Rules;

use App\Services\DeviconResolver;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Reject a Devicon class that has no matching SVG.
 *
 * Icons are stored as inline SVG, so an unresolvable class would be saved as-is
 * and then render blank. Failing here tells the admin straight away instead.
 */
class ResolvableDeviconIcon implements ValidationRule
{
    public function __construct(private DeviconResolver $devicons) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! str_contains($value, 'devicon-')) {
            return;
        }

        try {
            $resolved = $this->devicons->resolve($value);
        } catch (\Throwable) {
            // Unreachable CDN is not the admin's fault; let the save through and
            // let the observer retry on the next edit.
            return;
        }

        if ($resolved === null) {
            $fail(__('That Devicon icon does not exist. Check the class name at devicon.dev.'));
        }
    }
}
