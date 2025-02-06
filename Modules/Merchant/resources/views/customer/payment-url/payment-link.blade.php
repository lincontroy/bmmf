<div class="modal-header p-4">
    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="linkModalLabel">Payment Link</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-4">
    <div class="text-center">
        <p class="fs-20 fw-medium mb-2">{{ $merchantPaymentUrl->title }}</p>
        <p class="fs-16 fw-normal mb-3">{{ $merchantPaymentUrl->description }}</p>
    </div>
    <div class="mb-3 text-center">
        {!! $qr_image !!}
    </div>

    <div class="position-relative">
        <input class="custom-form-control bg-copy-box border-dotted py-4 mb-2 affiliate-url" type="text" value="{{ route('payment.index', ['payment_url' => $merchantPaymentUrl->uu_id]) }}">
       
        <button class="btn-copy copy-value" data-copyvalue="{{ route('payment.index', ['payment_url' => $merchantPaymentUrl->uu_id]) }}">
            <span> <i class="fa fa-copy"></i> {{ localize('copy') }}</span>
        </button>
    </div>
</div>
