<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\HtmlString;

/**
 * Emit the compiled stylesheet inline instead of as a <link>.
 *
 * The bundle is small enough (~10 KB over the wire) that the round trip costs
 * more than the bytes: as a <link> it is the only request left blocking the
 * first render, which shows up directly as LCP render delay.
 */
class InlineVite
{
    /**
     * Inline the stylesheet an entry point produces.
     *
     * Falls back to a normal tag while the Vite dev server is running, where no
     * manifest exists, and if anything goes wrong reading the built file, so a
     * broken build can never leave a page with no styles at all.
     */
    public static function styles(string $entry): HtmlString
    {
        if (! Vite::isRunningHot()) {
            try {
                return new HtmlString('<style'.self::nonceAttribute().'>'.Vite::content($entry).'</style>');
            } catch (\Throwable $e) {
                Log::warning('Falling back to a linked stylesheet', ['entry' => $entry, 'error' => $e->getMessage()]);
            }
        }

        return new HtmlString(Vite::__invoke([$entry])->toHtml());
    }

    private static function nonceAttribute(): string
    {
        $nonce = Vite::cspNonce();

        return $nonce === null ? '' : ' nonce="'.$nonce.'"';
    }
}
