<?php

namespace BenTools\ETL\Iterator;

use IteratorAggregate;

class CsvStringIterator implements IteratorAggregate, CsvIteratorInterface
{

    /**
     * @var StringIteratorInterface
     */
    private $stringIterator;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var string
     */
    private $escapeString;

    /**
     * CsvIterator constructor.
     * @param StringIteratorInterface $iterator
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeString
     */
    public function __construct(
        StringIteratorInterface $iterator,
        $delimiter = ',',
        $enclosure = '"',
        $escapeString = '\\'
    ) {
    
        $this->stringIterator = $iterator;
        $this->delimiter      = $delimiter;
        $this->enclosure      = $enclosure;
        $this->escapeString   = $escapeString;
    }

    /**
     * @param string $text
     * @param bool $skipEmptyLines
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeString
     * @return static
     */
    public static function createFromText(
        string $text,
        bool $skipEmptyLines = true,
        $delimiter = ',',
        $enclosure = '"',
        $escapeString = '\\'
    ) {

        return new static(new TextLinesIterator($text, $skipEmptyLines), $delimiter, $enclosure, $escapeString);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        foreach ($this->stringIterator as $line) {
            yield str_getcsv($line, $this->delimiter, $this->enclosure, $this->escapeString);
        }
    }
}
