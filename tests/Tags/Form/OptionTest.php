<?php

use Packaged\Glimpse\Tags\Form\Option;
use Packaged\SafeHtml\SafeHtml;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
  public function testCollection()
  {
    $tags = Option::collection(['a', 'b', 'c']);
    $this->assertEquals('<option>a</option><option>b</option><option>c</option>', SafeHtml::escape($tags, ''));
  }

  public function testAssocCollection()
  {
    $tags = Option::collection(['one' => 'a', 'two' => 'b']);
    $this->assertEquals('<option value="one">a</option><option value="two">b</option>', SafeHtml::escape($tags, ''));
  }

  public function testAssocStaticCollection()
  {
    $tags = Option::collection(['one' => 'a', 'two' => 'b', new Option('Z', 'abc')]);
    $this->assertEquals(
      '<option value="one">a</option><option value="two">b</option><option value="abc">Z</option>',
      SafeHtml::escape($tags, '')
    );
  }
}
