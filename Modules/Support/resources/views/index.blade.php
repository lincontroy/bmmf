@extends('support::layouts.master')

@section('content')
    <div class="chat-container row m-0">
        <div class="chat-list__sidebar p-0">
            <div class="d-flex justify-content-between align-items-center chat-title p-3 border-bottom">
                <p class="mb-0 fs-15 fw-semi-bold text-primary">{{ localize('Customers') }}</p>
                <button class="btn d-md-block d-none search-btn" title="Search in conversation">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.69724 15.3945C9.40504 15.3941 11.0636 14.8224 12.4089 13.7704L16.6385 18L17.999 16.6395L13.7694 12.4099C14.822 11.0645 15.3941 9.40549 15.3945 7.69724C15.3945 3.45318 11.9413 0 7.69724 0C3.45318 0 0 3.45318 0 7.69724C0 11.9413 3.45318 15.3945 7.69724 15.3945ZM7.69724 1.92431C10.881 1.92431 13.4702 4.51347 13.4702 7.69724C13.4702 10.881 10.881 13.4702 7.69724 13.4702C4.51347 13.4702 1.92431 10.881 1.92431 7.69724C1.92431 4.51347 4.51347 1.92431 7.69724 1.92431Z"
                            fill="#C4CACD" />
                    </svg>
                </button>
            </div>

            <div class="chat-list__in" id="chat-list__in">
                <div class="conversation-search">
                    <div class="d-flex">
                        <div class="input-group gap-2">
                            <i class="ti-search search__icon"></i>
                            <input class="form-control" type="text" name="search_box" id="search_box"
                                placeholder="Search user Id" value="<?php echo isset($search_key) ? $search_key : ''; ?>" required=""
                                data-action="{{ route('admin.support.search') }}">
                        </div>
                    </div>
                </div>
                <!--/.conversation search-->
                <input type="hidden" id="message_user_id">
                <input type="hidden" id="onload_url" value="{{ route('admin.support.onLoad') }}">
                <input type="hidden" id="page_increment" value="2">
                <div class="nav chat-list flex-column flex-nowrap nav" role="tablist" id="checkIdentify">
                    @csrf
                    @foreach ($customers as $key => $customer)
                        <a data-id="{{ $customer->id }}" data-userId="{{ $customer->user_id }}"
                            data-action="{{ route('admin.support.show', ['support' => $customer->id]) }}"
                            class="user-wise_message returnData_{{ $customer->id }} item-list item-list__chat d-flex align-items-start unseen @if ($key == 0) active @endif"
                            id="list-item1-tab" data-bs-toggle="tab" href="#list-item1" role="tab"
                            aria-controls="list-item1" aria-selected="true">
                            <div class="avatar">
                                @if ($customer->customerInfo && $customer->customerInfo->avatar)
                                    <img src="{{ storage_asset($customer->customerInfo->avatar) }}" alt="avatar" />
                                @elseif (empty($customer->customerInfo->user_id))
                                    <img src="{{ storage_asset('upload/customer/unknown.png') }}" alt="avatar" />
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" alt="avatar" />
                                @endif
                            </div>
                            <div class="info-text">
                                <h5>{{ $customer->user_name }}</h5>
                                <span
                                    class="@if ($customer->message_status == '0') text-black fw-bold @endif">{{ $customer->msg_time }}</span>
                                <p>{{ $customer->user_email }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!--/.chat list sidebar-->
        <div class="tab-content chat-panel p-0" id="showMessageContent">
            {{-- @include('support::show') --}}
        </div>
        <div class="chat-overlay"></div>
    </div>
    <!--/.chat container-->
@endsection
