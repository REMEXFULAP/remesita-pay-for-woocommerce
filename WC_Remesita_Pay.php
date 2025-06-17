<?php
/*
 * *****************************************************************************
 *   This file is part of the RemesitaPay package.
 *
 *   (c) REMEXFULAP <info@remesita.com>
 *
 *   For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 * ****************************************************************************
 */

/**
 * RemesitaPay Payment Gateway for WooCommerce
 */
if (!class_exists('WC_Remesita_Pay')) {
    class WC_RemesitaPay_Gateway extends WC_Payment_Gateway
    {
        private $business_unit_id;
        private $api_key;
        private $api_secret;
		public static $logEnabled = false;
		public static $log = false;

        
        public function __construct()
        {
            $this->id = 'remesita-pay';  
            $this->icon = 'data:image/png;base64,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'; 
            $this->has_fields = true;  
            $this->method_title = 'RemesitaPay';
            $this->method_description = 'Acepta pagos con tu cuenta RemesitaPay'; // will be displayed on the options page

            $this->supports = array(
                'products',
                'refunds'
            );

            $this->init_form_fields();
            $this->init_settings();

            $this->title              = $this->get_option('title');
            $this->description        = $this->get_option('description');
            $this->enabled            = $this->get_option('enabled');
            $this->business_unit_id   = $this->get_option('business_unit_id');
            $this->api_key            = $this->get_option('api_key');
            $this->api_secret         = $this->get_option('api_secret');
			$this->ipn_hash           = $this->get_option('ipn_hash'); 
			
			self::$logEnabled = 'yes' === $this->get_option('debug', 'no');
			


            if (is_admin())
                add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

            add_action('wp_enqueue_scripts', array($this, 'payment_scripts')); 
            add_action('admin_notices', array($this,  'do_ssl_check')); 
            add_action('init', array($this, 'register_ipn_endpoint')); 
            add_action('woocommerce_api_remesita_pay_'.$this->ipn_hash.'_ipn', array($this, 'handle_ipn'));   
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
			
			
        }

 

        /**
         * Plugin options, we deal with it in Step 3 too
         */
        public function init_form_fields()
        {
            $this->form_fields = include __DIR__.DIRECTORY_SEPARATOR.'settings.php'; 
           
        }
        protected function nonce_name(){
            return  'remesita_pay_'.$this->ipn_hash.'_nonce';
        }

        /**
         * You will need it if you want your custom credit card form, Step 4 is about it
         */
        public function payment_fields()
        {
            wp_nonce_field('remesita_pay_nonce_action',$this->nonce_name());
            ?><b><?php echo esc_html($this->get_option('description')); ?></b><?php
        }

        public function validate_fields()
        {
            //wc_add_notice(__('Por favor, escribe una tarjeta Remesita válida', 'text-domain'), 'error');
            return true;
        }

        /*
		 * Custom CSS and JS, in most cases required only when you decided to go with a custom credit card form
		 */
        public function payment_scripts()
        {
            if (!isset($_POST[$this->nonce_name()]) || !wp_verify_nonce($_POST[$this->nonce_name()], 'remesita_pay_nonce_action')) { 
                return;
            }
            // we need JavaScript to process a token only on cart/checkout pages, right?
            if (!is_cart() && !is_checkout() && !isset($_GET['pay_for_order'])) {
                return;
            }

            // if our payment gateway is disabled, we do not have to enqueue JS too
            if ('no' === $this->enabled) {
                return;
            }

            // no reason to enqueue JavaScript if API keys are not set
            if (empty($this->api_key) || empty($this->api_key) || empty($this->business_unit_id)) {
                return;
            }

            wp_enqueue_style('remesita-pay-gateway-styles', plugins_url('assets/remesita-pay-styles.css', __FILE__),[],1,['strategy'  => 'defer']);
            wp_enqueue_script('remesita-pay-gateway-js',  plugins_url('assets/remesita-pay.js', __FILE__),[],1,['strategy'  => 'defer']);
        }


        /*
		 *  Este método procesa el pago y genera un link de pago en Remesita.com
		 */
        public function process_payment($order_id)
        {
            // Sanitize and validate order_id
            $order_id = absint($order_id);
            if (!$order_id) {
                wc_add_notice(__('ID de pedido inválido', 'text-domain'), 'error');
                return;
            }

            // Verify and sanitize nonce
            $nonce_field = $this->nonce_name();
            $nonce_value = isset($_POST[$nonce_field]) ? sanitize_text_field($_POST[$nonce_field]) : '';
            // Validar que el nonce no esté vacío, sea alfanumérico y tenga longitud típica de WordPress (10-20 caracteres)
            if (
                empty($nonce_value) ||
                !preg_match('/^[a-zA-Z0-9]+$/', $nonce_value) ||
                strlen($nonce_value) < 10 ||
                strlen($nonce_value) > 20 ||
                !wp_verify_nonce($nonce_value, 'remesita_pay_nonce_action')
            ) {
                self::log('Nonce inválido o manipulado en process_payment: ' . $nonce_value, 'error');
                wc_add_notice(__('Error de seguridad en el pago. Por favor intenta nuevamente.', 'text-domain'), 'error');
                return;
            }

            $order = wc_get_order($order_id);
            if (!$order) {
                wc_add_notice(__('No se pudo encontrar el pedido', 'text-domain'), 'error');
                return;
            }
            $data = $this->create_payment_link($order);

            if ($data) {
                $order->add_order_note(__('Payment link generated:' , 'text-domain').  ' '.$data["link"]);
				self::log(__('Payment link generated:' , 'text-domain').  ' '.$data["link"]);

                $order->update_status('pending', __('Awaiting payment', 'text-domain'));
                $order->update_meta_data('external_payment_reference', sanitize_text_field($body['reference']??""));
                $order->save();  
 
                return [
                    'result'   => 'success',
                    'redirect' => $data["link"],
                ];
            } else {
				 self::log(__('Error generando el link de pago' , 'text-domain') , 'error');
                 wc_add_notice(__('Error generando el link de pago. Inténtelo luego', 'text-domain'), 'error');
                 return array('result' => 'fail');
            }
        }
        private function getAuthToken()
        {
            $api_key = $this->get_option('api_key');
            $api_secret = $this->get_option('api_secret');
            $response = wp_remote_post('https://api.remesita.com/rest/v1/auth', [
                'body' => wp_json_encode([
                    "api_key" => $api_key,
                    "api_secret" => $api_secret
                ]),
                'headers' => array(
                    'Content-Type' => 'application/json'
                ),
            ]);
            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (!empty($body) && isset($body['accessToken'])) {
                return $body['accessToken'];
            } else {
				self::log(__('Error obteniendo los tokens de Remesita con la configuracion de apiKey y apiSecret' , 'text-domain') , 'error');
                wc_add_notice(__('No fue posible conectar con Remesita.com', 'text-domain'), 'error');
                return false;
            }
        }

        // Función personalizada para crear un enlace de pago en remesita.com
        private function create_payment_link($order)
        {
            // Obtén las configuraciones desde la base de datos utilizando `get_option`. 
            $business_unit_id = $this->get_option('business_unit_id');

            // Genera las URLs de éxito, cancelación e IPN
            $success_url = $this->get_return_url($order); // Redirigir al finalizar
            $cancel_url = wc_get_cart_url(); // Regresa al carrito en caso de cancelación
            $ipn_url = home_url('/wc-api/remesita_pay_'.$this->ipn_hash).'_ipn'; // Ajusta esta URL según tu lógica de IPN 

            $items = WC()->cart->get_cart();
            $concept = self::cleanSpecialAnPuntuations(sprintf( "%s Order No%d %d items" , trim(get_bloginfo('name')), $order->get_id(), count($items)));
           
            $data = array(
                'businessUnitId' => $business_unit_id,
                'amount' => $order->get_total(),
                'concept' => $concept,
                'ipnUrl' => $ipn_url,
                'successUrl' => $success_url,
                'cancelUrl' => $cancel_url,
                'customId' => "WP".$order->get_id(), // Usa el ID del pedido para rastreo
                "sandbox" => $this->get_option('sandbox') === 'yes' , 
                'methods' => array(
                    'PREPAIDCARDBALANCE',
                    'REMWALLET',
                ),
                'feeAssumedBy' => 'collector',
                'payerName' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                'payerPhone' => $order->get_billing_phone(),
                'payerEmail' => $order->get_billing_email()
            ); 

            $token = $this->getAuthToken();
            $url='https://api.remesita.com/rest/v1/payment-link';
            $response = wp_remote_post($url, [
                'body' => wp_json_encode($data),
                'headers' => [
                    'Content-Type' => 'application/json',
                     'Authorization' =>  $token 
                    
                ],
            ]); 
            if (is_wp_error($response)) {
				self::log( __('Error generando link de pago', 'text-domain').": " . $response->get_error_message() , 'error');
				$order->add_order_note(__('Error generando link de pago:', 'text-domain')." " . $response->get_error_message());
                return false;
            } 

            $data = @json_decode(wp_remote_retrieve_body($response), true); 

            if (isset($data['link'])) {  
                if (isset( WC()->cart)){
                    WC()->cart->empty_cart();
                }
                return $data;
            } else {
                self::log( __('Error generando link de pago', 'text-domain')  , 'error');
                $order->add_order_note(__('Error generando link de pago', 'text-domain'));
                return false;
            }
        }

        public function register_ipn_endpoint()
        {
            add_rewrite_endpoint('wc-api/remesita_pay_'.$this->ipn_hash.'_ipn', EP_ROOT);
        }

        public function handle_ipn()
        {
            // Obtén los datos enviados desde la plataforma de pago externa
            $ipn_data = file_get_contents('php://input');
            if ($ipn_data === false) {
                self::log('IPN Error: No se pudieron leer los datos de entrada', 'error');
                status_header(400);
                wp_die('No se pudieron leer los datos de entrada');
                return;
            }

            $data = json_decode($ipn_data, true);
            if (json_last_error() !== JSON_ERROR_NONE || !$data) {
                self::log('IPN Error: Datos JSON inválidos. Error: '.json_last_error_msg(), 'error');
                status_header(400);
                wp_die('Invalid JSON data');
                return;
            }

            if (empty($data['custom_id']) && empty($data['ref'])) {
                error_log('IPN Error: Datos recibidos inválidos o faltantes.');
                return;
            }

            if (empty($data['custom_id']) && !empty($data['ref'])) {
                $reference = $data['ref'];
                $orders = wc_get_orders(array('meta_key' => 'external_payment_reference', 'meta_value' => $reference));
                if (empty($orders)) {
                    error_log("IPN Error: No order found for reference {$reference}");
                    return;
                }
                $order = $orders[0];
            } else {
                // Obtén el pedido utilizando el `customId` (que coincide con el ID de pedido)
                $order_id = str_replace("WP","",sanitize_text_field($data['custom_id']));
                $order = wc_get_order($order_id);
            }


            if (!$order) {
                // Manejar el caso en el que no se encuentre el pedido
                error_log('IPN Error: No se encontró el pedido para el ID');
                return;
            }
			 
			if ($order->is_paid()) { 
                wp_die('This payment has already been completed', null, ['response' => 409]);
            }

            $status = sanitize_text_field($data['status']);
            switch ($status) {
                case 'start':
                    case 'processing':
                    $order->update_status('pending', __('El pago se ha iniciado', 'text-domain'));
                    $order->add_order_note(__('La session de pago ha sido iniciada en Remesita', 'text-domain'));
                     break;
                case 'paid':
                    $ref = isset($data['ref']) ? sanitize_text_field($data['ref']) : '';
                    $order->payment_complete($ref);
                    $order->update_meta_data('external_payment_reference', $ref);
                    //$order->update_status('completed', __('El pago se ha capturado.', 'text-domain'));
                    $order->add_order_note("✅ " . __('Pago exitoso recibido a través de IPN.', 'text-domain'));

                    $customer_name = isset($data['customer']['name']) ? sanitize_text_field($data['customer']['name']) : '';
                    $customer_phone = isset($data['customer']['phone']) ? sanitize_text_field($data['customer']['phone']) : '';
                    $customer_email = isset($data['customer']['email']) ? sanitize_email($data['customer']['email']) : '';

                    $order->add_order_note(
                        __('Datos del Pagador:', 'text-domain') .
                        '<br><div style="border-radius:5px;border:1px solid gray;display:block;padding:8px;"><b>Name: ' .
                        $customer_name . "<br>Phone: " . $customer_phone . "<br>Email: " . $customer_email . '</b></div>'
                    );
                    if ($this->get_option('webhook_store') === 'yes')
                        $order->add_order_note("WEBHOOK \n" . wp_json_encode($data, JSON_PRETTY_PRINT));
                    if (isset(WC()->cart)) {
                        WC()->cart->empty_cart();
                    }
                    break;
                case 'payment_review':
                    $order->update_status('on-hold', __('El pago se ecnuentra en revisión.', 'text-domain'));
                    $order->add_order_note(__('El pago se encuentra en revision en Remesita', 'text-domain')); 
                    break;
                case 'completed': 
                    $order->add_order_note( "⚡️ ".__('Los fondos han sido liquidados a la cuenta Remesita del Negocio.', 'text-domain'));
                    if($this->get_option('webhook_store') === 'yes')
                        $order->add_order_note("WEBHOOK \n".wp_json_encode($data, JSON_PRETTY_PRINT)    );  
                    break;
                case 'cancelled':
                case 'canceled':
                    $reason = isset($data["cancelReason"]) ? $data["cancelReason"] : (isset($data["cancel_reason"]) ? $data["cancel_reason"] : "");
                    $order->update_status('cancelled',  trim(__('El pago ha sido cancelado.', 'text-domain') . "  $reason"));
                    $order->add_order_note('🚫 <b style="color:red">'.$reason.'</b>'   ); 
                    if($this->get_option('webhook_store') === 'yes')
                    $order->add_order_note("WEBHOOK \n".wp_json_encode($data, JSON_PRETTY_PRINT));  
                    break;
                default:
                    error_log("IPN Error: Unknown status {$status}");
                    return;
            } 

            $order->save();
 

            header('HTTP/1.1 200 OK');
            exit;
        }




         

        public function do_ssl_check()
        {
            if ($this->enabled  ) {
                if (get_option('woocommerce_force_ssl_checkout') == "no") {
                    sprintf("<div class=\"error\"><p><strong>%s</strong> ",$this->method_title) 
                    .esc_html__('está habilitado y WooCommerce no fuerza el certificado SSL en su página de pago. Asegúrese de tener un certificado SSL válido y de','text-domain')
                    .sprintf( "<a href=\"%s\">".esc_html__("forzar la seguridad de las páginas de pago.",'text-domain')."</a>",  admin_url('admin.php?page=wc-settings&tab=checkout')) 
                    . "</p></div>";
                }
            }
        }
        public function render_settings_page()
        {
            // Verifica permisos
            if (!current_user_can('manage_woocommerce')) {
                wp_die(esc_html__('No tienes permisos suficientes para acceder a esta página.', 'text-domain'));
            } 
            echo '<div class="wrap">';
            echo '<h1>' . esc_html__('Ajustes de Remesita Pay', 'text-domain') . '</h1>';  
            $this->generate_settings_html(); 
            echo '</div>';
        }
		/**
		 * Logging method.
		 *
		 * @param string $message Log message.
		 * @param string $level   Optional. Default 'info'. Possible values:
		 *                        emergency|alert|critical|error|warning|notice|info|debug.
		 */
		protected static function log($message, $level = 'info')
		{
			if (self::$logEnabled) {
				if (empty(self::$log)) {
					self::$log = wc_get_logger();
				}
				self::$log->log($level, $message, ['source' => 'remesita-pay']);
			}
		}
        /**
         * Process refund
         *
         * @param int $order_id Order ID.
         * @param float $amount Refund amount.
         * @param string $reason Refund reason.
         * @return bool|WP_Error
         */
        public function process_refund($order_id, $amount = null, $reason = '')
        {
            $order = wc_get_order($order_id);
            if (!$order) {
                return new WP_Error('error', __('Pedido no encontrado', 'text-domain'));
            }

            $reference = $order->get_meta('external_payment_reference');
            if (empty($reference)) {
                return new WP_Error('error', __('No se encontró referencia de pago para este pedido', 'text-domain'));
            }

            $token = $this->getAuthToken();
            if (!$token) {
                $error_msg = __('Error al autenticar con Remesita', 'text-domain');
                $order->add_order_note('❌ ' . $error_msg);
                self::log($error_msg, 'error');
                return new WP_Error('error', $error_msg);
            }

            $data = [
                'reference' => $reference,
                'amount' => $amount,
                'reason' => $reason
            ];

            $response = wp_remote_post('https://api.remesita.com/rest/v1/payment/refund', [
                'body' => wp_json_encode($data),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $token
                ],
            ]);

            if (is_wp_error($response)) {
                $error_msg = __('Error procesando reembolso:', 'text-domain') . $response->get_error_message();
                $order->add_order_note('❌ ' . $error_msg);
                self::log($error_msg, 'error');
                return new WP_Error('error', $error_msg);
            }

            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (!empty($body['success'])) {
                $order->add_order_note('✅ '.sprintf(__('Reembolso procesado por %s. ID: %s', 'text-domain'), wc_price($amount), $body['id'] ?? 'N/A'));
                return true;
            }

            $error = $body['error'] ?? __('Error desconocido al procesar reembolso', 'text-domain');
            $order->add_order_note('❌ ' . $error);
            self::log(__('Error en reembolso:', 'text-domain') . $error, 'error');
            return new WP_Error('error', $error);
        }

        static function cleanSpecialAnPuntuations($text)
        {
            if (empty($text)) return $text;

            $replacements = [
                "#" => "",
                'á' => "a", 'é' => "e", 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'Á' => 'A', 'É' => 'E', 'Í' => 'i', 'Ó' => 'O',
                'Ú' => 'U', 'ä' => 'a', 'ë' => 'e', 'ï' => 'i', 'ö' => 'o', 'ü' => 'u', 'Ä' => 'A', 'Ë' => 'E', 'Ï' => 'I', 'Ö' => 'O',
                'Ü' => 'U', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'ā' => 'a', 'ă' => 'a', 'ą' => 'a', 'Á' => 'A',
                'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ă' => 'A', 'Ą' => 'A',
                'è' => 'e', 'é' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ę' => 'e', 'ě' => 'e',
                'Ē' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ę' => 'E', 'Ě' => 'E',
                'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ì' => 'i', 'ĩ' => 'i', 'ī' => 'i', 'ĭ' => 'i',
                'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ì' => 'I', 'Ĩ' => 'I', 'Ī' => 'I', 'Ĭ' => 'I',
                'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ō' => 'o', 'ŏ' => 'o', 'ő' => 'o',
                'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ō' => 'O', 'Ŏ' => 'O', 'Ő' => 'O',
                'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ũ' => 'u', 'ū' => 'u', 'ŭ' => 'u', 'ů' => 'u',
                'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ũ' => 'U', 'Ū' => 'U', 'Ŭ' => 'U', 'Ů' => 'U',
                'ñ' => 'n', 'Ñ' => 'N'
            ];
            foreach ($replacements as $k => $v)
                $text = str_replace($k, $v, $text);

            $text = preg_replace("/\(|\)|-|\@|\"|'/i", "", $text);
            $text = mb_convert_encoding($text, 'UTF-8', 'ISO-8859-1');
            $text = preg_replace('/[^\wáéíóúÁÉÍÓÚüÜñÑ,. ]/', '', $text);
            $text = preg_replace("/,|\.|:|;|\?|¿|\!/", "", $text);
            return $text;
        }
    }
}
