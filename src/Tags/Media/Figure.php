<?php
namespace Packaged\Glimpse\Tags\Media;

use Packaged\Glimpse\Core\AbstractContainerTag;

class Figure extends AbstractContainerTag
{
  protected $_tag = 'figure';

  public static function forImage(Image $image, FigureCaption $caption)
  {
    return parent::create([$image, $caption]);
  }
}
