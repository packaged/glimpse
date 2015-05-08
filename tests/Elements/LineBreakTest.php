<?php
namespace Packaged\Tests\Glimpse\Elements;

use Packaged\Glimpse\Elements\LineBreak;

class LineBreakTest extends \PHPUnit_Framework_TestCase
{
  public function testTagHtml()
  {
    $tag = new LineBreak();
    $this->assertEquals('<br />', $tag->asHtml());
  }
}
