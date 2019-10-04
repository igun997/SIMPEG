<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
            <div class="form-group">
              <a href="<?= base_url("admin/admin/tambah") ?>" class='btn btn-success'>
                <i class="fa fa-plus"></i>
              </a>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table datatables">
              <thead>
                <th>NIP</th>
                <th>Nama Administrator</th>
                <th>Foto</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>JK</th>
                <th>Alamat</th>
                <th>Tgl Lahir</th>
                <th>Status</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                {data_admin}
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
                  <td>{tgl_lhr}</td>
                  <td>{status}</td>
                  <td>
                    <a href="<?= base_url("admin/admin/ubah/") ?>{nip}" class='btn btn-warning'>
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="<?= base_url("admin/admin/delete/") ?>{nip}" class='btn btn-danger'>
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
                {/data_admin}
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
