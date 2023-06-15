<?php

namespace App\Helpers;

use Psr\Log\LoggerInterface;

class SiteLogger
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;

    }

    public function logError($msg, $exception = null)
    {

        if ($exception != null) {
            $this->logger->info($msg, [
                "code"    => $exception->getCode(),
                "message" => $exception->getMessage(),
                "file"    => $exception->getFile(),
                "line"    => $exception->getLine(),
            ]);

            return;
        }

        $this->logger->info($msg);

    }


}