<?php

namespace Tbmatuka\EditorjsBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Tbmatuka\EditorjsBundle\Editor\EditorConfig;

class EditorjsTransformer implements DataTransformerInterface
{
    /**
     * @var EditorConfig|null
     */
    protected $config;

    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        if ($value === '') {
            return [];
        }

        $data = json_decode($value, true);

        if (!is_array($data)) {
            $errorMessage = 'JSON decode failed: '.json_last_error_msg();

            $exception = new TransformationFailedException($errorMessage);
            $exception->setInvalidMessage($errorMessage);

            throw $exception;
        }

        return $data;
    }

    public function setConfig(EditorConfig $config): void
    {
        $this->config = $config;
    }
}
