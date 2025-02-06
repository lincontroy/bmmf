<?php

namespace App\Services;

use App\Repositories\Eloquent\ExternalApiSetupRepository;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\QuickExchange\App\Repositories\Interfaces\QuickExchangeCoinRepositoryInterface;

class CoinMarketCapService
{
    protected $apiUrl = 'https://pro-api.coinmarketcap.com/v1';
    protected $apiKey;

    public function __construct(
        protected ExternalApiSetupRepository $externalApiSetupRepository,
        protected AcceptCurrencyRepositoryInterface $acceptCurrencyRepository,
        protected QuickExchangeCoinRepositoryInterface $quickExchangeCoinRepository
    ) {
        $coinmarketcap = $this->externalApiSetupRepository->firstWhere('name', 'coinmarketcap');

        if ($coinmarketcap) {
            $coinmarketcap = json_decode($coinmarketcap->data, true);
            $this->apiKey  = $coinmarketcap['api_key'];
        } else {
            $this->apiKey = "ab302835-9c0d-4b77-b8ed-f7ca7f285c53";
        }

    }

    public function coinExists($symbol)
    {
        $client = new Client();

        try {
            $response = $client->request('GET', $this->apiUrl . '/cryptocurrency/map', [
                'headers' => [
                    'X-CMC_PRO_API_KEY' => $this->apiKey,
                ],
                'query'   => [
                    'symbol' => $symbol,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['data']) && is_array($data['data'])) {

                foreach ($data['data'] as $coin) {

                    if (isset($coin['symbol']) && strtolower($coin['symbol']) === strtolower($symbol)) {
                        return true;
                    }

                }

            }

            return false;
        } catch (RequestException $e) {
            return false;
        }

    }

    /**
     * Update all accept currency rate
     *
     * @return RedirectResponse
     */
    public function currencyRateUpdate(): bool
    {
        $parameters = [
            'start'   => '1',
            'limit'   => '100',
            'convert' => 'USD',
        ];

        $response = Http::withHeaders([
            'Accepts'           => 'application/json',
            'X-CMC_PRO_API_KEY' => $this->apiKey,
        ])->get($this->apiUrl . '/cryptocurrency/listings/latest', $parameters);

        if ($response->successful()) {
            $currencies = $response->json('data');
            $this->acceptCurrencyRepository->updateCurrencyRate($currencies);
            $this->quickExchangeCoinRepository->updateCurrencyRate($currencies);
        } else {
            // Handle the error response here
            Log::error('Failed to fetch cryptocurrency data', [
                'status' => $response->status(),
                'error'  => $response->body(),
            ]);
        }

        return true;
    }

}
