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
                <label>Tunjangan</label>
                <select class="form-control" name="id_overtime">
                  <?php foreach ($extend["overtime"]->result() as $key => $value): ?>
                    <option value="<?= $value->id_overtime ?>">[<?= $value->kode_overtime ?>] <?= $value->nama_tunjangan ?> - <?= $value->total ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Jabatan</label>
                <select class="form-control" name="untuk">
                  <option value="anggota">Anggota</option>
                  <option value="ketua">Ketua</option>
                </select>
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
                <th>Jabatan</th>
                <th>Nama Tunjangan</th>
                <th>Total Tunjangan</th>
                <th>Jenis Tunjangan</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <?php foreach ($extend["ov"]->result() as $key => $value): ?>
                  <tr>
                    <td><?= ($key+1) ?></td>
                    <td><?= ucfirst($value->untuk) ?></td>
                    <td><?= $value->nama_tunjangan ?></td>
                    <td><?= number_format($value->total) ?></td>
                    <td><?= ucfirst($value->jenis_overtime) ?></td>
                    <td>
                      <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Aksi
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <a class="dropdown-item" href="<?= base_url("admin/divisi/tunjangan/".$value->id_divisi."?cmd=hapus&id=".$value->id_od) ?>">Hapus</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
