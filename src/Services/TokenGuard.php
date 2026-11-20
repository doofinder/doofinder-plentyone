<?php

namespace Doofinder\Services;

use Plenty\Plugin\ConfigRepository;

class TokenGuard
{
    private $config;

    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;
    }

    public function allows(string $given): bool
    {
        $token = (string) $this->config->get('Doofinder.token', '');

        return $token !== '' && $token === $given;
    }
}
