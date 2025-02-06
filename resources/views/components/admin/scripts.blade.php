 <!--Global script(used by all pages)-->
 <script src="{{ assets('vendor/jQuery/jquery.min.js') }}"></script>
 <script src="{{ assets('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ assets('vendor/metisMenu/metisMenu.min.js') }}"></script>
 <script src="{{ assets('vendor/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
 <script src="{{ assets('vendor/emojionearea/dist/emojionearea.min.js') }}"></script>

 @include('sweetalert::alert')

 <!--Page Scripts(used by all page)-->
 <script src="{{ assets('js/sidebar.min.js') }}"></script>
 <!-- Third Party Scripts(used by this page)-->
 @stack('lib-scripts')
 <script src="{{ assets('vendor/select2/dist/js/select2.min.js') }}"></script>
 <script src="{{ assets('js/pages/app.select2.js') }}"></script>
 <script src="{{ assets('js/custom.js?v=1') }}"></script>
 @stack('js')
