<?php
namespace Packaged\Glimpse\Tags\Text;

use Packaged\Glimpse\Tags\AbstractContentTag;

class Abbreviation extends AbstractContentTag
{
  protected $_tag = 'abbr';

  public function __construct($abbreviation = null, $meaning = null)
  {
    parent::__construct($abbreviation);
    $this->setAttribute('title', $meaning);
  }

  public static function create($abbreviation = '', $meaning = '')
  {
    $tag = new static($abbreviation, $meaning);
    return $tag;
  }
}
