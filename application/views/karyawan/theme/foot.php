
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
    $(document).ready(function() {
      $(".date").datepicker({
        format:"yyyy-m-d"
      });
      $(".datatables").DataTable({

      });
      $(".datatables_pinjam").DataTable({
        "order": [[ 4, "asc" ],[ 3, "desc" ]]
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
      $("#lama_angsuran").on('change', function(event) {
        event.preventDefault();
        lama_pinjam = parseFloat($(this).val());
        cicilan = parseFloat($("#jumlah_pinjaman").val());
        console.log(lama_pinjam);
        console.log(cicilan);
        $("#cicilan").val((cicilan/lama_pinjam));
      });
    });
  </script>

</body>

</html>
