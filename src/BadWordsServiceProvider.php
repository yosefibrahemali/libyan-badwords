<?php

namespace Yosef\LibyanBadwords\Providers;

use Illuminate\Support\ServiceProvider;
use Yosef\LibyanBadwords\Filters\LibyanBadWordsFilter;

class BadWordsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LibyanBadWordsFilter::class, function () {
            return new LibyanBadWordsFilter();
        });
    }

    public function boot()
    {
        //
    }
}
