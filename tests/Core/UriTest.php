<?php
namespace Packaged\Tests\Glimpse\Core;

use Packaged\Glimpse\Core\Uri;
use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{
  public function testURIParsing()
  {
    $uri = new Uri('http://user:pass@host:99/path/?query=value#fragment');
    $this->assertEquals('http', $uri->getProtocol(), 'protocol');
    $this->assertEquals('user', $uri->getUser(), 'user');
    $this->assertEquals('pass', $uri->getPass(), 'pass');
    $this->assertEquals('host', $uri->getDomain(), 'domain');
    $this->assertEquals('99', $uri->getPort(), 'port');

    $this->assertEquals('/path/', $uri->getPath(), 'path');
    $this->assertEquals(
      [
        'query' => 'value',
      ],
      $uri->getQueryParams(),
      'query params'
    );
    $this->assertEquals('fragment', $uri->getFragment(), 'fragment');
    $this->assertEquals(
      'http://user:pass@host:99/path/?query=value#fragment',
      (string)$uri,
      'uri'
    );

    $uri = new Uri('ssh://git@example.com/example/example.git');
    $this->assertEquals('ssh', $uri->getProtocol(), 'protocol');
    $this->assertEquals('git', $uri->getUser(), 'user');
    $this->assertEquals('', $uri->getPass(), 'pass');
    $this->assertEquals('example.com', $uri->getDomain(), 'domain');
    $this->assertEquals('', $uri->getPort(), 'port');

    $this->assertEquals('/example/example.git', $uri->getPath(), 'path');
    $this->assertEquals([], $uri->getQueryParams(), 'query params');
    $this->assertEquals('', $uri->getFragment(), 'fragment');
    $this->assertEquals(
      'ssh://git@example.com/example/example.git',
      (string)$uri,
      'uri'
    );

    $uri = new Uri('http://0@domain.com/');
    $this->assertEquals('0', $uri->getUser());
    $this->assertEquals('http://0@domain.com/', (string)$uri);

    $uri = new Uri('http://0:0@domain.com/');
    $this->assertEquals('0', $uri->getUser());
    $this->assertEquals('0', $uri->getPass());
    $this->assertEquals('http://0:0@domain.com/', (string)$uri);

    $uri = new Uri('http://%20:%20@domain.com/');
    $this->assertEquals(' ', $uri->getUser());
    $this->assertEquals(' ', $uri->getPass());
    $this->assertEquals('http://%20:%20@domain.com/', (string)$uri);

    $uri = new Uri('http://%40:%40@domain.com/');
    $this->assertEquals('@', $uri->getUser());
    $this->assertEquals('@', $uri->getPass());
    $this->assertEquals('http://%40:%40@domain.com/', (string)$uri);
  }

  public function testURIGeneration()
  {
    $uri = new Uri('http://example.com');
    $uri->setPath('bar');
    $this->assertEquals('http://example.com/bar', $uri->__toString());
  }

  public function testStrictURIParsingOfHosts()
  {
    $uri = new Uri('http://&amp;/');
    $this->assertEquals('', $uri->getDomain());
  }

  public function testStrictURIParsingOfLeadingWhitespace()
  {
    $uri = new Uri(' http://example.com/');
    $this->assertEquals('', $uri->getDomain());
  }

  public function testAppendPath()
  {
    $uri = new Uri('http://example.com');
    $uri->appendPath('foo');
    $this->assertEquals('http://example.com/foo', $uri->__toString());
    $uri->appendPath('bar');
    $this->assertEquals('http://example.com/foo/bar', $uri->__toString());

    $uri = new Uri('http://example.com');
    $uri->appendPath('/foo/');
    $this->assertEquals('http://example.com/foo/', $uri->__toString());
    $uri->appendPath('/bar/');
    $this->assertEquals('http://example.com/foo/bar/', $uri->__toString());

    $uri = new Uri('http://example.com');
    $uri->appendPath('foo');
    $this->assertEquals('http://example.com/foo', $uri->__toString());
    $uri->appendPath('/bar/');
    $this->assertEquals('http://example.com/foo/bar/', $uri->__toString());
  }

  public function testUnusualURIs()
  {
    $uri = new Uri('file:///path/to/file');
    $this->assertEquals('file', $uri->getProtocol(), 'protocol');
    $this->assertEquals('', $uri->getDomain(), 'domain');
    $this->assertEquals('/path/to/file', $uri->getPath(), 'path');

    $uri = new Uri('idea://open?x=/');
    $this->assertEquals('idea', $uri->getProtocol(), 'protocol');
    $this->assertEquals('open', $uri->getDomain(), 'domain');
    $this->assertEquals('', $uri->getPath(), 'path');
    $this->assertEquals(
      [
        'x' => '/',
      ],
      $uri->getQueryParams()
    );
  }

  public function testQueryParams()
  {
    $uri = new Uri('http://example.com?x=y');
    $this->assertEquals(['x' => 'y'], $uri->getQueryParams());
    $uri->setQueryParam('a', 'b');
    $this->assertEquals(['x' => 'y', 'a' => 'b'], $uri->getQueryParams());
    $uri->setQueryParam('x', null);
    $this->assertEquals(['a' => 'b'], $uri->getQueryParams());
    $uri->setQueryParams(['c' => 'd']);
    $this->assertEquals(['c' => 'd'], $uri->getQueryParams());
  }
}
