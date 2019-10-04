<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-8 offset-2">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
          {msg}
            <form class="form-horizontal" enctype="multipart/form-data" action="<?= base_url("admin/pengaturan/update") ?>" method="post">
              <div class="form-group">
                <label >Overtime</label>
                <input type="text" class="form-control" name="overtime" value="{overtime}" placeholder="">
              </div>
              <div class="form-group">
                <label >Tanggal Penggajian</label>
                <input type="text" class="form-control" name="tgl_penggajian" value="{tgl_penggajian}" placeholder="">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success">
                  Simpan Data
                </button>
              </div>
            </form>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
