<?php

namespace Common\Request;

use C24\ZF2\User\Client\SsoClientInterface;
use C24\ZF2\User\Cookie\LoginCookie;
use C24\ZF2\User\Model\C24LoginUser;
use C24\ZF2\User\Model\C24LoginUserSession;
use c24login\apiclient\client\exception\SessionExpired;
use Zend\Hydrator\ClassMethods;

/**
 * Trait with mocks for user authentication.
 *
 * @author  Markus Lommer <markus.lommer@check24.de>
 * @package Common\Request
 */
trait AuthenticationMockTrait
{
    /**
     * @var string
     */
    protected $USER_STATE_USER_WITH_TOKEN = 'user_with_token';

    /**
     * @var string
     */
    protected $USER_STATE_GUEST_WITH_TOKEN = 'guest_with_token';

    /**
     * @var string
     */
    protected $USER_STATE_EXPIRED_WITH_TOKEN = 'expired_with_token';

    /**
     * @var string
     */
    protected $USER_STATE_GUEST_NO_TOKEN = 'guest_no_token';

    /**
     * @var string
     */
    protected $MOCK_USER_ID = '40326823';

    /**
     * @param string $userState
     */
    protected function mockUserAuthentication($userState)
    {
        $this->mockSsoClientInterface($userState);

        $this->mockLoginCookieService($userState);
    }

    /**
     * @param string $userState
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSsoClientInterface($userState)
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $ssoClientMock */
        $ssoClientMock = $this->getServiceMock(
            SsoClientInterface::class,
            SsoClientInterface::class
        );

        $ssoClientMock
            ->expects($this->any())
            ->method('load')
            ->willReturn($this->getUserMock($userState));

        $ssoClientMock
            ->expects($this->any())
            ->method('initializeSession')
            ->willReturn($this->getUserSessionMock($userState));

        $this->mockSsoClientValidateMethod(
            $ssoClientMock,
            $userState
        );

        return $ssoClientMock;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $ssoClientMock
     * @param string                                   $userState
     */
    protected function mockSsoClientValidateMethod(
        \PHPUnit_Framework_MockObject_MockObject $ssoClientMock,
        $userState
    ) {
        $exceptionDataLoggedOutMock = [
            'user_email'      => 'dirk.hammer@check24.de',
            'user_logged_out' => 'yes',
        ];
        $exceptionDataExpiredMock   = [
            'user_email'      => 'dirk.hammer@check24.de',
            'user_logged_out' => 'no',
            'user_title'      => 'dr.',
            'user_gender'     => 'male',
            'user_firstname'  => 'Dirk',
            'user_surname'    => 'Hammer',
        ];

        switch ($userState) {
            case $this->USER_STATE_USER_WITH_TOKEN:
                $ssoClientMock
                    ->expects($this->any())
                    ->method('validate')
                    ->willReturn($this->getUserSessionMock($userState));
                break;
            case $this->USER_STATE_GUEST_WITH_TOKEN:
                $sessionExpiredExceptionMock = new SessionExpired();
                $sessionExpiredExceptionMock->set_data($exceptionDataLoggedOutMock);
                $ssoClientMock
                    ->expects($this->any())
                    ->method('validate')
                    ->willThrowException($sessionExpiredExceptionMock);
                break;
            case $this->USER_STATE_EXPIRED_WITH_TOKEN:
                $sessionExpiredExceptionMock = new SessionExpired();
                $sessionExpiredExceptionMock->set_data($exceptionDataExpiredMock);
                $ssoClientMock
                    ->expects($this->any())
                    ->method('validate')
                    ->willThrowException($sessionExpiredExceptionMock);
                break;
            case $this->USER_STATE_GUEST_NO_TOKEN:
            default:
        }
    }

    /**
     * @param string $userState
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockLoginCookieService($userState)
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $loginCookieMock */
        $loginCookieMock = $this->getServiceMock(
            LoginCookie::class,
            LoginCookie::class
        );

        $loginCookieMock
            ->expects($this->any())
            ->method('getValue')
            ->willReturn($this->getSessionTokenMock($userState));

