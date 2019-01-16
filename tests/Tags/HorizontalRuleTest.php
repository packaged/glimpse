<?php
namespace Packaged\Tests\Glimpse\Elements;

use Packaged\Glimpse\Tags\HorizontalRule;
use PHPUnit\Framework\TestCase;

class HorizontalRuleTest extends TestCase
{
  public function testTagHtml()
  {
    $tag = new HorizontalRule();
    $this->assertEquals('<hr />', $tag->asHtml());
  }
}
