<?php
namespace Common\View\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver as ViewResolver;

/**
 * Configures the view template path stack
 *
 * All non-active applications are excluded from rendering
 *
 * @author Robert Curth <robert.curth@check24.de>
 */
class ViewTemplatePathStackFactory implements FactoryInterface
{
    /**
     * Create the template path stack view resolver
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ViewResolver\TemplatePathStack
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $templatePathStack = new ViewResolver\TemplatePathStack();
        $templatePathStack->addPaths(
            $this->getViewPaths($serviceLocator)
        );

        return $templatePathStack;
    }


    /**
     * Returns the stack of view paths for the app
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    protected function getViewPaths(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Config');

        $inactive_apps = $this->getInactiveApps($config);
        $paths = $this->getTemplatePathStack($config);

        foreach ($paths as $key => $path) {
            foreach($inactive_apps as $module) {
                if (strpos($path, $module) !== false) {
                    $path = $paths[$key];

                    /**
                     * Place template last in order to use inactive apps as a fallback only
                     */
                    unset($paths[$key]);
                    array_unshift($paths, $path);
                }
            }
        }
        return $paths;
    }

    /**
     * Get the default template path stack
     *
     * @param $config
     *
     * @return array
     */
    protected function getTemplatePathStack($config) {
        return isset($config['view_manager']['template_path_stack']) ? $config['view_manager']['template_path_stack'] : [];
    }

    /**
     * Retrieve a list with all inactive apps
     * @param $config
     *
     * @return array
     */
    protected function getInactiveApps($config) {
        $current_app = $config['check24']['current_application'];

        $inactive_apps = array_diff($config['check24']['applications'], [$current_app]);
        return $inactive_apps;
    }
}
