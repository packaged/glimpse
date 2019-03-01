<?php
namespace Packaged\Glimpse\Tags\Table;

use Packaged\Glimpse\Core\AbstractContainerTag;
use Packaged\Glimpse\Core\HtmlTag;

class Table extends AbstractContainerTag
{
  protected $_tag = 'table';

  protected $_header;
  protected $_footer;

  /**
   * @param mixed|TableHeading ...$headings
   *
   * @return $this
   */
  public function addHeaderRow(...$headings)
  {
    if(!$this->_header)
    {
      $this->_header = [];
    }
    $this->_header[] = TableHeading::collection($headings);
    return $this;
  }

  /**
   * @param mixed|TableCell ...$row
   *
   * @return $this
   */
  public function addRow(...$row)
  {
    $this->appendContent(TableRow::create(TableCell::collection($row)));
    return $this;
  }

  /**
   * @param mixed|TableRow[] ...$rows
   *
   * @return $this
   */
  public function addRows(...$rows)
  {
    foreach($rows as $row)
    {
      $this->addRow(...$row);
    }
    return $this;
  }

  /**
   * @param mixed|TableCell ...$row
   *
   * @return $this
   */
  public function addFooterRow(...$row)
  {
    if(!$this->_footer)
    {
      $this->_footer = [];
    }
    $this->_footer[] = TableRow::create(TableCell::collection($row));
    return $this;
  }

  protected function _prepareForProduce(): HtmlTag
  {
    $table = parent::_prepareForProduce();

    if($this->_content)
    {
      $this->_content = [TableBody::create($this->_content)];
    }

    if($this->_header)
    {
      $table->prependContent(TableHead::create($this->_header));
    }
    if($this->_footer)
    {
      $table->appendContent(TableFoot::create($this->_footer));
    }
    return $table;
  }
}
