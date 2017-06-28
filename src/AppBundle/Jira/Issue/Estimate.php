<?php

namespace AppBundle\Jira\Issue;

/**
 * Class Estimate.
 */
final class Estimate
{
    /** @var int|null */
    private $originalInSeconds;

    /**
     * @return Estimate
     */
    public static function delayed(): self
    {
        return new self(1);
    }

    /**
     * Estimate constructor.
     *
     * @param int|null $originalInSeconds
     */
    public function __construct(?int $originalInSeconds)
    {
        $this->originalInSeconds = $originalInSeconds;
    }

    /**
     * @return string|null
     */
    public function getOriginal(): ?string
    {
        return $this->originalInSeconds ? gmdate('H:i:s', $this->originalInSeconds) : null;
    }
}
