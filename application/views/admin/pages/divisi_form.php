<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-8 offset-2">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
          {msg}
            <form class="form-horizontal" enctype="multipart/form-data" action="{action}" method="post">
              {info}
              <div class="form-group">
                <label >Nama Divisi</label>
                <input type="text" class="form-control" name="nama_divisi" value="{nama_divisi}" placeholder="">
              </div>
              <div class="form-group">
                <label >Gaji Pokok</label>
                <input type="text" class="form-control" name="gaji_pokok" value="{gaji_pokok}" placeholder="">
              </div>
              <div class="form-group">
                <label >Jam Masuk [SIP 1]</label>
                <input type="text" class="form-control time" name="jam_masuk1" value="{jam_masuk1}" placeholder="">
              </div>
              <div class="form-group">
                <label >Jam Masuk [SIP 2]</label>
                <input type="text" class="form-control time" name="jam_masuk2" value="{jam_masuk2}" placeholder="">
              </div>
              <div class="form-group">
                <label >Waktu Kerja</label>
                <input type="text" class="form-control" name="waktu_kerja" value="{waktu_kerja}" placeholder="">
              </div>
              <div class="form-group">
                <label >Hari Minggu Libur</label>
                <input type="text" disabled class="form-control" value="{libur_minggu}">
                <br>
                <select class="form-control" name="libur_minggu">
                  <option value="" selected>== Pilih ==</option>
                  <option value="ya">Ya</option>
                  <option value="tidak">Tidak</option>
                </select>
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
