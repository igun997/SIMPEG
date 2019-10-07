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
              <table class="table table-bordered">
              <thead>
                <tr style="white-space: nowrap">
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
