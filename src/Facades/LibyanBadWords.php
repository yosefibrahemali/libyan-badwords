<?php
namespace Yosef\LibyanBadwords\Facades;

use Illuminate\Support\Facades\Facade;

class LibyanBadWords extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Yosef\LibyanBadwords\Filters\LibyanBadWordsFilter::class;
    }
}
