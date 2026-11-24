<?php

namespace Doofinder\Providers;

use Doofinder\Services\ConfigurationGenerator;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\ServiceProvider;

class DoofinderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(DoofinderRouteServiceProvider::class);
    }

    public function boot(ConfigRepository $config)
    {
        if ((string) $config->get('Doofinder.token', '') === '') {
            pluginApp(ConfigurationGenerator::class)->generate();
        }
    }
}
