<?php

namespace Common\Hydrator\Strategy;

use DateTime;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class DateTimeStrategy
 *
 * @package Common\Hydrator\Strategy
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class DateTimeStrategy implements StrategyInterface
{
    /**
     * @param DateTime $value
     *
     * @return string
     */
    public function extract($value)
    {
        return $value->format(DateTime::ATOM);
    }

    /**
     * When using array syntax the array key must be timestamp.
     *
     * @param string|int|array $value
     *
     * @throws \InvalidArgumentException
     * @return DateTime|null
     */
    public function hydrate($value)
    {
        if ($value === null) {
            return $value;
        }

        $dateTime = new DateTime();

        if (is_int($value)) {
            $dateTime->setTimestamp($value);
        } elseif (is_array($value)) {
            $dateTime->setTimestamp(
                $value['timestamp']
            );
        } else {
            try {
                $dateTime = new DateTime($value);
            } catch(\Exception $exception) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Given value \'%s\' is not a valid DateTime argument',
                        $value
                    )
                );
            }
        }

        if ($dateTime === false) {
            $dateTime = null;
        }

        return $dateTime;
    }
}