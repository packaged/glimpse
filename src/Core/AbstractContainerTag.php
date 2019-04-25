<?php
namespace Packaged\Glimpse\Core;

class AbstractContainerTag extends HtmlTag
{
  public function __construct(...$content)
  {
    parent::__construct();
    $this->setContent(func_num_args() == 1 ? $content[0] : $content);
  }

  public static function create(...$content)
  {
    $tag = new static(...$content);
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
      else if(is_array($item))
      {
        $return[] = new static(...$item);
      }
      else
      {
        $return[] = new static($item);
      }
    }
    return $return;
  }
}
