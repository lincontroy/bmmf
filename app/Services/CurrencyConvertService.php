<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;

class CurrencyConvertService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.coingecko.com/api/v3/',
        ]);
    }

    public function coinRate(string $coinName): object
    {
        $coinName = Str::lower($coinName);

        try {

            $response = $this->client->request('GET', 'simple/price', [
                'query' => [
                    'ids'           => $coinName,
                    'vs_currencies' => 'usd',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data[$coinName]['usd'])) {
                return (object) ['status' => 'success', 'rate' => $data[$coinName]['usd']];
            } else {
                return (object) ['status' => 'error', 'message' => 'Something went wrong'];
            }

        } catch (RequestException $ex) {
            return (object) ['status' => 'error', 'message' => $ex->getMessage()];
        }

    }

}
