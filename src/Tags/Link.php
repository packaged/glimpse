<?php
namespace Packaged\Glimpse\Tags;

use Packaged\Glimpse\Core\HtmlTag;

class Link extends HtmlTag
{
  protected $_tag = 'a';

  public static function create($uri = null, $content = null)
  {
    return new static($uri, $content);
  }

  public function __construct($uri, $content = null)
  {
    $this->setAttribute('href', $uri);
    $this->setContent($content);
  }

  /**
   * The location specifies the URL of the page the link goes to.
   *
   * @param $uri
   *
   * @return $this
   */
  public function setLocation($uri)
  {
    return $this->setAttribute('href', $uri);
  }

  /**
   * The target attribute specifies where to open the linked document.
   *
   * @param string $target
   *
   * @return $this
   */
  public function setTarget($target = '_blank')
  {
    return $this->setAttribute('target', $target);
  }

  /**
   * Set the link to open in a new window or tab
   *
   * @return $this
   */
  public function forNewWindow()
  {
    return $this->setTarget('_blank');
  }

  /**
   * The download attribute specifies that the target will be downloaded
   * when a user clicks on the hyperlink.
   *
   * This attribute is only used if the href attribute is set.
   *
   * The value of the attribute will be the name of the downloaded file.
   * There are no restrictions on allowed values, and the browser will
   * automatically detect the correct file extension and add it to the
   * file (.img, .pdf, .txt, .html, etc.).
   *
   * If the value is omitted, the original href is used.
   *
   * @param $location
   *
   * @return $this
   */
  public function setDownload($location = null)
  {
    return $this->setAttribute('download', $location);
  }

  /**
   * The rel attribute specifies the relationship between
   * the current document and the linked document.
   *
   * Only used if the href attribute is present.
   *
   * alternate  Links to an alternate version of the document
   * author  Links to the author of the document
   * bookmark  Permanent URL used for bookmarking
   * help  Links to a help document
   * license  Links to copyright information for the document
   * next  The next document in a selection
   * nofollow  Links to an unendorsed document, like a paid link.
   * noreferrer Specifies that the browser should not send a HTTP referer header
   * prefetch  Specifies that the target document should be cached
   * prev  The previous document in a selection
   * search  Links to a search tool for the document
   * tag  A tag (keyword) for the current document
   *
   * @param string $relation
   *
   * @return $this
   */
  public function setRel($relation = 'noreferrer')
  {
    return $this->setAttribute('rel', $relation);
  }
}
