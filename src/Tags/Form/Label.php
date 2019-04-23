<?php
namespace Packaged\Glimpse\Tags\Form;

use Packaged\Glimpse\Core\HtmlTag;

class Label extends HtmlTag
{
  protected $_tag = 'label';

  public static function create($content = '', $for = null)
  {
    /** @var Label $ele */
    $ele = parent::create();
    $ele->setContent($content);
    $ele->setFor($for);
    return $ele;
  }

  /**
   * @return mixed
   */
  public function getFor()
  {
    return $this->getAttribute('for');
  }

  /**
   * @param mixed $for
   *
   * @return Label
   */
  public function setFor($for)
  {
    $this->setAttribute('for', $for, true);
    return $this;
  }
}
