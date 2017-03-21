<?php

namespace Common\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Class AllValidInputFilter
 *
 * @author  Lars Lenecke <lars.lenecke@check24.de>
 * @package Common\InputFilter
 */
class AllValidInputFilter extends InputFilter
{
    /**
     * {@inheritdoc}
     *
     * @TODO: We need this input filter to just return true on validation,
     * because else it would start to try guess the validators from the field
     * definitions that are coming from the backend.
     * We do not want to validate in the frontend currently.
     */
    public function isValid() {
        return true;
    }
}
