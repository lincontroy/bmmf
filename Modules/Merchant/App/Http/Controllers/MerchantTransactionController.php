<?php

namespace Modules\Merchant\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\App\DataTables\MerchantConfirmedDataTable;
use Modules\Merchant\App\DataTables\MerchantTransactionDataTable;
use Modules\Merchant\App\Services\MerchantAccountService;

class MerchantTransactionController extends Controller
{
    /**
     * MerchantAccountController of __construct
     * @param MerchantAccountService $merchantAccountService
     */
    public function __construct(
        protected MerchantAccountService $merchantAccountService,

    ) {

    }

    /**
     * Display a listing of the resource.
     *
     * @param MerchantTransactionDataTable $merchantTransactionDataTable
     * @return mixed
     */
    public function index(MerchantTransactionDataTable $merchantTransactionDataTable)
    {
        return $merchantTransactionDataTable->render('merchant::index');
    }

    /**
     * Display a listing of the resource.
     */
    public function confirmMerchant(MerchantConfirmedDataTable $merchantConfirmedDataTable)
    {
        return $merchantConfirmedDataTable->render('merchant::confirmed');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchant::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return false;
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('merchant::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('merchant::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $attribute['merchant_id'] = $id;
        $attribute['set_status']  = $request['set_status'];
        $attribute['checked_by']  = Auth::id();

        $deposit = $this->merchantAccountService->update($attribute);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant account update successfully"),
            'title'   => localize("Merchant"),
            'data'    => $deposit,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
