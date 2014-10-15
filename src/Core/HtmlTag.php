<?php
namespace Packaged\Glimpse\Core;

/**
 * Render a HTML tag in a way that treats user content as unsafe by default.
 *
 * Tag rendering has some special logic which implements security features:
 *
 *   - When rendering `<a>` tags, if the `rel` attribute is not specified, it
 *     is interpreted as `rel="noreferrer"`.
 *   - When rendering `<a>` tags, the `href` attribute may not begin with
 *     `javascript:`.
 *
 * These special cases can not be disabled.
 *
 * IMPORTANT: The `$tag` attribute and the keys of the `$attributes` array are
 * trusted blindly, and not escaped. You should not pass user data in these
 * parameters.
 *
 */
class HtmlTag implements ISafeHtmlProducer
{
  protected $_tag;
  protected $_attributes;
  protected $_content;

  public static function create()
  {
    return new static;
  }

  public static function createTag(
    $tag, array $attributes = [], $content = null
  )
  {
    $html = new static;
    $html->setTag($tag);
    $html->setAttributes($attributes);
    $html->setContent($content);
    return $html;
  }

  /**
   * The name of the tag, like `a` or `div`.
   *
   * @param $tag
   *
   * @return $this
   */
  public function setTag($tag)
  {
    $this->_tag = $tag;
    return $this;
  }

  public function getTag()
  {
    return $this->_tag;
  }

  /**
   * Array of attributes for the tag
   *
   * @param array $attributes
   *
   * @return $this
   */
  public function setAttributes(array $attributes)
  {
    $this->_attributes = $attributes;
    return $this;
  }

  public function removeAttribute($key)
  {
    unset($this->_attributes[$key]);
    return $this;
  }

  public function getAttributes()
  {
    return $this->_attributes;
  }

  /**
   * Content to put in the tag.
   *
   * @param $content
   *
   * @return $this
   */
  public function setContent($content)
  {
    $this->_content = $content;
    return $this;
  }

  public function getContent($asArray = true)
  {
    if($asArray)
    {
      return (array)$this->_content;
    }
    else if(is_array($this->_content))
    {
      return implode('', $this->_content);
    }
    return $this->_content;
  }

  public function setAttribute($key, $value)
  {
    $this->_attributes[$key] = $value;
    return $this;
  }

  public function getAttribute($key, $default = null)
  {
    return idx($this->_attributes, $key, $default);
  }

  public function hasAttribute($key)
  {
    return array_key_exists($key, $this->_attributes);
  }

  public function appendContent($content)
  {
    if(!is_array($this->_content))
    {
      $this->_content = [$this->_content];
    }
    $this->_content[] = $content;
    return $this;
  }

  public function setId($id)
  {
    return $this->setAttribute('id', $id);
  }

  public function getId()
  {
    return idx($this->_attributes, 'id');
  }

  public function addClass($class)
  {
    if(func_num_args() === 1)
    {
      return $this->_addClass($class);
    }

    foreach(func_get_args() as $class)
    {
      if(is_array($class))
      {
        foreach($class as $c)
        {
          $this->_addClass($c);
        }
      }
      else
      {
        $this->_addClass($class);
      }
    }
    return $this;
  }

  protected function _addClass($class)
  {
    if(!isset($this->_attributes['class']))
    {
      $this->_attributes['class'] = [];
    }
    $this->_attributes['class'][$class] = $class;
    return $this;
  }

  public function hasClass($class)
  {
    return isset($this->_attributes['class'][$class]);
  }

  public function removeClass($class)
  {
    unset($this->_attributes['class'][$class]);
    return $this;
  }

  public function getClasses()
  {
    return (array)idx($this->_attributes, 'class', []);
  }

  /**
   * @return SafeHtml|SafeHtml[]
   * @throws \Exception
   */
  public function produceSafeHTML()
  {
    // If the `href` attribute is present:
    //   - make sure it is not a "javascript:" URI. We never permit these.
    //   - if the tag is an `<a>` and the link is to some foreign resource,
    //     add `rel="nofollow"` by default.
    if(!empty($this->_attributes['href']))
    {

      // This might be a URI object, so cast it to a string.
      $href = (string)$this->_attributes['href'];

      if(isset($href[0]))
      {
        $isAnchorHref = ($href[0] == '#');

        // Is this a link to a resource on the same domain? The second part of
        // this excludes "///evil.com/" protocol-relative hrefs.
        $isDomainHref = ($href[0] == '/') && (!isset($href[1]) || $href[1] != '/');

        // Block 'javascript:' hrefs at the tag level: no well-designed
        // application should ever use them, and they are a potent attack vector.

        // This function is deep in the core and performance sensitive, so we're
        // doing a cheap version of this test first to avoid calling preg_match()
        // on URIs which begin with '/' or `#`. These cover essentially all URIs
        // in Phabricator.
        if(!$isAnchorHref && !$isDomainHref)
        {
          // Chrome 33 and IE 11 both interpret "javascript\n:" as a Javascript
          // URI, and all browsers interpret "  javascript:" as a Javascript URI,
          // so be aggressive about looking for "javascript:" in the initial
          // section of the string.

          $normalizedHref = preg_replace('([^a-z0-9/:]+)i', '', $href);
          if(preg_match('/^javascript:/i', $normalizedHref))
          {
            throw new \Exception(
              "Attempting to render a tag with an 'href' attribute that " .
              "begins with 'javascript:'. This is either a serious security " .
              "concern or a serious architecture concern. Seek urgent " .
              "remedy."
            );
          }
        }
      }
    }

    // For tags which can't self-close, treat null as the empty string -- for
    // example, always render `<div></div>`, never `<div />`.
    $selfClosingTags = [
      'area'    => true,
      'base'    => true,
      'br'      => true,
      'col'     => true,
      'command' => true,
      'embed'   => true,
      'frame'   => true,
      'hr'      => true,
      'img'     => true,
      'input'   => true,
      'keygen'  => true,
      'link'    => true,
      'meta'    => true,
      'param'   => true,
      'source'  => true,
      'track'   => true,
      'wbr'     => true,
    ];

    $attrString = '';
    foreach($this->_attributes as $k => $v)
    {
      if($v !== null)
      {
        $attrString .= ' ' . $k . '="' . SafeHtml::escape($v) . '"';
      }
      else
      {
        $attrString .= ' ' . $k;
      }
    }

    if($this->_content === null)
    {
      if(isset($selfClosingTags[$this->_tag]))
      {
        return new SafeHtml('<' . $this->_tag . $attrString . ' />');
      }
      $this->_content = '';
    }
    else
    {
      $this->_content = SafeHtml::escape($this->_content);
    }

    return new SafeHtml(
      '<' . $this->_tag . $attrString . '>' . $this->_content . '</' . $this->_tag . '>'
    );
  }

  public function __toString()
  {
    try
    {
      return $this->asHtml();
    }
    catch(\Exception $e)
    {
      return $e->getMessage() . '<br/>' . nl2br($e->getTraceAsString());
    }
  }

  public function asHtml()
  {
    return (string)$this->produceSafeHTML();
  }
}
