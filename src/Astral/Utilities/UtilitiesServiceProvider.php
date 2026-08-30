<?php

declare(strict_types=1);

namespace Astral\Utilities;

use Core\Container;
use Core\ServiceProviderInterface;
use Core\View;

/**
 * Provider optionnel — les helpers Str / Date / Arr restent utilisables
 * en statique sans ce provider.
 */
final class UtilitiesServiceProvider implements ServiceProviderInterface
{
    /**
     * @param array<string, mixed> $appConfig
     * @param array<string, mixed> $dbConfig
     */
    public function register(Container $container, array $appConfig, array $dbConfig): void
    {
        /** @var View $view */
        $view = $container->make(View::class);
        $view->share('str', Str::class);
        $view->share('date', Date::class);
        $view->share('arr', Arr::class);
    }
}
