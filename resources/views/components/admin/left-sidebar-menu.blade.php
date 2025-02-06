@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<div class="sidebar-body pt-4">
    <nav class="sidebar-nav">
        <ul class="metismenu">

            <!-- Dashboards -->
            <li>
                <a class="material-ripple" href="{{ route('admin.dashboard') }}">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.0353 8.95H6.31177C6.79544 8.95 7.19118 8.55427 7.19118 8.07059V1.0353C7.19118 0.551619 6.79544 0.155884 6.31177 0.155884H1.0353C0.551619 0.155884 0.155884 0.551619 0.155884 1.0353V8.07059C0.155884 8.55427 0.551619 8.95 1.0353 8.95ZM1.0353 15.9853H6.31177C6.79544 15.9853 7.19118 15.5896 7.19118 15.1059V11.5882C7.19118 11.1046 6.79544 10.7088 6.31177 10.7088H1.0353C0.551619 10.7088 0.155884 11.1046 0.155884 11.5882V15.1059C0.155884 15.5896 0.551619 15.9853 1.0353 15.9853ZM9.82941 15.9853H15.1059C15.5896 15.9853 15.9853 15.5896 15.9853 15.1059V8.07059C15.9853 7.58691 15.5896 7.19118 15.1059 7.19118H9.82941C9.34574 7.19118 8.95 7.58691 8.95 8.07059V15.1059C8.95 15.5896 9.34574 15.9853 9.82941 15.9853ZM8.95 1.0353V4.55294C8.95 5.03662 9.34574 5.43235 9.82941 5.43235H15.1059C15.5896 5.43235 15.9853 5.03662 15.9853 4.55294V1.0353C15.9853 0.551619 15.5896 0.155884 15.1059 0.155884H9.82941C9.34574 0.155884 8.95 0.551619 8.95 1.0353Z"
                            fill="#6C6C6C" />
                    </svg>
                    <span class="lh-1 ps-2">{{ localize('Dashboard') }}</span>
                </a>
            </li>

            @if (
                $_auth_user->can(PermissionMenuEnum::CUSTOMER_CUSTOMERS->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::ACCOUNT_VERIFICATION->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::ACCOUNT_VERIFIED->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::ACCOUNT_VERIFIED_CANCELED->value . '.' . PermissionActionEnum::READ->value))
                <!-- Customer -->
                <li>
                    <a class="has-arrow material-ripple" href="#">
                        <svg class="menu-icon" width="17" height="23" viewBox="0 0 17 23" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.4748 0.205985C11.4111 0.14082 11.3351 0.0890307 11.2511 0.0536579C11.1672 0.0182851 11.077 4.21315e-05 10.9859 0H2.33175C1.71545 0.0007144 1.12444 0.245105 0.687622 0.679865C0.250803 1.11463 0.00362489 1.70448 0 2.32077V20.4475C0.000726864 21.0657 0.246626 21.6584 0.683758 22.0955C1.12089 22.5326 1.71356 22.7785 2.33175 22.7792H14.3174C14.9356 22.7785 15.5282 22.5326 15.9654 22.0955C16.4025 21.6584 16.6484 21.0657 16.6491 20.4475V5.7621C16.649 5.58211 16.578 5.40941 16.4514 5.28147L11.4748 0.205985ZM11.5736 2.26859L14.3256 5.06724H12.5322C12.2779 5.06724 12.0341 4.96626 11.8544 4.7865C11.6746 4.60674 11.5736 4.36294 11.5736 4.10872V2.26859ZM14.3201 21.395H2.33175C2.07965 21.3943 1.83791 21.2946 1.65861 21.1174C1.47932 20.9401 1.37684 20.6996 1.37324 20.4475V2.32077C1.37324 2.06655 1.47422 1.82275 1.65398 1.64299C1.83374 1.46324 2.07754 1.36225 2.33175 1.36225H10.2004V4.10872C10.2011 4.72692 10.447 5.31959 10.8842 5.75672C11.3213 6.19385 11.914 6.43975 12.5322 6.44048H15.2786V20.4475C15.2757 20.7003 15.1731 20.9417 14.9931 21.1191C14.813 21.2966 14.5702 21.3958 14.3174 21.395H14.3201ZM12.9936 18.0031H13.8724V19.3764H2.83161V18.0031H3.71048V15.8774H5.08372V18.0031H6.3471V11.711H7.72033V18.0031H8.97547V13.6719H10.3487V18.0031H11.6203V15.1413H12.9936V18.0031ZM5.30344 4.76513H2.79042V3.39189H5.30344V4.76513ZM5.30344 7.5116H2.79042V6.13837H5.30344V7.5116ZM5.30344 10.2581H2.79042V8.88484H5.30344V10.2581Z"
                                fill="#6C6C6C" />
                        </svg>
                        <span class="lh-1 ps-2">{{ localize('Customer') }}</span>
                    </a>
                    <ul class="nav-second-level mm-collapse">
                        @if ($_auth_user->can(PermissionMenuEnum::CUSTOMER_CUSTOMERS->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.customers.index') }}">{{ localize('customers') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::ACCOUNT_VERIFICATION->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.customer-verify-doc.index') }}">{{ localize('Account Verification') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::ACCOUNT_VERIFIED->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.verified-customers') }}">{{ localize('Account Verified') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::ACCOUNT_VERIFIED_CANCELED->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.verified-canceled-customers') }}">{{ localize('Account Verified Canceled') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @foreach (Module::allEnabled() as $module)
                @if (view()->exists("{$module->getLowerName()}::menu"))
                    @include("{$module->getLowerName()}::menu")
                @endif
            @endforeach

            @if (
                $_auth_user->can(PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::READ->value))
                <!-- Roles Manage -->
                <li>
                    <a class="has-arrow material-ripple" href="#">
                        <svg class="menu-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.2548 19.9989H7.74525C7.41632 19.9989 7.14072 19.7499 7.10752 19.4227L6.86564 17.0408C6.34193 16.8141 5.84603 16.5316 5.38437 16.1968L3.15618 17.1869C2.85793 17.3194 2.50793 17.2068 2.34289 16.9254L0.0881211 13.08C-0.0802111 12.7929 -0.000895348 12.4248 0.270727 12.2325L2.24717 10.8336C2.21665 10.5561 2.20127 10.2767 2.20127 9.999C2.20127 9.72127 2.21665 9.44187 2.24717 9.16439L0.270727 7.76547C-0.000895348 7.5732 -0.0802111 7.20509 0.0881211 6.91799L2.34289 3.07264C2.50793 2.79118 2.85797 2.67858 3.15618 2.8111L5.38437 3.80122C5.84603 3.46644 6.34193 3.18383 6.86564 2.95717L7.10752 0.575344C7.14077 0.247996 7.41632 -0.000976562 7.74525 -0.000976562H12.2547C12.5837 -0.000976562 12.8593 0.247996 12.8925 0.575259L13.1344 2.95708C13.6581 3.18379 14.154 3.46635 14.6156 3.80114L16.8438 2.81101C17.142 2.67849 17.492 2.7911 17.6571 3.07255L19.9119 6.91791C20.0802 7.205 20.0009 7.57312 19.7293 7.76538L17.7528 9.1643C17.7833 9.44178 17.7987 9.72118 17.7987 9.99891C17.7987 10.2766 17.7833 10.556 17.7528 10.8335L19.7293 12.2324C20.0009 12.4247 20.0802 12.7928 19.9119 13.0799L17.6571 16.9253C17.4921 17.2067 17.142 17.3194 16.8438 17.1868L14.6156 16.1967C14.154 16.5315 13.6581 16.8141 13.1344 17.0407L12.8925 19.4226C12.8593 19.7499 12.5837 19.9989 12.2548 19.9989ZM8.32448 18.7168H11.6756L11.898 16.5263C11.9227 16.2835 12.0831 16.0758 12.3117 15.9905C12.9697 15.7449 13.5803 15.3974 14.1265 14.9574C14.3137 14.8067 14.5694 14.7733 14.7889 14.8708L16.8409 15.7827L18.5083 12.939L16.6948 11.6554C16.4946 11.5137 16.3929 11.2703 16.4326 11.0283C16.4884 10.6885 16.5166 10.3422 16.5166 9.99896C16.5166 9.65576 16.4884 9.30939 16.4326 8.96961C16.3928 8.72764 16.4946 8.48422 16.6948 8.34251L18.5083 7.05889L16.8409 4.21524L14.7889 5.12707C14.5694 5.22467 14.3136 5.19121 14.1265 5.04053C13.5803 4.60053 12.9697 4.25297 12.3116 4.00746C12.083 3.92212 11.9227 3.71443 11.898 3.47165L11.6756 1.28107H8.32448L8.102 3.47161C8.07734 3.71438 7.91696 3.92212 7.68837 4.00742C7.03038 4.25293 6.41975 4.60049 5.87347 5.04049C5.68633 5.19121 5.43061 5.22463 5.21108 5.12702L3.15908 4.21524L1.49166 7.05889L3.30519 8.34251C3.50536 8.48418 3.60712 8.72764 3.56741 8.96961C3.51165 9.30943 3.48336 9.65576 3.48336 9.99896C3.48336 10.3422 3.51165 10.6885 3.56741 11.0283C3.60716 11.2703 3.50536 11.5137 3.30519 11.6554L1.49166 12.939L3.15908 15.7827L5.21108 14.8708C5.43061 14.7732 5.68637 14.8067 5.87347 14.9574C6.41975 15.3974 7.03034 15.7449 7.68837 15.9905C7.917 16.0758 8.07734 16.2835 8.102 16.5263L8.32448 18.7168Z"
                                fill="#6C6C6C" />
                            <path d="M13.352 10.0706H12.07V11.9947H13.352V10.0706Z" fill="#6C6C6C" />
                            <path
                                d="M12.711 10.6746C11.3244 10.6746 10.1964 9.53796 10.1964 8.14088C10.1964 6.74379 11.3244 5.60718 12.711 5.60718C14.0976 5.60718 15.2256 6.74379 15.2256 8.14088C15.2256 9.53796 14.0976 10.6746 12.711 10.6746ZM12.711 6.88926C12.0313 6.88926 11.4784 7.45076 11.4784 8.14092C11.4784 8.83109 12.0313 9.39258 12.711 9.39258C13.3906 9.39258 13.9436 8.83109 13.9436 8.14092C13.9436 7.45076 13.3906 6.88926 12.711 6.88926Z"
                                fill="#6C6C6C" />
                            <path d="M7.93008 10.0706H6.64804V11.9947H7.93008V10.0706Z" fill="#6C6C6C" />
                            <path
                                d="M7.28906 10.6746C5.90248 10.6746 4.77441 9.53796 4.77441 8.14088C4.77441 6.74379 5.90248 5.60718 7.28906 5.60718C8.67563 5.60718 9.8037 6.74379 9.8037 8.14088C9.8037 9.53796 8.67563 10.6746 7.28906 10.6746ZM7.28906 6.88926C6.6094 6.88926 6.05646 7.45076 6.05646 8.14092C6.05646 8.83109 6.6094 9.39258 7.28906 9.39258C7.96871 9.39258 8.52165 8.83109 8.52165 8.14092C8.52165 7.45076 7.96871 6.88926 7.28906 6.88926Z"
                                fill="#6C6C6C" />
                            <path
                                d="M10.2698 14.0486H4.30832C3.9543 14.0486 3.6673 13.7616 3.6673 13.4076V12.4309C3.6673 11.6488 3.91285 10.9041 4.37738 10.2773L5.40741 11.0407C5.10776 11.445 4.94934 11.9258 4.94934 12.4309V12.7666H9.62875V12.4309C9.62875 11.9258 9.47034 11.445 9.17068 11.0407L10.2007 10.2773C10.6653 10.9042 10.9108 11.6489 10.9108 12.431V13.4076C10.9108 13.7616 10.6238 14.0486 10.2698 14.0486Z"
                                fill="#6C6C6C" />
                            <path
                                d="M15.6918 14.0487H13.5657V12.7666H15.0507V12.431C15.0507 11.9258 14.8923 11.445 14.5925 11.0406L15.6225 10.2771C16.0872 10.904 16.3328 11.6488 16.3328 12.431V13.4076C16.3328 13.7616 16.0458 14.0487 15.6918 14.0487Z"
                                fill="#6C6C6C" />
                            <path d="M12.711 12.7666H11.5518V14.0486H12.711V12.7666Z" fill="#6C6C6C" />
                        </svg>
                        <span class="lh-1 ps-2">{{ localize('Roles Manage') }}</span>
                    </a>
                    <ul class="nav-second-level mm-collapse">
                        @if ($_auth_user->can(PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.role.index') }}">{{ localize('Manage Roles') }}</a>
                            </li>
                        @endif

                        @if ($_auth_user->can(PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.user.index') }}">{{ localize('Manage Users') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (
                $_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::READ->value))
                <!-- Payment Gateway -->
                <li>
                    <a class="has-arrow material-ripple" href="#">
                        <svg class="menu-icon" width="24" height="16" viewBox="0 0 24 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.31566 7.28271C5.00578 7.28271 4.71974 7.35992 4.45753 7.54006C4.21916 7.41139 3.95695 7.33418 3.69475 7.33418C2.7651 7.33418 2.00232 8.15768 2.00232 9.16132C2.00232 10.165 2.7651 10.9885 3.69475 10.9885C3.98079 10.9885 4.243 10.9113 4.50521 10.7568C4.74358 10.9113 5.02962 10.9885 5.31566 10.9885C6.26914 10.9885 7.03193 10.165 7.03193 9.13559C7.03193 8.13195 6.24531 7.28271 5.31566 7.28271ZM3.83777 10.1135C3.79009 10.1135 3.74242 10.1392 3.69475 10.1392C3.21801 10.1392 2.81278 9.72748 2.81278 9.18705C2.81278 8.67237 3.19417 8.23488 3.69475 8.23488C3.74242 8.23488 3.76626 8.23488 3.81393 8.23488C3.67091 8.51796 3.5994 8.82677 3.5994 9.13559C3.5994 9.49587 3.67091 9.80468 3.83777 10.1135Z"
                                fill="#6C6C6C" />
                            <path
                                d="M20.7382 11.0916L19.594 12.3269L19.0934 11.7865C18.9266 11.6063 18.6882 11.6063 18.5214 11.7865C18.3545 11.9666 18.3545 12.224 18.5214 12.4041L19.308 13.2533C19.3795 13.3305 19.4987 13.382 19.594 13.382C19.7132 13.382 19.8086 13.3305 19.8801 13.2533L21.3103 11.7093C21.4771 11.5291 21.4771 11.2718 21.3103 11.0916C21.1434 10.9115 20.9051 10.9115 20.7382 11.0916Z"
                                fill="#6C6C6C" />
                            <path
                                d="M18.6405 7.90062C18.6405 7.66901 18.4498 7.46313 18.2353 7.46313H10.1546C9.94002 7.46313 9.74933 7.66901 9.74933 7.90062C9.74933 8.13223 9.94002 8.3381 10.1546 8.3381H18.2353C18.4737 8.3381 18.6405 8.13223 18.6405 7.90062Z"
                                fill="#6C6C6C" />
                            <path
                                d="M20.5475 8.7754V1.7242C20.5475 0.772029 19.8324 0 18.9504 0H1.62092C0.738947 0 0.023837 0.772029 0.023837 1.7242L0 12.6098C0 13.562 0.71511 14.334 1.59708 14.334H17.401C17.9969 15.1318 18.9027 15.6465 19.9039 15.6465C21.6678 15.6465 23.0981 14.1024 23.0981 12.1981C23.1219 10.4996 22.0016 9.10995 20.5475 8.7754ZM0.834295 1.7242C0.834295 1.26098 1.19185 0.874967 1.62092 0.874967H18.9504C19.3795 0.874967 19.737 1.26098 19.737 1.7242V2.5477H0.834295V1.7242ZM1.59708 13.4333C1.16801 13.4333 0.810458 13.0473 0.810458 12.5841L0.834295 6.04756H19.737V8.6982C19.2126 8.72393 18.7121 8.90407 18.2591 9.18715C18.2591 9.18715 18.2591 9.18715 18.2353 9.18715H12.1092C11.8947 9.18715 11.704 9.39303 11.704 9.62463C11.704 9.85624 11.8947 10.0621 12.1092 10.0621H17.3533C17.1626 10.3452 16.9958 10.654 16.9004 10.9886H14.2069C13.9923 10.9886 13.8016 11.1944 13.8016 11.426C13.8016 11.6576 13.9923 11.8635 14.2069 11.8635H16.7336C16.7336 11.9407 16.7336 12.0179 16.7336 12.1209C16.7336 12.5583 16.8051 12.9958 16.972 13.3818H1.59708V13.4333ZM19.9039 14.72C18.6167 14.72 17.544 13.5877 17.544 12.1723C17.544 10.7569 18.5929 9.62463 19.9039 9.62463C21.1911 9.62463 22.2638 10.7569 22.2638 12.1723C22.2638 13.5877 21.2149 14.72 19.9039 14.72Z"
                                fill="#6C6C6C" />
                        </svg>
                        <span class="lh-1 ps-2">{{ localize('Payment Settings') }}</span>
                    </a>
                    <ul class="nav-second-level mm-collapse">
                        @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.payment.gateway.index') }}">{{ localize('Payment Gateway List') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.accept.currency.index') }}">{{ localize('Accept Currency') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.currency.fiat.index') }}">{{ localize('Fiat Currency') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            @if (
                $_auth_user->can(PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_PACKAGE_BANNER->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_INVESTMENT->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_PAYMENT_WE_ACCEPT->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_B2X->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_TOP_INVESTOR->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_OUR_RATE->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_TEAM_MEMBER->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_BG_IMAGE->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::CMS_OUR_DIFFERENCE->value . '.' . PermissionActionEnum::READ->value))
                <!-- CMS -->
                <li>
                    <a class="has-arrow material-ripple" href="#">
                        <svg width="19" height="17" viewBox="0 0 19 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.96774 6.85336H10.3474L13.1492 4.01355L13.1755 3.98686V3.52003H3.96774V6.85336Z"
                                fill="#A0B4D6" />
                            <path
                                d="M14.8196 14.52H2.32352V1.85339H14.8196V2.32346L16.4638 1.07995V0.186707H0.67926V16.1867H16.4638V9.36995L14.8196 11.0366V14.52Z"
                                fill="#A0B4D6" />
                            <path
                                d="M8.74263 8.85338H3.96774V9.85339H8.20323C8.36449 9.50017 8.55187 9.15999 8.74263 8.85338Z"
                                fill="#A0B4D6" />
                            <path d="M3.96774 11.52V12.52H7.8678C7.75267 12.2066 7.71656 11.8667 7.73952 11.52H3.96774Z"
                                fill="#A0B4D6" />
                            <path
                                d="M10.9076 8.64246C10.3626 9.19485 8.95249 11.5204 9.49748 12.0731C10.0428 12.6258 12.3367 11.1962 12.882 10.6438L15.1234 8.37127L13.1492 6.37033L10.9076 8.64246Z"
                                fill="#A0B4D6" />
                            <path
                                d="M18.2705 3.1802C17.7252 2.62778 16.8415 2.62778 16.2965 3.1802L13.6006 5.91293L15.5749 7.91387L18.2705 5.18115C18.8155 4.62876 18.8155 3.73291 18.2705 3.1802ZM14.7476 6.27523L14.4088 5.93213L16.2961 4.01907L16.6343 4.36181L14.7476 6.27523Z"
                                fill="#A0B4D6" />
                        </svg>


                        <span class="lh-1 ps-2">{{ localize('CMS') }}</span>
                    </a>
                    <ul class="nav-second-level mm-collapse">
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.menu.index') }}">{{ localize('Menus') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_BG_IMAGE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.bg-image.index') }}">{{ localize('Bg Image') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.home-slider.index') }}">{{ localize('Home Slider') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.social-icon.index') }}">{{ localize('Social Icon') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.home-about.index') }}">{{ localize('Home About') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_PACKAGE_BANNER->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.package.banner.index') }}">{{ localize('Package Banner') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.join-us-today.index') }}">{{ localize('Join Us Today') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.merchant.index') }}">{{ localize('Merchant') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.why-chose.index') }}">{{ localize('Why Chose') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.satisfied-customer.index') }}">{{ localize('Satisfied Customer') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_PAYMENT_WE_ACCEPT->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.payment-we-accept.index') }}">{{ localize('Payment We Accept') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_STAKE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.stake.index') }}">{{ localize('Stake') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.faq.index') }}">{{ localize('FAQ') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_TOP_INVESTOR->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.top-investor.index') }}">{{ localize('Top Investor') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.blog.index') }}">{{ localize('Blog') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.contact.index') }}">{{ localize('Contact') }}</a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('admin.cms.contact.address.index') }}">{{ localize('Contact Address') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_B2X->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.b2x.index') }}">{{ localize('B2X') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.our-service.index') }}">{{ localize('Our Service') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_OUR_RATE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.our-rate.index') }}">{{ localize('Our Rate') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_TEAM_MEMBER->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a href="{{ route('admin.cms.team-member.index') }}">{{ localize('Team Member') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_OUR_DIFFERENCE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.our-difference.index') }}">{{ localize('Our Difference') }}</a>
                            </li>
                        @endif
                        @if ($_auth_user->can(PermissionMenuEnum::CMS_QUICK_EXCHANGE->value . '.' . PermissionActionEnum::READ->value))
                            <li>
                                <a
                                    href="{{ route('admin.cms.quickexchange.index') }}">{{ localize('Quick Exchange') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (
                $_auth_user->can(PermissionMenuEnum::SETTING_APP_SETTING->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_COMMISSION_SETUP->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_NOTIFICATION_SETUP->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_EMAIL_GATEWAY->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_SMS_GATEWAY->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value) ||
                    $_auth_user->can(PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value))
                <!-- Setting -->
                <li>
                    <a class="material-ripple" href="{{ route('admin.setting.index') }}">
                        <svg class="menu-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                stroke="#6C6C6C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M1.66666 10.7334V9.2667C1.66666 8.40003 2.37499 7.68336 3.24999 7.68336C4.75832 7.68336 5.37499 6.6167 4.61666 5.30836C4.18332 4.55836 4.44166 3.58336 5.19999 3.15003L6.64166 2.32503C7.29999 1.93336 8.14999 2.1667 8.54166 2.82503L8.63332 2.98336C9.38332 4.2917 10.6167 4.2917 11.375 2.98336L11.4667 2.82503C11.8583 2.1667 12.7083 1.93336 13.3667 2.32503L14.8083 3.15003C15.5667 3.58336 15.825 4.55836 15.3917 5.30836C14.6333 6.6167 15.25 7.68336 16.7583 7.68336C17.625 7.68336 18.3417 8.3917 18.3417 9.2667V10.7334C18.3417 11.6 17.6333 12.3167 16.7583 12.3167C15.25 12.3167 14.6333 13.3834 15.3917 14.6917C15.825 15.45 15.5667 16.4167 14.8083 16.85L13.3667 17.675C12.7083 18.0667 11.8583 17.8334 11.4667 17.175L11.375 17.0167C10.625 15.7084 9.39166 15.7084 8.63332 17.0167L8.54166 17.175C8.14999 17.8334 7.29999 18.0667 6.64166 17.675L5.19999 16.85C4.44166 16.4167 4.18332 15.4417 4.61666 14.6917C5.37499 13.3834 4.75832 12.3167 3.24999 12.3167C2.37499 12.3167 1.66666 11.6 1.66666 10.7334Z"
                                stroke="#6C6C6C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="lh-1 ps-2">{{ localize('Setting') }}</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>
</div>
