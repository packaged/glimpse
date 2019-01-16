<?php
namespace Packaged\Tests\Glimpse\Elements;

use Packaged\Glimpse\Tags\LineBreak;
use PHPUnit\Framework\TestCase;

class LineBreakTest extends TestCase
{
  public function testTagHtml()
  {
    $tag = new LineBreak();
    $this->assertEquals('<br />', $tag->asHtml());
  }
}
