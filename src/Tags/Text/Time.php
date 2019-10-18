<?php
namespace Packaged\Glimpse\Tags\Text;

use Packaged\Glimpse\Core\HtmlTag;

class Time extends HtmlTag
{
  protected $_tag = 'time';

  public function __construct($timestamp = null, $text = null)
  {
    parent::__construct();

    if($timestamp === null || $timestamp === '')
    {
      $timestamp = time();
    }

    if(empty($text))
    {
      $text = date('Y-m-d', $timestamp);
    }

    $this->setAttribute('datetime', is_numeric($timestamp) ? date(DATE_RFC3339, $timestamp) : $timestamp);
    $this->setContent($text);
  }

  public static function create($timestamp = '', $text = '')
  {
    $tag = new static($timestamp, $text);
    return $tag;
  }
}
