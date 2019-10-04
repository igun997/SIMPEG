
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800" ><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-info">
        <?= $this->session->flashdata("msg") ?>
      </div>
      <?php
        $this->main->setTable("absensi");
        $s = $this->main->get("masuk >= '".date("Y-m-d 00:00:00")."' AND masuk <= '".date("Y-m-d 00:00:00",strtotime("+1 day"))."' AND type='normal'")->num_rows();
        $a = $this->main->get("keluar >= '".date("Y-m-d 00:00:00")."' AND keluar <= '".date("Y-m-d 00:00:00",strtotime("+1 day"))."' AND type='normal'")->num_rows();
        $b = $this->main->get("masuk >= '".date("Y-m-d 00:00:00")."' AND masuk <= '".date("Y-m-d 00:00:00",strtotime("+1 day"))."' AND type='sakit'")->num_rows();
        $c = $this->main->get("masuk >= '".date("Y-m-d 00:00:00")."' AND masuk <= '".date("Y-m-d 00:00:00",strtotime("+1 day"))."' AND type='alfa'")->num_rows();
        $d = $this->main->get("masuk >= '".date("Y-m-d 00:00:00")."' AND masuk <= '".date("Y-m-d 00:00:00",strtotime("+1 day"))."' AND type='ijin'")->num_rows();
        $e = $this->main->get("masuk >= '".date("Y-m-d 00:00:00")."' AND masuk <= '".date("Y-m-d 00:00:00",strtotime("+1 day"))."' AND type='cuti'")->num_rows();
      ?>
      <div class="row">
        <div class="col-xl-3 col-md-5 mb-3">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hadir</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $s ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-5 mb-3">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tidak Hadir</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $a ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-md-5 mb-3">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sakit</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $b ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-md-5 mb-3">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ijin</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $d ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-md-5 mb-3">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cuti</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $e ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Statistik Absensi Karyawan
        </div>
        <div class="card-body">
        </div>
      </div>
    </div>
  </div>
</div>
