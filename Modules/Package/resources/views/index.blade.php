@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Package List') }}</h3>
                    @if ($_auth_user->can(PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::CREATE->value))
                        <div class="d-flex align-items-center gap-2">
                            <div class="border radius-10 p-1">
                                <button id="add-user-button" data-bs-toggle="modal" data-bs-target="#addPackage"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add New') }}</span>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Data table -->
                <x-data-table :dataTable="$dataTable" />
                <!-- Data table -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPackage" tabindex="-1" aria-labelledby="addPackageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Add New Plan') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.package.store') }}" data-insert="{{ route('admin.package.store') }}"
                        method="post" class="needs-validation" data="showCallBackData" id="package-form" novalidate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 g-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="name">{{ localize('Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}"
                                                class="custom-form-control bg-transparent @error('name') is-invalid @enderror"
                                                placeholder="Plan name" required />
                                            <div class="invalid-feedback" role="alert">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                                {{ localize('Invest Type') }}
                                                <span class="text-danger">*</span></label>
                                            <select
                                                class="custom-form-control bg-transparent placeholder-single  @error('invest_type') is-invalid @enderror"
                                                name="invest_type" id="invest_type" required>
                                                @foreach ($formData['investmentType'] as $index => $item)
                                                    <option value="{{ $item }}" @selected($item === '1')>
                                                        {{ $index }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" role="alert">
                                                @error('invest_type')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row rangeRow">
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Minimum Invest') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input name="min_price" id="min_price"
                                                    class="custom-form-control
                                                bg-transparent @error('min_price') is-invalid @enderror"
                                                    type="text" required />
                                                <div class="invalid-feedback" role="alert">
                                                    @error('min_price')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                                <span class="invest">USD</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Maximum Invest') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input name="max_price" id="max_price"
                                                    class="custom-form-control bg-transparent @error('max_price') is-invalid @enderror"
                                                    type="text" required />
                                                <div class="invalid-feedback" role="alert">
                                                    @error('max_price')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                                <span class="invest">USD</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row amountRow">
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                                {{ localize('Invest Amount') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input name="amount" id="amount"
                                                    class="custom-form-control
                                                bg-transparent @error('amount') is-invalid @enderror"
                                                    type="text" />
                                                <div class="invalid-feedback" role="alert">
                                                    @error('amount')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                                <span class="invest">USD</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2 modal-select">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Interest Type') }}
                                                <span class="text-danger">*</span></label>
                                            <select
                                                class="custom-form-control bg-transparent placeholder-single @error('interest_type') is-invalid @enderror"
                                                name="interest_type" id="interest_type" required>
                                                @foreach ($formData['interestType'] as $index => $item)
                                                    <option value="{{ $item }}">{{ $index }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" role="alert">
                                                @error('interest_type')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16
                                            fw-medium"><span
                                                    class="interestPercent">{{ localize('Interest Percent') }} </span>
                                                <span class="interestAmt">{{ localize('Interest Amount') }}</span>
                                                <span class="text-danger">*</span></label>
                                            <input name="interest" id="interest"
                                                class="custom-form-control bg-transparent @error('interest') is-invalid @enderror"
                                                type="text" required />
                                            <div class="invalid-feedback" role="alert">
                                                @error('interest')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2 modal-select">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Time') }}
                                                <span class="text-danger">*</span></label>
                                            <select
                                                class="custom-form-control bg-transparent placeholder-single  @error('plan_time_id') is-invalid @enderror"
                                                name="plan_time_id" id="plan_time_id" required>
                                                <option value="">{{ localize('Select Option') }}</option>
                                                @foreach ($planTimes as $k => $planTime)
                                                    <option value="{{ $planTime->id }}">{{ $planTime->name_ }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" role="alert">
                                                @error('plan_time_id')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2 modal-select">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Return Type') }}
                                                <span class="text-danger">*</span></label>
                                            <select class="custom-form-control bg-transparent placeholder-single"
                                                name="return_type" id="return_type" required>
                                                @foreach ($formData['returnType'] as $index => $item)
                                                    <option value="{{ $item }}">
                                                        {{ str_replace('_', ' ', $index) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row capitalBackRow">
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2 modal-select">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="repeat_time">{{ localize('Repeat Time') }} <span
                                                    class="text-danger">*</span></label>
                                            <input name="repeat_time" id="repeat_time"
                                                class="custom-form-control bg-transparent @error('repeat_time') is-invalid @enderror"
                                                type="text" />
                                            <div class="invalid-feedback" role="alert">
                                                @error('repeat_time')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-2 modal-select">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16
                                        fw-medium">Capital
                                                Back
                                                <span class="text-danger">*</span></label>
                                            <select
                                                class="custom-form-control bg-transparent basic-single @error('capital_back') is-invalid @enderror"
                                                name="capital_back" id="capital_back">
                                                <option value="">{{ localize('Select Option') }}</option>
                                                @foreach ($formData['capitalBack'] as $index => $item)
                                                    <option value="{{ $item }}">{{ $index }}</option>
                                                @endforeach
                                            </select>
                                            @error('capital_back')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="image">{{ localize('image') }}</label>
                                        <div class="border-all mb-3 p-2 radius-10 w-max-content" id="preview_file_image">
                                            <img width="80"  height="50" class="preview_image" src="{{ assets('img/package.png') }}"alt="" />
                                        </div>
                                        <div class="custom-file-button position-relative mb-3">
                                            <input type="file" name="image" id="image" accept="image/*"
                                                class="custom-form-control file-preview  @error('image') is-invalid @enderror"
                                                data-previewDiv="preview_file_image" />
                                        </div>
                                        <div class="invalid-feedback" role="alert">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-4 justify-content-between">
                                    <button type="reset"
                                        class="btn btn-reset fw-medium rounded-3
                                     w-100 resetBtn"><i
                                            class="fa fa-undo-alt"></i></button>
                                    <button type="submit"
                                        class="btn btn-save w-100 actionBtn">{{ localize('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('lib-styles')
        <link href="{{ assets('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ assets('vendor/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    @endpush

    @push('lib-scripts')
        <script src="{{ assets('vendor/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ assets('js/pages/app.select2.js') }}"></script>
    @endpush

    @push('js')
        <script src="{{ module_asset('Package', 'js/package.js') }}"></script>
    @endpush
</x-app-layout>
