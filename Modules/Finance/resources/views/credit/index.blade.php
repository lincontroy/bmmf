<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Credit List') }}</h3>

                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="add-user-button" data-bs-toggle="modal" data-bs-target="#addCredit"
                                    class="btn btn-save lh-sm">
                                <svg width="12" height="12"
                                     viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                                <span class="me-1">{{ localize('Add Credit') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Data table -->
                <x-data-table :dataTable="$dataTable"/>
                <!-- Data table -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCredit" tabindex="-1" aria-labelledby="addCreditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Add Credit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('deposit.store') }}" data-route="{{ route('admin.finance.getUser') }}"
                          method="post" class="needs-validation"
                          data="showCallBackData" id="credit-form" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 g-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                                {{ localize('Accept Currency') }}  <span class="text-danger">*</span></label>
                                            <select
                                                class="custom-form-control bg-transparent placeholder-single @error('accept_currency_id') is-invalid @enderror"
                                                name="accept_currency_id" id="accept_currency_id" required>
                                                <option value="">Select Option</option>
                                                @foreach ($currency as $index => $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" role="alert">
                                                @error('accept_currency_id')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                   for="user_id">{{ localize('User Id') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="user_id" id="user_id" value="{{ old('user_id') }}"
                                                   class="custom-form-control bg-transparent @error('user_id')
                                                   is-invalid
                                                   @enderror"
                                                   placeholder="User Id" required/>
                                            <div class="invalid-feedback userId" role="alert">
                                                @error('user_id')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                   for="amount">{{ localize('Amount') }}  <span class="text-danger">*</span></label>
                                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}"
                                                   class="custom-form-control bg-transparent @error('amount')
                                                   is-invalid
                                                   @enderror"
                                                   placeholder="amount" required/>
                                            <div class="invalid-feedback" role="alert">
                                                @error('amount')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                   for="note">{{ localize('Note') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="note" id="note" value="{{ old('note') }}"
                                                   class="custom-form-control bg-transparent @error('note')
                                                   is-invalid
                                                   @enderror"
                                                   placeholder="notes" required/>
                                            <div class="invalid-feedback" role="alert">
                                                @error('note')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-4 justify-content-between">
                                    <button type="reset" class="btn btn-reset fw-medium rounded-3
                                     w-100 resetBtn"><i class="fa fa-undo-alt"></i></button>
                                    <button type="submit" class="btn btn-save w-100 actionBtn">{{ localize('submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="creditDetails" tabindex="-1" aria-labelledby="addCreditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Credit Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="viewCreditDetails">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ localize('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('Finance', 'js/deposit.js') }}"></script>
    @endpush
</x-app-layout>
