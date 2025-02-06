<div class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" id="_edit_modal">
    <div {{ $attributes->merge(['class' => 'modal-dialog']) }}>
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="editModalLabel">{{ $modalTitle ?? 'Edit' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2 edit-modal">

            </div>
        </div>
    </div>
</div>
