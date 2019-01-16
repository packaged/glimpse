<?php
namespace Packaged\Tests\Glimpse\Core;

use Packaged\Glimpse\Core\CustomHtmlTag;
use Packaged\Glimpse\Core\Uri;
use PHPUnit\Framework\TestCase;

class HtmlTagTest extends TestCase
{
  public function testGettersAndSetters()
  {
    $tag = new CustomHtmlTag('a');
    $this->assertEquals('a', $tag->getTag());

    $tag->setId('myid');
    $this->assertEquals('myid', $tag->getId());

    $this->assertFalse($tag->hasAttribute('random'));
    $this->assertEquals('no', $tag->getAttribute('random', 'no'));
    $tag->setAttribute('random', 'test');
    $this->assertTrue($tag->hasAttribute('random'));
    $this->assertEquals('test', $tag->getAttribute('random'));

    $attr = ['test' => 'ran', 'class' => 'test', 'id' => 'four'];
    $tag->setAttributes($attr);
    $this->assertSame($attr, $tag->getAttributes());
    $this->assertEquals('four', $tag->getId());

    $tag->setContent('testing');
    $this->assertEquals('testing', $tag->getContent(false));
    $this->assertEquals(['testing'], $tag->getContent());
    $tag->appendContent('content');
    $this->assertEquals(['testing', 'content'], $tag->getContent());
    $this->assertEquals('testingcontent', $tag->getContent(false));

    $tag->setContent('testing');
    $tag->prependContent('content');
    $this->assertEquals(['content', 'testing'], $tag->getContent());
    $this->assertEquals('contenttesting', $tag->getContent(false));

    $tag->removeAttribute('class');
    $this->assertFalse($tag->hasClass('red'));
    $tag->addClass('red');
    $this->assertTrue($tag->hasClass('red'));
    $this->assertEquals(['red' => 'red'], $tag->getClasses());
    $tag->removeClass('red');
    $this->assertFalse($tag->hasClass('red'));

    $tag->addClass('red', 'blue', ['green', 'yellow'], 'orange');
    $this->assertTrue($tag->hasClass('yellow'));
    $this->assertTrue($tag->hasClass('blue'));
    $this->assertTrue($tag->hasClass('green'));
    $this->assertTrue($tag->hasClass('red'));
    $this->assertTrue($tag->hasClass('orange'));

    $tag->removeClass('yellow', ['blue', 'green'], 'red');
    $this->assertFalse($tag->hasClass('yellow'));
    $this->assertFalse($tag->hasClass('blue'));
    $this->assertFalse($tag->hasClass('green'));
    $this->assertFalse($tag->hasClass('red'));
    $this->assertTrue($tag->hasClass('orange'));
  }

  public function testCreateStatic()
  {
    $this->assertInstanceOf('\Packaged\Glimpse\Core\CustomHtmlTag', CustomHtmlTag::create());
  }

  public function testSelfClosers()
  {
    $this->assertEquals('<br />', (string)CustomHtmlTag::build('br'));
    $this->assertEquals(
      '<img src="x.gif" />',
      (string)CustomHtmlTag::build('img', ['src' => 'x.gif'])
    );
  }

  public function testNullContent()
  {
    $this->assertEquals('<div></div>', (string)CustomHtmlTag::build('div'));
  }

  public function testBooleanAttribute()
  {
    $this->assertEquals(
      '<option selected></option>',
      (string)CustomHtmlTag::build('option', ['selected' => null])
    );
  }

  public function testTagJavascriptProtocolRejection()
  {
    $hrefs = [
      'javascript:alert(1)'                 => true,
      'JAVASCRIPT:alert(2)'                 => true,
      // NOTE: When interpreted as a URI, this is dropped because of leading
      // whitespace.
      '     javascript:alert(3)'            => [true, false],
      '/'                                   => false,
      '/path/to/stuff/'                     => false,
      ''                                    => false,
      'http://example.com/'                 => false,
      '#'                                   => false,
      'javascript://anything'               => true,
      // Chrome 33 and IE11, at a minimum, treat this as Javascript.
      "javascript\n:alert(4)"               => true,
      // Opera currently accepts a variety of unicode spaces. This test case
      // has a smattering of them.
      "\xE2\x80\x89javascript:"             => true,
      "javascript\xE2\x80\x89:"             => true,
      "\xE2\x80\x84javascript:"             => true,
      "javascript\xE2\x80\x84:"             => true,
      // Because we're aggressive, all of unicode should trigger detection
      // by default.
      "\xE2\x98\x83javascript:"             => true,
      "javascript\xE2\x98\x83:"             => true,
      "\xE2\x98\x83javascript\xE2\x98\x83:" => true,
      // We're aggressive about this, so we'll intentionally raise false
      // positives in these cases.
      'javascript~:alert(5)'                => true,
      '!!!javascript!!!!:alert(6)'          => true,
      // However, we should raise true negatives in these slightly more
      // reasonable cases.
      'javascript/:docs.html'               => false,
      'javascripts:x.png'                   => false,
      'COOLjavascript:page'                 => false,
      '/javascript:alert(1)'                => false,
    ];

    foreach([false, true] as $useUri)
    {
      foreach($hrefs as $href => $expect)
      {
        if(is_array($expect))
        {
          $expect = ($useUri ? $expect[1] : $expect[0]);
        }

        if($useUri)
        {
          $href = new Uri($href);
        }

        $caught = null;
        try
        {
          CustomHtmlTag::build('a', ['href' => $href], 'go')->produceSafeHTML();
        }
        catch(\Exception $ex)
        {
          $caught = $ex;
        }
        $this->assertEquals(
          $expect,
          $caught instanceof \Exception,
          "Rejected href: {$href}"
        );
      }
    }
  }

  public function testToStringException()
  {
    $tag = CustomHtmlTag::build('a', ['href' => 'javascript:alert(\'Hi\');']);
    $this->assertContains('Attempting to render a tag with an', (string)$tag);
  }
}
