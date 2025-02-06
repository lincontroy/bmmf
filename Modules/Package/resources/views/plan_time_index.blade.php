@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('plan_times') }}</h3>
                    @if ($_auth_user->can(PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::CREATE->value))
                        <div class="d-flex align-items-center gap-2">
                            <div class="border radius-10 p-1">
                                <button id="add-plan-button" data-bs-toggle="modal" data-bs-target="#addPlan"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('add_new') }}</span>
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
    <div class="modal fade show" id="addPlan" tabindex="-1" aria-labelledby="modalLabel" aria-modal="true"
        role="dialog">
        <div class="modal-dialog">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modalLabel">{{ localize('add_time') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.plan-time.store') }}"
                        data-insert="{{ route('admin.plan-time.store') }}" method="post" class="needs-validation"
                        data="showCallBackData" id="plan-time-form" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 g-4">
                            <div class="col-12">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('time_name') }}</label>
                                    <input name="name_" id="name_" class="custom-form-control bg-transparent"
                                        type="text" placeholder="e.g.Hours, Day, Month" value="{{ old('name_') }}"
                                        required>
                                    <div class="invalid-feedback" role="alert">
                                        @error('name_')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <label
                                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('time_in_hours') }}
                                            <span class="text-danger">*</label>
                                    </div>
                                    <div class="position-relative">
                                        <input name="hours_" id="hours_"
                                            class="custom-form-control bg-transparent @error('hours_') is-invalid
                                        @enderror"
                                            type="text" value="{{ old('hours_') }}" required>
                                        <div class="invalid-feedback" role="alert">
                                            @error('hours_')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <span class="invest">{{ localize('hours') }}</span>

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
                                        class="btn btn-save w-100 actionBtn">{{ localize('submit') }}</button>
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
        <script>
            var showCallBackData = function() {
                $("#addPlan").modal('hide');
                $('#plan-time-table').DataTable().ajax.reload();
            }

            $(document).on('click', '#add-plan-button', function() {

                $("#modelLabel").html('Add Plan Time');
                $(".actionBtn").html('Submit');


                $("#plan-time-form").find('input[name="_method"]').remove();
                $("#plan-time-form").attr('action', $("#plan-time-form").attr('data-insert'));

                removeFormValidation($('#plan-time-form'), new FormData(document.querySelector('#plan-time-form')),
                    true)
            });

            $(document).on('click', '.edit-button', function() {
                // set form value
                $("#modelLabel").html('Update Plan Time');
                $(".actionBtn").html('Update');
                $("#plan-time-form").attr('action', $(this).attr('data-action'));

                if (!$("#plan-time-form").find('input[name="_method"]').length) {
                    $("#plan-time-form").prepend('<input type="hidden" name="_method" value="patch" />');
                }

                // set form data by route
                let result = setFormValue($(this).attr('data-route'), $('#plan-time-form'), new FormData(document
                    .querySelector(
                        '#plan-time-form')));

                result.then(data => {
                    $('#name_').val(data.name_);
                    $('#hours_').val(data.hours_);
                }).catch(res => {

                });

                // show model
                $("#addPlan").modal('show');
            });
        </script>
    @endpush
</x-app-layout>
