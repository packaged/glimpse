<?php
namespace Packaged\Glimpse\Core;

interface ISafeHtmlProducer
{
  /**
   * @return SafeHtml|SafeHtml[]
   */
  public function produceSafeHTML();
}
