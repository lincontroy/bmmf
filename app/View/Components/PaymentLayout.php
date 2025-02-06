<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PaymentLayout extends Component
{
    /**
     * Create the component instance.
     *
     * @param float $amount
     * @param string|null $paymentUrl
     */
    public function __construct(
        public float $amount,
        public string | null $paymentUrl = null,
        public string | null $storeLogo = null,
        public string | null $storeName = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('payment.layouts.app');
    }
}
