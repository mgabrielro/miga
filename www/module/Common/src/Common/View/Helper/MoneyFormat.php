<?php

namespace Common\View\Helper;

use Money\Money;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\I18n\View\Helper\CurrencyFormat;

/**
 * Class MoneyFormat
 *
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class MoneyFormat extends AbstractHelper
{
    /**
     * @var CurrencyFormat
     */
    private $currencyFormat;

    /**
     * MoneyFormat constructor.
     *
     * @param CurrencyFormat $currencyFormat
     */
    public function __construct(CurrencyFormat $currencyFormat)
    {
        $this->currencyFormat = $currencyFormat;
    }

    /**
     * Format a Money Object
     *
     * @param  Money  $money
     * @param  bool   $showDecimals
     * @param  string $locale
     * @param  string $pattern
     *
     * @return string
     */
    public function fromMoney(
        Money $money,
        $showDecimals = null,
        $locale = null,
        $pattern = null
    ) {
        $number = $money->getAmount() / 100;

        return $this->render(
            $number,
            $money->getCurrency()->getCode(),
            $showDecimals,
            $locale,
            $pattern
        );
    }

    /**
     * Formats money from float.
     *
     * @param  float  $number
     * @param  bool   $showDecimals
     * @param  string $locale
     * @param  string $pattern
     *
     * @return string
     */
    public function fromFloat($number, $showDecimals = null, $locale = null,
        $pattern = null
    ) {
        return $this->render(
            $number, null, $showDecimals, $locale, $pattern
        );
    }
    
    /**
     * @param float $number
     * @param string $currencyCode
     * @param bool $showDecimals
     * @param string $locale
     * @param string $pattern
     * @return string
     */
    public function render(
        $number,
        $currencyCode = null,
        $showDecimals = null,
        $locale = null,
        $pattern = null
    ) {
        return $this->currencyFormat->__invoke(
            $number,
            $currencyCode,
            $showDecimals,
            $locale,
            $pattern
        );
    }
}
