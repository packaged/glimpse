<?php
namespace Packaged\Glimpse\Tags\Media;

use Packaged\Glimpse\Tags\AbstractContentTag;

class Figure extends AbstractContentTag
{
  protected $_tag = 'figure';

  public static function forImage(Image $image, FigureCaption $caption)
  {
    return parent::create([$image, $caption]);
  }
}
