<?php
/**
 * Sastrawi Span (https://github.com/sastrawi/string-span)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\String\Span;

/**
 * Text span model
 *
 * @author Andy Librian
 */
class Span implements SpanInterface
{
    private $start = 0;

    private $end = 0;

    private $type;

    public function __construct($start, $end, $type = null)
    {
        if (!is_int($start) || $start < 0) {
            throw new \InvalidArgumentException("start index must be zero or greater: $start given.");
        }

        if (!is_int($end) || $end < 0) {
            throw new \InvalidArgumentException("end index must be zero or greater: $end given.");
        }

        if ($start > $end) {
            throw new \InvalidArgumentException(
                "start index can not be greater than end index: start=$start, end=$end"
            );
        }

        $this->start = $start;
        $this->end   = $end;
        $this->type  = $type;
    }

    /**
     * Get the start position.
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end position.
     *
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get type of the span.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the span length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->end - $this->start;
    }

    /**
     * Get covered text by this span.
     *
     * @param  string $text The text
     * @return string
     */
    public function getCoveredText($text)
    {
        return substr($text, $this->start, $this->getLength());
    }

    public function contains(SpanInterface $span)
    {
        return $this->start <= $span->getStart() && $span->getEnd() <= $this->end;
    }

    public function containsIndex($index)
    {
        return $this->start <= $index && $index < $this->end;
    }

    public function startsWith(SpanInterface $span)
    {
        return $this->getStart() == $span->getStart() && $this->contains($span);
    }

    public function intersects(SpanInterface $span)
    {
        $sstart = $span->getStart();

        //either $span's start is in this or this' start is in $span
        return $this->contains($span) || $span->contains($this) ||
            $this->getStart() <= $sstart && $sstart < $this->getEnd() ||
            $sstart <= $this->getStart() && $this->getStart() < $span->getEnd();
    }

    public function crosses(Span $span)
    {
        $sstart = $span->getStart();

        //either $span's start is in this or this' start is in $span
        return !$this->contains($span) && !$span->contains($this) &&
           ($this->getStart() <= $sstart && $sstart < $this->getEnd() ||
           $sstart <= $this->getStart() && $this->getStart() < $span->getEnd());
    }

    public function __toString()
    {
        $string = '['.$this->getStart().'..'.$this->getEnd().')';

        if ($this->getType() !== null) {
            $string .= ' '.$this->getType();
        }

        return $string;
    }
}
