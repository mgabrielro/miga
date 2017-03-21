<?php

namespace Common\View\Helper;

use C24\ZF2\Tracking\Service\TrackingEnabledService;
use Common\Service\VisualWebOptimizer;
use Zend\Config\Config;
use Zend\View\Helper\AbstractHelper;

/**
 * VisualWebOptimizer view helper
 *
 * @package Common\View\Helper
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class VisualWebOptimizerHelper extends AbstractHelper
{
    /**
     * @var string The template path
     */
    protected $templatePath = 'common/marketing/visualweboptimizer.phtml';

    /**
     * @var TrackingEnabledService
     */
    protected $trackingEnabledService;

    /**
     * @var VisualWebOptimizer
     */
    protected $visualWebOptimizer;

    /**
     * @param TrackingEnabledService $trackingEnabledService
     * @param VisualWebOptimizer $visualWebOptimizer
     */
    public function __construct(
        TrackingEnabledService $trackingEnabledService,
        VisualWebOptimizer $visualWebOptimizer
    ) {
        $this->setTrackingEnabledService($trackingEnabledService);
        $this->setVisualWebOptimizer($visualWebOptimizer);
    }


    /**
     * @param Config $vwoConfig
     * @return string
     */
    public function __invoke(Config $vwoConfig)
    {
        return $this->render($vwoConfig);
    }

    /**
     * @param Config $vwoConfig
     * @return string
     */
    public function render(Config $vwoConfig)
    {
        if (!$this->shouldRender()) {
            return '';
        }

        return $this->getView()->render($this->templatePath, [
            'vwoAccountID'          => $vwoConfig->accountId,
            'vwoSettingsTolerance'  => $vwoConfig->settingsTolerance,
            'vwoLibaryTolerance'    => $vwoConfig->libraryTolerance,
        ]);
    }

    /**
     *
     * @return bool
     */
    protected function shouldRender()
    {
        return (
            $this->getTrackingEnabledService()->isEnabled()
            && $this->getVisualWebOptimizer()->isEnabled()
        );
    }

    /**
     * @return TrackingEnabledService
     */
    public function getTrackingEnabledService()
    {
        return $this->trackingEnabledService;
    }

    /**
     * @param TrackingEnabledService $trackingEnabledService
     *
     * @return VisualWebOptimizerHelper
     */
    public function setTrackingEnabledService(TrackingEnabledService $trackingEnabledService)
    {
        $this->trackingEnabledService = $trackingEnabledService;

        return $this;
    }

    /**
     * @return VisualWebOptimizer
     */
    public function getVisualWebOptimizer()
    {
        return $this->visualWebOptimizer;
    }

    /**
     * @param VisualWebOptimizer $visualWebOptimizer
     *
     * @return VisualWebOptimizerHelper
     */
    public function setVisualWebOptimizer(VisualWebOptimizer$visualWebOptimizer)
    {
        $this->visualWebOptimizer = $visualWebOptimizer;

        return $this;
    }

}