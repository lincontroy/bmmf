 <!--Global script(used by all pages)-->
 <script src="{{ assets('plugins/jQuery/jquery.min.js') }}"></script>
 <script src="{{ assets('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ assets('plugins/metisMenu/metisMenu.min.js') }}"></script>
 <script src="{{ assets('plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>

 @include('sweetalert::alert')

 <script src="{{ assets('plugins/silck-slider/slick.min.js') }}"></script>

 <script src="{{ assets('js/pages/newsletter.active.js') }}"></script>

 <script src="{{ assets('plugins/datatables/dataTables.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/dataTables.responsive.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

 <script src="{{ assets('js/styleswitcher.js') }}"></script>
 <script src="{{ assets('js/sidebar.js') }}"></script>

 @stack('lib-scripts')
 <script src="{{ assets('plugins/select2/dist/js/select2.min.js') }}"></script>
 <script src="{{ assets('js/pages/app.select2.js') }}"></script>
 <script src="{{ assets('customer/js/custom.js?v=1') }}"></script>
 @stack('js')
