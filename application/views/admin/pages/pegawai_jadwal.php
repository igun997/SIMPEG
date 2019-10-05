<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
            {msg}
            <form class="" action="" method="post">
              <div class="form-group">
                <label>Jadwal</label>
                <select class="form-control" name="status">
                  <option value="0">Hadir</option>
                  <option value="1">Libur</option>
                </select>
              </div>
              <div class="form-group">
                <label>SIP</label>
                <input type="number" max="2" min="1" class="form-control" name="sip" value="1">
              </div>
              <input type="text"  hidden name="nip" value="{nip}" >
              <div class="form-group">
                <label>Jadwal</label>
                <input type="text" class="form-control datetime9" name="tanggal">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                  Simpan
                </button>
              </div>
            </form>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table datatables">
              <thead>
                <th>No</th>
                <th>Jadwal</th>
                <th>SIP</th>
                <th>Jadwal Tanggal</th>
                <th>Aksi</th>
              </thead>
              <tbody>
              {data_jadwal}
                <tr>
                  <th>{no}</th>
                  <th>{status}</th>
                  <th>{sip}</th>
                  <th>{tanggal}</th>
                  <th>
                    <a href="<?= base_url("admin/pegawai/jadwal_del/") ?>/{id_penjadwalan}" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </a>
                  </th>
                </tr>
              {/data_jadwal}
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
