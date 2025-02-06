<?php

namespace App\Http\Controllers\Currency;

use App\DataTables\AcceptCurrencyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcceptCurrencyRequest;
use App\Services\AcceptCurrencyService;
use App\Services\CoinMarketCapService;
use App\Services\CurrencyConvertService;
use App\Services\PaymentGatewayService;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class AcceptCurrencyController extends Controller
{

    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct(
        private AcceptCurrencyService $acceptCurrencyService,
        private PaymentGatewayService $paymentGatewayService,
        private CoinMarketCapService $coinMarketCapService,
        private CurrencyConvertService $currencyConvertService
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value  . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value  . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value  . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value  . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value  . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(AcceptCurrencyDataTable $acceptCurrencyDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Accept Currency List'),
            'description' => localize('Accept Currency List'),
        ]);

        $data['acceptPaymentGateway'] = $this->paymentGatewayService->findGateway();

        return $acceptCurrencyDataTable->render('backend.currency.accept_currency_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcceptCurrencyRequest $request)
    {
        $data = $request->validated();

        if (Str::lower($data['currency_symbol']) != "usd"
            && Str::lower($data['currency_symbol']) != "ltct") {
            $validatedCoinName = $this->currencyConvertService->coinRate($data['currency_name']);

            if ($validatedCoinName->status != "success") {
                return response()->json([
                    'success' => false,
                    'message' => localize("Invalid Coin Name!"),
                    'title'   => localize("Accept Currency"),
                    'data'    => [],
                ]);
            }

            $validatedCoinSymbol = $this->coinMarketCapService->coinExists($data['currency_symbol']);

            if (!$validatedCoinSymbol) {
                return response()->json([
                    'success' => false,
                    'message' => localize("Invalid Coin Symbol!"),
                    'title'   => localize("Accept Currency"),
                    'data'    => [],
                ]);
            }

        }

        $createData = $this->acceptCurrencyService->create($data);
        return response()->json([
            'success' => true,
            'message' => localize("created successfully"),
            'title'   => localize("Accept currency"),
            'data'    => $createData,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['acceptCurrencyInfo']    = $this->acceptCurrencyService->find($id);
        $data['paymentGatewayIdArray'] = $data['acceptCurrencyInfo']->currencyGateway->pluck('payment_gateway_id')->toArray();
        $data['acceptPaymentGateway']  = $this->paymentGatewayService->findGateway();

        return view('backend.currency.accept_currency_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcceptCurrencyRequest $request, string $id)
    {
        $validateData = $request->validated();

        if (Str::lower($validateData['currency_symbol']) != "usd"
            && Str::lower($validateData['currency_symbol']) != "ltct") {
            $validatedCoinName = $this->currencyConvertService->coinRate($validateData['currency_name']);

            if ($validatedCoinName->status != "success") {
                return response()->json([
                    'success' => false,
                    'message' => localize("Invalid Coin Name!"),
                    'title'   => localize("Accept Currency"),
                    'data'    => [],
                ]);
            }

            $validatedCoinSymbol = $this->coinMarketCapService->coinExists($validateData['currency_symbol']);

            if (!$validatedCoinSymbol) {
                return response()->json([
                    'success' => false,
                    'message' => localize("Invalid Coin Symbol!"),
                    'title'   => localize("Accept Currency"),
                    'data'    => [],
                ]);
            }

        }

        $updateData = $this->acceptCurrencyService->update($validateData, $id);

        return response()->json([
            'success' => true,
            'message' => localize("Updated successfully"),
            'title'   => localize("Accept Currency"),
            'data'    => $updateData,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->acceptCurrencyService->destroy(['currency_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Deleted successfully"),
            'title'   => localize("Currency Gateway"),
        ]);
    }

}
