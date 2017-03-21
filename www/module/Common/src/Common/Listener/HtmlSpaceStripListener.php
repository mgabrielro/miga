<?php

namespace Common\Listener;

use Common\Formatter\HtmlSpaceStrip;
use Zend\Mvc\MvcEvent;

/**
 * Class HtmlSpaceStripListener
 *
 * @package Common\Listener
 * @author Alexander Roddis <alexander.roddis@check24.de>
 */
class HtmlSpaceStripListener
{
    /**
     * strop
     *
     * @param MvcEvent $e
     * @return void
     */
    public function strip(MvcEvent $e)
    {
        $e->getResponse()->setContent(
            (string) new HtmlSpaceStrip($e->getResponse()->getContent())
        );
    }
}