<?php

if (!function_exists('libyan_clean')) {
    function libyan_clean(string $text): string {
        return app(\Yosef\LibyanBadwords\Filters\LibyanBadWordsFilter::class)->clean($text);
    }
}

if (!function_exists('libyan_contains_badwords')) {
    function libyan_contains_badwords(string $text): bool {
        return app(\Yosef\LibyanBadwords\Filters\LibyanBadWordsFilter::class)->containsBadWords($text);
    }
}
