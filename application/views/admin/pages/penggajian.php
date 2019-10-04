<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Daftar Pegawai
        </div>
        <div class="card-body">
          <form class="form-horizontal"  action="<?= base_url("admin/penggajian/gaji_laporan") ?>" method="get">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-2">
                <a href="<?= base_url("admin/penggajian/gaji") ?>" class='btn btn-success btn-sm'>Hasilkan Penggajian</a>
              </div>
              <div class="col-md-3">
                <input type="month" name="start" class="form-control">
              </div>
              <div class="col-md-3">
                <input type="month" name="end" class="form-control">
              </div>
              <div class="col-md-3">
                <button type='submit' class='btn btn-danger btn-sm'>Cetak Laporan Penggajian</button>
              </div>
            </div>
          </div>
        </form>
          <div class="col-md-12">
            {msg}
            <div class="table-responsive">
              <table class="table datatables">
                <thead>
                  <th>NIP</th>
                  <th>Nama Pegawai</th>
                  <th>Nomor HP</th>
                  <th>Email</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                  {data_karyawan}
                    <tr>
                      <td>{nip}</td>
                      <td>{nama}</td>
                      <td>{nomor_hp}</td>
                      <td>{email}</td>
                      <td>
                        <a href="<?= base_url("admin/penggajian/detail/") ?>{nip}" class="btn btn-success">
                          <i class="fa fa-search"></i>
                        </a>
                      </td>
                    </tr>
                  {/data_karyawan}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
