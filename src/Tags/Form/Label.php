<?php
namespace Packaged\Glimpse\Tags\Form;

use Packaged\Glimpse\Tags\AbstractContentTag;

class Label extends AbstractContentTag
{
  protected $_tag = 'label';
  protected $_for;

  public static function create($content = '', $for = null)
  {
    /** @var Label $ele */
    $ele = parent::create($content);
    $ele->setFor($for);
    return $ele;
  }

  /**
   * @return mixed
   */
  public function getFor()
  {
    return $this->_for;
  }

  /**
   * @param mixed $for
   *
   * @return Label
   */
  public function setFor($for)
  {
    $this->_for = $for;
    $this->setAttribute('for', $this->_for);
    return $this;
  }
}
