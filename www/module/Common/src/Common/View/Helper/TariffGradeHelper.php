<?php

namespace Common\View\Helper;

use shared\classes\calculation\client\model\tariff;
use Zend\View\Helper\AbstractHelper;

/**
 * Sums up tariff grade.
 *
 * @author Michael Bergmann <michael.bergmann@check24.de>
 */
class TariffGradeHelper extends AbstractHelper
{
    /**
     * Renders the tariff grade.
     *
     * @param tariff $tariff Tariff
     *
     * @return string
     */
    public function __invoke(tariff $tariff)
    {
        $gradeText = $tariff->get_tariff_grade_name();

        return $this->getView()->render('common/tariffGrade.phtml',
            array(
                'tariff' => $tariff,
                'gradeNumber' => number_format($tariff->get_tariff_grade_result(), 1, ',', NULL),
                'gradeText' => $gradeText,
                'gradeTextClass' => $this->gradeTextClass($gradeText),
            ));
    }

    /**
     * Build the grade text class
     *
     * @param $gradeText
     * @return string
     */
    protected function gradeTextClass($gradeText)
    {
        $gradeTextClass = "gradeText golden";

        if (strlen($gradeText) > 9) {
            $gradeTextClass .= " longText";
        }

        return $gradeTextClass;
    }

}
