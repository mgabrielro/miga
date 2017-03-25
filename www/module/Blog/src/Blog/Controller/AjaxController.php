<?php

namespace Blog\Controller;

use Blog\Service\PostServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class AjaxController extends AbstractActionController
{
    /**
     * @var \Blog\Service\PostServiceInterface
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function indexAction()
    {
    }

    public function searchAction()
    {
        $request    = $this->getRequest();

        if ($request->isXmlHttpRequest()){

            if ($request->isPost()) {

                $data = $request->getPost();

                if(isset($data['term']) && !empty($data['term'])){

                    $term = trim($data['term']);

                    $posts = $this->postService->findPostByTerm($term);

                }

            }

        }

        return new JsonModel($posts);

    }

}