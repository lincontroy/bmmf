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
        <h1 class="m-t-0">{{ localize('Transfer_No') }} : {{ $transferDetails->id }}</h1>
        <div>{{ get_ymd($transferDetails->date) }}</div>
        <address>
            <strong> {{ $transferDetails->senderInformation->first_name." "
            .$transferDetails->senderInformation->last_name }} </strong><br>
            <abbr title="{{ localize('Email') }}"><span class="fw-semi-bold"> {{ localize('Email') }} :</span> {{
            $transferDetails->senderInformation->email }}</abbr><br>
            <abbr title="{{ localize('Phone') }}"><span class="fw-semi-bold"> {{ localize('Phone') }} :</span> {{
            $transferDetails->senderInformation->phone }}</abbr><br>
            <abbr title="{{ localize('account') }}"><span class="fw-semi-bold"> {{ localize('Account') }} :</span> {{
            $transferDetails->senderInformation->user_id }}</abbr>
        </address>
    </div>
</div>
<hr>
<div class="table-responsive m-b-20">
    <table class="table table-border table-bordered ">
        <thead>
        <tr>
            <th>{{ localize('Email') }}</th>
            <th>{{ localize('Send To') }}</th>
            <th>{{ localize('Amount') }}</th>
            <th>{{ localize('Usr ID') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div><strong>{{ $transferDetails->receiverInformation->email }}</strong></div>
            </td>
            <td>{{ $transferDetails->receiverInformation->first_name.' '.$transferDetails->receiverInformation->last_name
            }}</td>
            <td>{{ $transferDetails->amount }}</td>
            <td>{{ $transferDetails->receiverInformation->user_id }}</td>
        </tr>
        </tbody>
    </table>
</div>
