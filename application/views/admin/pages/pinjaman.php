<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Pinjaman
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control datetime1" id="start" placeholder="Mulai">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control datetime2" id="end" placeholder="Sampai">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <button type="button" id="cari" class="btn btn-primary">
                  Cari
                </button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table datatables_pinjam">
              <thead>
                <th>No Inv</th>
                <th>Peminjam</th>
                <th>Jumlah</th>
                <th>Status Pengajuan</th>
                <th>Status Pelunasan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                {data_pinjam}
                  <tr>
                    <td>{id_pinjaman}</td>
                    <td>{nama}</td>
                    <td>{jumlah_pinjaman}</td>
                    <td>{status_pengajuan}</td>
                    <td>{status_pinjaman}</td>
                    <td>{tgl_pinjam}</td>
                    <td>
                      {action}
                      <a href="<?= base_url("admin/pinjaman/detail/") ?>{id_pinjaman}" class='btn btn-primary'>
                        <i class="fa fa-search"></i>
                      </a>
                    </td>
                  </tr>
                {/data_pinjam}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
