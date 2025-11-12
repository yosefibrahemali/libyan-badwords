<?php
namespace Yosef\LibyanBadwords\Filters;

class LibyanBadWordsFilter
{
    protected array $words = [];
    protected string $replacement = '[****]';
    protected array $normalizedWords = [];
    protected bool $ignoreCase;
    protected bool $normalize;
    protected bool $stripDiacritics;
    protected bool $latinTranslit;

    public function __construct(array $words = [], string $replacement = '[****]', array $options = [])
    {
        $this->words = $words;
        $this->replacement = $replacement;
        $this->ignoreCase = $options['ignore_case'] ?? true;
        $this->normalize = $options['normalize'] ?? true;
        $this->stripDiacritics = $options['strip_diacritics'] ?? true;
        $this->latinTranslit = $options['latin_transliteration'] ?? true;

        $this->buildNormalizedWords();
    }

    protected function normalizeText(string $text): string
    {
        // إزالة التشكيل
        if ($this->stripDiacritics) {
            $text = preg_replace('/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{06D6}-\x{06ED}]/u', '', $text);
        }

        // توحيد الألف والهمزات
        if ($this->normalize) {
            $map = [
                'إ' => 'ا', 'أ' => 'ا', 'آ' => 'ا',
                'ى' => 'ي', 'ئ' => 'ي', 'ؤ' => 'و',
                'ة' => 'ه'
            ];
            $text = strtr($text, $map);
        }

        // تحويل للحروف الصغيرة (إن كان مطلوبًا)
        if ($this->ignoreCase) {
            $text = mb_strtolower($text);
        }

        // إزالة مسافات زائدة
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    protected function buildNormalizedWords(): void
    {
        $this->normalizedWords = array_unique(array_filter(array_map(function($w) {
            return $this->normalizeText($w);
        }, $this->words)));
    }

    public function addWords(array $words): void
    {
        $this->words = array_merge($this->words, $words);
        $this->buildNormalizedWords();
    }

    public function clean(string $text): string
    {
        $original = $text;
        $normText = $this->normalizeText($text);

        foreach ($this->normalizedWords as $word) {
            if ($word === '') continue;
            // باستخدم preg_replace لتفادي مشاكل الحروف المجاورة
            $pattern = '/\b' . preg_quote($word, '/') . '\b/iu';
            $normText = preg_replace($pattern, $this->replacement, $normText);
        }

        // إذا أردت، نعيد دمج مكان الاستبدال مع النص الأصلي
        // لكن لأبسط الحل نعيد النص المطهر (المطبع)
        return $normText;
    }

    public function containsBadWords(string $text): bool
    {
        $normText = $this->normalizeText($text);
        foreach ($this->normalizedWords as $word) {
            if (trim($word) === '') continue;
            if (preg_match('/\b' . preg_quote($word, '/') . '\b/iu', $normText)) {
                return true;
            }
        }
        return false;
    }
}
