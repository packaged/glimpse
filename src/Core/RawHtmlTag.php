<?php
namespace Packaged\Glimpse\Core;

class RawHtmlTag extends HtmlTag
{
  public function __construct($tag, $content = null)
  {
    $this->_tag = $tag;
    if($content !== null)
    {
      $this->setContent($content);
    }
  }
}
