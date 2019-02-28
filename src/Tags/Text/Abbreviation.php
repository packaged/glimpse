<?php
namespace Packaged\Glimpse\Tags\Text;

use Packaged\Glimpse\Core\HtmlTag;

class Abbreviation extends HtmlTag
{
  protected $_tag = 'abbr';

  public function __construct($abbreviation = null, $meaning = null)
  {
    parent::__construct();
    $this->setContent($abbreviation);
    $this->setAttribute('title', $meaning);
  }

  public static function create($abbreviation = '', $meaning = '')
  {
    $tag = new static($abbreviation, $meaning);
    return $tag;
  }
}
