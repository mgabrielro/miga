<?php

    /**
     * Local Configuration Override For Development
     *
     * This configuration override file is for overriding environment-specific and
     * security-sensitive configuration information. Copy this file without the
     * .dist extension at the end and populate values as needed.
     *
     * @NOTE: This file is ignored from Git by default with the .gitignore included
     * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
     * credentials from accidentally being comitted into version control.
     */

    if (php_sapi_name() == 'cli') {
        // @todo improve
        $server_name = 'miga.de';
    } else {
        $server_name = $_SERVER['SERVER_NAME'];
    }

    $project_root = realpath(getcwd() . '/../');

    // api host name
    $api_host = 'miga.de';

    // calculate cookie domain
    $cookie_domain = substr($server_name, strpos($server_name, '.'));