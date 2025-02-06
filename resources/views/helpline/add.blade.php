@php
    use App\Enums\CustomerVerifyStatusEnum;
    use App\Enums\StatusEnum;
@endphp
<x-customer-app-layout>
    <div class="chat-container row m-0">
        <div class="col-12">
            <div class="messenger-dialog row">
                <div class="messenger-dialog__area p-0">
                    <div class="chat-header px-4 py-3 d-flex align-items-center justify-content-between">
                        <div class="meta-info data">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-img rounded-circle" id="profileImage">
                                    <img src="{{ auth()->user()->avatar ? storage_asset(auth()->user()->avatar) : assets('img/user.png') }}"
                                        class="img-fluid rounded-circle" alt="" />
                                </div>
                                <div>
                                    <p class="mb-1 fs-15 user-name fw-medium">
                                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="fs-16 text-black-50 mb-0 fw-medium d-none d-lg-block">{{ date('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="message-content message-content-scroll bg-text-green">
                        <div class="position-relative px-md-4 chat-history">
                            @foreach ($chatList as $message)
                                @if ($message->replay_status === '0')
                                    <div class="message-left">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ auth()->user()->avatar ? storage_asset(auth()->user()->avatar) : assets('img/user.png') }}"
                                                    class="img-fluid rounded-circle" alt="" />
                                                <span
                                                    class="message-title">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                                                <span class="text">{{ $message->created_at }}</span>
                                            </div>
                                        </div>
                                        <div class="message-box">
                                            <p class="text">{{ $message->msg_body }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="message-right">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="d-flex align-items-center">
                                                <span class="text">{{ $message->created_at }}</span>
                                                <span class="message-title">Support Team</span>
                                                <img src="{{ $settings->favicon ? storage_asset($settings->favicon) : assets('img/user.png') }}"
                                                    alt="Avatar" class="rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="message-box">
                                            <p class="text">{{ $message->msg_body }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <!--/.tab content-->
                    <div class="chat-area-bottom d-flex align-items-center">
                        <form action="{{ url('customer/helpline/send') }}" method="post"
                            class="form-send-message position-relative w-100">
                            @csrf
                            <input class="form-control emojionearea message-input" placeholder="Type a message here...">
                            <button type="submit" class="btn send d-flex align-items-center">
                                <svg width="24" height="24" viewBox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.5918 1.71245L2.38095 6.25004H7.25013C7.66434 6.25004 8.00013 6.58582 8.00013 7.00004C8.00013 7.41425 7.66434 7.75004 7.25013 7.75004H2.38095L1.5918 12.2876L13.9295 7.00004L1.5918 1.71245ZM0.988869 7.00004L0.0637969 1.68087C-0.0109877 1.25086 0.128154 0.811352 0.436783 0.502722C0.824568 0.114942 1.40938 0.00231168 1.91345 0.218342L15.3158 5.9622C15.7309 6.14013 16.0001 6.54835 16.0001 7.00004C16.0001 7.45172 15.7309 7.85995 15.3158 8.03788L1.91345 13.7817C1.40938 13.9978 0.824568 13.8851 0.436783 13.4974C0.128154 13.1887 -0.0109879 12.7492 0.0637969 12.3192L0.988869 7.00004Z"
                                        fill="#0060FF" />
                                </svg>

                            </button>
                        </form>
                    </div>
                    <!--/.chat area bottom-->
                </div>

                <div class="chat-list__sidebar--right">
                    <div class="chat-user__info text-center">
                        <div class="user-right">
                            <div class="avatar mb-3">
                                @if ($user && $user->avatar)
                                    <img src="{{ storage_asset($user->avatar) }}" alt="avatar" />
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" alt="avatar" />
                                @endif
                            </div>
                            <h5 class="title mb-1">{{ $user->user_name }}</h5>
                        </div>

                        <div class="user-right-info">
                            <p class="mb-0">{{ localize('USER INFORMATION') }}</p>
                        </div>
                        <div class="user-right-info-details">
                            <p>{{ $user->user_email }}</p>
                            @if ($user)
                                <p>{{ $user->phone }}</p>
                                <p>{{ $user->address }}</p>
                            @endif
                        </div>
                        @if ($user)
                            <div class="user-right-additional">
                                <p class="mb-0">Additional</p>
                            </div>
                            <div class="user-right-additional-details">
                                <table class="message-info-table">
                                    <tr>
                                        <td class="text-start">{{ localize('User ID') }}</td>
                                        <td class="px-2">:</td>
                                        <td class="text-start">{{ $user->user_id ?? '' }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-start">Status</td>
                                        <td class="px-2">:</td>
                                        @if ($user->status->value === StatusEnum::ACTIVE->value)
                                            <td class="text-start text-success">{{ StatusEnum::ACTIVE->name }}</td>
                                        @else
                                            <td class="text-start text-danger">{{ StatusEnum::INACTIVE->name }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="text-start">Verify Status</td>
                                        <td class="px-2">:</td>
                                        @if ($user->verified_status->value === CustomerVerifyStatusEnum::VERIFIED->value)
                                            <td class="text-start text-success">
                                                {{ CustomerVerifyStatusEnum::VERIFIED->name }}</td>
                                        @elseif($user->verified_status->value === CustomerVerifyStatusEnum::NOT_SUBMIT->value)
                                            <td class="text-start text-primary" role="status">
                                                {{ str_replace('_', ' ', CustomerVerifyStatusEnum::NOT_SUBMIT->name) }}
                                            </td>
                                        @else
                                            <td class="text-start text-success">
                                                {{ CustomerVerifyStatusEnum::PROCESSING->name }}</td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                <!--/.chat list sidebar right-->
            </div>
        </div>
        <div class="chat-overlay"></div>
        <!--/.chat list sidebar-->
    </div>

    @push('js')
        <script src="{{ asset('assets/js/app-chat.js') }}"></script>
    @endpush
</x-customer-app-layout>>
