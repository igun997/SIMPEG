<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
            <div class="form-group">
              <a href="<?= base_url("admin/pegawai/tambah") ?>" class='btn btn-success'>
                <i class="fa fa-plus"></i>
              </a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table datatables">
              <thead>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Foto</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>JK</th>
                <th>Alamat</th>
                <th>Pendidikan</th>
                <th>Tgl Lahir</th>
                <th>Status</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                {data_pegawai}
                <tr>
                  <td>{nip}</td>
                  <td>{nama}</td>
                  <td>
                    <img src="<?= base_url("upload/") ?>{foto}" style="width:auto;height:100px" alt="">
                  </td>
                  <td>{email}</td>
                  <td>{nomor_hp}</td>
                  <td>{jk}</td>
                  <td>{alamat}</td>
                  <td>{pendidikan}</td>
                  <td>{tgl_lhr}</td>
                  <td>{status}</td>
                  <td>
                    <div class="dropdown show">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?= base_url("admin/pegawai/ubah/") ?>{nip}">Ubah</a>
                        <a class="dropdown-item" href="<?= base_url("admin/pegawai/delete/") ?>{nip}">Hapus</a>
                        <a class="dropdown-item" href="<?= base_url("admin/pegawai/tunjangan/") ?>{nip}">Tambah Tunjangan</a>
                        <a class="dropdown-item" href="<?= base_url("admin/pegawai/jadwal/") ?>{nip}">Jadwal</a>
                      </div>
                    </div>
                  </td>
                </tr>
                {/data_pegawai}
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
