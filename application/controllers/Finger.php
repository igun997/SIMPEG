<?php

/**
 *
 */
class Finger extends CI_Controller
{
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
  public function set()
  {
    while (true) {
      sleep(2);
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
  public function sync()
  {
    echo "Sync Start . .".PHP_EOL;
    while (true) {
      sleep(2);
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
        $telat = 0;
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
    $this->response($ins);
  }

}
