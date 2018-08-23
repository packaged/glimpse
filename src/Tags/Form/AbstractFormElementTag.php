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

  public function setDisabled($disabled = true)
  {
    if($disabled)
    {
      $this->setAttribute('disabled', 'disabled');
    }
    else
    {
      $this->removeAttribute('disabled');
    }
    return $this;
  }

  public function isDisabled()
  {
    return $this->hasAttribute('disabled');
  }

  public function setRequired($required = true)
  {
    if($required)
    {
      $this->setAttribute('required', 'required');
    }
    else
    {
      $this->removeAttribute('required');
    }
    return $this;
  }

  public function isRequired()
  {
    return $this->hasAttribute('required');
  }

}
