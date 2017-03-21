<?php

use Common\Formatter\Slugalizer;

/**
 * Class SlugalizerTest
 *
 * @author Robert Curth <robert.curth@check24.de>
 */
class SlugalizerTest extends PHPUnit_Framework_TestCase
{
    /**
     * ::slugalize() Tests
     */
    public function testItReplacesSpacesWithUnderscores()
    {
        $this->assertEquals('foo_bar', (new Slugalizer())->slugalize('foo bar'));
    }
}