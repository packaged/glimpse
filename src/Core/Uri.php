<?php
namespace Packaged\Glimpse\Core;

use Packaged\Helpers\Arrays;
use Packaged\Helpers\ValueAs;

/**
 * Basic URI parser object.
 */
final class Uri
{
  private $protocol;
  private $user;
  private $pass;
  private $domain;
  private $port;
  private $path;
  private $query = [];
  private $fragment;

  public function __construct($uri)
  {
    $uri = (string)$uri;

    $matches = null;
    if(preg_match('(^([^/:]*://[^/]*)(\\?.*)\z)', $uri, $matches))
    {
      // If the URI is something like `idea://open?file=/path/to/file`, the
      // `parse_url()` function will parse `open?file=` as the host. This is
      // not the expected result. Break the URI into two pieces, stick a slash
      // in between them, parse that, then remove the path. See T6106.

      $parts = parse_url($matches[1] . '/' . $matches[2]);
      unset($parts['path']);
    }
    else
    {
      $parts = parse_url($uri);
    }

    // The parse_url() call will accept URIs with leading whitespace, but many
    // other tools (like git) will not. See T4913 for a specific example. If
    // the input string has leading whitespace, fail the parse.
    if($parts)
    {
      if(ltrim($uri) != $uri)
      {
        $parts = false;
      }
    }

    // NOTE: `parse_url()` is very liberal about host names; fail the parse if
    // the host looks like garbage.
    if($parts)
    {
      $host = Arrays::value($parts, 'host', '');
      if(!preg_match('/^([a-zA-Z0-9\\.\\-]*)$/', $host))
      {
        $parts = false;
      }
    }

    if(!$parts)
    {
      $parts = [];
    }

    // stringyness is to preserve API compatibility and
    // allow the tests to continue passing
    $this->setProtocol(Arrays::value($parts, 'scheme', ''));
    $this->setUser(rawurldecode(Arrays::value($parts, 'user', '')));
    $this->setPass(rawurldecode(Arrays::value($parts, 'pass', '')));
    $this->setDomain(Arrays::value($parts, 'host', ''));
    $this->setPort((string)Arrays::value($parts, 'port', ''));
    $this->setPath(Arrays::value($parts, 'path', ''));
    parse_str(Arrays::value($parts, 'query'), $this->query);
    $this->setFragment(Arrays::value($parts, 'fragment', ''));
  }

  public function __toString()
  {
    $prefix = null;
    if($this->protocol || $this->domain || $this->port)
    {
      $protocol = ValueAs::nonempty($this->protocol, 'http');

      $auth = '';
      if(strlen($this->user) && strlen($this->pass))
      {
        $auth = SafeHtml::escapeUri($this->user) . ':' .
          SafeHtml::escapeUri($this->pass) . '@';
      }
      else if(strlen($this->user))
      {
        $auth = SafeHtml::escapeUri($this->user) . '@';
      }

      if($protocol != 'javascript')
      {
        $prefix = $protocol . '://' . $auth . $this->domain;
      }
      else
      {
        $prefix = $protocol . ':';
      }
      if($this->port)
      {
        $prefix .= ':' . $this->port;
      }
    }

    if($this->query)
    {
      $query = '?' . http_build_query($this->query);
    }
    else
    {
      $query = null;
    }

    if(strlen($this->getFragment()))
    {
      $fragment = '#' . $this->getFragment();
    }
    else
    {
      $fragment = null;
    }

    return $prefix . $this->getPath() . $query . $fragment;
  }

  public function setQueryParam($key, $value)
  {
    if($value === null)
    {
      unset($this->query[$key]);
    }
    else
    {
      $this->query[$key] = $value;
    }
    return $this;
  }

  public function setQueryParams(array $params)
  {
    $this->query = $params;
    return $this;
  }

  public function getQueryParams()
  {
    return $this->query;
  }

  public function setProtocol($protocol)
  {
    $this->protocol = $protocol;
    return $this;
  }

  public function getProtocol()
  {
    return $this->protocol;
  }

  public function setDomain($domain)
  {
    $this->domain = $domain;
    return $this;
  }

  public function getDomain()
  {
    return $this->domain;
  }

  public function setPort($port)
  {
    $this->port = $port;
    return $this;
  }

  public function getPort()
  {
    return $this->port;
  }

  public function setPath($path)
  {
    if($this->domain && strlen($path) && $path[0] !== '/')
    {
      $path = '/' . $path;
    }
    $this->path = $path;
    return $this;
  }

  public function appendPath($path)
  {
    $first = strlen($path) ? $path[0] : null;
    $last = strlen($this->path) ? $this->path[strlen($this->path) - 1] : null;

    if(!$this->path)
    {
      return $this->setPath($path);
    }
    else if($first === '/' && $last === '/')
    {
      $path = substr($path, 1);
    }
    else if($first !== '/' && $last !== '/')
    {
      $path = '/' . $path;
    }

    $this->path .= $path;
    return $this;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function setFragment($fragment)
  {
    $this->fragment = $fragment;
    return $this;
  }

  public function getFragment()
  {
    return $this->fragment;
  }

  public function setUser($user)
  {
    $this->user = $user;
    return $this;
  }

  public function getUser()
  {
    return $this->user;
  }

  public function setPass($pass)
  {
    $this->pass = $pass;
    return $this;
  }

  public function getPass()
  {
    return $this->pass;
  }
}
