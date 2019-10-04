<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>Data Tunjangan</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
            <div class="form-group">
              <a href="<?= base_url("admin/overtime/tambah") ?>" class='btn btn-success'>
                <i class="fa fa-plus"></i> Tambah Tunjangan
              </a>
            </div>
          </div>
          <div class="col-md-12">
            <table class="table datatables">
              <thead>
                <th>Kode</th>
                <th>Nama Tunjangan</th>
                <th>Jenis</th>
                <th>Total</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                {data_overtime}
                <tr>
                  <td>{kode_overtime}</td>
                  <td>{nama_tunjangan}</td>
                  <td>{jenis_overtime}</td>
                  <td>{total}</td>
                  <td>
                    <div class="dropdown show">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?= base_url("admin/overtime/ubah/") ?>{id_overtime}">Ubah</a>
                        <a class="dropdown-item" href="<?= base_url("admin/overtime/delete/") ?>{id_overtime}">Hapus</a>
                      </div>
                    </div>
                  </td>
                </tr>
                {/data_overtime}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
