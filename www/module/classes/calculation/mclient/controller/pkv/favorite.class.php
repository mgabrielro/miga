<?php

namespace classes\calculation\mclient\controller\pkv;

use shared\classes\calculation\client AS shared_client;

/**
 * Favorite render class
 *
 * @author Gabriel Mandu <gabriel.mandu@check24.de>
 */
class favorite extends shared_client\controller\base {

    const DEFAULT_CONTROLLER = 'favorite';

    /**
     * Run
     *
     * @return shared_client\controllerstatus
     */
    public function run() {

        $status = '';
        $output = '';

        $view = $this->create_view();

        $response = $this->get_client()->get_favorites();

        if (empty($response['data'])) {

            $status = 0;

            $output['result']     = $view->render('pv/error.php');
            $output['filter']     = '';
            $output['footer']     = '';
            $output['head']       = '';
            $output['back_link']  = $this->get_client()->get_link('form');   // To be adapted as we need it
            $output['head_title'] = 'Merkzettel';

        } else {

            $status = 1;

            $view->has_favorites    = $response['data']['has_favorites'];
            $view->count_favorites  = $response['data']['count_favorites'];
            $view->favorites_groups = !empty($response['data']['groups']) ? $response['data']['groups'] : [];
            $view->is_favorite_page = !empty($response['data']['groups']) ? $response['data']['groups'] : [];
            $view->deviceoutput     = $this->get_client()->get_deviceoutput();
            $view->backlink_url     = '/pkv/benutzereingaben/';

            $output['filter']       = '';
            $output['footer']       = '';
            $output['head']         = '';
            $output['result']       = $view->render('default/pkv/favorite.php');
            $output['back_link']    = $this->get_client()->get_link('form');     // To be adapted as we need it
            $output['head_title']   = 'PKV - Versicherung';

        }

        return new shared_client\controllerstatus($status, $output);

    }
    
}
