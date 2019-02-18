<?php
namespace Packaged\Glimpse\Tags\Text;

use InvalidArgumentException;
use Packaged\Glimpse\Tags\AbstractContentTag;

class BiDirectionalText extends AbstractContentTag
{
  const DIR_LTR = 'ltr';
  const DIR_RTL = 'rtl';

  protected $_tag = 'bdo';

  public function __construct($content = null)
  {
    parent::__construct($content);
    $this->setDirection(self::DIR_LTR);
  }

  public static function create($content = '', $direction = self::DIR_LTR)
  {
    $ele = parent::create($content);
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
