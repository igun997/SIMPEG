<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-8 offset-2">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="col-md-12">
          {msg}
            <form class="form-horizontal" enctype="multipart/form-data" action="{action}" method="post">
              {info}
              <div class="form-group">
                <label >NIP</label>
                <input type="text" class="form-control" name="nip"  value="{nip}" placeholder="">
              </div>
              <div class="form-group">
                <label >Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" value="{nama}" placeholder="">
              </div>
              <div class="form-group">
                <label >Tanggal Lahir</label>
                <input type="text" class="form-control dateTgl" name="tgl_lhr"  value="{tgl_lhr}" placeholder="">
              </div>
              <div class="form-group">
                <label >Jenis Kelamin</label>
                <select class="form-control" name="jk">
                  <option value="{jk}" selected>{jk}</option>
                  <option value="{unjk}" >{unjk}</option>
                </select>
              </div>
              <div class="form-group">
                <label>Foto</label>
                <input type="file" class="form-control-file" name="foto" placeholder="">
                <img src="<?= base_url("upload/") ?>{foto}" onerror="this.src='<?= base_url("assets/no_images.png") ?>'" style="width:auto;height:200px" alt="">
              </div>
              <div class="form-group">
                <label >Email</label>
                <input type="email" class="form-control" name="email" value="" placeholder="{email}">
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
                <label >Pendidikan Terakhir</label>
                <div class="form-group">
                  <input type="text" class="form-control" disabled value="{pendidikan}" placeholder="">
                </div>
                <select class="form-control" name="pendidikan">
                  <option value="" selected>== Pilih ==</option>
                  <option value="SD">SD</option>
                  <option value="SMP">SMP</option>
                  <option value="SMA">SMA</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                </select>
              </div>
              <div class="form-group">
                <label >Divisi</label>
                <div class="form-group">
                  <input type="text" class="form-control" disabled value="{nama_divisi}" placeholder="">
                </div>
                <select class="form-control" name="id_divisi">
                  <option value="" selected>== Pilih ==</option>
                  <?php
                  $this->main->setTable("divisi");
                  foreach ($this->main->get()->result() as $key => $value) {
                    echo "<option value='{$value->id_divisi}'>{$value->nama_divisi}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label >Jabatan</label>
                <div class="form-group">
                  <input type="text" class="form-control" disabled value="{status_pegawai}" placeholder="">
                </div>
                <select class="form-control" name="status_pegawai">
                  <option value="" selected>== Pilih ==</option>
                  <option value="anggota">Anggota</option>
                  <option value="ketua">Ketua</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success">
                  Simpan Data
                </button>
              </div>
              {/info}
            </form>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
