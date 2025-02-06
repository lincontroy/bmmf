@php
    use App\Enums\TxnTypeEnum;
    use Carbon\Carbon;
    use Modules\Merchant\App\Enums\MerchantPaymentTransactionStatusEnum;
@endphp
<x-customer-app-layout>
    @php
        $currentMonthYear = Carbon::now()->format('F Y');
    @endphp
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="row">
                <!-- Total Transaction -->
                <div class="col-md-6 col-sm-12 g-3 mb-3">
                    <div class="card shadow-none radius-12">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="badge p-2 bg-label-primary mb-2 rounded">
                                    <svg width="28" height="25" viewBox="0 0 28 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M25 5.78125V3.09375C25 1.61159 23.7666 0.40625 22.25 0.40625H4.375C2.10075 0.40625 0.25 2.21494 0.25 4.4375V20.5625C0.25 23.5201 2.71675 24.5938 4.375 24.5938H25C26.5166 24.5938 27.75 23.3884 27.75 21.9062V8.46875C27.75 6.98659 26.5166 5.78125 25 5.78125ZM22.25 17.875H19.5V12.5H22.25V17.875ZM4.375 5.78125C4.02097 5.76577 3.68668 5.61744 3.44175 5.36713C3.19683 5.11682 3.06013 4.78383 3.06013 4.4375C3.06013 4.09117 3.19683 3.75818 3.44175 3.50787C3.68668 3.25756 4.02097 3.10923 4.375 3.09375H22.25V5.78125H4.375Z"
                                            fill="#3380FF" />
                                    </svg>
                                </div>
                                <h5 class="text-black mb-0">{{ localize('Transactions') }}</h5>

                            </div>
                            <h3 class="text-black fw-semi-bold fs-30 my-3">{{ $totalTransaction ?? 0 }}</h3>
                            <div class="pt-2">
                                <div class="d-flex align-items-center gap-2 gap-xxl-3">
                                    <span class="fs-13 text-muted fw-medium">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Transaction -->

                <!-- Total Customer -->
                <div class="col-md-6 col-sm-12 g-3 mb-3">
                    <div class="card shadow-none radius-12">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="badge p-2 bg-label-primary mb-2 rounded">
                                    <svg width="28" height="25" viewBox="0 0 28 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M25 5.78125V3.09375C25 1.61159 23.7666 0.40625 22.25 0.40625H4.375C2.10075 0.40625 0.25 2.21494 0.25 4.4375V20.5625C0.25 23.5201 2.71675 24.5938 4.375 24.5938H25C26.5166 24.5938 27.75 23.3884 27.75 21.9062V8.46875C27.75 6.98659 26.5166 5.78125 25 5.78125ZM22.25 17.875H19.5V12.5H22.25V17.875ZM4.375 5.78125C4.02097 5.76577 3.68668 5.61744 3.44175 5.36713C3.19683 5.11682 3.06013 4.78383 3.06013 4.4375C3.06013 4.09117 3.19683 3.75818 3.44175 3.50787C3.68668 3.25756 4.02097 3.10923 4.375 3.09375H22.25V5.78125H4.375Z"
                                            fill="#3380FF" />
                                    </svg>
                                </div>
                                <h5 class="text-black mb-0">{{ localize('Total Customer') }}</h5>
                            </div>
                            <h3 class="text-black fw-semi-bold fs-30 my-3">{{ $totalCustomer ?? 0 }}</h3>
                            <div class="pt-2">
                                <div class="d-flex align-items-center gap-2 gap-xxl-3">
                                    <span class="fs-13 text-muted fw-medium">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Total Customer -->
                <div class="col-lg-12 g-3 mb-3">
                    <div class="card py-4 pb-0 shadow-none radius-15">
                        <div
                            class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                            <h5 class="m-0 fs-20 text-black fw-semi-bold">{{ localize('Merchant Balance') }}</h5>
                        </div>
                        <div class="card-body min-height-50vh">
                            <div class="table-responsive history-table mb-1">
                                <table class="table">
                                    <tbody class="table-border-top-0">
                                        <tr>
                                            <th>
                                                {{ localize('Symbol') }}
                                            </th>
                                            <th>
                                                {{ localize('Balance') }}
                                            </th>
                                        </tr>
                                        @foreach ($merchantBalances as $merchantBalance)
                                            <tr>
                                                <th>
                                                    <div class="d-flex align-items-center gap-2">

                                                        <div class="loan-coin rounded-circle">
                                                            <img src="{{ $merchantBalance->acceptCurrency->logo ? assets('img/' . $merchantBalance->acceptCurrency->logo) : assets('img/image.svg') }}"
                                                                alt="" />
                                                        </div>
                                                        @if ($merchantBalance->acceptCurrency->name)
                                                            <span>
                                                                {{ $merchantBalance->acceptCurrency->name }}
                                                                ({{ $merchantBalance->acceptCurrency->symbol }})
                                                            </span>
                                                        @endif
                                                    </div>
                                                </th>
                                                <th class="text-success">
                                                    {{ number_format($merchantBalance->amount, 2) }}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card py-4 pb-0 shadow-none radius-15">
                <div
                    class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                    <h5 class="m-0 fs-20 text-black fw-semi-bold">{{ localize('Recent Transaction') }}</h5>
                    <a href="{{ route('customer.merchant.transaction.index') }}"
                        class="btn btn-outline-secondary fs-11 fw-semi-bold">{{ localize('View All') }}</a>
                </div>
                <div class="card-body min-height-70vh">
                    <div class="table-responsive history-table mb-1">
                        <table class="table">
                            <tbody class="table-border-top-0">
                                <tr>
                                    <th>{{ localize('User') }}</th>
                                    <th>{{ localize('Coin') }}</th>
                                    <th>{{ localize('Amount') }}</th>
                                    <th>{{ localize('Address') }}</th>
                                    <th>{{ localize('Status') }}</th>
                                </tr>
                                @foreach ($recentTransactions as $recentTransaction)
                                    <tr>
                                        <th>
                                            @if ($recentTransaction->merchantPaymentInfo)
                                                <p class="mb-1 fs-15 fw-medium">
                                                    {{ ($recentTransaction->merchantPaymentInfo->merchantCustomerInfo->first_name ?? null) . ' ' . ($recentTransaction->merchantPaymentInfo->merchantCustomerInfo->last_name ?? null) }}
                                                </p>
                                                <p class="mb-0 fs-12 fw-normal">
                                                    {{ $recentTransaction->merchantPaymentInfo->merchantCustomerInfo->email ?? null }}
                                                </p>
                                            @endif
                                        </th>
                                        <th>
                                            @if (
                                                $recentTransaction->merchantPaymentInfo &&
                                                    $recentTransaction->merchantPaymentInfo->merchantAcceptedCoin &&
                                                    $recentTransaction->merchantPaymentInfo->merchantAcceptedCoin->acceptCurrency)
                                                <div class="fee-coin rounded-circle">
                                                    <img src="{{ assets('img/' . $recentTransaction->merchantPaymentInfo->merchantAcceptedCoin->acceptCurrency->logo) }}"
                                                        alt="">
                                                </div>
                                            @else
                                                <img src="{{ assets('img/image.svg') }}" alt="" />
                                            @endif
                                        </th>
                                        <th>{{ $recentTransaction->amount }}
                                            {{ $recentTransaction->merchantPaymentInfo->merchantAcceptedCoin->acceptCurrency->symbol }}
                                        </th>
                                        <th>
                                            <div class="d-flex gap-3 copy-value"
                                                data-copyvalue="{{ $recentTransaction->transaction_hash }}">
                                                <p class="mb-1 w-px-160 text-truncate">
                                                    {{ $recentTransaction->transaction_hash }}</p>
                                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M10.4615 4.00504e-07H7.13321C5.6253 -1.72739e-05 4.43093 -2.61657e-05 3.49619 0.135333C2.5342 0.274625 1.75558 0.568127 1.14153 1.22947C0.527492 1.89082 0.254983 2.72943 0.125654 3.76552C-2.41964e-05 4.77226 -1.60384e-05 6.05863 3.71821e-07 7.68269V13.0349C3.71821e-07 14.6894 1.12579 16.0607 2.59734 16.3088C2.71055 16.984 2.9272 17.5602 3.36275 18.0294C3.85663 18.5613 4.47847 18.7901 5.21703 18.897C5.92839 19 6.83282 19 7.95495 19H10.5066C11.6287 19 12.5332 19 13.2446 18.897C13.9831 18.7901 14.6049 18.5613 15.0988 18.0294C15.5927 17.4974 15.8051 16.8277 15.9044 16.0323C16 15.2661 16 14.292 16 13.0834V8.56776C16 7.35922 16 6.38508 15.9044 5.61892C15.8051 4.82347 15.5927 4.15373 15.0988 3.6218C14.6632 3.1527 14.1282 2.91935 13.5013 2.79743C13.271 1.21251 11.9977 4.00504e-07 10.4615 4.00504e-07ZM12.2087 2.66987C11.9602 1.88783 11.2719 1.32558 10.4615 1.32558H7.17949C5.61492 1.32558 4.50339 1.32699 3.66018 1.44909C2.83468 1.56862 2.35907 1.7928 2.01182 2.1668C1.66457 2.5408 1.45643 3.05304 1.34544 3.94215C1.23207 4.85031 1.23077 6.04746 1.23077 7.73256V13.0349C1.23077 13.9076 1.75281 14.649 2.47891 14.9166C2.46152 14.3776 2.46153 13.7681 2.46154 13.0834V8.56776C2.46152 7.35922 2.46151 6.38508 2.55714 5.61892C2.65644 4.82347 2.86887 4.15373 3.36275 3.6218C3.85663 3.08987 4.47847 2.86108 5.21703 2.75413C5.92839 2.65113 6.83282 2.65115 7.95495 2.65116H10.5066C11.1423 2.65115 11.7082 2.65115 12.2087 2.66987ZM4.23303 4.55913C4.46012 4.31455 4.77895 4.15508 5.38102 4.0679C6.0008 3.97815 6.82224 3.97674 8 3.97674H10.4615C11.6393 3.97674 12.4607 3.97815 13.0805 4.0679C13.6826 4.15508 14.0014 4.31455 14.2285 4.55913C14.4556 4.8037 14.6037 5.1471 14.6846 5.79555C14.7679 6.46307 14.7692 7.34777 14.7692 8.61628V13.0349C14.7692 14.3034 14.7679 15.1881 14.6846 15.8556C14.6037 16.5041 14.4556 16.8474 14.2285 17.092C14.0014 17.3367 13.6826 17.4961 13.0805 17.5833C12.4607 17.673 11.6393 17.6744 10.4615 17.6744H8C6.82224 17.6744 6.0008 17.673 5.38102 17.5833C4.77895 17.4961 4.46012 17.3367 4.23303 17.092C4.00595 16.8474 3.85789 16.5041 3.77694 15.8556C3.69361 15.1881 3.69231 14.3034 3.69231 13.0349V8.61628C3.69231 7.34777 3.69361 6.46307 3.77694 5.79555C3.85789 5.1471 4.00595 4.8037 4.23303 4.55913Z"
                                                        fill="#6C6C6C"></path>
                                                </svg>
                                            </div>
                                        </th>
                                        <th>
                                            @if ($recentTransaction->status == MerchantPaymentTransactionStatusEnum::COMPLETE)
                                                <span
                                                    class="badge bg-label-success py-2 w-px-100">{{ enum_ucfirst_case($recentTransaction->status->name) }}</span>
                                            @elseif($recentTransaction->status == MerchantPaymentTransactionStatusEnum::PENDING)
                                                <span
                                                    class="badge bg-label-warning py-2 w-px-100">{{ enum_ucfirst_case($recentTransaction->status->name) }}</span>
                                            @else
                                                <span
                                                    class="badge bg-label-danger py-2 w-px-100">{{ enum_ucfirst_case($recentTransaction->status->name) }}</span>
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-app-layout>
