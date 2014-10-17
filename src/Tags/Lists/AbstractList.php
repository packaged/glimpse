<?php
namespace Packaged\Glimpse\Tags\Lists;

use Packaged\Glimpse\Core\HtmlTag;

abstract class AbstractList extends HtmlTag
{
  public function addItem($content)
  {
    if($content instanceof ListItem)
    {
      $this->appendContent($content);
    }
    else
    {
      $this->appendContent(ListItem::create($content));
    }
    return $this;
  }

  public function addItems(array $items)
  {
    foreach($items as $item)
    {
      $this->addItem($item);
    }
    return $this;
  }
}
