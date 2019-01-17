<?php

use Packaged\Glimpse\Tags\Form\Label;
use PHPUnit\Framework\TestCase;

class LabelTest extends TestCase
{

  public function testCreate()
  {
    $label = Label::create('a', 'abc');
    $this->assertEquals('abc', $label->getFor());
    $this->assertEquals('a', $label->getContent(false));
  }
}
