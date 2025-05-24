<?php

namespace Modules\Transaction\Services;

class UPaymentService
{
    /*
     * Test CREDENTIALS
     */
    const MERCHANT_ID = "1201";
    const USERNAME = "test";
    const PASSWORD = "test";
    const API_KEY = "jtest123";

    protected $paymentMode = 'test_mode';
    protected $test_mode = 1;
    protected $whitelabled = true;
    protected $paymentUrl = "https://api.upayments.com/test-payment";
    protected $apiKey = '';
    protected $charges = 0.150;
    protected $cc_charges = 2.7;

    public function __construct()
    {
        if (setting('payment_gateway', 'upayment.payment_mode') == 'live_mode') {
            $this->paymentMode = 'live_mode';
            $this->test_mode = false;
            $this->whitelabled = false;
            $this->paymentUrl = "https://api.upayments.com/payment-request";
            $this->apiKey = password_hash(setting('payment_gateway','upayment.' . $this->paymentMode . '.API_KEY') ?? self::API_KEY, PASSWORD_BCRYPT);
        } else {
            $this->apiKey = setting('payment_gateway' , ".upayment.$this->paymentMode.API_KEY") ?? self::API_KEY;
        }
        $this->charges = setting("payment_gateway", ".upayment.{$this->paymentMode}.charges") ?? $this->charges;
        $this->cc_charges = setting("payment_gateway", ".upayment.{$this->paymentMode}.cc_charges") ?? $this->cc_charges;
    }

    public function send($order, $payment, $userToken = '', $type = 'frontend')
    {
        if (auth()->check()) {
            $user = [
                'name' => auth()->user()->name ?? '',
                'email' => auth()->user()->email ?? '',
                'mobile' => auth()->user()->calling_code ?? '' . auth()->user()->mobile ?? '',
            ];
        } else {
            $user = [
                'name' => 'Guest User',
                'email' => 'test@test.com',
                'mobile' => '12345678',
            ];
        }

        $extraMerchantsData = array();
        $extraMerchantsData['amounts'][0] =  $order['total'];
        $extraMerchantsData['charges'][0] = $this->charges;
        $extraMerchantsData['chargeType'][0] = 'fixed'; // or 'percentage'
        $extraMerchantsData['cc_charges'][0] = $this->cc_charges; // or 'percentage'
        $extraMerchantsData['cc_chargeType'][0] = 'percentage'; // or 'percentage'
        $extraMerchantsData['ibans'][0] = setting('payment_gateway','upayment.' . $this->paymentMode . '.IBAN') ?? '';

        $url = $this->paymentUrls($type);

        $fields = [
            'api_key' => $this->apiKey,
            'merchant_id' => setting('payment_gateway','upayment.' . $this->paymentMode . '.MERCHANT_ID') ?? self::MERCHANT_ID,
            'username' => setting('payment_gateway','upayment.' . $this->paymentMode . '.USERNAME') ?? self::USERNAME,
            'password' => stripslashes(setting('payment_gateway','upayment.' . $this->paymentMode . '.PASSWORD') ?? self::PASSWORD),
            'order_id' => $order['id'],
            'CurrencyCode' => 'KWD',
            'CstFName' => $user['name'],
            'CstEmail' => $user['email'],
            'CstMobile' => $user['mobile'],
            'success_url' => $url['success'],
            'error_url' => $url['failed'],
            'ExtraMerchantsData' => json_encode($extraMerchantsData),
            'test_mode' => $this->test_mode, // 1 == test mode enabled
            'whitelabled' => $this->whitelabled, // false == in live mode
            'payment_gateway' => $payment, // knet / cc
            'reference' => $order['id'],
            'notifyURL' => route('frontend.orders.success.upayment'),
            'total_price' => $order['total'],
            'userToken' => $userToken,
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paymentUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $server_output = json_decode($server_output, true);

        if(curl_exec($ch) == false)
        {
            logger('PaymentError', [curl_error($ch), $fields, $this->paymentUrl]);
        }

//        if (auth()->id() == 4370) {
//            dd( $fields, $this->paymentUrl, curl_error($ch), $server_output);
//        }

        if ((isset($server_output['status']) && $server_output['status'] == 'errors') || $server_output == null) {
            return ['status' => false];
        }
        return ['status' => true, 'url' => $server_output['paymentURL']];
    }

    public function paymentUrls($type)
    {
        switch($type){
            case 'frontend':
                $url['success'] = route('frontend.orders.success.upayment');
                $url['failed'] = route('frontend.orders.success.upayment');
                break;
            case 'api':
                $url['success'] = route('api.orders.success.upayment');
                $url['failed'] = route('api.orders.success.upayment');
                break;
        }
        return $url;
    }
}
