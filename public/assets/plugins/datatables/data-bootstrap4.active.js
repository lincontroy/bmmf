(function ($) {
  "use strict";
  var tableBootstrap4Style = {
    initialize: function () {
      this.bootstrap4Styling();
      this.bootstrap4Modal();
      this.print();
    },
    bootstrap4Styling: function () {
      $(".bootstrap4-styling").DataTable();
    },
    bootstrap4Modal: function () {
      $(".bootstrap4-modal").DataTable({
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return "Details for " + data[0] + " " + data[1];
              },
            }),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
              tableClass: "table",
            }),
          },
        },
      });
    },
    print: function () {
      var table = $("#example").DataTable({
        lengthChange: false,
        ordering: false,
        buttons: false,
        searching: false,
        info: false,
      });

      table.buttons().container().appendTo("#example_wrapper .col-md-6:eq(0)");
    },
  };
  // Initialize
  $(document).ready(function () {
    "use strict";
    tableBootstrap4Style.initialize();
  });
})(jQuery);

(function ($) {
  "use strict";
  var tableBootstrap4Style = {
    initialize: function () {
      this.bootstrap4Styling();
      this.bootstrap4Modal();
      this.print();
    },
    bootstrap4Styling: function () {
      $(".bootstrap4-styling").DataTable();
    },
    bootstrap4Modal: function () {
      $(".bootstrap4-modal").DataTable({
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return "Details for " + data[0] + " " + data[1];
              },
            }),
            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
              tableClass: "table",
            }),
          },
        },
      });
    },
    print: function () {
      var table = $("#custom-table").DataTable({
        dom: '<"top"<"left-col"l><"center-col"B><"right-col"f>>rtip',
        language: {
          search: " ",
          searchPlaceholder: "search...",
        },
        lengthChange: true,
        ordering: false,
        buttons: true,
        searching: true,
        info: false,
        buttons: [
          {
            extend: "copy",
            className: "data-table-btn",
          },
          {
            extend: "excel",
            className: "data-table-btn",
          },
          {
            extend: "pdf",
            className: "data-table-btn",
          },
        ],
      });

      table.buttons().container().appendTo("#custom-table_wrapper .col-md-4:eq(0)");
    },
  };
  // Initialize
  $(document).ready(function () {
    "use strict";
    tableBootstrap4Style.initialize();
    $("#custom-table_filter input").addClass("custom-form-control custom-search");
  });
})(jQuery);
