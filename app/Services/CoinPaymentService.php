<?php

namespace App\Services;

use Illuminate\Http\Request;

class CoinPaymentService
{
    private $apiEndPoint;
    public function __construct(

    ) {
        $this->apiEndPoint = "https://www.coinpayments.net/api.php";
    }

    /**
     * Create deposit transaction
     * @param array $attributes
     * @return object
     */
    public function createDepositTxn(array $attributes): object
    {
        $postData = [
            "version"     => 1,
            "cmd"         => "create_transaction",
            "amount"      => number_format((float) $attributes['amount'], 8, '.', ''),
            "currency1"   => $attributes['currency1'],
            "currency2"   => $attributes['currency2'],
            "buyer_email" => $attributes['buyer_email'],
            "ipn_url"     => $attributes['ipn_url'],
            "key"         => $attributes['public_key'],
            "format"      => 'json',
        ];

        $postBody = http_build_query($postData, '', '&');
        $hmac     = hash_hmac('sha512', $postBody, $attributes['private_key']);

        $response = $this->sendRequest([
            'hmac'     => $hmac,
            'postBody' => $postBody,
        ]);

        if ($response["error"] == "ok") {
            return (object) [
                "status" => "success",
                "data"   => $response["result"],
            ];
        } else {
            return (object) [
                "status"  => "error",
                "message" => $response["error"],
            ];
        }

    }

    private function sendRequest(array $attributes): array
    {
        try {
            static $ch = null;

            if ($ch === null) {
                $ch = curl_init($this->apiEndPoint);

                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, ['HMAC: ' . $attributes['hmac']]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $attributes['postBody']);

            $data = curl_exec($ch);

            if ($data !== false) {

                if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                    $dec = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
                } else {
                    $dec = json_decode($data, true);
                }

                return $dec;
            } else {
                return ['error' => 'cURL error: ' . curl_error($ch)];
            }

        } catch (\Exception $ex) {
            return ['error' => 'cURL error: ' . $ex->getMessage()];
        }

    }

    public function paymentVerify(array $attributes, Request $request): object
    {
        $merchantId   = $attributes['merchant_id'];
        $ipnSecret    = $attributes['ipn_secret'];
        $orderAmount  = $attributes['orderAmount'];
        $inputRequest = file_get_contents('php://input');

        if (!$request->ipn_mode || $request->ipn_mode != 'hmac') {
            return (object) ['status' => 'error', 'message' => 'IPN Mode is not HMAC'];
        }

        if (!$request->server("HTTP_HMAC") || empty($request->server("HTTP_HMAC"))) {
            return (object) ['status' => 'error', 'message' => 'No HMAC signature sent.'];
        }

        $inputRequest = file_get_contents('php://input');

        if ($inputRequest === false || empty($inputRequest)) {
            return (object) ['status' => 'error', 'message' => 'Error reading POST data'];
        }

        if (!$request->merchant || $request->merchant != trim($merchantId)) {
            return (object) ['status' => 'error', 'message' => 'No or incorrect Merchant ID passed'];
        }

        $hmac = hash_hmac("sha512", $inputRequest, trim($ipnSecret));

        if (!hash_equals($hmac, $request->server("HTTP_HMAC"))) {
            return (object) ['status' => 'error', 'message' => 'HMAC signature does not match'];
        }

        if ($request->amount2 < $orderAmount) {
            return (object) ['status' => 'error', 'message' => 'Amount is less than order total.'];
        }

        if ($request->status >= 100 || $request->status == 2) {
            return (object) ['status' => 'success', 'data' => [
                'usd_value' => $request->amount1,
                'method'    => 'CoinPayment',
            ]];
        } elseif ($request->status < 0) {

            if ($request->status == -1) {
                return (object) ['status' => 'cancelled'];
            }

        }

        return (object) ['status' => 'error', 'message' => 'No Response'];
    }

}
