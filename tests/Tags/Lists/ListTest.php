<?php
namespace Packaged\Tests\Glimpse\Tags\Lists;

use Packaged\Glimpse\Tags\Lists\ListItem;
use Packaged\Glimpse\Tags\Lists\OrderedList;
use Packaged\Glimpse\Tags\Lists\UnorderedList;

class ListTest extends \PHPUnit_Framework_TestCase
{
  public function testOrderedList()
  {
    $list = new OrderedList();
    $this->assertEquals('<ol></ol>', (string)$list);
  }

  public function testUnOrderedList()
  {
    $list = new UnorderedList();
    $this->assertEquals('<ul></ul>', (string)$list);
  }

  public function testAddItem()
  {
    $list = new UnorderedList();
    $list->addItem('One');
    $this->assertEquals('<ul> <li>One</li></ul>', (string)$list);

    $list->addItem(ListItem::create('Two'));
    $this->assertEquals('<ul> <li>One</li> <li>Two</li></ul>', (string)$list);
  }

  public function testAddItems()
  {
    $list = new UnorderedList();
    $list->addItems(['One', ListItem::create('Two')]);
    $this->assertEquals('<ul> <li>One</li> <li>Two</li></ul>', (string)$list);
  }
}
