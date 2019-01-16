<?php
namespace Packaged\Tests\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;
use PHPUnit\Framework\TestCase;

class BasicTagsTest extends TestCase
{
  /**
   * @param $class
   * @param $expect
   *
   * @dataProvider tagDataProvider
   */
  public function testTagHtml($class, $expect)
  {
    $tag = new $class();
    $this->assertInstanceOf('\Packaged\Glimpse\Core\HtmlTag', $tag);
    /**
     * @var $tag HtmlTag
     */
    $this->assertEquals(
      '<' . $expect . '></' . $expect . '>',
      $tag->asHtml()
    );
  }

  public function tagDataProvider()
  {
    $ns = '\Packaged\Glimpse\Tags\\';
    return [
      [$ns . 'Table\Table', 'table'],
      [$ns . 'Table\TableHead', 'thead'],
      [$ns . 'Table\TableBody', 'tbody'],
      [$ns . 'Table\TableFoot', 'tfoot'],
      [$ns . 'Table\TableRow', 'tr'],
    ];
  }
}
