<?php
namespace Packaged\Glimpse\Tags\Form;

use Packaged\Glimpse\Tags\AbstractContentTag;

abstract class AbstractFormElementTag extends AbstractContentTag
{
  public function setName($name)
  {
    return $this->setOrRemoveAttribute('name', $name);
  }

  public function getName()
  {
    return $this->getAttribute('name');
  }

  public function setDisabled($disabled = true)
  {
    return $this->setOrRemoveAttribute('disabled', $disabled ? 'disabled' : null);
  }

  public function isDisabled()
  {
    return $this->hasAttribute('disabled');
  }

  public function setRequired($required = true)
  {
    return $this->setOrRemoveAttribute('required', $required ? 'required' : null);
  }

  public function isRequired()
  {
    return $this->hasAttribute('required');
  }
}
