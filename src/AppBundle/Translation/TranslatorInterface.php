<?php

namespace AppBundle\Translation;

/**
 * Interface TranslatorInterface.
 */
interface TranslatorInterface
{
    /**
     * @param string[]  $words
     * @param Direction $direction
     *
     * @return string[]
     */
    public function translate(array $words, Direction $direction): array;
}
