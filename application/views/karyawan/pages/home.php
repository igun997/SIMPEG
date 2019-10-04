<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-info">
        <?= $this->session->flashdata("msg") ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header">
          Profil Karyawan
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <center>
                <img src="<?= base_url("upload/") ?><?= $extend["info"]->foto ?>" onerror="this.src='<?= base_url("assets/no_images.png") ?>'"  class="img-fluid" style="height:200px" alt="">
              </center>
            </div>
            <div class="col-md-12">
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
                  <input type="email" class="form-control" name="email" value="<?= $extend["info"]->email ?>" disabled>
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
    <div class="col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header">
          Penggajian
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12">
                <form class="form-horizontal" action="<?= base_url("karyawan/home/cetak") ?>" method="get">
                  <div class="form-group">
                    <label for="">Mulai</label>
                    <input type="month" name="start" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Sampai</label>
                    <input type="month" name="end" class="form-control">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm btn-block">
                      Simpan
                    </button>
                  </div>
                </form>
                <div class="table-responsive">
                  <?php
                  $this->main->setTable("penggajian");
                  $inv = $this->main->get(["nip"=>$this->session->nip]);
                  ?>
                  <table class="table datatables">
                    <thead>
                      <th>Tanggal</th>
                      <th>Total Hadir</th>
                      <th>Total Tidak Hadir</th>
                      <th>Total Gaji</th>
                      <th>Pinalti Gaji</th>
                      <th>Gaji Akhir</th>
                      <th>Keterangan</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php foreach ($inv->result() as $key => $value): ?>
                        <tr>
                          <td><?= $value->dibuat ?></td>
                          <td><?= $value->total_hadir ?></td>
                          <td><?= $value->total_alpha ?></td>
                          <td><?= number_format($value->total_gaji) ?></td>
                          <td><?= number_format($value->pinalti_gaji) ?></td>
                          <td><?= number_format(($value->total_gaji-$value->pinalti_gaji)) ?></td>
                          <td><?= $value->keterangan ?></td>
                          <td>
                            <a href="<?= base_url("karyawan/home/cetak/".$value->id_penggajian) ?>" class="btn btn-primary">
                              <i class="fa fa-print"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <hr>
              <!-- <div class="col-md-12">
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
                    <a href="<?= base_url("karyawan/?start=".date("Y-m-d",strtotime("-1 months",strtotime(date("Y-m-".$extend["tgl_gajian"]))))."&end=".date("Y-m-".$extend["tgl_gajian"])) ?>" class="btn btn-block btn-success">Pertanggal Penggajian</a>
                  </div>
                </form>
              </div>
              <hr> -->
              <div class="col-md-12">
                  <div class="table-responsive">
                  <table class="table-bordered" style="width:100%">

                    <tr>
                      <?php
                      $start = date("Y-m-01");
                      $end = date("Y-m-t");
                      $nip = $extend["info"]->nip;
                      if ($extend["info"]->libur_minggu == "ya") {
                        $absen = $this->main->getAbsen($nip,$start,$end,true);
                        // $absen = $this->main->getAbsen($nip,$start,$end);
                      }else {
                        $absen = $this->main->getAbsen($nip,$start,$end);
                      }
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
                </div>
                <!-- <hr>
                <p>Gaji Pokok : Rp. <?= number_format($absen["data"]["gapok"]) ?></p>
                <p>Total Wajib Hadir : <?= ($absen["data"]["hadir"] + $absen["data"]["tidak_hadir"])  ?></p>
                <p>Total  Hadir : <?= $absen["data"]["hadir"] ?></p>
                <p>Pinalti Ketidakhadiran : Rp. <?= number_format($absen["data"]["pinalti"]) ?></p>
                <p>Pinalti Terlambat Masuk : Rp. <?= number_format($absen["data"]["pinalti_telat"]) ?></p>
                <p>Gaji Akhir : Rp. <?= number_format($absen["data"]["gapok_akhir"]) ?></p> -->
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
