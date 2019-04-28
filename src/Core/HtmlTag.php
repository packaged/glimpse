<?php
namespace Packaged\Glimpse\Core;

use Packaged\Ui\Html\HtmlElement;
use function array_unshift;
use function implode;
use function is_array;

/**
 * Render a HTML tag in a way that treats user content as unsafe by default.
 *
 * Tag rendering has some special logic which implements security features:
 *
 *   - When rendering `<a>` tags, if the `rel` attribute is not specified, it
 *     is interpreted as `rel="noreferrer"`.
 *   - When rendering `<a>` tags, the `href` attribute may not begin with
 *     `javascript:`.
 *
 * These special cases can not be disabled.
 *
 * IMPORTANT: The `$tag` attribute and the keys of the `$attributes` array are
 * trusted blindly, and not escaped. You should not pass user data in these
 * parameters.
 *
 */
abstract class HtmlTag extends HtmlElement
{
  protected $_content;

  public function __construct() { }

  /**
   * @return static
   */
  public static function create()
  {
    return new static();
  }

  /**
   * @param $content
   *
   * @return $this
   */
  public function appendContent($content)
  {
    if(!is_array($this->_content))
    {
      $this->_content = [$this->_content];
    }
    $this->_content[] = $content;
    return $this;
  }

  /**
   * @param $content
   *
   * @return $this
   */
  public function prependContent($content)
  {
    if(!is_array($this->_content))
    {
      $this->_content = [$this->_content];
    }
    array_unshift($this->_content, $content);
    return $this;
  }

  public function asHtml()
  {
    return (string)$this->render();
  }

  /**
   * @param HtmlTag $tag
   *
   * @return $this
   */
  public function copyFrom(HtmlTag $tag)
  {
    $this->setContent($tag->getContent());
    $this->setAttributes($tag->getAttributes());
    $this->addClass($tag->getClasses());
    return $this;
  }

  /**
   * @param bool $asArray
   *
   * @return array|string
   */
  public function getContent($asArray = true)
  {
    if($asArray)
    {
      if($this->_content === '')
      {
        return [];
      }
      return is_array($this->_content) ? $this->_content : [$this->_content];
    }
    else if(is_array($this->_content))
    {
      return implode('', $this->_content);
    }
    return $this->_content;
  }

  /**
   * Content to put in the tag.
   *
   * @param $content
   *
   * @return $this
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  protected function _prepareForProduce(): HtmlElement
  {
    //Make any changes to the tag just before building the html
    return $this;
  }

  protected function _getContentForRender()
  {
    return $this->_content;
  }
}
