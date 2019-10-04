<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Penggajian extends CI_Controller{
  /**
 	 * Konstruktor
 	 *
 	 * @return void
	 */

  public function __construct()
  {
    parent::__construct();
    $this->load->model("crud/main");
    if ($this->session->level != "admin") {
      redirect(base_url("public"));
    }
  }
  /**
 	 * Index Home
 	 *
 	 * @return void
	 */
  public function gaji_laporan()
  {
    $this->main->setJoin([
      "table"=>"penggajian",
      "join"=>[
        "users|users.nip = penggajian.nip|null",
        "divisi|divisi.id_divisi = users.id_divisi|null"
      ]
    ]);
    $start = date("01-m-Y",strtotime($this->input->get("start")));
    $end = date("t-m-Y",strtotime($this->input->get("end")));
    // echo $end;
    // exit();
    $row = $this->main->get("penggajian.dibuat >= '".date("Y-m-d",strtotime($start))."' AND penggajian.dibuat <= '".date("Y-m-d",strtotime($end))."'");
    $this->load->library('pdf');
    $pdf = new FPDF('l', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Image(base_url("assets/img/logo.png"),20,2,30);
    $pdf->Cell(300, 7, 'CV LOVA', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(300, 6, 'JALAN RAYA BANJARAN KEC. Pameungpeuk', 0, 1, 'C');
    $pdf->Cell(300, 6, '0265-592324', 0, 1, 'C');
    $pdf->Line(20, 33, 300-20, 33);
    $pdf->Line(20, 34, 300-20, 34);
    $pdf->Cell(8, 8, '',0,1);
    $month = ["01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"July","08"=>"Agustus","09"=>"September (Indra :*)","10"=>"Oktober","11"=>"November","12"=>"Desember"];
    $pdf->Cell(300, 7, 'LAPORAN PENGGAJIAN PEGAWAI', 0, 1, 'C');
    $pdf->Cell(300, 7, '#'.date("Ym-0001"), 0, 1, 'C');
    $pdf->Cell(300, 7, 'Periode Bulan '.$month[date("m",strtotime($start))]." ".date("Y",strtotime($start)), 0, 1, 'C');
    $pdf->SetFillColor(223,230,233);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('','B');
    // Header
    $pdf->SetLeftMargin(60);
    $header = array('NIP', 'Nama Pegawai', 'Gaji Bersih');
    $w = array(60, 65, 70);
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    // Color and font restoration
    $pdf->SetFillColor(223,230,233);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    // Data
    $fill = false;
    $data =  [1,2,3,4];
    $d = [0,0];
    foreach($row->result() as $k => $v)
    {
        $pdf->Cell($w[0],6,$v->nip,'LR',0,'L',$fill);
        $pdf->Cell($w[1],6,$v->nama,'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,number_format($v->total_gaji-$v->pinalti_gaji),'LR',0,'R',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $d[] = ($v->total_gaji-$v->pinalti_gaji);
    }

    $pdf->Cell($w[0],6,"Total",'LR',0,'L',$fill);
    $pdf->Cell($w[1],6,"",'LR',0,'L',$fill);
    $pdf->Cell($w[2],6,number_format(array_sum($d)),'LR',0,'R',$fill);
    $pdf->Ln();
    // Closing line
    $pdf->Cell(array_sum($w),0,'','T');
    $pdf->Ln();

    $pdf->SetLeftMargin(100);
     $pdf->Cell(120,1,'',0,0);
     $pdf->Cell(0,12,'Bandung , '.date('d/m/Y'),0,1,'C');
     $pdf->Cell(120,5,'',0,0);
     $pdf->Cell(0,5,'Direktur',0,1,'C');
     $pdf->Cell(120,5,'',0,0);
     $pdf->Cell(0,40,'Gerry Gustira',0,1,'C');
   $pdf->Output();
  }
  public function index()
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $data = $this->main->get(["status"=>"aktif","level"=>"karyawan"]);
    $build = [
      "block_title"=>"Penggajian Pegawai",
      "data_karyawan"=>$data->result_array(),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','penggajian','foot'],['title'=>"Penggajian Pegawai",'other'=>$build]);
  }
  public function gaji()
  {
    $this->main->setTable("setting");
    $tgl_gajian = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
    $this->main->setTable("penggajian");
    $num = $this->main->get("DATE_FORMAT(dibuat,'%m-%d') >= '".date("m-d")."'");
    if ($tgl_gajian == date("d")) {
      if ($num->num_rows() < 1) {
        $this->main->setJoin([
          "table"=>"users",
          "join"=>[
            "divisi|divisi.id_divisi = users.id_divisi|null"
          ]
        ]);
        $this->main->setSelect("users.*,divisi.libur_minggu");
        $get = $this->main->get(["users.level"=>"karyawan","users.status"=>"aktif"]);
        $dataGaji = [];
        foreach ($get->result() as $key => $value) {
          $start = date("Y-m-d",strtotime("-1 months",strtotime(date("Y-m-".$tgl_gajian))));
          $end = date("Y-m-".$tgl_gajian);
          $nip = $value->nip;
          if ($value->libur_minggu == "ya") {
            $absen = $this->main->getAbsen($nip,$start,$end,true);
          }else {
            $absen = $this->main->getAbsen($nip,$start,$end);
          }
          $this->main->setTable("pinjaman");
          $x = $this->main->get(["nip"=>$nip,"status_pinjaman"=>"belum","status_pengajuan"=>"disetujui"]);
          $tunjangan = $absen["data"]["json"];
          if ($x->num_rows() > 0) {
            if ($absen["data"]["gapok_akhir"] > 0) {
              if (($absen["data"]["gapok_akhir"]/2) > $x->row()->cicilan) {
                $this->main->setTable("pinjaman_detail");
                $instan = $this->main->get(["id_pinjaman"=>$x->row()->id_pinjaman]);
                $totalangsuran = 0;
                foreach ($instan->result() as $b => $a) {
                  $totalangsuran = $totalangsuran + $a->total_bayar;
                }
                if (($x->row()->jumlah_pinjaman - $totalangsuran) >  $x->row()->cicilan) {
                  $cicilan =  $x->row()->cicilan;
                }else {
                  $cicilan =  $x->row()->cicilan - ($x->row()->jumlah_pinjaman - $totalangsuran);
                }
                $this->main->insert(["total_bayar"=>$cicilan,"id_pinjaman"=>$x->row()->id_pinjaman]);
                if (($cicilan + $totalangsuran) == $x->row()->jumlah_pinjaman) {
                  $this->main->setTable("pinjaman");
                  $this->main->update(["status_pinjaman"=>"lunas"],["nip"=>$nip]);
                }
                $dataGaji[] = ["nip"=>$nip,"total_hadir"=>$absen["data"]["hadir"],"total_alpha"=>$absen["data"]["tidak_hadir"],"total_gaji"=>$absen["data"]["gapok"],"pinalti_gaji"=>(round($absen["data"]["pinalti"] + $absen["data"]["pinalti_telat"])+$cicilan),"keterangan"=>"Gaji dikurangi cicilan pinjaman per bulan sebesar Rp.".number_format($x->row()->cicilan)." dan total pinalty gaji sebesar Rp.".number_format(round($absen["data"]["pinalti"] + $absen["data"]["pinalti_telat"]))];
              }else {
                $dataGaji[] = ["nip"=>$nip,"total_hadir"=>$absen["data"]["hadir"],"total_alpha"=>$absen["data"]["tidak_hadir"],"total_gaji"=>$absen["data"]["gapok"],"pinalti_gaji"=>round($absen["data"]["pinalti"] + $absen["data"]["pinalti_telat"]),"keterangan"=>"Gaji tidak mencukupi untuk melunasi tunggakan pinjaman bulan ini sebesar Rp.".number_format($x->row()->cicilan)." dari total pinjaman sebesar Rp.".number_format($x->row()->jumlah_pinjaman),"tunjangan"=>$tunjangan];
              }
            }else {
              $dataGaji[] = ["nip"=>$nip,"total_hadir"=>$absen["data"]["hadir"],"total_alpha"=>$absen["data"]["tidak_hadir"],"total_gaji"=>$absen["data"]["gapok"],"pinalti_gaji"=>round($absen["data"]["pinalti"] + $absen["data"]["pinalti_telat"]),"keterangan"=>"Gaji tidak mencukupi untuk melunasi tunggakan cicilan bulan ini sebesar Rp.".number_format($x->row()->cicilan)." dari total pinjaman sebesar Rp.".number_format($x->row()->jumlah_pinjaman),"tunjangan"=>$tunjangan];
            }
          }else {
            $dataGaji[] = ["nip"=>$nip,"total_hadir"=>$absen["data"]["hadir"],"total_alpha"=>$absen["data"]["tidak_hadir"],"total_gaji"=>$absen["data"]["gapok"],"pinalti_gaji"=>round($absen["data"]["pinalti"] + $absen["data"]["pinalti_telat"]),"keterangan"=>null,"tunjangan"=>$tunjangan];
          }
        }
        $ins = $this->db->insert_batch("penggajian",$dataGaji);
        if ($ins) {
          $this->session->set_flashdata("message","<div class='alert alert-success'>Penggajian Telah Di Selesaikan</div>");
        }else {
          $this->session->set_flashdata("message","<div class='alert alert-danger'>Gagal Menyimpan Data Penggajian</div>");
        }
        // $this->session->set_flashdata("message",json_encode($dataGaji));
      }else {
        $this->session->set_flashdata("message","<div class='alert alert-danger'>Penggajian Telah Dilakukan Sebelumnya</div>");
      }
    }else {
      $this->session->set_flashdata("message","<div class='alert alert-danger'>Bukan Tanggal Penggajian</div>");
    }
    redirect($_SERVER["HTTP_REFERER"]);
  }
  public function detail($nip='')
  {
    $this->main->setTable("users");
    $getdata = $this->main->get(["nip"=>$nip]);
    $this->main->setTable("setting");
    $tgl_gajian = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
    if ($getdata->num_rows() > 0) {
      $this->template->setFolder("admin");
      $this->template->defaultStyle("front");
      $this->main->setTable("penggajian");
      $gajian = $this->main->get(["nip"=>$nip])->result_array();
      $this->main->setJoin([
        "table"=>"users",
        "join"=>[
          "divisi|divisi.id_divisi = users.id_divisi|null"
        ]
      ]);
      $data = $this->main->get(["users.level"=>"karyawan","users.status"=>"aktif","nip"=>$nip])->row();
      foreach ($gajian as $key => &$value) {
        $value["akhir_gaji"] = ($value["total_gaji"] - $value["pinalti_gaji"]);
      }
      $build = [
        "block_title"=>"Detail Pegawai [{$data->nip}] - [$data->nama]",
        "gaji"=>$gajian
      ];

      $ext = [
        "info"=>$data,
        "tgl_gajian"=>$tgl_gajian
      ];
      $this->template->renderHTML(['head','penggajian_detail','foot'],["extend"=>$ext,'title'=>"Penggajian Pegawai",'other'=>$build]);
    }else {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
}
