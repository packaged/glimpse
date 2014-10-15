<?php
namespace Packaged\Tests\Glimpse\Tags;

use Packaged\Glimpse\Tags\Link;

class LinkTest extends \PHPUnit_Framework_TestCase
{
  public function testCreate()
  {
    $link = new Link('http://www.test.com');
    $this->assertEquals('<a href="http://www.test.com"></a>', $link->asHtml());
    $link = new Link('http://www.test.com', 'Test');
    $this->assertEquals(
      '<a href="http://www.test.com">Test</a>',
      $link->asHtml()
    );
  }

  public function testNewWindow()
  {
    $link = new Link('http://www.test.com');
    $link->forNewWindow();
    $this->assertEquals(
      '<a href="http://www.test.com" target="_blank"></a>',
      $link->asHtml()
    );
  }

  public function testTarget()
  {
    $link = new Link('http://www.test.com');
    $link->setTarget('random');
    $this->assertEquals(
      '<a href="http://www.test.com" target="random"></a>',
      $link->asHtml()
    );
  }

  public function testLocation()
  {
    $link = new Link('http://www.test.com');
    $link->setLocation('/here');
    $this->assertEquals('<a href="/here"></a>', $link->asHtml());
  }

  public function testRel()
  {
    $link = new Link('/rel');
    $link->setRel('nofollow');
    $this->assertEquals('<a href="/rel" rel="nofollow"></a>', $link->asHtml());
  }

  public function testDownload()
  {
    $link = new Link('/file.png');
    $link->setDownload();
    $this->assertEquals('<a href="/file.png" download></a>', $link->asHtml());
    $link->setDownload('file');
    $this->assertEquals(
      '<a href="/file.png" download="file"></a>',
      $link->asHtml()
    );
  }
}
