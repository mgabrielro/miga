<?php

namespace Common\Register\Exception;

use Common\Exception\RemoteException;

/**
 * Class InvalidContainerIdException
 *
 * @package Common\Register\Exception
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class InvalidContainerIdException extends RemoteException
    implements RegisterExceptionInterface
{
}