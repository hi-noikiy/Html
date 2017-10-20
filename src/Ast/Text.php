<?php
declare(strict_types=1);

namespace CommonCrane\Html\Ast;

use CommonCrane\Html\VirtualDom\Text as TextInterface;

/**
 * A Text represents a text-node.
 */
final class Text implements TextInterface
{

    protected $text;

    /**
     * Construct a new Text with text-content set to $text
     * 
     * @param string $text The text-content of the new Text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Get the html-representation of the this Text.
     */
    public function toHtml() : string
    {
        return htmlspecialchars($this->text, ENT_HTML5 | ENT_NOQUOTES);
    }

    /**
     * Get the raw-text-representation of the this Text. This method is
     * only used for <script>- and <style>-elements. These elements use
     * a different encoding-algorithm. For exmaple, an ampersand "&" is
     * not replaced by the html-escaping-sequence "&amp;", but left
     * unmodifier.
     * 
     * @param string $localName A localName, that is escaped inside the
     *        text-content of this Text.
     */
    public function toRawText (string $localName) : string
    {
        $tests = [
            '/<(' . $localName . ')/ium', // test for forbidden opening tags
            '/<\/(' .$localName. ')/ium', // test for forbidden closing tags
            '/<!--/ium'                   // test for forbidden opening comments
        ];
        $replacements = [
            '<\\\$1',
            '<\\/$1',
            '<\\!--'
        ];
        return preg_replace($tests, $replacements, $this->text);
    }

    /**
     * Get the text-content of the this Text.
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * Get a new Text that is like this one but with its text-content set to
     * $text.
     * 
     * @param string $text The text-content of the new Text
     */
    public function setText(string $text) : TextInterface
    {
        return new Text($text);
    }
}
