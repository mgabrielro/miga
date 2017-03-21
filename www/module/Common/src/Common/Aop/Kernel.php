<?php

namespace Common\Aop;

use Common\Aop\Aspect\Cache\Feedback;
use Common\Aop\Aspect\Logging\ClientRequest;
use Go\Aop\Features;
use Go\Core\AspectContainer;
use Go\Core\AspectKernel;
use Go\Instrument\ClassLoading\AopComposerLoader;
use Go\Instrument\ClassLoading\SourceTransformingLoader;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Kernel
 *
 * @package Common\Aop
 * @author Alexander Roddis <alexander.roddis@check24.de>
 */
class Kernel extends AspectKernel implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * @param array $options
     *
     * @return void
     */
    public function init(array $options = array())
    {
        static $did_already_run = FALSE;

        // run function only once
        if ($did_already_run) {
            return;
        }

        $this->options = $this->normalizeOptions($options);
        define('AOP_CACHE_DIR', $this->options['cacheDir']);

        /** @var $container AspectContainer */
        $container = $this->container = new $this->options['containerClass'];
        $container->set('kernel', $this);
        $container->set('kernel.interceptFunctions', $this->hasFeature(Features::INTERCEPT_FUNCTIONS));
        $container->set('kernel.options', $this->options);

        SourceTransformingLoader::register();

        $did_already_run = TRUE;
    }

    /**
     *
     * @return void
     */
    public function lazyInit()
    {
        static $did_already_run = FALSE;

        if ($did_already_run) {
            return;
        }

        $container = $this->container;

        foreach ($this->registerTransformers() as $sourceTransformer) {
            SourceTransformingLoader::addTransformer($sourceTransformer);
        }

        // Register kernel resources in the container for debug mode
        if ($this->options['debug']) {
            $this->addKernelResourcesToContainer($container);
        }

        AopComposerLoader::init();

        // Register all AOP configuration in the container
        $this->configureAop($container);

        // register aspects from aspect manager
        $this->registerAspectServices($container);

        $did_already_run = TRUE;
    }

    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
        // some configuration stuff goes here
    }

    /**
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function registerAspectServices(AspectContainer $container)
    {
        /** @var AspectManager $am */
        $am = $this->getServiceLocator()->get('AspectManager');

        $registeredAspects = $am->getRegisteredServices()['factories'];

        foreach($registeredAspects as $aspectServiceKey) {
            $container->registerAspect($am->get($aspectServiceKey));
        }
    }
}