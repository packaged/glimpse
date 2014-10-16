<?php
namespace Packaged\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;

abstract class AbstractContentTag extends HtmlTag
{
  public function __construct($content = null)
  {
    $this->setContent($content);
  }

  public static function collection(array $items)
  {
    $return = [];
    foreach($items as $item)
    {
      $return[] = new static($item);
    }
    return $return;
  }
}
