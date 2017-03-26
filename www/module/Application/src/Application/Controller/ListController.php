<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController
{
    public function indexAction()
    {
        echo 'inside ListController'; exit;
        return new ViewModel();
    }
}
