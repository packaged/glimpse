<?php
namespace Packaged\Glimpse\Core;

class CustomHtmlTag extends HtmlTag
{
  public function __construct($tag = 'x-custom-tag', $content = null)
  {
    $this->_tag = $tag;
    if($content !== null)
    {
      $this->setContent($content);
    }
  }

  public static function build($tag, array $attributes = [], $content = null)
  {
    $html = new static($tag, $content);
    $html->setAttributes($attributes);
    return $html;
  }

  /**
   * The name of the tag, like `a` or `div`.
   *
   * @param $tag
   *
   * @return $this
   */
  public function setTag($tag)
  {
    $this->_tag = $tag;
    return $this;
  }
}
