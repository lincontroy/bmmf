<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('User balances') }}</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>{{ localize('User') }}</th>
                                <th>{{ localize('Balance') }}</th>
                                <th>{{ localize('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        @php
                                $balances = App\Models\WalletManage::all();
                            @endphp

                            @foreach($balances as $balance)
                                <tr>
                                    <td>
                                        @php
                                            $user = App\Models\User::where('id', $balance->user_id)->value('username');
                                        @endphp
                                        {{ $user }}
                                    </td>
                                    <td>{{ $balance->balance }}</td>
                                    <td>
                                    <button class="btn btn-primary btn-sm edit-balance-btn" 
                                        data-id="{{ $balance->id }}" 
                                        data-balance="{{ $balance->balance }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editBalanceModal">
                                    Edit Balance
                                </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
               
            </div>
        </div>
    </div>

    <!-- Edit Balance Modal -->
<div class="modal fade" id="editBalanceModal" tabindex="-1" aria-labelledby="editBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBalanceModalLabel">Edit Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateBalanceForm">
                    @csrf
                    <input type="hidden" id="wallet_id">
                    <div class="form-group">
                        <label for="new_balance">New Balance</label>
                        <input type="number" class="form-control" id="new_balance" name="new_balance" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Balance</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Open modal and populate fields
    $('.edit-balance-btn').click(function() {
        let walletId = $(this).data('id');
        let currentBalance = $(this).data('balance');

        $('#wallet_id').val(walletId);
        $('#new_balance').val(currentBalance);
    });

    // AJAX request to update balance
    $('#updateBalanceForm').submit(function(e) {
        e.preventDefault();

        let walletId = $('#wallet_id').val();
        let newBalance = $('#new_balance').val();

        $.ajax({
            url: "{{ route('update.balance') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: walletId,
                balance: newBalance
            },
            success: function(response) {
                if (response.success) {
                    alert('Balance updated successfully!');
                    location.reload();
                } else {
                    alert('Error updating balance');
                }
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    });
});
</script>
<!-- Bootstrap JS (Including Popper.js for Modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    @push('js')
        <script src="{{ module_asset('Finance', 'js/deposit.js') }}"></script>
    @endpush
</x-app-layout>