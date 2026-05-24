<?php

namespace App;

use Illuminate\Http\Response;
use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public function withPaths(array $paths): static
    {
        $basePath = dirname(__DIR__);

        return parent::withPaths([
            'app'      => $paths['app'] ?: $basePath.'/app',
            'config'   => $paths['config'] ?: $basePath.'/config',
            'database' => $paths['database'] ?: $basePath.'/database',
            'public'   => $paths['public'] ?: $basePath.'/public',
            'resources'=> $paths['resources'] ?: $basePath.'/resources',
            'routes'   => $paths['routes'] ?: $basePath.'/routes',
            'storage'  => $paths['storage'] ?: $basePath.'/storage',
            'tests'    => $paths['tests'] ?: $basePath.'/tests',
        ]);
    }
}
