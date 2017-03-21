<?php

namespace Common\Validator;

use Zend\Validator\Exception\InvalidArgumentException;

/**
 * Class Check
 *
 * Each Method throws an Error if Validation failed.
 *
 * @package Common\Validator
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Check
{
    /**
     * Checks if a variable is an integer. Casts it to integer
     *
     * @param integer &$value Variable
     * @param string $name Name of variable, for error output
     * @param boolean $zero_allowed True: 0 is allowed, false: 0 is not allowed
     * @param integer $min Minimum value allowed
     * @param integer $max Maximum value allowed
     * @param array|NULL $allowed Allowed values
     * @return void
     */
    public static function is_integer(&$value, $name, $zero_allowed = false, $min = NULL, $max = NULL, $allowed = NULL) {

        $ok = (is_int($value));

        if (!$ok && is_float($value)) {
            $ok = $value === (float)(int)$value;
        }

        if (!$ok && is_string($value)) {
            $ok = ($value === '' || $value === (string)(int)$value || ltrim($value, '0+') === (string)(int)$value);
        }

        if (!$ok) {
            throw new InvalidArgumentException('$' . $name . ' must be an integer ($value = ' . $value . ')');
        }

        $value = (int)$value;

        if ($zero_allowed != true && $value == 0) {
            throw new InvalidArgumentException('$' . $name . ' must be integer and is not allowed to be zero ($value = ' . $value . ')');
        }

        if ($min !== NULL && $value < $min) {
            throw new InvalidArgumentException('$' . $name . ' is below the allowed minimum of ' . $min);
        }

        if ($max !== NULL && $value > $max) {
            throw new InvalidArgumentException('$' . $name . ' is above the allowed maximum of ' . $max);
        }

        if ($allowed !== NULL && !in_array($value, $allowed)) {
            throw new InvalidArgumentException('$' . $name . ' is not in allowed list');
        }

    }

    /**
     * checks if value is a string
     *
     * @param string $value The value to validate
     * @param string $name Name of variable, for error output
     * @param boolean $empty_allowed True: string can be empty (""), false: must not be empty
     * @param array $allowed_values Array with allowed values
     * @param array $disallowed_values Array with disallowed values
     * @return void
     */
    public static function is_string($value, $name, $empty_allowed = false, array $allowed_values = NULL, array $disallowed_values = NULL)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('$' . $name . ' must be a string');
        }

        if (!$empty_allowed) {
            self::not_empty($value, $name);
        }

        if (is_array($allowed_values) && in_array($value, $allowed_values) == false) {
            throw new InvalidArgumentException('$' . $name . ' value is "' . $value . '" which is not among the allowed values (' . implode(',', $allowed_values) . ')');
        }

        if (is_array($disallowed_values) && in_array($value, $disallowed_values) == true) {
            throw new InvalidArgumentException('$' . $name . ' value is "' . $value . '" which is among the disallowed values (' . implode(',', $disallowed_values) . ')');
        }
    }

    /**
     * Checks if the variable is boolean
     *
     * @param boolean $value Variable
     * @param string $name  Name of the variable, for error output
     * @return void
     */
    public static function is_boolean($value, $name)
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException('$' . $name . ' must be boolean');
        }
    }

    /**
     * Checks if a variable is a array
     *
     * @param array $value Variable
     * @param string $name Name of variable, for error output
     * @param boolean $empty_allowed True: array can be empty, false: must not be empty
     * @return void
     */
    public static function is_array($value, $name, $empty_allowed = false)
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('$' . $name . ' must be an array');
        }

        if (!$empty_allowed) {
            self::not_empty($value, $name);
        }
    }

    /**
     * Checks if the variable is boolean
     *
     * @param object $value Variable
     * @param string $name Name of the variable, for error output
     * @param boolean $nullable Allow object null values
     * @return void
     */
    public static function is_object($value, $name, $nullable = false)
    {
        if ($value === NULL && $nullable == false) {
            throw new InvalidArgumentException('$' . $name . ' must be not null');
        } else if ($value !== NULL && !is_object($value)) {
            throw new InvalidArgumentException('$' . $name . ' must be an object');
        }
    }



    /**
     * Checks if a variable is an float. Casts it into float
     *
     * @param float &$value Variable
     * @param string $name Name of variable, for error output
     * @param boolean $zero_allowed True: 0 is allowed, false: 0 is not allowed
     * @param integer $min Minimum value allowed
     * @param integer $max Maximum value allowed
     * @return void
     */
    public static function is_float(&$value, $name, $zero_allowed = false, $min = NULL, $max = NULL)
    {
        if (!is_float($value) && !is_int($value))
        {
            $regex = '/^[+-]?[0-9][0-9]*(\.[0-9]*)?([Ee][+-]?[0-9][0-9]*)?$/';
            if (!is_string($value) || ($value != '' && !preg_match($regex, $value))) {
                throw new InvalidArgumentException('$' . $name . ' must be a float ($value = ' . $value . ')');
            }
        }

        $value = (float)$value;

        if ($min !== NULL) {
            $min = (float)$min;
        }

        if ($max !== NULL) {
            $max = (float)$max;
        }

        $value = (float)$value;

        if ($zero_allowed != true && $value == 0) {
            throw new InvalidArgumentException('$' . $name . ' must be a float and is not allowed to be zero ($value = ' . $value . ')');
        }

        if ($min !== NULL && $value < $min) {
            throw new InvalidArgumentException('$' . $name . ' is below the allowed minimum of ' . $min);
        }

        if ($max !== NULL && $value > $max) {
            throw new InvalidArgumentException('$' . $name . ' is above the allowed maximum of ' . $max);
        }
    }


    /**
     * Checks if a variable is a iso comliant date
     *
     * @param string $value Variable
     * @param string $name Name of variable, for error output
     * @param boolean $empty_allowed True: string can be empty (""), false: must not be empty
     * @param string $start Start
     * @param string $end End
     * @return void
     */
    public static function is_date($value, $name, $empty_allowed = false, $start = '', $end = '') {

        if ($empty_allowed != true && $value == '') {
            throw new InvalidArgumentException('$' . $name . ' must not be empty');
        }

        if ($value == '') {
            return;
        }

        $_value = strtotime($value);

        if ($_value === false) {
            throw new InvalidArgumentException('$' . $name . ' must be a valid date format');
        }

        if ($start != '')
        {
            $_start = strtotime($start);

            if ($_start === false) {
                throw new InvalidArgumentException('Unable to convert "' . $start . '" into a tmestamp');
            }

            if ($_value < $_start) {
                throw new InvalidArgumentException('"' . $value . '" can\'t lie behind "' . $start . '"');
            }
        }

        if ($end != '')
        {
            $_end = strtotime($end);

            if ($_end === false) {
                throw new InvalidArgumentException('Unable to convert "' . $end . '" into a tmestamp');
            }

            if ($_value > $_end) {
                throw new InvalidArgumentException('"' . $value . '" can\'t lie ahead of "' . $end . '"');
            }
        }
    }


    /**
     * Checks if a variable is a non-empty array
     *
     * @param mixed $value Variable
     * @param string $name Name of variable, for error output
     * @return void
     */
    public static function not_empty($value, $name)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('$' . $name . ' must not be empty');
        }
    }

}