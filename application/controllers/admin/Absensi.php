<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Absensi extends CI_Controller{
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
   public function print()
   {
     $periode = $this->input->get("periode");
     $this->load->library('pdf');
     $pdf = new FPDF('l', 'mm', 'A4');
     $pdf->AddPage("L");
     $pdf->SetFont('Arial', 'B', 12);
     $pdf->Image(base_url("assets/img/logo.png"),20,2,30);
     $pdf->Cell(300, 7, 'CV LOVA', 0, 1, 'C');
     $pdf->SetFont('Arial', '', 12);
     $pdf->Cell(300, 6, 'JALAN RAYA BANJARAN KEC. Pameungpeuk', 0, 1, 'C');
     $pdf->Cell(300, 6, '0265-592324', 0, 1, 'C');
     $pdf->Line(20, 33, 300-20, 33);
     $pdf->Line(20, 34, 300-20, 34);
     $pdf->Cell(8, 8, '',0,1);
     $month = ["01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"July","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"];
     $pdf->Cell(300, 7, 'LAPORAN ABSENSI PEGAWAI', 0, 1, 'C');
     $pdf->Cell(300, 7, 'Periode Bulan '.$month[date("m",strtotime($periode))]." ".date("Y",strtotime($periode)), 0, 1, 'C');
     $pdf->SetFillColor(223,230,233);
     $pdf->SetTextColor(0);
     $pdf->SetDrawColor(0);
     $pdf->SetLineWidth(.3);
     $pdf->SetFont('','B',7);
     // Header
     $pdf->SetLeftMargin(10);
     $header = ['NIP', 'Nama Pegawai'];
     $this->main->setTable("setting");
     $tgl_penggajian = $this->main->get(["meta_key"=>"tgl_penggajian"])->row();
     $tgl = $tgl_penggajian->meta_value;
     $end = date("Y-m-".$tgl,strtotime($periode));
     $start = date("Y-m-d",strtotime("-1 month",strtotime($end)));
     $this->main->setTable("users");
     $s = $this->main->get(["level"=>"karyawan"]);
     foreach ($s->result() as $keyx => $valuex) {
       $nip = $valuex->nip;
       $absen = $this->main->getAbsen($nip,$start,$end,true,true);
       $w = [];
       $w[] = 16;
       $w[] = 55;
       $presensi = [];
       foreach ($absen["absen"] as $key => $value) {
         $header[] = $key;
         $w[] = 7.5;

       }
       for($i=0;$i<count($header);$i++)
       $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
       $pdf->Ln();
       // Color and font restoration
       $pdf->SetFillColor(223,230,233);
       $pdf->SetTextColor(0);
       $pdf->SetFont('');
       break;
     }
     $fill = false;
     foreach ($s->result() as $keyx => $valuex) {

       $nip = $valuex->nip;
       $absen = $this->main->getAbsen($nip,$start,$end,true,true);
       $pdf->Cell($w[0],6,$valuex->nip,'LR',0,'L',$fill);
       $pdf->cell($w[1],6,$valuex->nama,'LR',0,'L',$fill);
       foreach ($absen["absen"] as $k => $va) {
         $pdf->Cell($w[$k+2],6,$va,'LR',0,'C',$fill);
       }
       // var_dump($abs)
       // exit();
       $pdf->Ln();
       $fill = !$fill;
     }
     // Data
     // foreach($row->result() as $k => $v)
     // {
     // }

     // $pdf->Cell($w[0],6,"Total",'LR',0,'L',$fill);
     // $pdf->Cell($w[1],6,"",'LR',0,'L',$fill);
     // $pdf->Cell($w[2],6,number_format(array_sum($d)),'LR',0,'R',$fill);
     // $pdf->Ln();
     // Closing line
     // $pdf->Cell(array_sum($w),0,'','T');
     $pdf->Ln();
     $pdf->Cell(300, 6, 'Rekapitulasi Absensi Pegawai', 0, 1, 'L');
     $new_w = [20,20,10,10,10,10,10];
     $header_w = ["NIP","Nama","Sakit","Ijin","Alfa","Cuti","Hadir"];
     for($i=0;$i<count($header_w);$i++)
     $pdf->Cell($new_w[$i],7,$header_w[$i],1,0,'C',true);
     $pdf->Ln();
     // Color and font restoration
     $pdf->SetFillColor(223,230,233);
     $pdf->SetTextColor(0);
     $pdf->SetFont('');
     $xsss = [];
     foreach ($s->result() as $keyx => $valuex) {
       $nip = $valuex->nip;
       $absen = $this->main->getAbsen($nip,$start,$end,true,true);
       $sx = 0;
       $xs = 0;
       $as = 0;
       $cs = 0;
       $hs = 0;
       foreach ($absen["absen"]  as $k => $va) {
         if ($va  == "S") {
           $sx++;
         }elseif ($va == "I") {
           $xs++;
         }elseif ($va == "X") {
           $as++;
         }elseif ($va == "C") {
           $cs++;
         }elseif ($va == "*") {
           $hs++;
         }
       }
       $pdf->Cell($new_w[0],6,$valuex->nip,'LR',0,'L',$fill);
       $pdf->cell($new_w[1],6,$valuex->nama,'LR',0,'L',$fill);
       $pdf->cell($new_w[2],6,$sx,'LR',0,'L',$fill);
       $pdf->cell($new_w[3],6,$xs,'LR',0,'L',$fill);
       $pdf->cell($new_w[4],6,$as,'LR',0,'L',$fill);
       $pdf->cell($new_w[5],6,$cs,'LR',0,'L',$fill);
       $pdf->cell($new_w[6],6,$hs,'LR',0,'L',$fill);
       // var_dump($abs)
       // exit();
       $pdf->Ln();
       $fill = !$fill;
     }
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
    $get = $this->main->get(["status"=>"aktif","level"=>"karyawan"]);
    $build = [
      "block_title"=>"Monitoring Absensi Pegawai",
      "data_users"=>$get->result_array()
    ];
    $this->template->renderHTML(['head','absensi','foot'],['title'=>"Monitoring Absensi Pegawai",'other'=>$build]);
  }
  public function detail($id="")
  {
    $start = $this->input->get("start");
    $end = $this->input->get("end");
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setJoin([
      "table"=>"users",
      "join"=>[
        "absensi|absensi.nip = users.nip|null"
      ]
    ]);
    $get = $this->main->get(["users.nip"=>$id]);
    if (!isset($get->row()->nama)) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
    $build = [
      "block_title"=>"Detail Absensi NIP ".$id." - ".$get->row()->nama,
      "data_detail"=>$get->result_array(),
      "data_absensi"=>"",
    ];
    $ext = ["start"=>$start,"end"=>$end,"nip"=>$id];
    $this->template->renderHTML(['head','absensi_detail','foot'],["extend"=>$ext,'title'=>"Detail Absensi NIP ".$id,'other'=>$build]);
  }
  public function tambah()
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $build = [
      "block_title"=>"Tambah - Data Absen",
      "action"=>base_url("admin/absensi/create"),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->main->setTable("users");
    $as = $this->main->get(["level"=>"karyawan"]);
    $ext = [
      "pegawai"=>$as->result()
    ];
    $this->template->renderHTML(['head','absensi_form','foot'],["extend"=>$ext,'title'=>"Tambah - Data Absen",'other'=>$build]);
  }
  public function create()
  {
    $this->main->setTable("users");
    $id_divisi = $this->main->get(["nip"=>$this->input->post("nip")])->row()->id_divisi;
    $waktu_kerja = $this->main->get(["nip"=>$this->input->post("nip")])->row()->waktu_kerja;
    $sip = "jam_masuk".$this->main->get(["nip"=>$this->input->post("nip")])->row()->sip;
    $this->main->setTable("divisi");
    $tgl = $this->input->post("tgl");
    $type = $this->input->post("type");

    $telat = $this->input->post("telat");
    $lembur = $this->input->post("lembur");
    $jam_masuk = $tgl." ".$this->main->get(["id_divisi"=>$id_divisi])->row()->{$sip};
    $jam_keluar = date("Y-m-d H:i:s",strtotime("+".$waktu_kerja." hours",strtotime($tgl." ".$jam_masuk)));
    if ($type == "normal") {
      if ($lembur == "iya") {
        $jam_keluar = date("Y-m-d H:i:s",strtotime("+ 2 hours",$jam_keluar));
      }
    }
    $data = ["nip"=>$this->input->post("nip"),"masuk"=>$jam_masuk,"keluar"=>$jam_keluar,"type"=>$type,"telat"=>$telat];
    $this->main->setTable("absensi");
    $ins = $this->main->insert($data);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
