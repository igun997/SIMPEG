<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
            <div class="form-group">
              <a href="<?= base_url("admin/divisi/tambah") ?>" class='btn btn-success'>
                <i class="fa fa-plus"></i>
              </a>
            </div>
          </div>
          <div class="col-md-12">
            <table class="table datatables">
              <thead>
                <th>ID</th>
                <th>Nama Divisi</th>
                <th>Gaji Pokok</th>
                <th>Jam Masuk [SIP 1]</th>
                <th>Jam Masuk [SIP 2]</th>
                <th>Total Jam Kerja</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                {data_divisi}
                <tr>
                  <td>{id_divisi}</td>
                  <td>{nama_divisi}</td>
                  <td>{gaji_pokok}</td>
                  <td>{jam_masuk1}</td>
                  <td>{jam_masuk2}</td>
                  <td>{waktu_kerja}</td>
                  <td>
                    <div class="dropdown show">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?= base_url("admin/divisi/ubah/") ?>{id_divisi}">Ubah</a>
                        <a class="dropdown-item" href="<?= base_url("admin/divisi/delete/") ?>{id_divisi}">Hapus</a>
                        <a class="dropdown-item" href="<?= base_url("admin/divisi/tunjangan/") ?>{id_divisi}">Tambah Tunjangan</a>
                      </div>
                    </div>

                  </td>
                </tr>
                {/data_divisi}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
