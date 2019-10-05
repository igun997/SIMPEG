<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 	 * Main CRUD
 	 *
	 */

class Main extends CI_Model{
  public $table = "";
  public $limit = [];
  public $join = [];
  public $select = '*';
  public function __construct()
  {
    parent::__construct();

  }
  /**
 	 * Set Your Table
 	 *
 	 * @param string $value
 	 * @return void
	 */

  public function setTable($value='')
  {
    $this->table = $value;
    $this->limit = [];
    $this->join = [];
    $this->select = '*';
    return $this;
  }
  public function setJoin($data = [])
  {
    $this->table = $data["table"];
    $this->join = $data["join"];
  }
  public function setLimit($start='',$offset='')
  {
    $this->limit["start"] = $start;
    $this->limit["offset"] = $offset;

  }
  public function setSelect($data='*')
  {
      $this->select = $data;
  }
  /**
 	 * Run Primary Query
 	 * @example $this->main->setTable("TABLE"); $this->main->get();
 	 * @param mixed $value
 	 * @return mixed
	 */
  public function get($data = "",$order="")
  {
    if (count($this->join) > 0) {
      $this->db->select($this->select);
      $this->db->from($this->table);
      foreach ($this->join as $key => $value) {
        $exp = explode("|",$value);
        $tipe = null;
        if ($exp[2] != "null") {
          $tipe = $exp[2];
        }
        if (count($exp) > 0) {
          $this->db->join($exp[0],$exp[1],$tipe);
        }
      }
      if ($data != "") {
        $this->db->where($data);
      }
      if ($order != "") {
        $this->db->order_by($order["table"],$order["order"]);
      }
      if (count($this->limit) > 0) {
        $this->db->limit($this->limit["start"],$this->limit["offset"]);
      }
      return $this->db->get();
    }else {
      $this->db->select($this->select);
      if($data != ""){
        if($order != ""){
          if (count($this->limit) > 0) {
            return $this->db->order_by($order["table"],$order["order"])->limit($this->limit["start"],$this->limit["offset"])->get_where($this->table,$data);
          }
          return $this->db->order_by($order["table"],$order["order"])->get_where($this->table,$data);
        }else{
          if (count($this->limit) > 0) {
            return $this->db->limit($this->limit["start"],$this->limit["offset"])->get_where($this->table,$data);
          }
          return $this->db->get_where($this->table,$data);
        }
      }else{
        if($order != ""){
          if (count($this->limit) > 0) {
            return $this->db->order_by($order["table"],$order["order"])->limit($this->limit["start"],$this->limit["offset"])->get($this->table);
          }
          return $this->db->order_by($order["table"],$order["order"])->get($this->table);
        }else{
          if (count($this->limit) > 0) {
            return $this->db->limit($this->limit["start"],$this->limit["offset"])->get($this->table);
          }
          return $this->db->get($this->table);
        }
      }
    }
  }
  /**
 	 * Run Primary Query
 	 * @example $this->main->setTable("TABLE"); $this->main->get();
 	 * @param mixed $value
 	 * @return mixed
	 */
  public function insert($data=[])
  {
    return $this->db->insert($this->table,$data);
  }
  /**
 	 * Run Primary Query
 	 * @example $this->main->setTable("TABLE"); $this->main->get();
 	 * @param mixed $value
 	 * @return mixed
	 */
  public function delete($data=[])
  {
     $this->db->delete($this->table,$data);
     return $this->db->affected_rows() > 0;
  }
  /**
 	 * Run Primary Query
 	 * @example $this->main->setTable("TABLE"); $this->main->get();
 	 * @param mixed $value
 	 * @return mixed
	 */
  public function update($data=[],$where=[])
  {
    if(count($where) > 0){
      $this->db->update($this->table,$data,$where);
      return $this->db->affected_rows() > 0;
    }else{
      $this->db->update($this->table,$data);
      return $this->db->affected_rows() > 0;
    }
  }
  public function datatablesConvert($res=[],$select="")
  {
    $data = [];
    $data["data"] = [];
    foreach ($res as $key => $value) {
      $inner = [];
      $exp = explode(",",$select);
      foreach ($exp as $k => $v) {
        $inner[] = $value->{"$v"};
      }
      $data["data"][] = $inner;
    }
    return $data;
  }
  public function select2Convert($data=[],$op=[])
  {
    $s = [];
    $s[] = ["text"=>"== Pilih ==","id"=>""];
    foreach ($data as $key => $value) {
      $s[] = ["text"=>$value->{$op["text"]},"id"=>$value->{$op["id"]}];
    }
    return $s;
  }
  public function loopDate($start,$end_date=null)
  {
    $begin = new DateTime($start);
    if ($end_date == null) {
      $end = new DateTime(date("Y-m-t",strtotime($start)));
    }else {
      $end = new DateTime(date("Y-m-d",strtotime("1 day",strtotime($end_date))));
    }
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    $data = [];
    foreach ($period as $dt) {
        $data[] = $dt->format("Y-m-d");
    }
    return $data;
  }
  public function getAbsen($nip,$from=null,$to=null,$mondaypass=false,$plain=false)
  {
    $mondaypass=false;
    if ($from == null) {
      $date = $this->loopDate(date("Y-m-01"));
    }elseif($from != null && $to == null) {
      $date = $this->loopDate($from);
    }else {
      $date = $this->loopDate($from,$to);
    }
    // if ($mondaypass == true) {
    //   foreach ($date as $key => &$value) {
    //     if (date("l",strtotime($value)) == "Sunday") {
    //       unset($date[$key]);
    //     }
    //   }
    // }
    // echo json_encode($date);
    // exit();
    if ($from == null) {
      $from = date("Y-m-01");
      $to = date("Y-m-t");
    }
    $this->db->select('absensi.*,users.nama,divisi.gaji_pokok')
          ->from('absensi')
          ->join('users', 'users.nip = absensi.nip',"left")
         ->join('divisi', 'users.id_divisi = divisi.id_divisi');
    $this->db->where('absensi.masuk >=', $from);
    $this->db->where('absensi.masuk <=', date("Y-m-d",strtotime("+1 days",strtotime($to))));
    $this->db->where(["absensi.nip"=>$nip]);
    $getdata = $this->db->get();
    $absen = [];
    $m = 0;
    $t = 0;
    $ij = 0;
    $sakit = 0;
    $cuti = 0;
    $telat = 0;
    $overtimedate = 0;
    $overtime = 0;
    $koretlah = [];
    $d = [];
    $this->main->setTable("setting");
    $s = $this->main->get(["meta_key"=>"overtime"])->row()->meta_value;
    foreach ($date as $k => $v) {
      $time = strtotime($v);
      $this->main->setTable("penjadwalan");
      $search = date("Y-m-d",$time);
      $match = $this->main->get(["nip"=>$nip,"tanggal"=>$search]);
      if ($match->num_rows() > 0) {
        $rows = $match->row();
        if ($rows->status != 1) {
          if ($plain == false) {
            $abs = "<td style='background-color:red;color:#fff'> <i class='fas fa-times'></i> </td>";
          }else {
            $abs = "X";
          }
          foreach ($getdata->result() as $key => $value) {
            $e = explode(" ",$value->masuk);
            if ($mondaypass == true) {
              if (date("l",strtotime($e[0])) == "Sunday") {
                continue;
              }
            }
            $e = $e[0];
            if ($e == $v) {
              $m++;
              $telat = $telat + $value->telat;
              $d[] = $value->telat;
              $start = strtotime($value->masuk);
              $end = strtotime($value->keluar);
              if ($end > $start) {
                $this->main->setJoin([
                  "table"=>"users",
                  "join"=>[
                    "divisi|divisi.id_divisi = users.id_divisi|null"
                  ]
                ]);
                $ob = $this->main->get(["users.nip"=>$value->nip])->row();
                $sip = $rows->sip;
                $jaker = $ob->waktu_kerja;
                $sipdiv = strtotime($e." ".$ob->{"jam_masuk".$sip});
                $keluarjam = date("Y-m-d",strtotime("+ ".$jaker." hours",$sipdiv));
                $kstrto = strtotime($keluarjam);
                $koretlah[] = $kstrto;
                if ($end > $kstrto) {
                  $overtimedate++;
                }
              }
              if ($plain == false) {
                if ($value->type == "sakit") {
                  $abs = "<td style='background-color:yellow;'> <i class='fas fa-medkit'></i> </td>";
                  $sakit++;
                }elseif ($value->type == "ijin") {
                  $ij++;
                  $abs = "<td style='background-color:green;color:#fff'> <i class='fas fa-info'></i> </td>";
                }elseif($value->type == "normal") {
                  $abs = "<td> <i class='fas fa-check' ></i> </td>";
                }elseif($value->type == "cuti") {
                  $cuti++;
                  $abs = "<td> <i class='fas fa-check-double'></i> </td>";
                }
              }else {
                if ($value->type == "sakit") {
                  $abs = "S";
                  $sakit++;
                }elseif ($value->type == "ijin") {
                  $ij++;
                  $abs = "I";
                }elseif($value->type == "normal") {
                  $abs = "*";
                }elseif($value->type == "cuti") {
                  $cuti++;
                  $abs = "C";
                }
              }
              break;
            }
          }
          $x = date("m/d",$time);
          if ($mondaypass == true) {
            if (date("l",strtotime($v)) != "Sunday") {
              $absen[$x] = $abs;
            }
          }else {
            $absen[$x] = $abs;
          }
        }
      }
    }
    // echo json_encode($absen);
    // exit();
    // $ts = [];
    // if ($mondaypass == true) {
    //   foreach ($absen as $key => $value) {
    //     if (date("l",strtotime($value)) != "Sunday") {
    //       $ts[date("m/d",strtotime($key))] = $value;
    //     }
    //   }
    // }
    // // var_dump($ts);
    // // exit();
    // $absen = $ts;
    // echo json_encode($koretlah);
    $gapok = 0;
    if (isset($getdata->row()->gaji_pokok)) {
      $gapok = $getdata->row()->gaji_pokok;
    }
    $totalKerja = count($absen);
    $pinalti = ($gapok/$totalKerja);
    $telatminus = ($telat/60) * ($pinalti/24);
    $ijin = (($pinalti/24)*0.75);
    $t = (count($absen) - $m);
    $over = ($overtimedate*$s);
    $gapokakhir = $gapok - (($t*$pinalti)+($ijin*$ij)+$telatminus);
    $this->main->setJoin([
      "table"=>"overtime_users",
      "join"=>[
        "overtime|overtime.id_overtime = overtime_users.id_overtime|null"
      ]
    ]);
    $anj = $this->main->get(["overtime_users.nip"=>$nip]);
    $this->main->setTable("users");
    $s = $this->main->get(["nip"=>$nip]);
    $this->main->setJoin([
      "table"=>"overtime_divisi",
      "join"=>[
        "overtime|overtime.id_overtime = overtime_divisi.id_overtime|null"
      ]
    ]);
    $bab = $this->main->get(["overtime_divisi.id_divisi"=>$s->row()->id_divisi]);
    $tunj = [];
    $xs = [];
    $xj = [];
    foreach ($anj->result() as $key => $value) {
      $tunj[] = ($value->jenis_overtime == "cost")?($value->total*-1):$value->total;
      $xs[] = ["nama"=>$value->nama_tunjangan,"total"=>(($value->jenis_overtime == "cost")?"(".($value->total*-1).")":$value->total)];
    }
    foreach ($bab->result() as $key => $value) {
      if ($value->untuk != $s->row()->status_pegawai) {
        continue;
      }
      $tunj[] = ($value->jenis_overtime == "cost")?($value->total*-1):$value->total;
      $xs[] = ["nama"=>$value->nama_tunjangan,"total"=>(($value->jenis_overtime == "cost")?"(".($value->total*-1).")":$value->total)];
    }
    $json  = json_encode(["lembur"=>["total_lembur"=>$overtimedate,"total_bonus"=>$over],"pinalti"=>["tidak_hadir"=>($t+$ij),"telat_masuk"=>$telatminus],"tunjangan"=>$xs]);
    return ["absen"=>$absen,"data"=>["pinalti"=>(($pinalti*$t)+($ijin*$ij)),"cuti"=>$cuti,"ijin"=>$ij,"sakit"=>$sakit,"minus_jam"=>$telat,"pinalti_telat"=>$telatminus,"hadir"=>$m,"tidak_hadir"=>($t+$ij),"gapok"=>$gapok,"gapok_akhir"=>$gapokakhir+($over)+(array_sum($tunj)),"overtime"=>["jumlah"=>$overtimedate,"tambahan"=>$over],"list_tunjangan"=>$xs,"json"=>$json]];
  }
}
