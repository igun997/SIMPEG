<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Pegawai extends CI_Controller{
  /**
 	 * Konstruktor
 	 *
 	 * @return void
	 */

  public function __construct()
  {
    parent::__construct();
    $this->load->model("crud/main");
    $this->load->model("proses/upload_wrapper","gambar");
    if ($this->session->level != "admin") {
      redirect(base_url("public"));
    }
  }
  /**
 	 * Index Home
 	 *
 	 * @return void
	 */
   public function jadwal_del($id)
   {
     $this->main->setTable("penjadwalan");
     $d = $this->main->delete(["id_penjadwalan"=>$id]);
     redirect($_SERVER["HTTP_REFERER"]);
   }
   public function jadwal($nip)
   {
     if (isset($_POST["status"])) {
       $d = $this->input->post(null,true);
       $this->main->setTable("penjadwalan");
       $ins = $this->main->insert($d);
       if ($ins) {
         $this->session->set_flashdata("message","<div class='alert alert-success'>Data Sukses Di Simpan</div>");
       }else {
         $this->session->set_flashdata("message","<div class='alert alert-danger'>Data Gagal Di Simpan</div>");
       }
     }
     $this->template->setFolder("admin");
     $this->template->defaultStyle("front");
     $this->main->setTable("users");
     $s = $this->main->get(["nip"=>$nip]);
     if ($s->num_rows() > 0) {
       $row = $s->row();
       $this->main->setTable("penjadwalan");
       $x = $this->main->get();
       $rs = $x->result_array();
       foreach ($rs as $key => &$value) {
         $value["no"] = ($key+1);
         $value["tanggal"] = date("d-m-Y",strtotime($value["tanggal"]));
         $value["status"] = ($value["status"] == 0)?"Hadir":"Libur";
       }
       $build = [
         "block_title"=>"Jadwal Kerja - ".$row->nama,
         "data_jadwal"=>$rs,
         "nip"=>$nip,
         "msg"=>$this->session->flashdata("message")
       ];
       $this->template->renderHTML(['head','pegawai_jadwal','foot'],['title'=>"Jadwal Kerja - ".$row->nama,'other'=>$build]);
     }else {
       redirect($_SERVER["HTTP_REFERER"]);
     }
   }
   public function index()
   {
     $this->template->setFolder("admin");
     $this->template->defaultStyle("front");
     $this->main->setJoin([
       "table"=>"users",
       "join"=>[
         "divisi|divisi.id_divisi = users.id_divisi|null"
       ]
     ]);
     $data = $this->main->get(["users.level"=>"karyawan","users.status"=>"aktif"]);
     $build = [
       "block_title"=>"Data Pegawai",
       "data_pegawai"=>$data->result_array(),
       "msg"=>$this->session->flashdata("message")
     ];
     $this->template->renderHTML(['head','pegawai','foot'],['title'=>"Data Pegawai",'other'=>$build]);
   }

  public function tunjangan($nip)
  {
    if ($this->input->get("cmd") == "hapus") {
      $this->main->setTable("overtime_users");
      $hapus = $this->main->delete(["id_oa"=>$this->input->get("id")]);
      if ($hapus) {
        $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Hapus Data </div>');
      }else {
        $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Hapus Data </div>');
      }
      redirect($_SERVER["HTTP_REFERER"]);
    }
    if (isset($_POST["id_overtime"])) {
      $this->main->setTable("overtime_users");
      $d = $this->input->post(null,true);
      $d["nip"] = $nip;
      $h = $this->main->insert($d);
      if ($h) {
        $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
      }else {
        $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
      }
    }
    $this->main->setTable("users");
    $g = $this->main->get(["nip"=>$nip])->row();
    $this->main->setTable("overtime");
    $d = $this->main->get();
    $this->main->setJoin([
      "table"=>"overtime_users",
      "join"=>[
        "overtime|overtime.id_overtime = overtime_users.id_overtime|null"
      ]
    ]);
    $x = $this->main->get(["overtime_users.nip"=>$nip]);
    $ext = [
      "overtime"=>$d,
      "ov"=>$x
    ];
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $build = [
      "block_title"=>"Tambah Tunjangan Pegawai [{$g->nama}]",
      "action"=>base_url("admin/pegawai/tunjangan")."/".$nip,
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','tunjangan','foot'],['extend'=>$ext,'title'=>"Tambah Tunjangan Pegawai",'other'=>$build]);
  }
  public function tambah()
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $build = [
      "block_title"=>"Tambah - Data Pegawai",
      "info"=>[["nip"=>"","nama"=>"","tgl_lhr"=>"","nomor_hp"=>"","alamat"=>"","jk"=>"laki-laki","unjk"=>"perempuan","email"=>"","nama_divisi"=>"","id_divisi"=>"","sip"=>"","pendidikan"=>""]],
      "action"=>base_url("admin/pegawai/create"),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','pegawai_form','foot'],['title'=>"Tambah - Data Pegawai",'other'=>$build]);
  }
  public function ubah($id)
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $info = $this->main->get(["nip"=>$id,"level"=>"karyawan","status"=>"aktif"])->row();
    $this->main->setTable("divisi");
    $divisi = $this->main->get(["id_divisi"=>$info->id_divisi])->row();
    $info->nama_divisi = $divisi->nama_divisi;

    if ($info->jk == "laki-laki") {
      $info->unjk = "perempuan";
    }else {
      $info->unjk = "laki-laki";
    }
    $build = [
      "block_title"=>"Ubah - Data Pegawai",
      "info"=>[$info],
      "action"=>base_url("admin/pegawai/update/".$id),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','pegawai_form','foot'],['title'=>"Ubah - Data Pegawai",'other'=>$build]);
  }
  public function delete($id)
  {
    $this->main->setTable("users");
    $s = $this->main->update(["status"=>"tidak"],["nip"=>$id]);
    redirect($_SERVER["HTTP_REFERER"]);
  }
  public function update($id)
  {
    $dpost = $this->input->post(null,true);
    $dpost["foto"] = null;
    if ($dpost["password"] == "") {
      unset($dpost["password"]);
    }
    if ($dpost["id_divisi"] == "") {
      unset($dpost["id_divisi"]);
    }
    unset($dpost["nip"]);
    $x = $this->gambar->upload("foto");
    if ($x != false) {
      $dpost["foto"] = $x["file_name"];
    }else {
      unset($dpost["foto"]);
    }
    $this->main->setTable("users");
    $ins = $this->main->update($dpost,["nip"=>$id]);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function create()
  {
    $dpost = $this->input->post(null,true);
    $dpost["foto"] = null;
    if ($dpost["password"] == "") {
      unset($dpost["password"]);
    }
    if ($dpost["sip"] == "") {
      unset($dpost["sip"]);
    }
    $x = $this->gambar->upload("foto");
    if ($x != false) {
      $dpost["foto"] = $x["file_name"];
    }else {
      $dpost["foto"] = null;
    }
    $dpost["level"] = "karyawan";
    $dpost["status"] = "aktif";
    $this->main->setTable("users");
    $ins = $this->main->insert($dpost);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
