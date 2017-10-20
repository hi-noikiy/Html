<?php
declare(strict_types=1);

namespace CommonCrane\Html\Test\Unit\Ast;

use PHPUnit\Framework\TestCase;
use CommonCrane\Html\VirtualDom\Attribute;
use CommonCrane\Html\VirtualDom\Text;
use CommonCrane\Html\Ast\RawTextElement;

class RawTextElementTest extends TestCase
{
    public function testToHtml()
    {
        $textStub = $this->createMock(Text::class);
        $textStub->method('toRawText')->willReturn('');
        $element = new RawTextElement('element', [], $textStub);
        $elementHtml = $element->toHtml();
        $this->assertEquals('<element></element>', $elementHtml);
    }

    public function testWithAttributes()
    {
        $textStub = $this->createMock(Text::class);
        $textStub->method('toRawText')->willReturn('');
        $attributeStub = $this->createMock(Attribute::class);
        $attributeStub->method('toHtml')->willReturn('attribute="value"');
        $element = new RawTextElement('element', [$attributeStub], $textStub);
        $elementHtml = $element->toHtml();
        $this->assertEquals('<element attribute="value"></element>', $elementHtml);
    }

    public function testBeautify ()
    {
        $textStub = $this->createMock(Text::class);
        $textStub->method('toRawText')->willReturn('');
        $element = new RawTextElement('element', [], $textStub);
        $beautified = $element->beautify();
        $this->assertEquals($element, $beautified);
    }

    public function testGetLocalName()
    {
        $textStub = $this->createMock(Text::class);
        $localName = 'element';
        $element = new RawTextElement($localName, [], $textStub);
        $this->assertEquals($localName, $element->getLocalName());
    }

    public function testGetAttributes()
    {
        $textStub = $this->createMock(Text::class);
        $attributes = [];
        $element = new RawTextElement('element', $attributes, $textStub);
        $this->assertEquals($attributes, $element->getAttributes());
    }

    public function testSetLocalName()
    {
        $textStub = $this->createMock(Text::class);
        $expected = 'setelement';
        $element = new RawTextElement('element', [], $textStub);
        $actual = $element->setLocalName($expected)->getLocalName();
        $this->assertEquals($expected, $actual);
    }

    public function testSetAttributes()
    {
        $textStub = $this->createMock(Text::class);
        $attributeStub = $this->createMock(Attribute::class);
        $expected = [$attributeStub];
        $element = new RawTextElement('element', [], $textStub);
        $actual = $element->setAttributes($expected)->getAttributes();
        $this->assertEquals($expected, $actual);
    }

    public function testGetText()
    {
        $expected = $this->createMock(Text::class);
        $element = new RawTextElement('element', [], $expected);
        $actual = $element->getText();
        $this->assertEquals($expected, $actual);
    }

    public function testSetText()
    {
        $textStub = $this->createMock(Text::class);
        $expected = $this->createMock(Text::class);
        $element = new RawTextElement('element', [], $textStub);
        $actual = $element->setText($expected)->getText();
        $this->assertEquals($expected, $actual);
    }
}
