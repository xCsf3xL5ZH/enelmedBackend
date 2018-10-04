<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonRequestToArrayConventer
{
    public function getJsonRequestContentAsArray(Request $request) : array
    {
        $content = $request->getContent();

        if(empty($content)){
            throw new BadRequestHttpException();
        } else {
            $params = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new BadRequestHttpException();
            }
        }

        return $params;
    }
}