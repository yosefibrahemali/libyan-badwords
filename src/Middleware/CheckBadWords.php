<?php
namespace Yosef\LibyanBadwords\Middleware;

use Closure;
use Illuminate\Http\Request;
use Yosef\LibyanBadwords\Filters\LibyanBadWordsFilter;

class CheckBadWords
{
    protected LibyanBadWordsFilter $filter;

    public function __construct(LibyanBadWordsFilter $filter)
    {
        $this->filter = $filter;
    }

    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                $value = $this->filter->clean($value);
            }
        });
        $request->merge($input);
        return $next($request);
    }
}
