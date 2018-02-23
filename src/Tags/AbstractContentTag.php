<?php
namespace Packaged\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;

abstract class AbstractContentTag extends HtmlTag
{
  public function __construct($content = null)
  {
    $this->setContent($content);
  }

  public static function create($content = '')
  {
    $tag = new static($content);
    return $tag;
  }

  public static function collection(array $items)
  {
    $return = [];
    foreach($items as $item)
    {
      if($item instanceof static)
      {
        $return[] = $item;
      }
      else
      {
        $return[] = new static($item);
      }
    }
    return $return;
  }
}
