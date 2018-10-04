<?php

namespace App\Service;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;


class ObjectSerializer
{

    public function serialize($object, $mapping, $timeFormat = 'Y-m-d')
    {

        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer(array(new DateTimeNormalizer($timeFormat), $normalizer));

        return $serializer->normalize($object, null, array('attributes' => $mapping));

    }

}