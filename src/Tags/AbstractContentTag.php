<?php
namespace Packaged\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;

abstract class AbstractContentTag extends HtmlTag
{
  public function __construct($content = null)
  {
    $this->setContent($content);
  }
}
