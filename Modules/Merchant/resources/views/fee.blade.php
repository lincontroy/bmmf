@section('title')
    Merchant Fees
@endsection
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <form action="{{ route('admin.merchant.create') }}" data-insert="" method="post" class="needs-validation"
                data="showCallBackData" id="package-form" novalidate="" enctype="multipart/form-data"
                data-resetvalue="false">
                @csrf
                <div class="card p-4 p-xl-5 radius-15">
                    <h3 class="fs-24 mb-5 text-color-2 fw-medium lh-1">{{ localize('Merchant Fees') }}</h3>
                    <div class="row">
                        @foreach ($currencies as $key => $currency)
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ $currency['name'] }}</label>
                                    <div class="align-items-center border d-flex gap-3 p-1 rounded-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-floral-white fee-coin p-2 radius-10">
                                                @if ($currency['logo'])
                                                    <img src="{{ assets('img/' . $currency['logo']) }}"
                                                        alt="" />
                                                @else
                                                    {{ $currency['symbol'] }}
                                                @endif
                                            </div>
                                            <span class="text-color-4 fs-15 fw-normal">Fee*</span>
                                        </div>
                                        <input name="accept_currency_id[]" type="hidden"
                                            value="{{ $currency['id'] }}" />
                                        <input name="percent[]" class="custom-form-control border-0" type="text"
                                            placeholder="Fee Percent"
                                            value="{{ $currency['marchentAcceptCoinInfo']->percent ?? 0 }}" required />
                                        <span class="px-3">%</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-save actionBtn">{{ localize('Update') }}</button>
                        </div>
                    </div>
                    <div class="col-12">
                        {{ $currencies->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('Merchant', 'js/fees.js?v=1') }}"></script>
    @endpush
</x-app-layout>
