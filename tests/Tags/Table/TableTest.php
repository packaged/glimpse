<?php
namespace Packaged\Tests\Glimpse\Tags\Table;

use Packaged\Glimpse\Tags\Table\Table;
use Packaged\Glimpse\Tags\Table\TableCell;
use Packaged\Glimpse\Tags\Table\TableRow;
use Packaged\Glimpse\Tags\Text\Paragraph;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
  public function testTable()
  {
    $table = Table::create(Paragraph::create('paragraph'));
    $this->assertEquals('<table><tbody><p>paragraph</p></tbody></table>', $table->produceSafeHTML()->getContent());

    $table = Table::create(TableRow::collection([TableCell::collection(['test1', 'test2'])]));

    $this->assertEquals(
      '<table><tbody><tr><td>test1</td><td>test2</td></tr></tbody></table>',
      $table->produceSafeHTML()->getContent()
    );

    $tbl = Table::create();
    $tbl->addRow("test1", "test2");
    $this->assertEquals(
      '<table><tbody><tr><td>test1</td><td>test2</td></tr></tbody></table>',
      $tbl->produceSafeHTML()->getContent()
    );

    $tbl = Table::create()
      ->addRow("test1", "test2")
      ->addHeaderRow('col1', 'col2')
      ->addFooterRow(Paragraph::create('footer'));

    $this->assertEquals(
      '<table><thead><th>col1</th><th>col2</th></thead><tbody><tr><td>test1</td><td>test2</td></tr></tbody><tfoot><tr><td><p>footer</p></td></tr></tfoot></table>',
      $tbl->produceSafeHTML()->getContent()
    );

    $tbl = Table::create()
      ->addRows(["row1-1", "row1-2"], ['row2-1', 'row2-2'])
      ->addHeaderRow('col1', 'col2')
      ->addFooterRow(Paragraph::create('footer'));

    $this->assertEquals(
      '<table><thead><th>col1</th><th>col2</th></thead><tbody><tr><td>row1-1</td><td>row1-2</td></tr><tr><td>row2-1</td><td>row2-2</td></tr></tbody><tfoot><tr><td><p>footer</p></td></tr></tfoot></table>',
      $tbl->produceSafeHTML()->getContent()
    );
  }
}
