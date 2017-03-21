<?php


    namespace classes\tracking;

    /**
     * Abstract class base for tracking classes
     *
     * @author Stephan Eicher <stephan.eicher@check24.de>
     */
    abstract class base {

        /**
         * Renders and return the render tracking pixel (html)
         *
         * @return string
         */
        public abstract function render();

    }
