<style media="screen">
  th {
    text-align: center;
  }
  td {
    text-align: center;
  }
</style>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-4">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Pegawai
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <img src="<?= base_url("upload/") ?>{foto}" onerror="this.src='<?= base_url("assets/no_images.png") ?>'"  class="img-fluid" alt="">
            </div>
            <div class="col-md-8">
              <form class="form-horizontal" >
                <div class="form-group">
                  <label >NIP</label>
                  <input type="text" class="form-control" name="email" value="<?= $extend["info"]->nip ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Nama Divisi</label>
                  <input type="text" class="form-control" name="email" value="<?= $extend["info"]->nama_divisi ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Nama Lengkap</label>
                  <input type="text" class="form-control" name="email" value="<?= $extend["info"]->nama ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Tanggal Lahir</label>
                  <input type="text" class="form-control" name="email" value="<?= $extend["info"]->tgl_lhr ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Jenis Kelamin</label>
                  <input type="text" class="form-control" name="email" value="<?= $extend["info"]->jk ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Email</label>
                  <input type="email" class="form-control" name="email" value="<?= $extend["info"]->nomor_hp ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Nomor HP</label>
                  <input type="text" class="form-control" name="nomor_hp" value="<?= $extend["info"]->nomor_hp ?>" disabled>
                </div>
                <div class="form-group">
                  <label >Alamat</label>
                  <textarea name="alamat" class="form-control" rows="8" cols="80" disabled><?= $extend["info"]->alamat ?></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Penggajian Sebelumnya
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table datatables">
                <thead>
                  <th>Tanggal Penggajian</th>
                  <th>Total Hadir</th>
                  <th>Total Tidak Hadir</th>
                  <th>Total Gaji</th>
                  <th>Pengurangan Gaji</th>
                  <th>Gaji Akhir</th>
                  <th>Keterangan</th>
                </thead>
                <tbody>
                  {gaji}
                    <tr>
                      <td>{dibuat}</td>
                      <td>{total_hadir}</td>
                      <td>{total_alpha}</td>
                      <td>{total_gaji}</td>
                      <td>{pinalti_gaji}</td>
                      <td>{akhir_gaji}</td>
                      <td>{keterangan}</td>
                    </tr>
                  {/gaji}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Absensi & Kalkulasi Gaji
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <form class="form-horizontal" action="" method="get">
              <div class="form-group">
                <label>Dari</label>
                <input type="text" class="form-control date" name="start">
              </div>
              <div class="form-group">
                <label>Sampai</label>
                <input type="text" class="form-control date" name="end">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">
                  Cari
                </button>
                <a href="<?= base_url("admin/penggajian/detail/".$extend["info"]->nip."?start=".date("Y-m-d",strtotime("-1 months",strtotime(date("Y-m-".$extend["tgl_gajian"]))))."&end=".date("Y-m-".$extend["tgl_gajian"])) ?>" class="btn btn-block btn-success">Pertanggal Penggajian</a>
              </div>
            </form>
          </div>
          <hr>
          <div class="col-md-12">
            <?php if ($this->input->get("start") != null): ?>
              <div class="table-responsive">
              <table class="table-bordered" style="width:100%">
                <tr>
                  <?php
                  $start = $this->input->get("start");
                  $end = $this->input->get("end");
                  $nip = $extend["info"]->nip;
                  $start = $this->input->get("start");
                  $end = $this->input->get("end");
                  $nip = $extend["info"]->nip;
                  if ($extend["info"]->libur_minggu == "ya") {
                    $absen = $this->main->getAbsen($nip,$start,$end,true);
                    // $absen = $this->main->getAbsen($nip,$start,$end);
                  }else {
                    $absen = $this->main->getAbsen($nip,$start,$end);
                  }
                  // $absen = $this->main->getAbsen($nip,$start,$end,true);
                  foreach ($absen["absen"] as $key => $value) {
                    echo "<th>{$key}</th>\n";
                  }
                  ?>
                </tr>
                <tr>
                  <?php foreach ($absen["absen"] as $key => $value): ?>
                    <?= $value ?>
                  <?php endforeach; ?>
                </tr>

              </table>
              <?php
              // var_dump($absen);
               ?>
            </div>
            <hr>
            <p>Gaji Pokok : Rp. <?= number_format($absen["data"]["gapok"]) ?></p>
            <p>Total Wajib Hadir : <?= ($absen["data"]["hadir"] + $absen["data"]["tidak_hadir"])  ?></p>
            <p>Total  Hadir : <?= $absen["data"]["hadir"] ?></p>
            <p>Total Sakit : <?= $absen["data"]["sakit"] ?></p>
            <p>Total Ijin : <?= $absen["data"]["ijin"] ?></p>
            <p>Total Cuti : <?= $absen["data"]["cuti"] ?></p>
            <p>Total Ketidakhadiran : <?= $absen["data"]["tidak_hadir"] ?></p>
            <p>Pinalti Ketidakhadiran : Rp. <?= number_format($absen["data"]["pinalti"]) ?></p>
            <p>Pinalti Terlambat Masuk : Rp. <?= number_format($absen["data"]["pinalti_telat"]) ?></p>
            <p>Waktu Lembur : <?= ($absen["data"]["overtime"]["jumlah"]) ?></p>
            <p>Biaya Lembur : Rp. <?= number_format($absen["data"]["overtime"]["tambahan"]) ?></p>
            <hr>
            <h5>Tunjangan</h5>
            <?php foreach ($absen["data"]["list_tunjangan"] as $key => $value): ?>
              <p><?= $value["nama"] ?> - <?= ($value["total"]) ?></p>
            <?php endforeach; ?>
            <hr>
            <p>Gaji Akhir : Rp. <?= number_format($absen["data"]["gapok_akhir"]) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
