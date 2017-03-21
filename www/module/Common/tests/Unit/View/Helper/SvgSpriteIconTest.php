<?php

namespace Common\Unit\View\Helper;

use Common\View\Helper\SvgSpriteIcon;

/**
 * Class SvgSpriteIconTest
 *
 * @package Common\Unit\View\Helper
 * @author  Markus Lommer <markus.lommer@check24.de>
 */
class SvgSpriteIconTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const CACHE_BUSTING_KEY_MOCK = 'cAcHeBuStEr';

    /**
     * @var string
     */
    const SVG_SPRITE_PATH = '/svg/sprite/path/sprite.svg';

    /**
     * @test
     * @dataProvider validParameterProvider
     *
     * @param string $fragmentInput
     * @param array  $classesInput
     * @param string $expectedResultType
     * @param string $expectedResultValue
     */
    public function itTestsOutput(
        $fragmentInput,
        $classesInput,
        $expectedResultType,
        $expectedResultValue
    ) {
        $helper = new SvgSpriteIcon(
            static::CACHE_BUSTING_KEY_MOCK,
            static::SVG_SPRITE_PATH
        );

        $helperOutput = $helper($fragmentInput, $classesInput);

        $this->assertNotEmpty($helperOutput, 'result of invocation should not be empty');
        $this->assertInternalType($expectedResultType, $helperOutput);
        $this->assertEquals($expectedResultValue, $helperOutput);
    }

    /**
     * @return array
     */
    public function validParameterProvider()
    {
        $expectedResultValue1 = <<<SVG_TAG_1
<svg class="class1 class2">
     <use xlink:href="/svg/sprite/path/sprite.svg?v=cAcHeBuStEr#svg-icon-warning"></use>
</svg>
SVG_TAG_1;

        return [
            [
                '#svg-icon-warning',
                [
                    'class1',
                    'class2',
                ],
                'string',
                $expectedResultValue1,
            ],
        ];
    }
}