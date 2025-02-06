<x-customer-app-layout>
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="card shadow-none radius-15">
                <div
                    class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3 px-4 px-xl-5 py-4  border-bottom">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">
                        {{ localize('my_Generation') }}
                    </h3>
                </div>
                <div class="card-body px-4 px-xl-5">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <ul class="nav nav-pills generation-tab customer-details" id="pills-tab" role="tablist">
                            <!--                            <li class="nav-item"
                                data-status="1"
                                data-si="canceled">
                                <a class="nav-link"
                                   aria-selected="true">{{ localize('generation_one') }}
                            </a>
                        </li>-->
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-generation-one-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-generation-one" type="button" role="tab"
                                        aria-controls="pills-generation-one"
                                        aria-selected="true">{{ localize('generation_one') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-generation-two-tab" data-bs-toggle="pill"
                                   data-bs-target="#pills-generation-two" type="button" role="tab"
                                   aria-controls="pills-generation-two"
                                   aria-selected="true">{{ localize('generation_two') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-generation-three-tab" data-bs-toggle="pill"
                                   data-bs-target="#pills-generation-three" type="button" role="tab"
                                   aria-controls="pills-generation-three"
                                   aria-selected="true">{{ localize('generation_three') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-generation-four-tab" data-bs-toggle="pill"
                                   data-bs-target="#pills-generation-four" type="button" role="tab"
                                   aria-controls="pills-generation-four"
                                   aria-selected="true">{{ localize('generation_four') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-generation-five-tab" data-bs-toggle="pill"
                                   data-bs-target="#pills-generation-five" type="button" role="tab"
                                   aria-controls="pills-generation-five"
                                   aria-selected="true">{{ localize('generation_five') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active table-responsive" id="pills-generation-one" role="tabpanel"
                             aria-labelledby="pills-generation-tab">
                            <table id="generation-one-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('user_ID') }}</th>
                                    <th>{{ localize('user_name') }}</th>
                                    <th>{{ localize('name') }}</th>
                                    <th>{{ localize('amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($generations as $key => $generation)
                                    @if($generation['level'] == 2)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $generation['user_id'] }}</td>
                                    <td>{{ $generation['username']  }}</td>
                                    <td>{{ $generation['name'] }}</td>
                                    <td>{{ $generation['amount'] }}</td>
                                </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade table-responsive" id="pills-generation-two" role="tabpanel"
                             aria-labelledby="pills-generation-tab">
                            <table id="generation-one-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('user_ID') }}</th>
                                    <th>{{ localize('user_name') }}</th>
                                    <th>{{ localize('name') }}</th>
                                    <th>{{ localize('amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($generations as $key => $generation)

                                    @if($generation['level'] == 3)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $generation['user_id'] }}</td>
                                        <td>{{ $generation['username']  }}</td>
                                        <td>{{ $generation['name'] }}</td>
                                        <td>{{ $generation['amount'] }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade table-responsive" id="pills-generation-three" role="tabpanel"
                             aria-labelledby="pills-generation-tab">
                            <table id="generation-three-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('user_ID') }}</th>
                                    <th>{{ localize('user_name') }}</th>
                                    <th>{{ localize('name') }}</th>
                                    <th>{{ localize('amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($generations as $key => $generation)

                                    @if($generation['level'] == 4)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $generation['user_id'] }}</td>
                                            <td>{{ $generation['username']  }}</td>
                                            <td>{{ $generation['name'] }}</td>
                                            <td>{{ $generation['amount'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade table-responsive" id="pills-generation-four" role="tabpanel"
                             aria-labelledby="pills-generation-tab">
                            <table id="generation-four-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('user_ID') }}</th>
                                    <th>{{ localize('user_name') }}</th>
                                    <th>{{ localize('name') }}</th>
                                    <th>{{ localize('amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($generations as $key => $generation)

                                    @if($generation['level'] == 5)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $generation['user_id'] }}</td>
                                            <td>{{ $generation['username']  }}</td>
                                            <td>{{ $generation['name'] }}</td>
                                            <td>{{ $generation['amount'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade table-responsive" id="pills-generation-five" role="tabpanel"
                             aria-labelledby="pills-generation-tab">
                            <table id="generation-four-table" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{ localize('sl') }}</th>
                                    <th>{{ localize('user_ID') }}</th>
                                    <th>{{ localize('user_name') }}</th>
                                    <th>{{ localize('name') }}</th>
                                    <th>{{ localize('amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($generations as $key => $generation)

                                    @if($generation['level'] == 6)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $generation['user_id'] }}</td>
                                            <td>{{ $generation['username']  }}</td>
                                            <td>{{ $generation['name'] }}</td>
                                            <td>{{ $generation['amount'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-app-layout>
