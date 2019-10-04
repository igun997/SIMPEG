<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>Data Tunjangan</color></h1>
  <div class="row">
    <div class="col-md-8 offset-2">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
          {msg}
            <form class="form-horizontal" enctype="multipart/form-data" action="{action}" method="post">
              {info}
              <div class="form-group">
                <label >Kode Tunjangan</label>
                <input type="text" class="form-control" name="kode_overtime"  value="{kode_overtime}" placeholder="">
              </div>
              <div class="form-group">
                <label >Nama Tunjangan</label>
                <input type="text" class="form-control" name="nama_tunjangan"  value="{nama_tunjangan}" placeholder="">
              </div>
              <div class="form-group">
                <label >Jenis Tunjangan</label>
                <input type="text" class="form-control" name=""  value="{jenis_overtime}" disabled>
                <br>
                <select class="form-control" name="jenis_overtime">
                  <option value=""> == Pilih == </option>
                  <option value="benefit">Benefit</option>
                  <option value="cost">Cost</option>
                </select>
              </div>
              <div class="form-group">
                <label >Total</label>
                <input type="number" class="form-control" name="total" value="{total}" placeholder="">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success">
                  Simpan Data
                </button>
              </div>
              {/info}
            </form>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
