<?php
namespace Packaged\Glimpse\Tags\Media;

use Packaged\Glimpse\Core\HtmlTag;

class Image extends HtmlTag
{
  protected $_tag = 'img';

  public static function create($src = '', $alternateText = '')
  {
    $ele = parent::create();
    $ele->setAttribute('src', $src);
    $ele->setAttribute('alt', $alternateText);
    return $ele;
  }
}
