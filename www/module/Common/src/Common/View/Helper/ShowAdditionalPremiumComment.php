<?php

namespace Common\View\Helper;

use Common\Calculation\Model\Parameter\OccupationGroup;
use Common\Calculation\Model\Tariff\Gkv;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ShowAdditionalPremiumComment
 *
 * @package Common\View\Helper
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class ShowAdditionalPremiumComment extends AbstractHelper
{
    /**
     * @param Gkv $tariff
     * @param string $occupationGroup
     *
     * @return bool
     */
    public function __invoke(Gkv $tariff, $occupationGroup)
    {
        return (
            $tariff->hasAdditionalPremiumComment()
            && $occupationGroup !== OccupationGroup::UNEMPLOYMENT_BENEFIT_2
        );
    }
}