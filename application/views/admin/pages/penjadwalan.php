<script type="text/javascript">
  <?php
    if (isset($_GET["bulan"])) {
  ?>
      const bln12 = <?= $_GET["bulan"] ?>;
  <?php
    }else{
      echo "const bln12 = null;";
    }
  ?>
</script>
<style media="screen">
  td,th {
    width: 2px !important;
  }
</style>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Penjadwalan
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Bulan</label>
              <select class="form-control" id="bulanku">
                <option value="">== Pilih ==</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
            <div class="form-group">
              <label>Divisi</label>
              <select class="form-control" id="divisi">
                <option value="">== Pilih ==</option>
                {data_divisi}
                <option value="{id_divisi}">{nama_divisi}</option>
                {/data_divisi}
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table border="1" style="font-size:10px;">
              <thead>
                <tr style="white-space: nowrap;">
                  <th>NIP</th>
                  <th>Nama Lengkap</th>
                  {date}
                  <th>{d}</th>
                  {/date}
                </tr>
              </thead>
              <tbody id="penjadwalan">

              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
