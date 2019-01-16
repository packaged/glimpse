<?php

use Packaged\Glimpse\Tags\Form\Input;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
  public function testType()
  {
    $input = new Input();
    $this->assertEquals(Input::TYPE_TEXT, $input->getType());
    $input->setType(Input::TYPE_WEEK);
    $this->assertEquals(Input::TYPE_WEEK, $input->getType());
  }

  public function testValue()
  {
    $input = new Input();
    $this->assertEmpty($input->getValue());
    $input->setValue('abc');
    $this->assertEquals('abc', $input->getValue());
  }
}
