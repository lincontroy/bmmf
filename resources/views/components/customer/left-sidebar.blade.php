<nav class="sidebar sidebar-bunker">
    <!-- sidebar header-->
    <div class="sidebar-header justify-content-center">
        <a href="{{ route('customer.dashboard') }}" class="sidebar-brand">
            <img class="sidebar-brand_icon w-100"
                src="{{ $_setting->logo ? storage_asset($_setting->logo) : assets('img/logo.png') }}"
                alt="{{ config('app.name') }}" />
        </a>
    </div>
    <div class="profile-element d-flex align-items-center flex-shrink-0">
        <div class="avatar online">
            <img src="{{ $_auth_user->avatar ? storage_asset($_auth_user->avatar) : assets('img/user.png') }}"
                class="img-fluid rounded-circle" alt="" />
        </div>
        <div class="profile-text">
            <h6 class="m-0">{{ $_auth_user->first_name . ' ' . $_auth_user->last_name }}</h6>
            <span>{{ localize('UserId') }} : {{ $_auth_user->user_id }}</span>
        </div>
    </div>
    <!-- end sidebar header-->

    <!-- sidebar menu -->
    <x-customer.left-sidebar-menu />
    <!-- end sidebar menu -->

    <!-- sidebar-body -->
    <div class="sidebar-signout-btn">
        <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
            @csrf
            <button class="user-signout text-center" type="submit">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.44 14.62L20 12.06L17.44 9.5" stroke="#3380FF" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9.76001 12.06H19.93" stroke="#3380FF" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11.76 20C7.34001 20 3.76001 17 3.76001 12C3.76001 7 7.34001 4 11.76 4" stroke="#3380FF"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>{{ localize('Sign Out') }}</span>
            </button>
        </form>
    </div>

</nav>
