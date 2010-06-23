<?php
/**
 * Makes a string to an url safe identifier
 *
 * @author Lars Olesen
 */

/**
 * Makes a string to an url safe identifier
 *
 * <code>
 * $identifier = new VIH_Identifier('Lars Olesen');
 * $identifier->prepend('12');
 * echo $identifier->process();
 * </code>
 *
 * @author Lars Olesen
 */
class VIH_Identifier
{
    /**
     * @var string
     */
    private $raw_identifier = '';

    /**
     * @var string
     */
    private $identifier = '';

    /**
     * Constructor
     *
     * @param string $raw_identifier The string to convert
     *
     * @return void
     */
    function __construct($raw_identifier)
    {
        $this->raw_identifier = $raw_identifier;
    }

    /**
     * Used if you want to prepend something to the string
     *
     * @param string $string The stuff to prepend
     *
     * @return void
     */
    function prepend($string)
    {
        $this->raw_identifier = $string . ' ' . $this->raw_identifier;
    }

    /**
     * Process the raw identifier
     *
     * @return string
     */
    function process()
    {
        $this->identifier = $this->raw_identifier;
        $this->identifier = trim($this->identifier);
        $this->identifier = strtolower($this->identifier);
        $this->identifier = str_replace(' ', '-', $this->identifier);
        $this->identifier = str_replace('æ', 'ae', $this->identifier);
        $this->identifier = str_replace('o', 'o', $this->identifier);
        $this->identifier = str_replace('å', 'aa', $this->identifier);
        return $this->identifier;
    }
}

