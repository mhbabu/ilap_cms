<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class TrimStrings
{
    public function handle(Request $request, Closure $next): mixed
    {
        $request->replace($this->trimAll($request->all()));
        return $next($request);
    }

    private function trimAll(array $data): array
    {
        return array_map(fn ($v) => is_string($v) ? trim($v) : $v, $data);
    }
}
