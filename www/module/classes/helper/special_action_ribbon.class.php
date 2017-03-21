<?php

namespace classes\helper;

use Zend\View\Helper\AbstractHelper;

    /**
     * Class special_action_ribbon
     * 
     * @author Jaha Deliu <jaha.deliu@check24.de>
     */
    class special_action_ribbon extends AbstractHelper {

        protected $active_to = '2015-11-15 23:59';
        protected $active_from = '2015-10-15 00:00';

        /**
         * Invokes current method
         *
         * @return mixed
         */
        public function __invoke() {
            return $this;
        }

        /**
         * Checks by date if the current action is active
         *
         * @return bool
         */
        public function is_active() {

            if (time() >= strtotime($this->get_active_from()) && time() <= strtotime($this->get_active_to())) {
                return true;
            }

            return false;

        }

        /**
         * Returns the current valid to date string
         *
         * @return string
         */
        public function get_active_to() {
            return $this->active_to;
        }

        /**
         * Returns the current valid from date string
         *
         * @return string
         */
        public function get_active_from() {
            return $this->active_from;
        }

        /**
         * Renders the ribbon
         *
         * @return string
         */
        public function render_ribbon() {

            if ($this->is_active()) {
                return $this->view->render('common/special_action_ribbon.phtml');
            } else {
                return '';
            }

        }

        /**
         * Renders the ribbon container
         *
         * @return string
         */
        public function render_container($with_section = false) {

            if ($this->is_active()) {
                return $this->view->render('common/special_action_ribbon_container.phtml', ['with_section' => $with_section]);
            } else {
                return '';
            }

        }

    }