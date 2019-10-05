
      </div>
      <!-- End of Main Content -->

<!-- MODAL -->
<!-- Button trigger modal -->



 <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; SIMPEG CV.LOVA 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url("public/home/logout") ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
  {js}
  <script src="{url}"></script>
  {/js}
  <script type="text/javascript">
    minDateFilter = "";
    maxDateFilter = "";
    $.fn.dataTable.ext.search.push(
      function( settings, data, dataIndex ) {
          var min = new Date($('#start').val()).getTime();
          var max = new Date($('#end').val()).getTime();
          var age = new Date(data[5]).getTime() // use data for the age column

          if ( ( isNaN( min ) && isNaN( max ) ) ||
               ( isNaN( min ) && age <= max ) ||
               ( min <= age   && isNaN( max ) ) ||
               ( min <= age   && age <= max ) )
          {
              return true;
          }
          return false;
      }
    );
    $(document).ready(function() {
      function getBase64FromImageUrl(url) {
        var img = new Image();
    		img.crossOrigin = "anonymous";
        img.onload = function () {
            var canvas = document.createElement("canvas");
            canvas.width =this.width;
            canvas.height =this.height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(this, 0, 0);
            var dataURL = canvas.toDataURL("image/png");
            return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
        };
        img.src = url;
    	}
      var date = new Date("<?= date("Y-m-d",strtotime("-19 years")) ?>");
      var currentMonth = date.getMonth();
      var currentDate = date.getDate();
      var currentYear = date.getFullYear();
      $(".dateTgl").datepicker({
        format:"yyyy-m-d",
        autoclose: true,
        todayHighlight: true,
        endDate:new Date(currentYear, currentMonth, currentDate)
      });
      $(".date").datepicker({
        format:"yyyy-m-d",
      });
      $(".datatables").DataTable({

      });
      $(".select2").select2();
      var tbl = $(".datatables_pinjam").DataTable({
        "order": [[ 4, "asc" ],[ 3, "desc" ]],
        dom: 'Bfrtip',
        buttons: [
          {
              text:"Export ke PDF",
              extend: 'pdfHtml5',
              pageSize: 'A4',
              title:"Laporan Peminjaman",
              customize:function(doc){
      						//Remove the title created by datatTables
      						doc.content.splice(0,1);
      						//Create a date string that we use in the footer. Format is dd-mm-yyyy
      						var now = new Date();
      						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
      						// Logo converted to base64
      						var logo = "data:image/jpeg;base64,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AgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA=";
      						// The above call should work, but not when called from codepen.io
      						// So we use a online converter and paste the string in.
      						// Done on http://codebeautify.org/image-to-base64-converter
      						// It's a LONG string scroll down to see the rest of the code !!!

      						// A documentation reference can be found at
      						// https://github.com/bpampuch/pdfmake#getting-started
      						// Set page margins [left,top,right,bottom] or [horizontal,vertical]
      						// or one number for equal spread
      						// It's important to create enough space at the top for a header !!!
      						doc.pageMargins = [20,60,20,30];
      						// Set the font size fot the entire document
      						doc.defaultStyle.fontSize = 7;
      						// Set the fontsize for the table header
      						doc.styles.tableHeader.fontSize = 7;
                  doc.content[0].margin = [ 100, 20, 100, 0 ] //left, top, right, bottom
                  var pj = doc.content.length;
                  doc.styles.ttd_identitas = {margin:[400,80,0,0],alignment:"center"};
                  doc.styles.ttd_tempat = {margin:[400,70,0,0],alignment:"center"};
                  doc.styles.ttd_jabatan = {margin:[400,10,0,0],alignment:"center"};
                  doc.content[pj] = {text:"Bandung , "+jsDate.toString(),style:"ttd_tempat"};
                  var pj = doc.content.length;
                  doc.content[pj] = {text:"Direktur",style:"ttd_jabatan"};
                  var pj = doc.content.length;
                  doc.content[pj] = {text:"Gerry Gustira",style:"ttd_identitas"};
                  doc.content.unshift({canvas: [{ type: 'line', x1: 0, y1: 5, x2: 595-2*40, y2: 5, lineWidth: 1 }]});
                  doc.content.unshift({text:"0266-592324",fontSize: 12,alignment:"center"});
                  doc.content.unshift({text:"JALAN RAYA BANJARAN KEC. Pemeungpuk",fontSize: 14,alignment:"center"});
                  doc.content.unshift({text:"CV LOVA",fontSize: 18,alignment:"center"});
      						// Create a header object with 3 columns
      						// Left side: Logo
      						// Middle: brandname
      						// Right side: A document title
      						doc['header']=(function() {
      							return {
      								columns: [
                        {
      										image: logo,
      										width: 24
      									},
      									{
      										alignment: 'left',
      										italics: true,
      										text: 'CV LOVA',
      										fontSize: 18,
      										margin: [10,0]
      									},
      									{
      										alignment: 'right',
      										fontSize: 14,
      										text: 'Laporan Peminjaman'
      									}
      								],
      								margin: 20
      							}
      						});
      						// Create a footer object with 2 columns
      						// Left side: report creation date
      						// Right side: current page and total pages
      						doc['footer']=(function(page, pages) {
      							return {
      								columns: [
      									{
      										alignment: 'left',
      										text: ['Tanggal Cetak: ', { text: jsDate.toString() }]
      									},
      									{
      										alignment: 'right',
      										text: ['Halaman ', { text: page.toString() },	' dari ',	{ text: pages.toString() }]
      									}
      								],
      								margin: 20
      							}
      						});
      						// Change dataTable layout (Table styling)
      						// To use predefined layouts uncomment the line below and comment the custom lines below
      						// doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
      						var objLayout = {};
      						objLayout['hLineWidth'] = function(i) { return .5; };
      						objLayout['vLineWidth'] = function(i) { return .5; };
      						objLayout['hLineColor'] = function(i) { return '#aaa'; };
      						objLayout['vLineColor'] = function(i) { return '#aaa'; };
      						objLayout['paddingLeft'] = function(i) { return 4; };
      						objLayout['paddingRight'] = function(i) { return 4; };
      						doc.content[0].layout = objLayout;
      				},
              exportOptions: {
                  columns: [ 0, 1, 2,3,4,5 ]
              },

          }
        ],
         "iDisplayLength": -1,
         "sPaginationType": "full_numbers",
      });
      $('.time').timepicker({
          minuteStep: 1,
          template: 'dropdown',
          appendWidgetTo: 'body',
          showSeconds: false,
          showMeridian: false,
          defaultTime: false,
          icons:{
            up: 'fa fa-caret-up',
            down: 'fa fa-caret-down'
        }
      });
      // Date range filter
      $(".datetime3").datepicker({
        format:"yyyy-mm-dd",
        viewMode: "months",
        minViewMode: "months"
      });
      $(".datetime9").datepicker({
        format:"yyyy-mm-dd",
      });
      $(".datetime1").datepicker({
        format:"yyyy-mm-dd",
        "onSelect": function(date) {
          minDateFilter = new Date(date).getTime();
          tbl.draw();
          console.log(minDateFilter);
        }
      }).change(function() {
        console.log("Time 1");
        minDateFilter = new Date(this.value).getTime();
        tbl.draw();
        console.log(minDateFilter);
      });
      $(".datetime2").datepicker({
        format:"yyyy-mm-dd",
        "onSelect": function(date) {
          maxDateFilter = new Date(date).getTime();
          console.log(maxDateFilter);
          tbl.draw();
        }
      }).change(function() {
        console.log("Time 1");
        maxDateFilter = new Date(this.value).getTime();
        console.log(maxDateFilter);
        tbl.draw();
      });
      if ($(".datatables_absensi").length > 0) {
        var x = $(".datatables_absensi").DataTable({
          ajax:"<?= base_url("api/read") ?>",
          "order": [[ 2, "desc" ]]
        });
        setInterval(function () {
          console.log("Reload");
          x.ajax.reload();
        }, 2000);
      }
    });
  </script>

</body>

</html>
