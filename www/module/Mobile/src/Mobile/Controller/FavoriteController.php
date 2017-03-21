<?php

namespace Mobile\Controller;

use Common\Controller\BaseController;
use Check24\Piwik\CustomVariable as PiwikCustomVariable;

/**
 * Class FavoriteController
 *
 * @package Mobile\Controller
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class FavoriteController extends MainController
{

    /**
     * Favorite page
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()  {

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        // Referrer
        $this->handleReferrer($request);

        // Handle pkvfavorites COOKIE
        $this->handlePkvfavoritesMobile();

        // Set generic layout variables
        $this->assignGenericParameter();

        // Assign JS assets
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/favorite/c24.vv.pkv.favorite.js'), true);

        // Assign CSS assets
        $this->assign('common_css', $this->get_css('massets/css/common/'));
        $this->assign('result_css', $this->get_css('massets/css/result/'));
        $this->assign('favorite_css', $this->get_css('massets/css/favorite/'));

        // Assign template variables
        $this->assign('actual_page', $this->get_page_name());

        // Render the favorite page
        $status = $this->getServiceLocator()->get('classes\calculation\mclient\controller\pkv\favorite')->run();

        /** @var array $api_content */
        $api_content = $status->get_output();

        // It needs to be extended, here is just prepared - see PVPKV-3195
        $piwikCustomVariables = [
            new PiwikCustomVariable(1, 'Deviceoutput', $this->getDeviceOutput())
        ];

        return $this->getViewModel('mobile/pkv/form.phtml', [
            'result_head'          => $api_content['head'],
            'result_header_filter' => $api_content['filter'],
            'result'               => $api_content['result'],
            'result_footer'        => $api_content['footer'],
            'generaltracking'      => $this->getGeneralTracking(),
            'piwik' => [
                'page' => 'favorite',
                'vars' => $piwikCustomVariables
            ]
        ]);

    }

    /**
     * It generates a pkvfavorites_mobile token
     *
     * @return string
     */
    public static function generate_pkvfavorites_mobile_token() {
        return md5(round(microtime(true) * 1000) . uniqid('mobile', true));
    }

    /**
     * It tells us on which page we are
     *
     * @return string
     */
    protected function get_page_name() {
        return self::FAVORITE_PAGE;
    }

}