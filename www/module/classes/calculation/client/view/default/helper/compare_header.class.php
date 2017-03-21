<?php

    namespace shared\classes\calculation\client\view\helper;

    use \shared\classes\common\utils;

    /**
     * print icon view helper
     *
     * @author Robert Eichholtz <robert.eichholtz@check24.de>
     */
    class compare_header extends base {
        
        /**
         * @var
         */
        private $tariffs;

        /**
         * @var \Application\View\Helper\PointPlan
         */
        private $point_plan_helper;

        /**
         * Constructor
         *
         * @param \shared\classes\calculation\client\view $view View
         * @param array $tariffs The tariffs
         * @param \Application\View\Helper\PointPlan $point_plan_helper The point plan helper
         * @return void
         */
        public function __construct(\shared\classes\calculation\client\view $view, $tariffs, \Application\View\Helper\PointPlan $point_plan_helper = NULL) {

            utils::check_string($view->product_key, 'view->product_key');

            $this->tariffs = $tariffs;
            $this->point_plan_helper = $point_plan_helper;

            parent::__construct($view);

        }

        /**
         * Returns the rendered output.
         *
         * @return string
         */
        protected function create_output() {

            $this->view->tariffs = $this->tariffs;
            $this->view->point_plan = $this->point_plan_helper->render();

            return $this->view->render($this->view->product_key . '/compare_header.phtml');

        }

    }