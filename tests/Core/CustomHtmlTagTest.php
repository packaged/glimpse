<?php
namespace Packaged\Tests\Glimpse\Core;

use Packaged\Glimpse\Core\CustomHtmlTag;
use PHPUnit\Framework\TestCase;

class CustomHtmlTagTest extends TestCase
{
  public function testCustomHtmlTag()
  {
    $this->assertEquals('<hr />', new CustomHtmlTag('hr'));
    $this->assertEquals('<br />', new CustomHtmlTag('br'));
    $this->assertEquals('<span>Test</span>', new CustomHtmlTag('span', 'Test'));
  }

  public function testChangeTag()
  {
    $tag = new CustomHtmlTag('hr');
    $this->assertEquals('<hr />', $tag);
    $tag->setTag('br');
    $this->assertEquals('<br />', $tag);
  }
}
