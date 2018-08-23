<?php
namespace Packaged\Glimpse\Tags\Form;

use Packaged\Glimpse\Tags\AbstractContentTag;

abstract class AbstractFormElementTag extends AbstractContentTag
{
  public function setName($name)
  {
    $this->setAttribute('name', $name);
    return $this;
  }

  public function getName()
  {
    return $this->getAttribute('name');
  }
}
