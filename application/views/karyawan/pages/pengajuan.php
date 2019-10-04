<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-8 offset-2">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
          {msg}
            <form class="form-horizontal" enctype="multipart/form-data" action="{action}" method="post">
              <div class="form-group">
                <label>Jumlah Pinjaman *3x Dari Gaji Pokok</label>
                <input type="number" class="form-control" name="jumlah_pinjaman" id="jumlah_pinjaman" max="{max_gaji}" placeholder="" >
              </div>
              <div class="form-group">
                <label>Tenor</label>
                <select class="form-control" name="lama_angsuran" id="lama_angsuran">
                  <option value="3">3 Bulan</option>
                  <option value="6">6 Bulan</option>
                  <option value="12">12 Bulan</option>
                </select>
              </div>
              <div class="form-group">
                <label>Cicilan</label>
              <input type="text" class="form-control" id="cicilan" readonly >
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
