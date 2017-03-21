<?php

return array(
    'factories' => array(
        \classes\calculation\mclient\client::class                 => \classes\calculation\mclient\factory\client_factory::class,
        'classes\calculation\mclient\form'                         => 'classes\calculation\mclient\factory\form_factory',
        'classes\calculation\mclient\controller\pkv\form'          => 'classes\calculation\mclient\controller\pkv\factory\form_factory',
        'classes\calculation\mclient\controller\pkv\result'        => 'classes\calculation\mclient\controller\pkv\factory\result_factory',
        'classes\calculation\mclient\controller\pkv\tariff_detail' => 'classes\calculation\mclient\controller\pkv\factory\tariff_detail_factory',
        'classes\calculation\mclient\controller\pkv\favorite'      => 'classes\calculation\mclient\controller\pkv\factory\favorite_factory',
        'shared\classes\common\rs_rest_client\rs_rest_client'      => 'classes\calculation\mclient\controller\pkv\factory\rest_client_factory',
        'Mobile\Form\Form'                                         => 'Mobile\Form\FormFactory'
    ),
    'shared' => array(
        'Mobile\Form\Form' => false,
        'classes\calculation\mclient\client' => false,
        'classes\calculation\mclient\form' => false
    )
);