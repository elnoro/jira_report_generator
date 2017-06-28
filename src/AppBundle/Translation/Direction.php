<?php

namespace AppBundle\Translation;

/**
 * Class Direction.
 */
class Direction
{
    /** @var string */
    private $from;

    /** @var string */
    private $to;

    /**
     * Direction constructor.
     *
     * @param string $from
     * @param string $to
     */
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }
}