        return $loginCookieMock;
    }

    /**
     * @param string $userState
     *
     * @return C24LoginUser
     */
    protected function getUserMock($userState)
    {
        switch ($userState) {
            case $this->USER_STATE_USER_WITH_TOKEN:
            case $this->USER_STATE_GUEST_WITH_TOKEN:
            case $this->USER_STATE_EXPIRED_WITH_TOKEN:
                $userData = $this->getUserDataMock($userState);
                break;
            case $this->USER_STATE_GUEST_NO_TOKEN:
                return null;
            default:
                $userData = [];
        }

        $hydrator = new ClassMethods();

        /** @var C24LoginUser $user */
        $user = $hydrator->hydrate(
            $userData,
            new C24LoginUser()
        );

        return $user;
    }

    /**
     * @param string $userState
     *
     * @return array
     */
    protected function getUserDataMock($userState)
    {
        $userDataMock               = [
            'user_id'     => $this->MOCK_USER_ID,
            'gender'      => 'male',
            'firstname'   => 'Dirk',
            'surname'     => 'Hammer',
            'prefixphone' => '',
            'birthday'    => '1974-03-05',
            'zipcode'     => '24118',
            'title'       => 'dr.',
            'phone'       => '',
            'email'       => 'dirk.hammer@check24.de',
        ];
        $exceptionDataLoggedOutMock = [
            'user_email'      => 'dirk.hammer@check24.de',
            'user_logged_out' => 'yes',
        ];
        $exceptionDataExpiredMock   = [
            'user_email'      => 'dirk.hammer@check24.de',
            'user_logged_out' => 'no',
            'user_title'      => 'dr.',
            'user_gender'     => 'male',
            'user_firstname'  => 'Dirk',
            'user_surname'    => 'Hammer',
        ];

        switch ($userState) {
            case $this->USER_STATE_USER_WITH_TOKEN:
                $data = $userDataMock;
                break;
            case $this->USER_STATE_GUEST_WITH_TOKEN:
                $data = $exceptionDataLoggedOutMock;
                break;
            case $this->USER_STATE_EXPIRED_WITH_TOKEN:
                $data = $exceptionDataExpiredMock;
                break;
            case $this->USER_STATE_GUEST_NO_TOKEN:
            default:
                $data = [];
        }

        return $data;
    }

    /**
     * @param string $userState
     *
     * @return C24LoginUserSession|null
     */
    protected function getUserSessionMock($userState)
    {
        $expiryDateTime           = new \DateTime('now +2h');
        $expiryDateTimeStringMock = $expiryDateTime->format('Y-m-d H:i:s');
        $userValidateMock         = [
            'user_id'                => $this->MOCK_USER_ID,
            'c24session_expiry_date' => $expiryDateTimeStringMock,
            'last_login_provider'    => 'check24',
        ];

        $c24SessionExpiredTokenMock = 'b8b244ddf41ae36e95bd165f0e689676';
        $expiredSessionDataMock     = [
            'c24Session' => $c24SessionExpiredTokenMock,
            'expired'    => true,
        ];

        switch ($userState) {
            case $this->USER_STATE_USER_WITH_TOKEN:
                $sessionData = $userValidateMock;
                break;
            case $this->USER_STATE_GUEST_WITH_TOKEN:
                $sessionData = $expiredSessionDataMock;
                break;
            case $this->USER_STATE_EXPIRED_WITH_TOKEN:
                $sessionData = $expiredSessionDataMock;
                break;
            case $this->USER_STATE_GUEST_NO_TOKEN:
                return null;
            default:
                $sessionData = [];
        }

        $hydrator = new ClassMethods();

        /** @var C24LoginUserSession $userSessionMock */
        $userSessionMock = $hydrator
            ->hydrate(
                $sessionData,
                new C24LoginUserSession()
            );

        return $userSessionMock;
    }

    /**
     * @param string $userState
     *
     * @return string|null
     */
    protected function getSessionTokenMock($userState)
    {
        switch ($userState) {
            case $this->USER_STATE_USER_WITH_TOKEN:
                $sessionTokenMock = 'valid_token';
                break;
            case $this->USER_STATE_GUEST_WITH_TOKEN:
                $sessionTokenMock = 'expired_token';
                break;
            case $this->USER_STATE_EXPIRED_WITH_TOKEN:
                $sessionTokenMock = 'logged_out_token';
                break;
            case $this->USER_STATE_GUEST_NO_TOKEN:
            default:
                $sessionTokenMock = null;
        }

        return $sessionTokenMock;
    }
}
