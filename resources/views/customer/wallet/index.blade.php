@php use App\Enums\TransactionTypeEnum; @endphp
<x-customer-app-layout>
    <div class="card py-4 pb-0 shadow-none radius-15">
        <div
            class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
            <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('wallets') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-4">
                    <thead>
                    <tr>
                        <th>{{ localize('symbol') }}</th>
                        <th class="text-center">{{ localize('balance') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wallets as $key => $wallet)
                        <tr>
                            <td>
                                <img width="32" height="32" class="rounded-circle"
                                     src="{{ assets($wallet->logo?'img/'.$wallet->logo:'img/user.png') }}">
                                <span>{{ $wallet->name }} ({{ $wallet->symbol }})</span>
                            </td>
                            <td class="text-center">{{ $wallet->getBalance?number_format($wallet->getBalance->balance,6):'0.000000' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table class="table table-bordered mb-4">
                    <thead>
                    <tr>
                        <th>{{ localize('coin') }}</th>
                        <th>{{ localize('date') }}</th>
                        <th>{{ localize('transaction_type') }}</th>
                        <th>{{ localize('transaction') }}</th>
                        <th class="text-center">{{ localize('amount') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactionLogs as $index => $log)
                        <tr>
                            <td>
                                <img width="32" height="32" class="rounded-circle"
                                     src="{{ $log->currency?assets('img/'.$log->currency->logo):assets('img/user.png') }}">
                                <span>{{ $log->currency->name }} ({{ $log->currency->symbol }})</span>
                            </td>
                            <td>{{ get_ymd($log->created_at) }}</td>
                            @if($log->transaction_type == TransactionTypeEnum::DEBIT->value)
                                <td class="text-danger">{{ localize('Debited') }}</td>
                            @else
                                <td class="text-success">{{ localize('Credited') }}</td>
                            @endif
                            <td>{{ str_replace('_', ' ', $log->transaction) }}</td>
                            @if($log->transaction_type == TransactionTypeEnum::DEBIT->value)
                                <td class="text-danger text-center">-{{ number_format($log->amount, 6) }}</td>
                            @else
                                <td class="text-success text-center">+{{ number_format($log->amount, 6) }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="float-end">
                {{ $transactionLogs->links() }}
            </div>
        </div>
    </div>
</x-customer-app-layout>
