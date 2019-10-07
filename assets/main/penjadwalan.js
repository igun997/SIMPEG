$(document).ready(function() {
  console.log("Penjadwalan ...");
  if (bln12 != null) {
    $("#bulanku").val(bln12);
  }
  $("#bulanku").on('change',  function(event) {
    event.preventDefault();
    if ($(this).val() == "") {
      location.href = base_url+"admin/penjadwalan";
    }else {
      location.href = base_url+"admin/penjadwalan?bulan="+$(this).val();
    }
  });
  $("#divisi").on('change', function(event) {
    event.preventDefault();
    console.log("Changed Divisi");
    console.log($(this).val());
    $.ajax({
      url: base_url+"api/getmember/"+$(this).val()+"/"+bln12,
      type: 'GET',
      dataType: 'JSON'
    })
    .done(function(r) {
      console.log(r);
      $("#penjadwalan").html("");
      $.each(r,function(index, el) {
        $("#penjadwalan").append('<tr>');
        $("#penjadwalan").append('<td>'+el.nip+'</td>');
        $("#penjadwalan").append('<td>'+el.nama_lengkap+'</td>');
        for (var i = 0; i < el.data.length; i++) {
          var label = null;
          label = el.data[i];
          if (el.data[i].label == "L") {
            $("#penjadwalan").append('<td class="changeIt" data-id="'+el.data[i].id+'">X</td>');
          }else if (el.data[i].label == "X") {
            $("#penjadwalan").append('<td class="insertIt" data-tgl="'+el.data[i].tgl+'" data-nip="'+el.nip+'"> </td>');
          }else {
            $("#penjadwalan").append('<td class="changeIt" data-id="'+el.data[i].id+'">'+el.data[i].label+'</td>');
          }
        }
        $("#penjadwalan").append('</tr>');
      });
    })
    .fail(function() {
      alert("Koneksi Error");
    })
    .always(function() {

    });

  });
  $("#penjadwalan").on('click', '.changeIt', function(event) {
    event.preventDefault();
    console.log("Ubah ID "+$(this).data("id"));
    $.post(base_url+"api/updateabsen",{simbol:$(this).html(),id:$(this).data("id")},function(rs){
      if (rs.status == 1) {
        $("#divisi").trigger("change");
      }else {
        alert("Kesalahan Database");
      }
    });
  });
  $("#penjadwalan").on('click', '.insertIt', function(event) {
    event.preventDefault();
    console.log("Insert Untuk "+$(this).data("tgl"));
    $.post(base_url+"api/setabsen",{status:0,nip:$(this).data("nip"),tanggal:$(this).data("tgl"),sip:"1"},function(r){
      if (r.status == 1) {
        $("#divisi").trigger("change");
      }else {
        alert("Kesalahan Database");
      }
    }).fail(function(){
      alert("Koneksi Error");
    });
  });
});
