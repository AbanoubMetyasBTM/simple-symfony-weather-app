<?php

namespace App\Helpers;

class ValidationHelper
{


    public static function convertErrorsToArray($errors): array
    {

        $errorsMessages = [];

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorsMessages[] = $error->getPropertyPath() . ' - ' . $error->getMessage();
            }
        }

        return $errorsMessages;

    }

}