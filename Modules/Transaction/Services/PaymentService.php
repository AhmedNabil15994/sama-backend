<?php

namespace Modules\Transaction\Services;

class PaymentService
{
    const EMAIL_MYFATOORAH = "apiaccount@myfatoorah.com";
    const PASSWORD_MYFATOORAH = "api12345*";

    public function send($order, $type, $payment)
    {
        $url = $this->paymentUrls($type);

        $access_token = $this->generateToken();

        $lang = (locale() == 'ar') ? 1 : 2;

        if (!empty($access_token)) {
            $t = time();
            $post_string = '{
						"InvoiceValue": 10,
						"CustomerName": "' . $order->orderAddress->username . '",
						"CustomerAddress": "' . $order->orderAddress->address . '",
						"CustomerReference": "' . $t . '",
						"DisplayCurrencyIsoAlpha": "KWD",
						"CountryCodeId": "00",
						"CustomerMobile": "50000000",
						"CustomerEmail": "' . $order->orderAddress->email . '",
						"DisplayCurrencyId": 3,
						"SendInvoiceOption": 1,
						"SupplierCode": "' . $order->vendor->supplier_code_myfatorah . '",
						"InvoiceItemsCreate": [
							{
								"ProductId"	 : null,
								"ProductName": "Daweny Order",
								"Quantity"	 : 1,
								"UnitPrice"	 : "' . $order->subtotal . '"
							},
							{
								"ProductId"	 : null,
								"ProductName": "Daweny Shipping",
								"Quantity"	 : 1,
								"UnitPrice"	 : "' . $order->shipping . '"
							},
						],
						"CallBackUrl"			: "' . $url['success'] . '",
						"Language"				: ' . $lang . ',
						"ExpireDate"			: "2022-12-31T13:30:17.812Z",
						"ApiCustomFileds"	: "order_id=' . $order->id . '",
						"ErrorUrl"				: "' . $url['failed'] . '"
							}';

            $soap_do = curl_init();
            curl_setopt($soap_do, CURLOPT_URL, "https://apidemo.myfatoorah.com/ApiInvoices/CreateInvoiceIso");
            curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
            curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($soap_do, CURLOPT_POST, true);
            curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($soap_do, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($post_string),
                'Accept: application/json',
                'Authorization: Bearer ' . $access_token
            ]);

            $result1 = curl_exec($soap_do);
            $err = curl_error($soap_do);
            return $json1 = json_decode($result1, true);
            $RedirectUrl = $json1['RedirectUrl'];
            $ref_Ex = explode('/', $RedirectUrl);
            $referenceId = $ref_Ex[4];
            curl_close($soap_do);

            return $RedirectUrl;
        }
    }

    public function success($request)
    {
        return $data = $this->getOrderStatus($request);
    }

    public function error($request)
    {
        return $data = $this->getOrderStatus($request);
    }

    public function getOrderStatus($request)
    {
        if ($request['paymentId']) {

            $access_token = $this->generateToken();
            $id = $request['paymentId'];
            $password = self::PASSWORD_MYFATOORAH;

            $url = 'https://apidemo.myfatoorah.com/ApiInvoices/Transaction/' . $id;
            $soap_do1 = curl_init();
            curl_setopt($soap_do1, CURLOPT_URL, $url);
            curl_setopt($soap_do1, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($soap_do1, CURLOPT_TIMEOUT, 10);
            curl_setopt($soap_do1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($soap_do1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($soap_do1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($soap_do1, CURLOPT_POST, false);
            curl_setopt($soap_do1, CURLOPT_POST, 0);
            curl_setopt($soap_do1, CURLOPT_HTTPGET, 1);
            curl_setopt($soap_do1, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json',
                'Authorization: Bearer ' . $access_token
            ]);

            $result_in = curl_exec($soap_do1);
            $err_in = curl_error($soap_do1);
            $file_contents = htmlspecialchars(curl_exec($soap_do1));
            curl_close($soap_do1);

            return $getRecorById = json_decode($result_in, true);
        }
    }

    public function generateToken()
    {
        $username = self::EMAIL_MYFATOORAH;
        $password = self::PASSWORD_MYFATOORAH;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://apidemo.myfatoorah.com/Token');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'password', 'username' => $username, 'password' => $password
        ]));
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        $json = json_decode($result, true);

        if (isset($json['access_token']) && !empty($json['access_token'])) {
            $access_token = $json['access_token'];
        } else {
            $access_token = '';
        }

        if (isset($json['token_type']) && !empty($json['token_type'])) {
            $token_type = $json['token_type'];
        } else {
            $token_type = '';
        }

        return $access_token;
    }

    public function paymentUrls($type)
    {
        if ($type == 'orders') {
            $url['success'] = url(route('frontend.orders.success'));
            $url['failed'] = url(route('frontend.orders.failed'));
        }

        if ($type == 'subscriptions') {
            $url['success'] = url(route('frontend.subscriptions.success'));
            $url['failed'] = url(route('frontend.subscriptions.failed'));
        }


        if ($type == 'api-order') {
            $url['success'] = url(route('api.orders.success'));
            $url['failed'] = url(route('api.orders.failed'));
        }

        return $url;
    }

    public function setTransactions($request,$order){
        $order->transactions()->updateOrCreate(
            [
                'transaction_id' => $request['OrderID'],
            ],
            [
                'auth' => $request['Auth'],
                'tran_id' => $request['TranID'],
                'result' => $request['Result'],
                'post_date' => $request['PostDate'],
                'ref' => $request['Ref'],
                'track_id' => $request['TrackID'],
                'payment_id' => $request['PaymentID'],
            ]
        );
    }

}
