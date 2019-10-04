<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Monitoring Absensi
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table datatables_absensi">
              <thead>
                <th>NIP</th>
                <th>Nama</th>
                <th>Waktu Absensi</th>
                <th>Status</th>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Absensi
        </div>
        <div class="card-body">
          <form  action="<?= base_url("admin/absensi/print") ?>" method="get">
          <div class="row">
            <div class="col-md-4">
              <a href="<?= base_url("admin/absensi/tambah") ?>" class="btn btn-success">
                <i class="fa fa-plus"></i>
              </a>
            </div>
              <div class="col-md-4">
                <input type="text" name="periode"  class="form-control datetime3">
              </div>
              <div class="col-md-4">
                <button type='submit' class='btn btn-danger btn-sm'>Cetak Absensi</button>
              </div>
          </div>
        </form>
          <div class="table-responsive">
            <table class="table datatables">
              <thead>
                <th>NIP</th>
                <th>Nama</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                {data_users}
                  <tr>
                    <td>{nip}</td>
                    <td>{nama}</td>
                    <td>
                      <a href="<?= base_url("admin/absensi/detail/") ?>{nip}" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                      </a>
                    </td>
                  </tr>
                {/data_users}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
