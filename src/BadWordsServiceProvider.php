<?php

namespace Yosef\LibyanBadwords;

use Illuminate\Support\ServiceProvider;
use Yosef\LibyanBadwords\Filters\LibyanBadWordsFilter;

class BadWordsServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
     
        $this->app->singleton(LibyanBadWordsFilter::class, function ($app) {
        $config = $app['config']->get('badwords', []);
        $words = $config['words'] ?? [];
        if (!empty($config['load_from_file']) && file_exists($config['words_file'])) {
            $fileWords = array_filter(array_map('trim', file($config['words_file'])));
            $words = array_unique(array_merge($words, $fileWords));
        }
        $replacement = $config['replacement'] ?? '[تم الحجب]';
        $options = [
            'ignore_case' => $config['ignore_case'] ?? true,
            'normalize' => $config['normalize'] ?? true,
            'strip_diacritics' => $config['strip_diacritics'] ?? true,
            'latin_transliteration' => $config['latin_transliteration'] ?? true,
        ];
        return new LibyanBadWordsFilter($words, $replacement, $options);
    });


    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        // نشر ملف الإعدادات ليتمكن المستخدم من تعديله
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/badwords.php' => config_path('badwords.php'),
            ], 'config');
        }
    }
}