<?php
namespace Packaged\Tests\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;
use Packaged\Glimpse\Tags\AbstractContentTag;
use Packaged\Glimpse\Tags\Text\Paragraph;
use Packaged\Helpers\Objects;
use Packaged\SafeHtml\SafeHtml;
use PHPUnit\Framework\TestCase;

class AbstractContentTagsTest extends TestCase
{
  /**
   * @param $class
   * @param $expect
   *
   * @dataProvider tagDataProvider
   */
  public function testTagHtml($class, $expect)
  {
    /** @var AbstractContentTag $tag */
    $tag = Objects::create($class, ['Test']);
    $this->assertInstanceOf('\Packaged\Glimpse\Core\HtmlTag', $tag);
    /**
     * @var $tag HtmlTag
     */
    $this->assertEquals('<' . $expect . '>Test</' . $expect . '>', $tag->asHtml());

    $tag = $tag::create('Test');
    $this->assertInstanceOf('\Packaged\Glimpse\Core\HtmlTag', $tag);
    /**
     * @var $tag HtmlTag
     */
    $this->assertEquals('<' . $expect . '>Test</' . $expect . '>', $tag->asHtml());
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
      [$ns . 'Text\HeadingSix', 'h6'],
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
      [$ns . 'Table\TableCell', 'td'],
      [$ns . 'Table\TableHeading', 'th'],
      [$ns . 'Lists\ListItem', 'li'],
    ];
  }

  public function testCollection()
  {
    $tags = Paragraph::collection(['a', 'b', 'c']);
    $this->assertEquals('<p>a</p><p>b</p><p>c</p>', SafeHtml::escape($tags, ''));
  }

  public function testStaticCollection()
  {
    $tags = Paragraph::collection(['a', new Paragraph('b'), 'c']);
    $this->assertEquals('<p>a</p><p>b</p><p>c</p>', SafeHtml::escape($tags, ''));
  }
}
