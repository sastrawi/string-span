<?php
/**
 * Sastrawi Span (https://github.com/sastrawi/string-span)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\String\Span;

/**
 * Text span interface
 *
 * @author Andy Librian
 */
interface SpanInterface
{
    /**
     * Get the start position.
     *
     * @return int
     */
    public function getStart();

    /**
     * Get the end position.
     *
     * @return int
     */
    public function getEnd();

    /**
     * Get type of the span.
     *
     * @return string
     */
    public function getType();

    /**
     * Get the span length
     *
     * @return int
     */
    public function getLength();

    /**
     * Get covered text by this span.
     *
     * @param  string $text The text
     * @return string
     */
    public function getCoveredText($text);

    public function contains(SpanInterface $span);

    public function containsIndex($index);

    public function startsWith(SpanInterface $span);

    public function intersects(SpanInterface $span);

    public function crosses(Span $span);

    public function __toString();
}
