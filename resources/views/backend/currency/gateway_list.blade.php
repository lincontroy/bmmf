@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 radius-15">
                    <div
                        class="card-header d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center pt-0 mb-3">
                        <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Payment Gateway') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 gy-5">
                            @foreach ($paymentGateway as $gateway)
                                <div class="col-md-6 col-lg-3 col-xl_5 payment-gateway">
                                    <div class="upload-doc p-2 position-relative">
                                        <div class="mb-3 max-height-80">
                                            <img class="radius-10 w-100 min-height-80 max-height-80"
                                                src="{{ asset('storage/' . $gateway->logo) }}" alt="" />
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <span class="fs-18 text-color-2">{{ $gateway->name }}</span>
                                            @if ($gateway->status == '1')
                                                <div id="gateway-status-{{ $gateway->id }}">
                                                    <span class="fs-18 text-success">{{ localize('Active') }}</span>
                                                </div>
                                            @else
                                                <div id="gateway-status-{{ $gateway->id }}">
                                                    <span class="fs-18 text-danger">{{ localize('Inactive') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div
                                            class="d-flex align-items-center gap-3 justify-content-center payment-btn-group">
                                            @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::UPDATE->value))
                                                <a href="javascript:void(0)"
                                                    class="btn btn-navy py-2 px-3 radius-10 lh-1 edit-button"
                                                    data-action="{{ route('admin.payment.gateway.edit', ['gateway' => $gateway->id]) }}">
                                                    <svg width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M12.6907 0.583178C11.9131 -0.194389 10.6525 -0.194396 9.87492 0.583178L8.76004 1.69806L3.51286 6.94521C3.4278 7.0303 3.36747 7.13689 3.33829 7.25356L2.6746 9.90835C2.61805 10.1345 2.68432 10.3738 2.84917 10.5386C3.01402 10.7035 3.25327 10.7698 3.47945 10.7132L6.1342 10.0495C6.25094 10.0203 6.35747 9.95999 6.44255 9.8749L11.6516 4.66592L12.8046 3.51288C13.5822 2.73531 13.5822 1.47462 12.8046 0.697048L12.6907 0.583178ZM10.8135 1.52179C11.0727 1.2626 11.4929 1.2626 11.7521 1.52179L11.866 1.63566C12.1252 1.89485 12.1252 2.31508 11.866 2.57427L11.1914 3.24893L10.159 2.17627L10.8135 1.52179ZM9.22025 3.11505L10.2526 4.18771L5.63397 8.80635L4.23064 9.15718L4.58146 7.75386L9.22025 3.11505ZM1.32739 4.09605C1.32739 3.72951 1.62454 3.43236 1.99108 3.43236H5.30956C5.67612 3.43236 5.97325 3.13521 5.97325 2.76866C5.97325 2.40211 5.67612 2.10496 5.30956 2.10496H1.99108C0.891442 2.10496 0 2.99641 0 4.09605V11.3967C0 12.4964 0.891442 13.3878 1.99108 13.3878H9.29173C10.3914 13.3878 11.2828 12.4964 11.2828 11.3967V8.07821C11.2828 7.71171 10.9857 7.41451 10.6191 7.41451C10.2526 7.41451 9.95542 7.71171 9.95542 8.07821V11.3967C9.95542 11.7633 9.65829 12.0604 9.29173 12.0604H1.99108C1.62454 12.0604 1.32739 11.7633 1.32739 11.3967V4.09605Z"
                                                            fill="white" />
                                                    </svg>
                                                    <span>{{ localize('Edit') }}</span>
                                                </a>
                                            @endif
                                            @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::DELETE->value))
                                                <a href="javascript:void(0)"
                                                    class="btn btn-danger py-2 px-3 radius-10 lh-1 delete-button"
                                                    action-type="Delete"
                                                    data-action="{{ route('admin.payment.gateway.destroy', ['gateway' => $gateway->id]) }}"
                                                    data-callback="gatewayDestroy" title="Delete">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                    {{ localize('Erase') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.edit-modal class="modal-lg modal-dialog-scrollable" />

    @push('js')
        <script src="{{ assets('js/currency/gateway.js') }}"></script>
    @endpush
</x-app-layout>
