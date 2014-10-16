<?php
namespace Packaged\Tests\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;

class BasicTagsTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @param $class
   * @param $expect
   *
   * @dataProvider tagDataProvider
   */
  public function testTagHtml($class, $expect)
  {
    $tag = newv($class, ['Test']);
    $this->assertInstanceOf('\Packaged\Glimpse\Core\HtmlTag', $tag);
    /**
     * @var $tag HtmlTag
     */
    $this->assertEquals(
      '<' . $expect . '>Test</' . $expect . '>',
      $tag->asHtml()
    );
  }

  public function tagDataProvider()
  {
    $ns = '\Packaged\Glimpse\Tags\\';
    return [
      [$ns . 'Div', 'div'],
      [$ns . 'Text\CodeBlock', 'code'],
      [$ns . 'Text\BoldText', 'b'],
      [$ns . 'Text\StrongText', 'strong'],
      [$ns . 'Text\EmphasizedText', 'em'],
      [$ns . 'Text\HeadingOne', 'h1'],
      [$ns . 'Text\HeadingTwo', 'h2'],
      [$ns . 'Text\HeadingThree', 'h3'],
      [$ns . 'Text\HeadingFour', 'h4'],
      [$ns . 'Text\HeadingFive', 'h5'],
      [$ns . 'Text\Headingsix', 'h6'],
      [$ns . 'Text\Caption', 'caption'],
      [$ns . 'Text\Citation', 'cite'],
      [$ns . 'Text\DeletedText', 'del'],
      [$ns . 'Text\InsertedText', 'ins'],
      [$ns . 'Text\ItalicText', 'i'],
      [$ns . 'Text\MarkedText', 'mark'],
      [$ns . 'Text\Paragraph', 'p'],
      [$ns . 'Text\QuotedText', 'q'],
      [$ns . 'Text\SubscriptText', 'sub'],
      [$ns . 'Text\SuperscriptText', 'sup'],
    ];
  }
}
