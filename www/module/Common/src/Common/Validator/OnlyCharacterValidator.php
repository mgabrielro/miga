<?php

namespace Common\Validator;

use Zend\Validator\Regex;

/**
 * Class OnlyCharacterValidator
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class OnlyCharacterValidator extends Regex
{
    /**
     * @var string
     */
    const INVALID_FORMAT = 'invalidFormat';

    /**
     * This is from backoffice code validation/register/name.class.php:14.
     */
    public function __construct()
    {
        parent::__construct('/[^A-Za-z- éááäöüßÄÖÜÁĂăČčÇçÄäÀàĀāĿŀĄąĊċĐđÅåŁłÃãÂâáćéǵíḱĺḿńóṕŕśúẃýźàèìǹòùẁỳâĉêĝĥîĵôŝûŵŷẑåůẘẙḓḙḽṋṱṷäëïöüÿłøőűăĕğĭŏŭȃȇȋȏȓȗãĩñõũṽỹąęįǫųǎčďĎěǧȟǐǰǩľĽňǒřšťŤǔžçģķļņŗşţȧḃċḋėḟġḣıȷŀṁṅȯṗṙṡṫẇẋẏżāēḡīōūȳḁṳȁȅȉȍȑȕḫḛḭṵạḅḍḥịḳḷṃṇọṛṣṭụṿẉỵẓḇḏẖḵḻṉṟṯẕ]/is');
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $valid = !parent::isValid($value);

        if (!$valid) {
            $this->abstractOptions['messages'] = [
                self::INVALID_FORMAT => self::INVALID_FORMAT
            ];
        }

        return $valid;
    }
}