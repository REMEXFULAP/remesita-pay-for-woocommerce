<?php
/*
 * *****************************************************************************
 *   This file is part of the QvaPay package.
 *
 *   (c) Rafael Santos <raf.rsr@gmail.com>
 *
 *   For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 * ****************************************************************************
 */

defined('ABSPATH') || exit;
return [
    'enabled' =>  [
        'title'       => __('Habilitar/Deshabilitar', 'text-domain'),
        'label'       => __('Habilita pagos con RemesitaPay', 'text-domain'),
        'type'        => 'checkbox',
        'description' => '',
        'default'     => 'no'
    ],
    'title' => [
        'title'       => __('Título', 'text-domain'),
        'type'        => 'text',
        'description' => __('Este es el titulo que ve tu cliente al seleccionar la forma de pago.', 'text-domain'),
        'default'     => 'RemesitaPay',
        'desc_tip'    => true
    ],
    'description' => [
        'title' => __('Descripción', 'text-domain'),
        'type'        => 'textarea',
        'description' => __('Descripcion de la forma de pago presentada al cliente', 'text-domain'),
        'default'     => __('Paga con tu Wallet o saldo de tu Tarjeta Remesita.', 'text-domain'),
    ],
    'information_section1' => [
        'title'       => '<hr><h1>' . __('Datos de Integración', 'text-domain') . '</h1>',
        'type'        => 'title',
    ],
    'business_unit_id' => [
        'title'        => __('ID de negocio en Remesita', 'text-domain'),
        'type'         => 'text'
    ],
    'api_key' => [
        'title'       => 'API Key',
        'type'        => 'text'
    ],
    'api_secret' => [
        'title'       => 'API Secret',
        'type'        => 'text'
    ],
    'ipn_hash' => [
        'title'       => 'IPN HASH',
        'type'        => 'text',
        'description' => __('Este hash se usará como parate de la url de callback a donde remesita enviará la data de el pago en segundo plano.', 'text-domain'),
        'default'     => md5(microtime())

    ],

    'information_section2' => [
        'title'       => '<hr><h1>' . __('Prueba tu integración', 'text-domain') . '</h1>',
        'type'        => 'title',
    ],
   /* 'test-data_info' =>   [
        'title'       => '<div style="padding:10px;border:1px solid gray;border-radius:10px;display:block;margin-top:20px"><ul><li>' . __('Simula un pago completado con la tarjeta:', 'text-domain') . ' <b>4242424242424242</b> ✅</li><li>' . __('Simula un pago cancelado con la tarjeta:', 'text-domain') . ' <b>4000056655665556</b> 🚫</li></ul></div>',
        'type'        => 'title',
         
    ],*/
    'sandbox' => [
        'title'       => __('Modo de Pruebas', 'text-domain'),
        'label'       => __('Activa modo de pruebas y testea tu integración.', 'text-domain'),
        'type'        => 'checkbox',
        'description' => '<b style="color:red">' . __('Ten en cuenta que en modo prueba no se aceptan pagos reales y viceversa', 'text-domain') . '</b>',
        'default'     => 'no'
    ],
    'debug' => [
        'title'       => __('Modo de desarrollador', 'text-domain'),
        'label'       => __('Activa esta casilla para se activen los logs', 'text-domain'),
        'type'        => 'checkbox',
        'description' => '',
        'default'     => 'no'
    ],
    'webhook_store' => [
        'title'       => __('Almacenar logs de los Webhook', 'text-domain'),
        'label'       => __('Activa esta casilla y en cada pedido se almacenara como nota el Payload de los Webhook enviados por Remesita en segundo plano', 'text-domain'),
        'type'        => 'checkbox',
        'description' => '',
        'default'     => 'no'
    ]

];
