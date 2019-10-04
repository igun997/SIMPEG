<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-8 offset-2">
      <div class="card shadow mb-4">
        <div class="card-header">
          Pengaturan Akun
        </div>
        <div class="card-body">
          <div class="col-md-12">
          {msg}
          {info}
            <form class="form-horizontal" enctype="multipart/form-data" action="<?= base_url("admin/akun/action") ?>" method="post">
              <div class="form-group">
                <label >NIP</label>
                <input type="text" class="form-control" name="nip" disabled value="{nip}" placeholder="">
              </div>
              <div class="form-group">
                <label >Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" value="{nama}" placeholder="">
              </div>
              <div class="form-group">
                <label >Tanggal Lahir</label>
                <input type="text" class="form-control date" name="tgl_lhr"  value="{tgl_lhr}" placeholder="">
              </div>
              <div class="form-group">
                <label >Jenis Kelamin</label>
                <select class="form-control" name="jk">
                  <?php if ($this->session->jk == null): ?>
                    <option value="laki-laki"><?= strtoupper("laki-laki") ?></option>
                    <option value="perempuan"><?= strtoupper("perempuan") ?></option>
                  <?php else: ?>
                    <option value="<?= $this->session->jk ?>" selected><?= strtoupper($this->session->jk) ?></option>
                    <?php if ($this->session->jk == "laki-laki"): ?>
                      <option value="perempuan"><?= strtoupper("perempuan") ?></option>
                    <?php endif; ?>
                    <?php if ($this->session->jk == "perempuan"): ?>
                      <option value="laki-laki"><?= strtoupper("laki-laki") ?></option>
                    <?php endif; ?>
                  <?php endif; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Foto</label>
                <input type="file" class="form-control-file" name="foto" placeholder="">
                <img src="<?= base_url("upload/") ?>{foto}" onerror="this.src='<?= base_url("assets/no_images.png") ?>'" style="width:auto;height:200px" alt="">
              </div>
              <div class="form-group">
                <label >Email</label>
                <input type="email" class="form-control" name="email" value="{email}" placeholder="">
              </div>
              <div class="form-group">
                <label >Password</label>
                <input type="password" class="form-control" name="password" value="" placeholder="Isi Untuk Mengubah Password">
              </div>
              <div class="form-group">
                <label >Nomor HP</label>
                <input type="text" class="form-control" name="nomor_hp" value="{nomor_hp}" placeholder="">
              </div>
              <div class="form-group">
                <label >Alamat</label>
                <textarea name="alamat" class="form-control" rows="8" cols="80">{alamat}</textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-warning">
                  Update Data
                </button>
              </div>
            </form>
          {/info}
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
