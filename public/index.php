<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

(new \Symfony\Component\Dotenv\Dotenv())->usePutenv()->bootEnv(dirname(__DIR__).'/.env');

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
