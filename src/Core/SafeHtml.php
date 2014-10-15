<?php
namespace Packaged\Glimpse\Core;

final class SafeHtml
{
  private $content;

  public function __construct($content)
  {
    $this->content = (string)$content;
  }

  public function __toString()
  {
    return $this->content;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function append($html /* , ... */)
  {
    foreach(func_get_args() as $html)
    {
      $this->content .= self::escape($html);
    }
    return $this;
  }

  public static function escape($string, $arrayGlue = ' ')
  {
    if($string instanceof SafeHtml)
    {
      return $string;
    }
    else if($string instanceof ISafeHtmlProducer)
    {
      $result = $string->produceSafeHTML();
      if($result instanceof SafeHtml)
      {
        return $result;
      }
      else if(is_array($result))
      {
        return self::escape($result, $arrayGlue);
      }
      else if($result instanceof ISafeHtmlProducer)
      {
        return self::escape($result, $arrayGlue);
      }
      else
      {
        try
        {
          assert_stringlike($result);
          return self::escape((string)$result);
        }
        catch(\Exception $ex)
        {
          $class = get_class($string);
          throw new \Exception(
            "Object (of class '{$class}') implements " .
            "ISafeHTMLProducer but did not return anything " .
            "renderable from produceSafeHTML()."
          );
        }
      }
    }
    else if(is_array($string))
    {
      return implode(
        $arrayGlue,
        array_map(['\Packaged\Glimpse\Core\SafeHtml', 'escape'], $string)
      );
    }

    return esc($string);
  }

  /**
   * Escape text for inclusion in a URI or a query parameter. Note that this
   * method does NOT escape '/', because "%2F" is invalid in paths and Apache
   * will automatically 404 the page if it's present. This will produce correct
   * (the URIs will work) and desirable (the URIs will be readable) behavior in
   * these cases:
   *
   *    '/path/?param='.phutil_escape_uri($string);         # OK: Query Parameter
   *    '/path/to/'.phutil_escape_uri($string);             # OK: URI Suffix
   *
   * It will potentially produce the WRONG behavior in this special case:
   *
   *    COUNTEREXAMPLE
   *    '/path/to/'.phutil_escape_uri($string).'/thing/';   # BAD: URI Infix
   *
   * In this case, any '/' characters in the string will not be escaped, so you
   * will not be able to distinguish between the string and the suffix (unless
   * you have more information, like you know the format of the suffix). For infix
   * URI components, use @{function:phutil_escape_uri_path_component} instead.
   *
   * @param   string $string Some string.
   *
   * @return  string  URI encoded string, except for '/'.
   */
  public static function escapeUri($string)
  {
    return str_replace('%2F', '/', rawurlencode($string));
  }

  /**
   * Escape text for inclusion as an infix URI substring. See discussion at
   * @{function:phutil_escape_uri}. This function covers an unusual special case;
   * @{function:phutil_escape_uri} is usually the correct function to use.
   *
   * This function will escape a string into a format which is safe to put into
   * a URI path and which does not contain '/' so it can be correctly parsed when
   * embedded as a URI infix component.
   *
   * However, you MUST decode the string with
   * @{function:phutil_unescape_uri_path_component} before it can be used in the
   * application.
   *
   * @param   string $string Some string.
   *
   * @return  string  URI encoded string that is safe for infix composition.
   */
  public static function escapeUriPathComponent($string)
  {
    return rawurlencode(rawurlencode($string));
  }

  /**
   * Unescape text that was escaped by
   * @{function:phutil_escape_uri_path_component}. See
   * @{function:phutil_escape_uri} for discussion.
   *
   * Note that this function is NOT the inverse of
   * @{function:phutil_escape_uri_path_component}! It undoes additional escaping
   * which is added to survive the implied unescaping performed by the webserver
   * when interpreting the request.
   *
   * @param string $string Some string emitted
   *                       from @{function:phutil_escape_uri_path_component} and
   *                       then accessed via a web server.
   *
   * @return string Original string.
   */
  public static function unescapeUriPathComponent($string)
  {
    return rawurldecode($string);
  }
}
