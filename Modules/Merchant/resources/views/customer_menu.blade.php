<!-- Merchant -->
<li>
    <a class="has-arrow material-ripple" href="#">
        <svg class="menu-icon" width="17" height="23" viewBox="0 0 17 23" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M11.4748 0.205985C11.4111 0.14082 11.3351 0.0890307 11.2511 0.0536579C11.1672 0.0182851 11.077 4.21315e-05 10.9859 0H2.33175C1.71545 0.0007144 1.12444 0.245105 0.687622 0.679865C0.250803 1.11463 0.00362489 1.70448 0 2.32077V20.4475C0.000726864 21.0657 0.246626 21.6584 0.683758 22.0955C1.12089 22.5326 1.71356 22.7785 2.33175 22.7792H14.3174C14.9356 22.7785 15.5282 22.5326 15.9654 22.0955C16.4025 21.6584 16.6484 21.0657 16.6491 20.4475V5.7621C16.649 5.58211 16.578 5.40941 16.4514 5.28147L11.4748 0.205985ZM11.5736 2.26859L14.3256 5.06724H12.5322C12.2779 5.06724 12.0341 4.96626 11.8544 4.7865C11.6746 4.60674 11.5736 4.36294 11.5736 4.10872V2.26859ZM14.3201 21.395H2.33175C2.07965 21.3943 1.83791 21.2946 1.65861 21.1174C1.47932 20.9401 1.37684 20.6996 1.37324 20.4475V2.32077C1.37324 2.06655 1.47422 1.82275 1.65398 1.64299C1.83374 1.46324 2.07754 1.36225 2.33175 1.36225H10.2004V4.10872C10.2011 4.72692 10.447 5.31959 10.8842 5.75672C11.3213 6.19385 11.914 6.43975 12.5322 6.44048H15.2786V20.4475C15.2757 20.7003 15.1731 20.9417 14.9931 21.1191C14.813 21.2966 14.5702 21.3958 14.3174 21.395H14.3201ZM12.9936 18.0031H13.8724V19.3764H2.83161V18.0031H3.71048V15.8774H5.08372V18.0031H6.3471V11.711H7.72033V18.0031H8.97547V13.6719H10.3487V18.0031H11.6203V15.1413H12.9936V18.0031ZM5.30344 4.76513H2.79042V3.39189H5.30344V4.76513ZM5.30344 7.5116H2.79042V6.13837H5.30344V7.5116ZM5.30344 10.2581H2.79042V8.88484H5.30344V10.2581Z"
                fill="#6C6C6C"></path>
        </svg>
        <span class="lh-1 ps-2">{{ localize('Merchant') }}</span>
    </a>
    <ul class="nav-second-level mm-collapse">
        <li>
            <a href="{{ route('customer.merchant.dashboard.index') }}">{{ localize('Dashboard') }}</a>
        </li>
        <li>
            <a href="{{ route('customer.merchant.account-request.index') }}">{{ localize('Request Application') }}</a>
        </li>
        <li>
            <a href="{{ route('customer.merchant.customer.index') }}">{{ localize('Customers') }}</a>
        </li>
        <li>
            <a href="{{ route('customer.merchant.payment-url.index') }}">{{ localize('Payment Url') }}</a>
        </li>
        <li>
            <a href="{{ route('customer.merchant.transaction.index') }}">{{ localize('All Transaction List') }}</a>
        </li>
        <li>
            <a href="{{ route('customer.merchant.withdraw.create') }}">{{ localize('Withdraw') }}</a>
        </li>
    </ul>
</li>
