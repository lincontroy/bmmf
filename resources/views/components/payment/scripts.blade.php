 <!--script(used by all pages)-->
 <script src="{{ assets('plugins/jQuery/jquery.min.js') }}"></script>
 <script src="{{ assets('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ assets('plugins/metisMenu/metisMenu.min.js') }}"></script>
 <script src="{{ assets('plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>

 @include('sweetalert::alert')


 <!-- Third Party Scripts(used by this page)-->
 <script src="{{ assets('plugins/select2/dist/js/select2.min.js') }}"></script>
 <script src="{{ assets('js/pages/payment.select2.js') }}"></script>
 <script src="{{ assets('js/pages/newsletter.active.js') }}"></script>

 <!-- Third Party Scripts(used by this page)-->
 <script src="{{ assets('plugins/datatables/dataTables.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/dataTables.responsive.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/dataTables.buttons.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/jszip.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/pdfmake.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/vfs_fonts.js') }}"></script>
 <script src="{{ assets('plugins/datatables/buttons.html5.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/buttons.print.min.js') }}"></script>
 <script src="{{ assets('plugins/datatables/buttons.colVis.min.js') }}"></script>

 @stack('lib-scripts')


 <script src="{{ assets('plugins/datatables/data-bootstrap4.active.js') }}"></script>
 <script src="{{ assets('js/styleswitcher.js') }}"></script>
 <script src="{{ assets('js/sidebar.js') }}"></script>
 <script src="{{ assets('js/payment-custom.js') }}"></script>
 @stack('js')
