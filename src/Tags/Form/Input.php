<?php
namespace Packaged\Glimpse\Tags\Form;

class Input extends AbstractFormElementTag
{
  const TYPE_BUTTON = 'button';
  const TYPE_CHECKBOX = 'checkbox';
  const TYPE_COLOR = 'color';
  const TYPE_DATE = 'date';
  const TYPE_DATETIME_LOCAL = 'datetime-local';
  const TYPE_EMAIL = 'email';
  const TYPE_FILE = 'file';
  const TYPE_HIDDEN = 'hidden';
  const TYPE_IMAGE = 'image';
  const TYPE_MONTH = 'month';
  const TYPE_NUMBER = 'number';
  const TYPE_PASSWORD = 'password';
  const TYPE_RADIO = 'radio';
  const TYPE_RANGE = 'range';
  const TYPE_RESET = 'reset';
  const TYPE_SEARCH = 'search';
  const TYPE_SUBMIT = 'submit';
  const TYPE_TEL = 'tel';
  const TYPE_TEXT = 'text';
  const TYPE_TIME = 'time';
  const TYPE_URL = 'url';
  const TYPE_WEEK = 'week';

  protected $_tag = 'input';

  public function __construct($content = null)
  {
    parent::__construct();
    $this->setContent($content);
    $this->setType(self::TYPE_TEXT);
  }

  public function setType($type)
  {
    $this->setAttribute('type', $type);
    return $this;
  }

  public function getType()
  {
    return $this->getAttribute('type');
  }

  public function setValue($value)
  {
    $this->setAttribute('value', $value);
    return $this;
  }

  public function getValue()
  {
    return $this->getAttribute('value');
  }
}
