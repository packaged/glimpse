<?php
namespace Packaged\Tests\Glimpse\Tags\Text;

use Packaged\Glimpse\Tags\Text\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
  public function testTimeTag()
  {
    $time = 0;
    $timeTag = Time::create($time);
    $this->assertEquals(
      $timeTag->render(),
      '<time datetime="1970-01-01T00:00:00+00:00">1970-01-01</time>'
    );

    $timeTag = Time::create($time, 'Epoch');
    $this->assertEquals(
      $timeTag->render(),
      '<time datetime="1970-01-01T00:00:00+00:00">Epoch</time>'
    );

    $timeTag = Time::create('20:00', '8pm');
    $this->assertEquals(
      $timeTag->render(),
      '<time datetime="20:00">8pm</time>'
    );

    $timeTag = Time::create('PT2H30M', '2h 30m');
    $this->assertEquals(
      $timeTag->render(),
      '<time datetime="PT2H30M">2h 30m</time>'
    );
  }
}
