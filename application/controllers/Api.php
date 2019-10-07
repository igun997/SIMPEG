<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
/**
 	 * API Restfull
 	 * @author Indra Gunanda
	 */

class Api extends REST_Controller
{
    /**
 	 * Konstruktor
 	 * Konstruktor Berisi, pemuatan model "crud/main" dan "admin/car"  serta limitasi pengguna hanya untuk hak akses "admin"
 	 * @return json
	 */
    public $dpost = null;
    public $dget = null;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("crud/main");
        $this->load->helper("finger");
        $this->dget = $this->input->get(null,true);
        $this->dpost = $this->input->post(null,true);
    }
    /**
 	 * Initial Method
 	 *
 	 * @return json
	 */
   public function updateabsen_post()
   {
     $d = $this->dpost;
     $this->main->setTable("penjadwalan");
     $s = $this->main->get(["id_penjadwalan"=>$d["id"]]);
     if ($s->num_rows() > 0) {
       if ($d["simbol"] == "P") {
         $status = 0;
         $sip = 2;
       }elseif ($d["simbol"] == "S") {
         $status = 1;
         $sip = 0;
       }elseif ($d["simbol"] == "X") {
         $status = 0;
         $sip = 1;
       }
       $sa = $this->main->update(["sip"=>$sip,"status"=>$status],["id_penjadwalan"=>$d["id"]]);
       if ($sa) {
         $this->response(["status"=>1]);
       }else {
         $this->response(["status"=>0]);
       }
     }else {
       $this->response(["status"=>0]);
     }
   }
   public function setabsen_post()
   {
     $d = $this->dpost;
     $this->main->setTable("penjadwalan");
     $s = $this->main->insert($d);
     if ($s) {
       $this->response(["status"=>1]);
     }else {
       $this->response(["status"=>0]);
     }
   }
   public function getmember_get($id,$bulan = null)
   {
     $this->main->setTable("setting");
     $r = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
     if ($bulan == null) {
       $date = $this->main->loopDate(date("Y-m-01"),date("Y-m-".$r));
     }else {
       $date = $this->main->loopDate(date("Y-".$bulan."-01"),date("Y-".$bulan."-".$r));
     }
     $this->main->setTable("users");
     $get = $this->main->get(["id_divisi"=>$id,"level"=>"karyawan"]);
     if ($get->num_rows() > 0) {
       $member = [];
       foreach ($get->result() as $key => $value) {
         $temp = ["nip"=>$value->nip,"nama_lengkap"=>$value->nama];
         $abs = [];
         for ($i=0; $i < count($date) ; $i++) {
           $this->main->setTable("penjadwalan");
           $rCek = $this->main->get(["nip"=>$value->nip,"tanggal"=>$date[$i]]);
           if ($rCek->num_rows() > 0) {
             $rCecRow = $rCek->row();
             if ($rCecRow->sip == 1) {
               $rLabel = "P";
             }else {
               $rLabel = "S";
             }
             if ($rCecRow->status == 0) {
               $abs[] = ["label"=>$rLabel,"id"=>$rCecRow->id_penjadwalan];
             }else {
               $abs[] = ["label"=>"L","id"=>$rCecRow->id_penjadwalan];
             }
           }else {
             $abs[] = ["label"=>"X","tgl"=>$date[$i]];
           }
         }
         $temp["data"] = $abs;
         $member[] = $temp;
       }
       $this->response($member);
     }else {
       $this->response([], 404);
     }
   }
    public function index_post()
    {
      $this->response([], 404);
    }
    /**
   * Initial Method
   *
   * @return json
   */
    public function index_get()
    {
        $this->response([], 404);
    }
    /**
   * Initial Method
   *
   * @return json
   */
    public function index_put()
    {
        $this->response([], 404);
    }
    /**
   * Initial Method
   *
   * @return json
   */
    public function index_delete()
    {
        $this->response([], 404);
    }
    public function set_get()
    {
      while (true) {
        sleep(60);
        echo "Saving Data . . ".PHP_EOL;
        $this->main->setTable("users");
        $data = [];
        $res = $this->main->get(["level"=>"karyawan","status"=>"aktif","sync"=>0]);
        foreach ($res->result() as $key => $value) {
          $data[] = cmd("set_user_info",["pin"=>$value->nip,"name"=>$value->nama]);
          $this->main->update(["sync"=>1],["nip"=>$value->nip]);
        }
      }


    }
    public function read_get()
    {
      $data = cmd();
      $dataTables = [];
      $cek = function($nip){
        $this->main->setTable("users");
        $x = $this->main->get(["nip"=>$nip]);
        if ($x->num_rows() > 0) {
          return $x->row();
        }else {
          return false;
        }
      };
      if (!isset($data["Row"])) {
        $data["Row"] = [];
      }else {
        if (!isset($data["Row"][0])) {
          $temp = $data["Row"];
          $data["Row"] = [];
          $data["Row"][] = $temp;
        }
      }
      $jam = function($from,$to){
        $waktuKerja = ($to - $from)/3600;
        return $waktuKerja;
      };
      foreach ($data["Row"] as $value) {
        $nama = "Tidak Dikenal";
        $status = "Tidak Diketahui";
        $ceker = $cek($value["PIN"]);
        if ($ceker != false) {
          $nama = $ceker->nama;
          $full = $value["DateTime"];
          $time = explode(" ",$value["DateTime"]);
          $this->main->setTable("setting");
          $masuk = $this->main->get(["meta_key"=>"jam_masuk"])->row()->meta_value;
          $keluar = $this->main->get(["meta_key"=>"jam_keluar"])->row()->meta_value;
          $this->main->setTable("divisi");
          $getAtt = $this->main->get(["id_divisi"=>$ceker->id_divisi])->row();
          $masukFull = $getAtt->{"jam_masuk".$ceker->sip};
          $masuk = $getAtt->{"jam_masuk".$ceker->sip};
          $total = $getAtt->waktu_kerja;
          $masuk = strtotime($masuk);
          $waktu = strtotime($time[1]);
          $out = strtotime("+".$total." hour",$masuk);
          if ($waktu >= ($masuk-(30*60)) && $waktu < $masuk) {
            $status = "<label class='btn btn-success'>Masuk</label>";
          }elseif ($waktu > $masuk && $waktu < $out) {
            $status = "<label class='btn btn-warning'>Terlambat Masuk</label>";
          }else{
            $status = "<label class='btn btn-danger'>Keluar</label>";
          }
        }
        $dataTables[] = (object) ["nip"=>$value["PIN"],"nama"=>$nama,"presensi"=>$value["DateTime"],"status"=>$status];
      }
      $con = $this->main->datatablesConvert($dataTables,"nip,nama,presensi,status");
      $this->response($con);
    }
    public function del_get($id='')
    {
      $this->response(cmd("delete_user",["pin"=>$id]));
    }
    public function reset_get()
    {
      $data = cmd("delete_data",["value"=>3]);
      $this->response($data);
    }

    public function sync_get()
    {
      while (true) {
        sleep(60);
        echo "Sync Success . .".PHP_EOL;
        $data = cmd();
        $dataTables = [];
        $cek = function($nip){
          $this->main->setTable("users");
          $x = $this->main->get(["nip"=>$nip]);
          if ($x->num_rows() > 0) {
            return $x->row();
          }else {
            return false;
          }
        };
        if (!isset($data["Row"])) {
          $data["Row"] = [];
        }else {
          if (!isset($data["Row"][0])) {
            $temp = $data["Row"];
            $data["Row"] = [];
            $data["Row"][] = $temp;
          }
        }
        foreach ($data["Row"] as $value) {
          $nama = "Tidak Dikenal";
          $status = "Tidak Diketahui";
          $ceker = $cek($value["PIN"]);
          if ($ceker != false) {
            $nama = $ceker->nama;
            $full = $value["DateTime"];
            $time = explode(" ",$value["DateTime"]);
            $this->main->setTable("setting");
            $masuk = $this->main->get(["meta_key"=>"jam_masuk"])->row()->meta_value;
            $keluar = $this->main->get(["meta_key"=>"jam_keluar"])->row()->meta_value;
            $this->main->setTable("divisi");
            $getAtt = $this->main->get(["id_divisi"=>$ceker->id_divisi])->row();
            $masukFull = $getAtt->{"jam_masuk".$ceker->sip};
            $masuk = $getAtt->{"jam_masuk".$ceker->sip};
            $total = $getAtt->waktu_kerja;
            $masuk = strtotime($masuk);
            $waktu = strtotime($time[1]);
            $out = strtotime("+".$total." hour",$masuk);
            $telat = 0;
            if ($waktu >= ($masuk-(30*60)) && $waktu < $masuk) {
              $status = "IN";
            }elseif ($waktu > $masuk && $waktu < $out) {
              $status = "IN";
              $date1 = new DateTime(date("H:i:s",$waktu));
              $date2 = new DateTime(date("H:i:s",$masuk));
              $diff = $date2->diff($date1);
              $telat = $diff->format('%h')*60;
            }else{
              $status = "OUT";
            }
          }
          $dataTables[] =  ["nip"=>$value["PIN"],"nama"=>$nama,"presensi"=>$value["DateTime"],"status"=>$status,"telat"=>$telat];
        }
        $recordNIP = [];
        foreach ($dataTables as $key => $value) {
          $recordNIP[] = $value["nip"];
        }
        $recordNIP = array_unique($recordNIP);
        $record = [];
        foreach ($dataTables as $key => $value) {
          foreach ($recordNIP as $k => $v) {
            if ($v == $value["nip"]) {
              $record[$v] = [];
            }
          }
        }
        foreach ($record as $key => $value) {
          foreach ($dataTables as $k => $v) {
            if ($key == $v["nip"]) {

              $time = $v["presensi"];
              if ($v["status"] == "IN") {
                if (isset($record[$key]["masuk"])) {
                  continue;
                }
                $record[$key]["telat"] = $v["telat"];
                $record[$key]["masuk"] = $time;
              }else {
                if (isset($record[$key]["keluar"])) {
                  continue;
                }
                $record[$key]["keluar"] = $time;
              }
            }
          }
        }
        $normal = [];
        foreach ($record as $key => $value) {
          if (!isset($value["masuk"]) || !isset($value["keluar"])) {
            continue;
          }
          $this->main->setTable("absensi");
          $c = $this->main->get(["nip"=>$key,"masuk"=>$value["masuk"],"keluar"=>$value["keluar"],"telat"=>$value["telat"]]);
          if ($c->num_rows() == 0) {
            $normal[] = ["nip"=>$key,"masuk"=>$value["masuk"],"keluar"=>$value["keluar"],"telat"=>$value["telat"]];
          }
        }
        if (count($normal) > 0) {
          $ins = $this->db->insert_batch("absensi",$normal);
        }else {
          $ins = 0;
        }
      }
      // $this->response($ins);
    }
    public function test_get()
    {
      $data = $this->main->getAbsen("10515213","2019-06-01","2019-06-28");
      $this->response($data);
    }
}
