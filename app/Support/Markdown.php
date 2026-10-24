<?php

namespace App\Support;

use Illuminate\Support\Str;

class Markdown
{
    /**
     * Render Markdown with raw HTML escaped and unsafe links (javascript:, data:) removed,
     * so stored content can never inject scripts.
     */
    public static function toSafeHtml(?string $markdown): string
    {
        return (string) Str::markdown((string) $markdown, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 20,
        ]);
    }
}
