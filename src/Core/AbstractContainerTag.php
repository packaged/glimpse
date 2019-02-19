<?php
namespace Packaged\Glimpse\Core;

class AbstractContainerTag extends HtmlTag
{
  public function __construct(...$content)
  {
    $this->setContent($content);
  }

  public static function create(...$content)
  {
    $tag = new static(...$content);
    return $tag;
  }

}
