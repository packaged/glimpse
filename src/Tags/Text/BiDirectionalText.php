<?php
namespace Packaged\Glimpse\Tags\Text;

use InvalidArgumentException;
use Packaged\Glimpse\Core\HtmlTag;

class BiDirectionalText extends HtmlTag
{
  const DIR_LTR = 'ltr';
  const DIR_RTL = 'rtl';

  protected $_tag = 'bdo';

  public function __construct($content = null)
  {
    parent::__construct();
    $this->setContent($content);
    $this->setDirection(self::DIR_LTR);
  }

  public static function create($content = '', $direction = self::DIR_LTR)
  {
    $ele = parent::create();
    $ele->setContent($content);
    $ele->setAttribute('dir', $direction);
    return $ele;
  }

  public function setDirection($direction)
  {
    if(in_array($direction, [self::DIR_RTL, self::DIR_LTR], true))
    {
      return $this->setAttribute('dir', $direction);
    }
    throw new InvalidArgumentException("$direction is not a valid direction.");
  }

  public function getDirection()
  {
    return $this->getAttribute('dir');
  }
}
