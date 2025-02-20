<?php

namespace Modules\Finance\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\WalletManage;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use App\Services\Customer\CustomerService;
use App\Services\SettingService;
use App\Traits\ChecksPermissionTrait;
use Dompdf\Dompdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Finance\App\DataTables\CreditDataTable;
use Modules\Finance\App\DataTables\DepositsDataTable;
use Modules\Finance\App\Http\Requests\CreditRequest;
use Modules\Finance\App\Services\DepositService;
use Modules\Finance\App\Models\Deposit;


class DepositController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Summary of __construct
     * @param DepositService $depositService
     */
    public function __construct(
        protected DepositService $depositService,
        protected SettingService $settingService,
        protected CustomerService $customerService,
        protected AcceptCurrencyRepositoryInterface $acceptCurrencyRepository,
    ) {
        $this->mapActionPermission = [
            'index'       => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'addCredit'   => PermissionMenuEnum::FINANCE_CREDIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'getUser'     => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'store'       => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'create'      => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'show'        => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'generatePdf' => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'edit'        => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'update'      => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
            'destroy'     => PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(DepositsDataTable $depositsDataTable)
    {

        cs_set('theme', [
            'title'       => localize('Credit'),
            'description' => localize('Credit'),
        ]);

        return $depositsDataTable->render('finance::index');
    }

    public function balances()
    {
        cs_set('theme', [
            'title'       => localize('Balances'),
            'description' => localize('Balances'),
        ]);

        return view('finance::balance');
    }

    public function updateBalance(Request $request) {
        $request->validate([
            'id' => 'required|exists:wallet_manages,id',
            'balance' => 'required|numeric|min:0'
        ]);
    
        $wallet = WalletManage::find($request->id);
        $wallet->balance = $request->balance;
        $wallet->save();
    
        return response()->json(['success' => true, 'message' => 'Balance updated successfully!']);
    }

    /**
     * Display a listing of the resource.
     */
    public function addCredit(CreditDataTable $creditDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Credit List'),
            'description' => localize('Credit List'),
        ]);

        $currency = $this->acceptCurrencyRepository->all();

        return $creditDataTable->render('finance::credit.index', compact('currency'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getUser(Request $request): JsonResponse
    {
        $id     = $request['id'];
        $userId = $request['user_id'] ? $request['user_id'] : $id;
        $user   = $this->customerService->findByAttributes(['user_id' => $userId]);

        return response()->json([
            'success' => true,
            'message' => $user ? "Your user is (" . $user->first_name . " " . $user->last_name . ")" : "User not found!",
            'title'   => "Add Credit",
            'data'    => $user ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CreditRequest $request): JsonResponse
    {
        dd($request);
        $data   = $request->validated();
        $userId = (string) $request['user_id'];

        $checkExists = $this->customerService->findByAttributes(['user_id' => $userId]);

        if (!$checkExists) {
            return response()->json([
                'success' => false,
                'message' => localize("User does not exist!"),
                'title'   => localize("Add Credit"),
                'data'    => null,
            ]);
        }

        $data['customer_id'] = $checkExists->id;

        $credit = $this->depositService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Credit added successfully"),
            'title'   => localize("Add Credit"),
            'data'    => $credit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        cs_set('theme', [
            'title'       => localize('B2X'),
            'description' => localize('B2X'),
        ]);

        $settingInfo   = $this->settingService->formData();
        $creditDetails = $this->depositService->creditDetails($id);

        $html = view('finance::credit.credit_details', compact('creditDetails', 'settingInfo'))->render();

        $response = ['info' => $html, 'details' => $creditDetails];

        return response()->json([
            'success' => true,
            'message' => "",
            'title'   => localize("Deposit"),
            'data'    => $response,
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function generatePdf(Request $request)
    {
        $id            = $request['id'];
        $settingInfo   = $this->settingService->formData();
        $creditDetails = $this->depositService->creditDetails($id);

        $html = view('finance::credit.credit_details', compact('creditDetails', 'settingInfo'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Set the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Generate the PDF content
        $pdfContent = $dompdf->output();

        // Set the headers for PDF download
        $headers = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="document.pdf"',
        ];

        // Return the PDF content as a downloadable attachment
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'document.pdf', $headers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {


        $attribute['deposit_id'] = $id;
        $attribute['set_status'] = $request['set_status'];
        $attribute['updated_by'] = Auth::id();

        //update the new deposit balance


        $deposit_details=Deposit::where('id',$id)->first();

    

        $customer_id=$deposit_details->customer_id;

       

        $user_details=Customer::where('id',$customer_id)->first();

        

        $user_id=$user_details->user_id;

       

        //get this information from wallet manager

        $wallet_info=WalletManage::where('user_id',$user_id)->first();

        

        $balance=$wallet_info->balance;

        $newbalance=$balance+$deposit_details->amount;
        // dd($deposit_details->amount);

        $deposit = $this->depositService->update($attribute);

        // dd($deposit);
        try{
            WalletManage::where('user_id',$user_id)->update(['balance'=>$newbalance]);
            return response()->json([
                'success' => true,
                'message' => localize("Deposit update successfully"),
                'title'   => localize("Deposit"),
                // 'data'    => $deposit,
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => localize($e->getMessage()),
                'title'   => localize("Deposit"),
                // 'data'    => $deposit,
            ]);
        }

        



        //get the user details from the customer 

       

        // return response()->json([
        //     'success' => true,
        //     'message' => localize("Deposit update successfully"),
        //     'title'   => localize("Deposit"),
        //     'data'    => $deposit,
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        dd($id);
    }

}
