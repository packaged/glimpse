<?php
namespace Packaged\Tests\Glimpse\Elements;

use Packaged\Glimpse\Elements\HorizontalRule;

class HorizontalRuleTest extends \PHPUnit_Framework_TestCase
{
  public function testTagHtml()
  {
    $tag = new HorizontalRule();
    $this->assertEquals('<hr />', $tag->asHtml());
  }
}
