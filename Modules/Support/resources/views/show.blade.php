@php
    use App\Enums\CustomerVerifyStatusEnum;
    use Carbon\Carbon;
    use App\Enums\StatusEnum;
@endphp

<div class="tab-pane show active" id="list-item1" role="tabpanel" aria-labelledby="list-item1-tab">
    <div class="messenger-dialog row m-0">
        <div class="messenger-dialog__area p-0">
            <div class="chat-header d-flex align-items-center">
                <button type="button" class="btn chat-sidebar-collapse d-block d-xl-none">
                    <i class="material-icons">{{ localize('menu') }}</i>
                </button>
                <div class="meta-info data">
                    <h5><a href="#">{{ localize('Support') }}</a></h5>
                </div>
                <button class="btn d-block d-lg-none chat-settings-collapse" title="Settings"><i
                        class="material-icons">{{ localize('settings') }}</i></button>
            </div>


            <div class="message-content message-content-scroll bg-text-green">
                @if (isset($customerMessages))
                    <div class="position-relative">

                        @foreach ($customerMessages as $key => $message)
                            @php
                                $carbonDate = Carbon::parse($message->msg_time);
                            @endphp

                            @if ($message->replay_status == '0')
                                <div class="message-left">
                                    <div class="align-items-center d-flex justify-content-start">
                                        <div class="d-flex align-items-center">
                                            @if ($customer->customerInfo && $customer->customerInfo->avatar)
                                                <img src="{{ storage_asset($customer->customerInfo->avatar) }}"
                                                    alt="avatar" />
                                            @elseif (empty($customer->customerInfo->user_id))
                                                <img src="{{ storage_asset('upload/customer/unknown.png') }}"
                                                    alt="avatar" />
                                            @else
                                                <img src="{{ asset('assets/img/user.png') }}" alt="avatar" />
                                            @endif
                                            <span class="message-title">{{ $customer->user_name }}</span>

                                        </div>
                                    </div>
                                    <div class="align-items-center d-flex flex-column gap-2">
                                        <span class="fs-11 text-black-50">{{ $message->msg_time }}</span>
                                        <div class="message-box">
                                            <p class="text">{{ $message->msg_body }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!--/.message-->
                            @else
                                <div class="message-right">
                                    <div class="align-items-center d-flex justify-content-end">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="message-title">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                                            @if (auth()->user()->image)
                                                <img class="avatar" src="{{ storage_asset(auth()->user()->image) }}"
                                                    alt="avatar" />
                                            @else
                                                <img class="avatar" src="{{ asset('assets/img/user.png') }}"
                                                    alt="avatar" />
                                            @endif
                                        </div>
                                    </div>

                                    <div class="align-items-center d-flex flex-column gap-2">
                                        <span class="fs-11 text-black-50">{{ $message->msg_time }}</span>
                                        <div class="message-box">
                                            <p class="text">
                                                {{ $message->msg_body }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/.message-->
                            @endif
                        @endforeach
                        <!--/.message-->
                    </div>
                @endif
            </div>
            <!--/.tab content-->
            <div class="chat-area-bottom d-flex align-items-center">
                <form class="position-relative w-100" action="{{ route('admin.support.store') }}"
                    data-insert="{{ route('admin.support.store') }}" method="post" id="message-form"
                    enctype="multipart/form-data">
                    @csrf
                    <textarea name="msg_body" id="msg_body" class="form-control emojionearea" placeholder="Type a message here..."
                        rows="1" required></textarea>
                    <button type="button" class="btn send d-flex align-items-center" id="sentMessage">
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
        @if (isset($customer))
            <div class="chat-list__sidebar--right">
                <div class="chat-user__info text-center">
                    <div class="user-right">
                        <div class="avatar mb-3">
                            @if ($customer->customerInfo && $customer->customerInfo->avatar)
                                <img src="{{ storage_asset($customer->customerInfo->avatar) }}" alt="avatar" />
                            @elseif (empty($customer->customerInfo->user_id))
                                <img src="{{ storage_asset('upload/customer/unknown.png') }}" alt="avatar" />
                            @else
                                <img src="{{ asset('assets/img/user.png') }}" alt="avatar" />
                            @endif
                        </div>
                        <h5 class="title mb-1">{{ $customer->user_name }}</h5>
                    </div>

                    <div class="user-right-info">
                        <p class="mb-0">USER INFORMATION</p>
                    </div>
                    <div class="user-right-info-details">
                        <p>{{ $customer->user_email }}</p>
                        @if ($customer->customerInfo)
                            <p>{{ $customer->customerInfo->phone }}</p>
                            <p>{{ $customer->customerInfo->address }}</p>
                        @endif
                    </div>
                    @if ($customer->customerInfo)
                        <div class="user-right-additional">
                            <p class="mb-0">Additional</p>
                        </div>
                        <div class="user-right-additional-details">
                            <table class="message-info-table">
                                <tr>
                                    <td class="text-start">User ID</td>
                                    <td class="px-2">:</td>
                                    <td class="text-start">{{ $customer->user_id ?? '' }}</td>
                                </tr>

                                <tr>
                                    <td class="text-start">Status</td>
                                    <td class="px-2">:</td>
                                    @if ($customer->customerInfo->status->value === StatusEnum::ACTIVE->value)
                                        <td class="text-start text-success">{{ StatusEnum::ACTIVE->name }}</td>
                                    @else
                                        <td class="text-start text-danger">{{ StatusEnum::INACTIVE->name }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-start">Verify Status</td>
                                    <td class="px-2">:</td>
                                    @if ($customer->customerInfo->verified_status->value === CustomerVerifyStatusEnum::VERIFIED->value)
                                        <td class="text-start text-success">
                                            {{ CustomerVerifyStatusEnum::VERIFIED->name }}</td>
                                    @elseif($customer->customerInfo->verified_status->value === CustomerVerifyStatusEnum::NOT_SUBMIT->value)
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
        @endif
        <!--/.chat list sidebar right-->
    </div>
</div>
