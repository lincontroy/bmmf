@php
    use Carbon\Carbon;
    use App\Enums\SiteAlignEnum;
@endphp
<nav class="navbar-custom-menu navbar navbar-expand-xl m-0">
    <div class="sidebar-toggle-icon d-block d-lg-none" id="sidebarCollapse">{{ localize('sidebar toggle') }}
        <span></span>
    </div>
    <!-- search  -->
    <!--/.sidebar toggle icon-->
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Toggler -->
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse"
            aria-expanded="true" aria-label="Toggle navigation"><span></span> <span></span></button>
    </div>
    <div class="navbar-icon d-flex">
        <!-- navbar nav-->
        <ul class="navbar-nav flex-row align-items-center">
            <!-- dropdown-->
            <li class="nav-item dropdown notification">
                <a class="nav-link dropdown-toggle @if ($_notificationCount > 0) badge-dot @endif" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="typcn typcn-bell"></i>
                </a>
                <!-- dropdown-menu -->
                <div class="dropdown-menu">
                    <div class="notification-header">
                        <p class="notification-title mb-0">{{ localize('Notifications') }}</p>
                        <a href="{{ route('customer.account.profile') }}"
                            class="notification-text mb-0">{{ localize('Mark All as Read') }}</a>
                    </div>

                    <!-- notification -->
                    <div class="notification-list">

                        @foreach ($_notifications as $notify)
                            <!-- notification item -->
                            <a href="{{ route('customer.account.profile') }}"
                                class="notification d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="notification-body">
                                        <h6>{{ $notify->subject }}</h6>
                                        <span>{{ $notify->details }}</span><br />
                                        <span class="text-muted">{{ $notify->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="notification-badge"></span>
                            </a>
                            <!-- end notification item -->
                        @endforeach

                        <a href="{{ route('customer.account.profile') }}"
                            class="notification d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="notification-body">
                                    <h6>{{ localize('View All Notifications') }} </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- notification -->

                </div>
                <!-- dropdown-menu -->
            </li>

            <!--/.dropdown-->
            <li class="nav-item dropdown user-menu">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="align-items-center bg-alice-blue d-flex gap-5 admin-bg px-3 py-2 rounded">
                        <div class="align-items-center d-flex gap-2 text-start">
                            <div class="img-user">
                                <img src="{{ auth()->user()->avatar ? storage_asset(auth()->user()->avatar) : assets('img/user.png') }}"
                                    class="img-fluid rounded-circle" alt="" />
                            </div>
                            <div class="d-flex flex-column gap-1 d-none d-lg-block">
                                <p class="fs-13 fw-bold text-dark lh-sm m-0">
                                    {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
                                <span class="fs-11 text-black-50">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="d-none d-lg-block">
                            <svg width="5" height="20" viewBox="0 0 5 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.53259 17.3748C4.53259 17.9759 4.29382 18.5523 3.8688 18.9773C3.44379 19.4023 2.86735 19.6411 2.26629 19.6411C1.66523 19.6411 1.08879 19.4023 0.663781 18.9773C0.238769 18.5523 -7.27897e-08 17.9759 -9.90628e-08 17.3748C-1.25336e-07 16.7738 0.238769 16.1973 0.663781 15.7723C1.08879 15.3473 1.66523 15.1085 2.26629 15.1085C2.86735 15.1085 3.44379 15.3473 3.8688 15.7723C4.29382 16.1973 4.53259 16.7738 4.53259 17.3748ZM4.53259 9.82051C4.53259 10.4216 4.29382 10.998 3.8688 11.423C3.44379 11.848 2.86735 12.0868 2.26629 12.0868C1.66523 12.0868 1.08879 11.848 0.663781 11.423C0.238769 10.998 -4.02999e-07 10.4216 -4.29272e-07 9.82051C-4.55545e-07 9.21945 0.238769 8.64301 0.663781 8.218C1.08879 7.79299 1.66523 7.55422 2.26629 7.55422C2.86735 7.55422 3.44379 7.79299 3.8688 8.218C4.29382 8.64301 4.53259 9.21945 4.53259 9.82051ZM4.53258 2.2662C4.53258 2.86726 4.29382 3.4437 3.8688 3.86871C3.44379 4.29373 2.86735 4.5325 2.26629 4.5325C1.66523 4.5325 1.08879 4.29373 0.663781 3.86871C0.238768 3.4437 -7.33208e-07 2.86726 -7.59481e-07 2.2662C-7.85755e-07 1.66514 0.238768 1.08871 0.663781 0.663692C1.08879 0.23868 1.66523 -8.97182e-05 2.26629 -8.97444e-05C2.86735 -8.97707e-05 3.44379 0.23868 3.8688 0.663692C4.29382 1.0887 4.53258 1.66514 4.53258 2.2662Z"
                                    fill="#A2A7B4" />
                            </svg>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-header d-sm-none">
                        <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <div class="user-header">
                        <div class="img-user">
                            <img src="{{ auth()->user()->avatar ? storage_asset(auth()->user()->avatar) : assets('img/user.png') }}"
                                alt="" />
                        </div>
                        <!-- img-user -->
                        <div>
                            <h6>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h6>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                    </div>

                    <!-- user-header -->
                    <a href="{{ route('customer.account.profile') }}" class="dropdown-item">
                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.3678 12.9181C13.9927 12.0295 13.4483 11.2224 12.765 10.5417C12.0838 9.859 11.2768 9.3147 10.3886 8.93884C10.3806 8.93487 10.3727 8.93288 10.3647 8.9289C11.6036 8.03402 12.409 6.57636 12.409 4.93178C12.409 2.20737 10.2017 0 7.47726 0C4.75285 0 2.54548 2.20737 2.54548 4.93178C2.54548 6.57636 3.35087 8.03402 4.58978 8.93089C4.58183 8.93487 4.57387 8.93686 4.56592 8.94083C3.67502 9.31668 2.87559 9.8556 2.18952 10.5437C1.50685 11.2249 0.96255 12.0319 0.586693 12.9201C0.21745 13.7896 0.0183091 14.7218 4.97274e-05 15.6663C-0.000481045 15.6876 0.00324171 15.7087 0.0109987 15.7284C0.0187557 15.7482 0.03039 15.7662 0.0452161 15.7814C0.0600421 15.7966 0.0777598 15.8087 0.0973254 15.8169C0.116891 15.8252 0.137908 15.8294 0.159139 15.8294H1.35231C1.43981 15.8294 1.50941 15.7598 1.5114 15.6743C1.55117 14.1391 2.16764 12.7013 3.25741 11.6116C4.38496 10.484 5.88239 9.86355 7.47726 9.86355C9.07213 9.86355 10.5696 10.484 11.6971 11.6116C12.7869 12.7013 13.4033 14.1391 13.4431 15.6743C13.4451 15.7618 13.5147 15.8294 13.6022 15.8294H14.7954C14.8166 15.8294 14.8376 15.8252 14.8572 15.8169C14.8768 15.8087 14.8945 15.7966 14.9093 15.7814C14.9241 15.7662 14.9358 15.7482 14.9435 15.7284C14.9513 15.7087 14.955 15.6876 14.9545 15.6663C14.9346 14.7158 14.7377 13.7911 14.3678 12.9181ZM7.47726 8.3522C6.56448 8.3522 5.7054 7.99624 5.0591 7.34994C4.4128 6.70364 4.05683 5.84455 4.05683 4.93178C4.05683 4.019 4.4128 3.15992 5.0591 2.51361C5.7054 1.86731 6.56448 1.51135 7.47726 1.51135C8.39004 1.51135 9.24912 1.86731 9.89542 2.51361C10.5417 3.15992 10.8977 4.019 10.8977 4.93178C10.8977 5.84455 10.5417 6.70364 9.89542 7.34994C9.24912 7.99624 8.39004 8.3522 7.47726 8.3522Z"
                                fill="#6C6C6C" />
                        </svg>
                        <span>{{ localize('View Profile') }}</span></a>
                    <a href="{{ route('customer.account.account.index') }}" class="dropdown-item">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                stroke="#6C6C6C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M1.66669 10.7334V9.2667C1.66669 8.40003 2.37502 7.68336 3.25002 7.68336C4.75835 7.68336 5.37502 6.6167 4.61669 5.30836C4.18335 4.55836 4.44169 3.58336 5.20002 3.15003L6.64169 2.32503C7.30002 1.93336 8.15002 2.1667 8.54169 2.82503L8.63335 2.98336C9.38335 4.2917 10.6167 4.2917 11.375 2.98336L11.4667 2.82503C11.8584 2.1667 12.7084 1.93336 13.3667 2.32503L14.8084 3.15003C15.5667 3.58336 15.825 4.55836 15.3917 5.30836C14.6334 6.6167 15.25 7.68336 16.7584 7.68336C17.625 7.68336 18.3417 8.3917 18.3417 9.2667V10.7334C18.3417 11.6 17.6334 12.3167 16.7584 12.3167C15.25 12.3167 14.6334 13.3834 15.3917 14.6917C15.825 15.45 15.5667 16.4167 14.8084 16.85L13.3667 17.675C12.7084 18.0667 11.8584 17.8334 11.4667 17.175L11.375 17.0167C10.625 15.7084 9.39169 15.7084 8.63335 17.0167L8.54169 17.175C8.15002 17.8334 7.30002 18.0667 6.64169 17.675L5.20002 16.85C4.44169 16.4167 4.18335 15.4417 4.61669 14.6917C5.37502 13.3834 4.75835 12.3167 3.25002 12.3167C2.37502 12.3167 1.66669 11.6 1.66669 10.7334Z"
                                stroke="#6C6C6C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span>{{ localize('Account Settings') }}</span>
                    </a>

                    <a href="javascript:void(0)" class="dropdown-item" id="themeSwitch"
                        data-light="{{ localize('Light Mode') }}" data-dark="{{ localize('Dark Mode') }}">
                        <i class="far fa-lightbulb fs-15 me-2 w-auto"></i>
                        <span class="ms-0 fs-14 fw-normal">{{ localize('Light Mode') }}</span>
                    </a>

                    <form method="POST" action="{{ route('customer.account.update-site-align') }}" class="d-inline">
                        @csrf
                        @if ($_auth_user->site_align && $_auth_user->site_align->value === SiteAlignEnum::LEFT_TO_RIGHT->value)
                            <input type="hidden" name="site_align"
                                value="{{ SiteAlignEnum::RIGHT_TO_LEFT->value }}" />
                            <button class="user-signout mb-2">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="25"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-text-direction-ltr"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 19h14" /><path d="M17 21l2 -2l-2 -2" /><path d="M16 4h-6.5a3.5 3.5 0 0 0 0 7h.5" /><path d="M14 15v-11" /><path d="M10 15v-11" /></svg>
                                <span>{{ localize('RTL') }}</span>
                            </button>
                        @else
                            <input type="hidden" name="site_align"
                                value="{{ SiteAlignEnum::LEFT_TO_RIGHT->value }}" />
                            <button class="user-signout mb-2">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-text-direction-rtl"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 4h-6.5a3.5 3.5 0 0 0 0 7h.5" /><path d="M14 15v-11" /><path d="M10 15v-11" /><path d="M5 19h14" /><path d="M7 21l-2 -2l2 -2" /></svg>
                                <span>{{ localize('LTR') }}</span>
                            </button>
                        @endif
                    </form>

                    <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                        @csrf
                        <button class="user-signout border-top-white">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.44 15.4789L20 12.9189L17.44 10.3589" stroke="#6C6C6C" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.76001 12.9189H19.93" stroke="#6C6C6C" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M11.76 20.8589C7.34001 20.8589 3.76001 17.8589 3.76001 12.8589C3.76001 7.85889 7.34001 4.85889 11.76 4.85889"
                                    stroke="#6C6C6C" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>{{ localize('Sign Out') }}</span>
                        </button>
                    </form>
                </div>
                <!--/.dropdown-menu -->
            </li>

        </ul>
        <!-- navbar nav-->
    </div>
</nav>
