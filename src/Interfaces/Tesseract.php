<?php

namespace ConceptCore\Tesseract\Interfaces;

interface Tesseract
{
    public function setImage(string $image): self;

    public function setLang(string ...$languages): self;
}
