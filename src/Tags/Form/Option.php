<?php
namespace Packaged\Glimpse\Tags\Form;

use Packaged\Helpers\Arrays;

class Option extends AbstractFormElementTag
{
  protected $_tag = 'option';

  public function __construct($content = null, $value = null)
  {
    parent::__construct();
    if($value !== null)
    {
      $this->setAttribute('value', $value);
    }
    $this->setContent($content);
  }

  public static function collection(array $items)
  {
    $return = [];
    $isAssoc = Arrays::isAssoc($items);
    foreach($items as $k => $item)
    {
      if($item instanceof static)
      {
        $return[] = $item;
      }
      else
      {
        $return[] = new static($item, $isAssoc ? $k : null);
      }
    }
    return $return;
  }

}
