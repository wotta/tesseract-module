<?php

namespace ConceptCore\Tesseract\Objects;

use ConceptCore\Tesseract\Interfaces\Tesseract as TesseractInterface;
use ReflectionClass;
use ReflectionProperty;
use thiagoalessio\TesseractOCR\TesseractOCR;

class Tesseract implements TesseractInterface
{
    /** @var TesseractOCR */
    private $tesseractOCR;

    /** @var ReflectionClass */
    private $reflectionClass;

    /** @var ReflectionProperty */
    protected $imageProperty;

    public function __construct(TesseractOCR $tesseractOCR)
    {
        $this->tesseractOCR = $tesseractOCR;
        $this->tesseractOCR->executable(config('tesseract.executable'));

        $this->reflectionClass = new ReflectionClass($tesseractOCR);

        $this->imageProperty = $this->getImagePropertyValue();
    }

    public function setImage(string $image): TesseractInterface
    {
        if (!is_file($image)) {
            throw new \Exception('file not found');
        }

        $this->imageProperty->setValue($this->tesseractOCR, $image);

        return $this;
    }

    public function setLang(string ...$languages): TesseractInterface
    {
        $languages = empty($languages) ? config('tesseract.lang') : $languages;

        call_user_func_array([$this->tesseractOCR, 'lang'], $languages);

        return $this;
    }

    protected function run(): string
    {
        return str_replace("\n", '<br />', $this->tesseractOCR->run());
    }

    public function __call(string $method, array $arguments): TesseractInterface
    {
        if (!method_exists($this->tesseractOCR, $method)) {
            throw new \BadMethodCallException(
                sprintf('Trying to call [%s] on %s', $method, 'TesseractOCR')
            );
        }

        call_user_func_array([$this->tesseractOCR, $method], $arguments);

        return $this;
    }

    public function __toString(): string
    {
        return $this->run();
    }

    private function getImagePropertyValue(): ReflectionProperty
    {
        $property = $this->reflectionClass->getProperty('image');
        $property->setAccessible(true);

        return $property;
    }
}