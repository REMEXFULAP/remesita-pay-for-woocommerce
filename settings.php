<?php 

defined('ABSPATH') || exit;

return [
    'enabled' => [
        'title' => __('Enable/Disable', 'remesita'),
        'type' => 'checkbox',
        'label' => __('Enable Remesita Pay', 'remesita'),
        'default' => 'yes',
    ],
    'app_id' => [
        'title' => __('APP ID', 'remesita'),
        'type' => 'text',
        'default' => '',
        'required' => true,
        'desc_tip' => true,
    ],
    'app_secret' => [
        'title' => __('APP Secret', 'remesiuta'),
        'type' => 'text',
        'default' => '',
        'desc_tip' => true,
    ],
    'debug' => [
        'title' => __('Debug Errors', 'remesita'),
        'type' => 'checkbox',
        'label' => __('Enable Logs', 'remesita'),
        'default' => 'no',
        'description' => sprintf(__(
            'Save logs for all events during the payment process. <br/> May contains sensitive information and must be enabled only for debugging purposes <br/><br/> Can check your logs easily <a href="%1$s">here</a>',
            'remesita'
        ),'/wp-admin/admin.php?page=wc-status&tab=logs'),
    ],
    'webhook_hash' => [
        'title' => __('WebHook Hash', 'remesita'),
        'type' => 'string',
        'description' => __(
            'This hash is used to create a unique url for your webhook.<br/> Once configured in your Remesita application should NOT BE modified <br/> otherwise your application will stop working. <br/> We suggest use a hard to guess url in order to avoid fake requests.',
            'remesita'
        ),
        'default' => md5(get_site_url()),
        'desc_tip' => false,
    ],
];
