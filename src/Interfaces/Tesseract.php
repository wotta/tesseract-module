<?php

namespace ConceptCore\Tesseract\Interfaces;

interface Tesseract
{
    public function setImage(string $image): Tesseract;

    public function setLang(string ...$languages): Tesseract;
}