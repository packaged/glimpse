<?php
namespace Packaged\Tests\Glimpse\Core;

use Packaged\Glimpse\Core\RawHtmlTag;

class RawHtmlTagTest extends \PHPUnit_Framework_TestCase
{
  public function testRawHtmlTag()
  {
    $this->assertEquals('<hr />', new RawHtmlTag('hr'));
    $this->assertEquals('<br />', new RawHtmlTag('br'));
    $this->assertEquals('<span>Test</span>', new RawHtmlTag('span', 'Test'));
  }
}
