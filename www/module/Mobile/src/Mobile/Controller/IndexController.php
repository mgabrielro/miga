<?php

namespace Mobile\Controller;

use Common\Controller\BaseController;

/**
 * Class IndexController
 *
 * @package Mobile\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class IndexController extends MainController
{
    /**
     * Login user
     *
     * @return \Zend\Http\Response
     */
    public function indexAction()
    {
        if ($cs_code = $this->request->getQuery('cs_code')) {
            $this->get("SessionContainer")->offsetSet('cs_code', $cs_code);
        }

        return $this->redirect()->toRoute('mobile/pkv/input1');
    }
}