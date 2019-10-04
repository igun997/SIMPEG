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
                <label >Karyawan</label>
                <select class="form-control select2" name="nip">
                  <?php foreach ($extend["pegawai"] as $key => $value): ?>
                    <option value="<?= $value->nip ?>"><?= $value->nama." - ".$value->nip ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label >Keterangan</label>
                <select class="form-control" name="type">
                  <option value="normal">Hadir</option>
                  <option value="ijin">Ijin</option>
                  <option value="sakit">Sakit</option>
                  <option value="cuti">Cuti</option>
                  <option value="alfa">Tidak Hadir</option>
                </select>
              </div>
              <div class="form-group">
                <label>Telat</label>
                <input type="number" class="form-control" name="telat" placeholder="Hitungan Menit">
              </div>
              <div class="form-group">
                <label>Tanggal Absen</label>
                <input type="text" class="form-control date" name="tgl" placeholder="Tanggal Masuk">
              </div>
              <div class="form-group">
                <label>Lembur</label>
                  <select class="form-control" name="lembur">
                    <option value="tidak">Tidak</option>
                    <option value="iya">Iya</option>
                  </select>
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
