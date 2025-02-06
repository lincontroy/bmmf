 <nav class="sidebar sidebar-bunker">
     <!-- sidebar header-->
     <div class="sidebar-header justify-content-center">
         <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
             <img class="sidebar-brand_icon w-100"
                 src="{{ $_setting->logo ? storage_asset($_setting->logo) : assets('img/logo.png') }}"
                 alt="{{ config('app.name') }}" />
         </a>
     </div>
     <!-- end sidebar header-->

     <!-- sidebar menu -->
     <x-admin.left-sidebar-menu />
     <!-- end sidebar menu -->

     <!-- sidebar-body -->
     <div class="sidebar-signout-btn">
         <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
             @csrf
             <button class="user-signout text-center" type="submit">
                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                     <path d="M17.44 14.62L20 12.06L17.44 9.5" stroke="#3380FF" stroke-width="1.5"
                         stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                     <path d="M9.76001 12.06H19.93" stroke="#3380FF" stroke-width="1.5" stroke-miterlimit="10"
                         stroke-linecap="round" stroke-linejoin="round" />
                     <path d="M11.76 20C7.34001 20 3.76001 17 3.76001 12C3.76001 7 7.34001 4 11.76 4" stroke="#3380FF"
                         stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
                 <span class="fs-16 fw-semi-bold">{{ localize('Sign Out') }}</span>
             </button>
         </form>
     </div>

 </nav>
