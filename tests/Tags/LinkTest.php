<?php
namespace Packaged\Tests\Glimpse\Tags;

use Packaged\Glimpse\Tags\Link;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
  const URL = 'http://www.test.com';

  public function testCreate()
  {
    $link = new Link(self::URL, '');
    $this->assertEquals('<a href="http://www.test.com"></a>', $link->asHtml());
    $link = new Link(self::URL, 'Test');
    $this->assertEquals('<a href="http://www.test.com">Test</a>', $link->asHtml());
  }

  public function testNewWindow()
  {
    $link = Link::create(self::URL);
    $link->forNewWindow();
    $this->assertEquals('<a href="' . self::URL . '" target="_blank">' . self::URL . '</a>', $link->asHtml());
  }

  public function testTarget()
  {
    $link = new Link(self::URL);
    $link->setTarget('random');
    $this->assertEquals('<a href="' . self::URL . '" target="random">' . self::URL . '</a>', $link->asHtml());
  }

  public function testLocation()
  {
    $link = new Link(self::URL);
    $link->setLocation('/here');
    $this->assertEquals('<a href="/here">' . self::URL . '</a>', $link->asHtml());
  }

  public function testRel()
  {
    $link = new Link('/rel');
    $link->setRel('nofollow');
    $this->assertEquals('<a href="/rel" rel="nofollow">/rel</a>', $link->asHtml());
  }

  public function testDownload()
  {
    $link = new Link('/file.png');
    $link->setDownload();
    $this->assertEquals('<a href="/file.png" download>/file.png</a>', $link->asHtml());
    $link->setDownload('file');
    $this->assertEquals('<a href="/file.png" download="file">/file.png</a>', $link->asHtml());
  }
}
