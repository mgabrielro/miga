<?php

namespace Common\Listener;

use Zend\Mvc\MvcEvent;
use Zend\Console\Request as ConsoleRequest;

/**
 * Handle Routing Events like Redirects or Error Handling
 *
 * Class RouteListener
 * @package Common\Listener
 */
class RouteListener
{

    /**
     * Adjusts the request path with trailing slash if missing.
     *
     * @param MvcEvent $event MvcEvent
     * @return NULL|\Zend\Http\PhpEnvironment\Response
     */
    public function onRoute(MvcEvent $event)
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();

        if ($request instanceof ConsoleRequest) {
            return NULL;
        }

        $routematch = $event->getRouter()->match($event->getRequest());

        // We are checking for an existing route match.
        // This happens if you have added a valid route inside module.config.php
        // and the request will hit that entry.
        // In that case we don't want to change the request uri so we continue with
        // standard Z2 behavior.

        if ($routematch !== NULL) {
            return NULL;
        }

        /** @var \Zend\Http\PhpEnvironment\Response $response */
        $response = $event->getResponse();
        $uri = $request->getUri();

        $path = $uri->getPath();

        // Check if user maybe requested a controller without trailing slash
        // just append it right away.

        if (substr($path, -1) != "/") {
            $path .= '/';
        }

        // If we have changed the requested path by
        // adding trailing slash or changed the path completely
        // we need to redirect the user to this changed path.

        if ($uri->getPath() !== $path)
        {
            // Due to the fact that we could have query params in the url
            // we need to append them after we have our redirect target.

            if ($uri->getQuery()) {
                $path .= '?' . $uri->getQuery();
            }

            $response->setStatusCode(302);
            $response->getHeaders()->addHeaderLine('Location', $path);

            return $response;
        }

        // This is the default behavior for non matching routes.
        // It will only happen if the user requested an url which matches all criteria
        // (having trailing slash, and not root path)
        // so the user requested a non existent page and he will get a "404 Page not found"

        // @ToDo: Add Error handling and catch the url that was called. This case should never happen.

        $response->setStatuscode(404);
    }
}