<?php

use Packaged\Glimpse\Tags\Form\Input;
use PHPUnit\Framework\TestCase;

class AbstractFormElementTagTest extends TestCase
{

  public function testSetDisabled()
  {
    $element = new Input('');
    $this->assertFalse($element->isDisabled());
    $element->setDisabled(true);
    $this->assertTrue($element->isDisabled());
    $element->setDisabled(false);
    $this->assertFalse($element->isDisabled());
  }

  public function testSetName()
  {
    $element = new Input('');
    $this->assertEquals('', $element->getName());
    $element->setName('name');
    $this->assertEquals('name', $element->getName());
    $element->setName('name2');
    $this->assertEquals('name2', $element->getName());
  }

  public function testSetRequired()
  {
    $element = new Input('');
    $this->assertFalse($element->isRequired());
    $element->setRequired(true);
    $this->assertTrue($element->isRequired());
    $element->setRequired(false);
    $this->assertFalse($element->isRequired());
  }
}
