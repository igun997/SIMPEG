<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Home extends CI_Controller{
  /**
 	 * Konstruktor
 	 *
 	 * @return void
	 */

  public function __construct()
  {
    parent::__construct();
    $this->load->model("crud/main");
    if ($this->session->level != "karyawan") {
      redirect(base_url("public"));
    }
  }
  /**
 	 * Index Home
 	 *
 	 * @return void
	 */
  public function cetak($id="")
  {
      if ($this->input->get("start") != null) {
        $this->main->setJoin([
          "table"=>"penggajian",
          "join"=>[
            "users|users.nip = penggajian.nip|null",
            "divisi|divisi.id_divisi = users.id_divisi|null"
          ]
        ]);
        $wow = $this->main->get("penggajian.dibuat >= '".date("Y-m-01",strtotime($this->input->get("start")))."' AND penggajian.dibuat <= '".date("Y-m-t",strtotime($this->input->get("end")))."' AND penggajian.nip = '".$this->session->nip."'");
        // echo json_encode($wow->result());
        // exit();
				$this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        $pdf->SetFont('Arial', 'B', 12);
        foreach ($wow->result() as $ea => $row) {
          $pdf->AddPage();
          $pdf->Image(base_url("assets/img/logo.png"),20,2,30);
          $pdf->Cell(190, 7, 'CV LOVA', 0, 1, 'C');
          $pdf->SetFont('Arial', '', 12);
          $pdf->Cell(190, 6, 'JALAN RAYA BANJARAN KEC. Pameungpeuk', 0, 1, 'C');
          $pdf->Cell(190, 6, '0265-592324', 0, 1, 'C');
          $pdf->Line(20, 33, 210-20, 33);
          $pdf->Line(20, 34, 210-20, 34);
          $pdf->Cell(8, 8, '',0,1);
          $pdf->Cell(190, 7, 'SLIP GAJI', 0, 1, 'C');
          $month = ["01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September (Indra :*)","10"=>"Oktober","11"=>"November","12"=>"Desember"];
          $pdf->Cell(190, 7, 'BULAN '.$month[date("m",strtotime($row->dibuat))], 0, 1, 'C');
           $pdf->SetFont('Arial', '', 12);
           $pdf->Cell(30, 6, 'Nama', 0, 0, 'l');
           $pdf->Cell(70, 6, ': '.$row->nama, 0, 0, 'l');
           $pdf->Cell(40, 6, 'NIP', 0, 0, 'l');
           $pdf->Cell(30, 6, ': '.$row->nip, 0, 1, 'l');
           $pdf->Cell(30, 6, 	'Jabatan', 0, 0, 'l');
           $pdf->Cell(70, 6, ': '.$row->nama_divisi, 0, 0, 'l');
           $pdf->Cell(40, 6, 'Pendidikan Terakhir', 0, 0, 'l');
           $pdf->Cell(30, 6, ': '.$row->pendidikan, 0, 1, 'l');
           $pdf->Cell(8, 8, '',0,1);
           $pdf->Cell(30, 6, '+(PENERIMAAN)', 0, 1, 'l');
           $pdf->Cell(30, 6, 'Gaji Pokok ', 0, 0, 'l');
           $pdf->Cell(70, 6, ': '.number_format($row->total_gaji), 0, 1, 'l');
           $tunjangan = json_decode($row->tunjangan);
           foreach ($tunjangan->tunjangan as $key => $value) {
             $pdf->Cell(30, 6, 'T '.$value->nama, 0, 0, 'l');
             $pdf->Cell(70, 6, ($value->total), 0, 1, 'l');
           }
           if ($tunjangan->lembur->total_lembur == 0) {
             // code...
           }else {
             $pdf->Cell(30, 6, 'Uang Lembur ', 0, 0, 'l');
             $pdf->Cell(70, 6, ': '.(($tunjangan->lembur->total_lembur)."X ".number_format($tunjangan->lembur->total_bonus/$tunjangan->lembur->total_lembur)." = ".number_format($tunjangan->lembur->total_bonus)), 0, 1, 'l');
           }

           $pdf->Cell(30, 6, 'Gaji Akhir ', 0, 0, 'l');
           $pdf->Cell(70, 6, ': '.number_format($row->total_gaji-$row->pinalti_gaji), 0, 0, 'l');
           $pdf->Cell(40, 6, 'Potongan', 0, 0, 'l');
           $pdf->Cell(30, 6, ': '.number_format($row->pinalti_gaji), 0, 1, 'l');
           $pdf->Cell(120,1,'',0,0);
           $pdf->Cell(50,8,'Bandung,'.date('d/m/Y'),0,1,'C');
           $pdf->Cell(120,5,'',0,0);
           $pdf->Cell(50,5,'Direktur',0,1,'C');
        }
        $pdf->Output();
      }else {
        $this->main->setJoin([
          "table"=>"penggajian",
          "join"=>[
            "users|users.nip = penggajian.nip|null",
            "divisi|divisi.id_divisi = users.id_divisi|null"
          ]
        ]);
        $row = $this->main->get(["penggajian.id_penggajian"=>$id])->row();
				$this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        $pdf->AddPage("P");
        $pdf->SetFont('Arial', 'B', 12);
      	$pdf->Image(base_url("assets/img/logo.png"),0,2,30);
        $pdf->Cell(150, 7, 'CV LOVA', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(150, 6, 'JALAN RAYA BANJARAN KEC. Pameungpeuk', 0, 1, 'C');
        $pdf->Cell(150, 6, '0265-592324', 0, 1, 'C');
        $pdf->Line(1, 33, 168-20, 33);
        $pdf->Line(1, 34, 168-20, 34);
        $pdf->Cell(8, 8, '',0,1);
        $pdf->Cell(120, 7, 'SLIP GAJI', 0, 1, 'C');
        $month = ["01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September (Indra :*)","10"=>"Oktober","11"=>"November","12"=>"Desember"];
        $pdf->Cell(120, 7, 'BULAN '.$month[date("m",strtotime($row->dibuat))]." ".date("Y",strtotime($row->dibuat)), 0, 1, 'C');
       $pdf->SetFont('Arial', '', 12);
       $pdf->Cell(20, 6, 'Nama', 0, 0, 'l');
       $pdf->Cell(50, 6, ': '.$row->nama, 0, 0, 'l');
       $pdf->Cell(20, 6, 'NIP', 0, 0, 'l');
       $pdf->Cell(10, 6, ': '.$row->nip, 0, 1, 'l');
       $pdf->Cell(20, 6, 	'Jabatan', 0, 0, 'l');
       $pdf->Cell(50, 6, ': '.$row->nama_divisi, 0, 0, 'l');
       $pdf->Cell(30, 6, 'Pend Terakhir', 0, 0, 'l');
       $pdf->Cell(40, 6, ': '.$row->pendidikan, 0, 1, 'l');

		   $pdf->Cell(8, 8, '',0,1);
	 	   $pdf->Cell(30, 6, '+(PENERIMAAN)', 0, 1, 'l');
       $pdf->Cell(30, 6, 'Gaji Pokok ', 0, 0, 'l');
       $pdf->Cell(70, 6, ': '.number_format($row->total_gaji), 0, 1, 'l');
       $tunjangan = json_decode($row->tunjangan);
       $minus = [];
       foreach ($tunjangan->tunjangan as $key => $value) {
         if (str_replace(")","",str_replace("(","",$value->total)) < 0) {
          $minus[] = $value;
        }else {
          $pdf->Cell(30, 6, 'T '.$value->nama, 0, 0, 'l');
          $pdf->Cell(70, 6, ($value->total), 0, 1, 'l');
        }
      }
       if ($tunjangan->lembur->total_lembur == 0) {

       }else {
         $pdf->Cell(30, 6, 'Uang Lembur ', 0, 0, 'l');
         $pdf->Cell(70, 6, ': '.(($tunjangan->lembur->total_lembur)."X ".number_format($tunjangan->lembur->total_bonus/$tunjangan->lembur->total_lembur)." = ".number_format($tunjangan->lembur->total_bonus)), 0, 1, 'l');
       }
		   $pdf->Cell(30, 6, 'Gaji Akhir ', 0, 0, 'l');
       $pdf->Cell(70, 6, ': '.number_format($row->total_gaji-$row->pinalti_gaji), 0, 1, 'l');
       $pot = "";
       foreach ($minus as $ks => &$vs) {
         $vs->total = abs(str_replace(")","",str_replace("(","",$vs->total)));
       }
       $pdf->Cell(0,0,'',0,1);
       $pdf->ln();
       $pdf->Cell(40, 6, '-(Potongan) ', 0, 1, 'l');
       $pdf->Cell(40, 6, 'Absensi ', 0, 0, 'l');
       $pdf->Cell(0, 6, ': '.number_format($row->pinalti_gaji), 0, 1, 'l');
       foreach ($minus as $ks => &$vs) {
         $vs->total = abs(str_replace(")","",str_replace("(","",$vs->total)));
         $pdf->Cell(40, 6, $vs->nama, 0, 0, 'l');
         $pdf->Cell(0, 6, ': '.number_format($vs->total), 0, 1, 'l');
       }
       $pdf->Cell(40,1,'',0,0);
       $pdf->Cell(50,8,'Bandung,'.date('d/m/Y'),0,1,'C');
       $pdf->Cell(40,5,'',0,0);
       $pdf->Cell(50,8,'Direktur',0,1,'C');
       $pdf->Cell(40,5,'',0,0);
       $pdf->Cell(50,20,'Gerry Gustira',0,1,'C');
       $pdf->Output();
      }

  }
  public function index()
  {
    $this->main->setTable("setting");
    $tgl = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
    if (($tgl - date("d")) <= 7) {
      $sisa = ($tgl - date("d"));
      if ($sisa > 0) {
        $this->session->set_flashdata("msg","{$sisa} Hari Sebelum Hari Penggajian");
      }
    }
    $this->template->setFolder("karyawan");
    $this->template->defaultStyle("front");
    $this->main->setTable("setting");
    $tgl_gajian = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
    $this->main->setJoin([
      "table"=>"users",
      "join"=>[
        "divisi|divisi.id_divisi = users.id_divisi|null"
      ]
    ]);
    $data = $this->main->get(["users.level"=>"karyawan","users.status"=>"aktif","nip"=>$this->session->nip])->row();
    $build = [
      "block_title"=>"Dashboard Karyawan"
    ];
    $ext = [
      "info"=>$data,
      "tgl_gajian"=>$tgl_gajian
    ];
    $this->template->renderHTML(['head','home','foot'],["extend"=>$ext,'title'=>"Dashboard Karyawan",'other'=>$build]);
  }
}
