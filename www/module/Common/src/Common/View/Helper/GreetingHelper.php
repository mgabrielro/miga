<?php

namespace Common\View\Helper;
use Zend\View\Helper\AbstractHelper;

/**
 * Class GreetingHelper
 *
 * Set gender and surname in login popup on mobile
 * @package Common\View\Helper
 * @author Johannes Hofmockel <johannes.hofmockel@check24.de>
 */
    class GreetingHelper extends AbstractHelper
    {
        public function __invoke(array $userData)
        {
            if (empty($userData['gender']) && empty($userData['surname'])) {
                return '';
            }

            $greeting = 'Frau';

            if ($userData['gender'] == 'male') {
                $greeting = 'Herr';
            }

            return $greeting . ' ' . $userData['surname'];
        }
    }
