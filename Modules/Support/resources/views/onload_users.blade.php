
@foreach($customers as $key => $customer)
    <a data-id="{{ $customer->id }}" data-userId="{{ $customer->user_id }}"
       data-action="{{ route('admin.support.show', ['support' => $customer->id]) }}"
       class="user-wise_message returnData_{{ $customer->id }} item-list item-list__chat d-flex align-items-start unseen @if($key == 0) active @endif"
       id="list-item1-tab"
       data-bs-toggle="tab" href="#list-item1" role="tab" aria-controls="list-item1"
       aria-selected="true">
        <div class="avatar">
            @if($customer->customerInfo && $customer->customerInfo->avatar)
                <img src="{{ storage_asset($customer->customerInfo->avatar) }}" alt="avatar"/>
            @else
                <img src="{{ asset('assets/img/user.png') }}" alt="avatar"/>
            @endif
            <div class="status online"></div>
        </div>
        <div class="info-text">
            <h5>{{ $customer->user_name }}</h5>
            <span class="@if($customer->message_status === '0') text-black fw-bold @endif">{{ $customer->msg_time }}</span>
            <p>{{ $customer->user_email }}</p>
        </div>
    </a>
@endforeach
