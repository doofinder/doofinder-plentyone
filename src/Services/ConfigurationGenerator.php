<?php

namespace Doofinder\Services;

use Illuminate\Support\Str;
use Plenty\Modules\Authorization\Services\AuthHelper;
use Plenty\Modules\Plugin\Contracts\ConfigurationRepositoryContract;
use Plenty\Modules\Plugin\Contracts\PluginRepositoryContract;
use Plenty\Modules\Plugin\PluginSet\Contracts\PluginSetRepositoryContract;
use Plenty\Plugin\Application;

class ConfigurationGenerator
{
    public function generate()
    {
        $values = [
            ['key' => 'feed_url', 'value' => 'https://p' . pluginApp(Application::class)->getPlentyId() . '.my.plentysystems.com/rest/doofinder/v1/feed'],
            ['key' => 'token', 'value' => Str::random(40)],
        ];

        pluginApp(AuthHelper::class)->processUnguarded(function () use ($values) {
            pluginApp(ConfigurationRepositoryContract::class)->saveConfiguration(
                pluginApp(PluginRepositoryContract::class)->getPluginByName('Doofinder')->id,
                $values,
                pluginApp(PluginSetRepositoryContract::class)->getCurrentPluginSetId()
            );
        });
    }
}
