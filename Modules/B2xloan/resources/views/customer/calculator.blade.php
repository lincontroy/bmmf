<div class="col-lg-12">
    <div class="row g-3 justify-content-center mb-4">
        <h3 class="fw-bold text-black-50 mb-4 text-center">{{ $headerData->small_content }}</h3>
        @foreach($responseDataSet as $key => $item)
            <div class="col-lg-6 col-xl-3 col-xxl-05">
                <div class="d-flex flex-column h-100 justify-content-center loan-border p-4 radius-10 text-center">
                    <p class="fw-normal fs-18 mb-4 text-black-50">{{ $item['label'] }}</p>
                    @if($key === 2)
                    <h3 class="fw-bold fs-22 mb-0 text-black-50">{{ $item['value'] }}%</h3>
                    @else
                        <h3 class="fw-bold fs-22 mb-0 text-black-50">${{ $item['value'] }}</h3>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>


