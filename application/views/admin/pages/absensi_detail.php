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
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Absensi
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table-bordered" style="width:100%">
              <tr>
                <?php
                $start = $extend["start"];
                $end = $extend["end"];
                $nip = $extend["nip"];
                $absen = $this->main->getAbsen($nip,$start,$end);
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

        </div>
      </div>
    </div>

  </div>
</div>
