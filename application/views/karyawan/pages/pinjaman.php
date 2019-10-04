<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Pinjaman
        </div>
        <div class="card-body">
          <div class="form-group">
            <a href="<?= base_url("karyawan/pinjaman/tambah") ?>" class="btn btn-success">
              <i class="fa fa-plus"></i>
            </a>
          </div>
          <div class="table-responsive">
            <table class="table datatables_pinjam">
              <thead>
                <th>No Inv</th>
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
                    <td>{jumlah_pinjaman}</td>
                    <td>{status_pengajuan}</td>
                    <td>{status_pinjaman}</td>
                    <td>{tgl_pinjam}</td>
                    <td>
                      {action}
                      <a href="<?= base_url("karyawan/pinjaman/detail/") ?>{id_pinjaman}" class='btn btn-primary'>
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
