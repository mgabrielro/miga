<?php

namespace Mobile\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Google Tag Manager Tracking Pixel/Script View Helper
 *
 * This view helper will render the correct
 *
 * @author Armin Beširović <armin.besirovic@check24.de>
 * @package Mobile\View\Helper
 */
class GoogleTagManager extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * Template to use to render the GTM code
     *
     * @var string
     */
    protected $template = 'partials/tracking/google-tag-manager.phtml';

    /**
     * Tag manager helper
     *
     * Will read the cookie value from WPSET (if none it has a fallback), use the provided areaId and render the partial
     * specified above.
     *
     * @param string $areaId Area ID (page name like "input1")
     * @return string Rendered code
     */
    public function __invoke($areaId,  $emarsys_key = '')
    {

        $sm = $this->getServiceLocator()->getServiceLocator();

        /** @var \Monolog\Logger $log */
        $log = $sm->get('Logger');

        /** @var \Zend\View\Helper\Partial $partialHelper */
        $partialHelper = $this->getServiceLocator()->get('partial');

        $productId = $sm->get('ZendConfig')->check24->product->id;

        try {
            /** @var \classes\wpset $wpset */
            $wpset = $this->getServiceLocator()->getServiceLocator()->get('classes\wpset');
            $pid = $wpset->get_tracking_id($productId);
        } catch (\Exception $e) {
            $log->warning('Google Tag Manager could not find WPSET tracking ID, exception message: ' . $e->getMessage());
            return '';
        }

        if (empty($pid)) {
            return '';
        }

        try {
            $output = $partialHelper($this->template, [
                'pid'    => $pid,
                'areaid' => $areaId,
                'emarsys_key' => $emarsys_key
            ]);
        } catch (\Exception $e) {
            $log->warning('Google Tag Manager could not render output, exception message: ' . $e->getMessage());
            return '';
        }

        return $output;
    }
}
