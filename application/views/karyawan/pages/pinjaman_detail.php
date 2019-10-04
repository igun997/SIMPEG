<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><font color=black>{block_title}</color></h1>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card shadow mb-4">
        <div class="card-header">
          Data Pinjaman
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <p>Total Pinjaman : Rp.<?= number_format($extend["info"]->jumlah_pinjaman) ?></p>
            <p>Lama Angsuran : <?= number_format($extend["info"]->lama_angsuran) ?> Bulan</p>
            <p>Cicilan Bulanan : Rp.<?= number_format($extend["info"]->cicilan) ?></p>
            <p>Total Dibayar : Rp.<?= number_format($extend["info"]->total_bayar) ?></p>
          </div>
          <hr>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table datatables">
                <thead>
                  <th>Tanggal Angsuran</th>
                  <th>Jumlah Angsuran</th>
                </thead>
                <tbody>
                  {angsuran}
                  <tr>
                    <td>{tgl_bayar}</td>
                    <td>{total_bayar}</td>
                  </tr>
                  {/angsuran}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
