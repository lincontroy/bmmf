<div class="row">
    <div class="col-sm-6">
        @if($settingInfo['setting']['logo'] != '')
            <img class="img-responsive"
                 src="{{ $settingInfo['setting']->logo ?? null ? storage_asset($settingInfo['setting']->logo ?? null) : admin_asset('img/logo-1.png') }}"
                 alt="{{ localize('Logo') }}" />
        @else
            <img src="https://nishuedemo.bdtask-demo.com/public/uploads/settings/1609072784_a3d6ceb248256f995c1e.png"
                 class="img-responsive" alt="">
        @endif
        <br>
        <address>
            <strong>{{ $settingInfo['setting']['title'] }}</strong>
            <br>
            {{ $settingInfo['setting']['description'] }}
        </address>
    </div>
    <div class="col-sm-6 text-right">
        <h1 class="m-t-0">{{ localize('Credit_No') }} : {{ $creditDetails->id }}</h1>
        <div>{{ get_ymd($creditDetails->date) }}</div>
        <address>
            <strong> {{ $creditDetails->customerInfo->first_name." "
            .$creditDetails->customerInfo->last_name }} </strong><br>
            <abbr title="{{ localize('Email') }}"><span class="fw-semi-bold"> {{ localize('Email') }} :</span> {{
            $creditDetails->customerInfo->email }}</abbr><br>
            <abbr title="{{ localize('Phone') }}"><span class="fw-semi-bold"> {{ localize('Phone') }} :</span> {{
            $creditDetails->customerInfo->phone }}</abbr><br>
            <abbr title="{{ localize('account') }}"><span class="fw-semi-bold"> {{ localize('Account') }} :</span> {{
            $creditDetails->customerInfo->user_id }}</abbr>
        </address>
    </div>
</div>
<hr>
<div class="table-responsive m-b-20">
    <table class="table table-border table-bordered ">
        <thead>
        <tr>
            <th>{{ localize('User ID') }}</th>
            <th>{{ localize('Date') }}</th>
            <th>{{ localize('Amount') }}</th>
            <th>{{ localize('Comments') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div><strong>{{ $creditDetails->user_id }}</strong></div>
            </td>
            <td>{{ get_ymd($creditDetails->date) }}</td>
            <td>{{ $creditDetails->amount }}</td>
            <td>{{ $creditDetails->comments }}</td>
        </tr>
        </tbody>
    </table>
</div>
