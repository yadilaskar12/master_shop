
$(document).ready(function() {

  var carousel = $("#carousel").waterwheelCarousel({
    flankingItems: 3,
    movingToCenter: function ($item) {
      $('#callback-output').prepend('movingToCenter: ' + $item.attr('id') + '<br/>');
    },
    movedToCenter: function ($item) {
      $('#callback-output').prepend('movedToCenter: ' + $item.attr('id') + '<br/>');
    },
    movingFromCenter: function ($item) {
      $('#callback-output').prepend('movingFromCenter: ' + $item.attr('id') + '<br/>');
    },
    movedFromCenter: function ($item) {
      $('#callback-output').prepend('movedFromCenter: ' + $item.attr('id') + '<br/>');
    },
    clickedCenter: function ($item) {
      $('#callback-output').prepend('clickedCenter: ' + $item.attr('id') + '<br/>');
    }
  });
  
  $('#prev').bind('click', function () {
   carousel.prev();
   return false
 });
  $('#next').bind('click', function () {
    carousel.next();
    return false;
  });

    //input Data Efek Masterialize//
    
    $(".sidenav").sidenav();
    $('input#input_text').characterCounter();
    M.updateTextFields();
    $('select').formSelect();
    $('checkbox').formSelect();

	// script pencarian //

	$('#cari').blur(function(){
		$('.mod').fadeOut();
	});

// efek scroling //
var top=$('.backtop');top.hide(); $(window).on('scroll', function(){
	if ($(window). scrollTop() > 500) {
   top.fadeIn();
   $('nav').addClass('r');
   $('nav ul li a').css({
    'color':'rgb(36,166,157)'
  });
 }
 else{
   top.fadeOut();
   $("nav").removeClass('r');
   $('nav ul li a').css({
    'color':'white'
  });
 }
});

top.on('click', function(e){$("html, body").animate({scrollTop: 0}, 500);});
var kiri= $('.tombol_kiri').on('click', function(event){
 $('.kiri').slideDown();event.preventDefault();
});

var win= $(window).click(function(){
  $('.kiri').hide();

});
// var al=[];
// al=['kucing',1,'manggga','roti','tanah',23,['mata','3','aku']];
// console.log(al[6][1]);             

// paralax//
$(window).scroll(function(){
  var wscroll=$(this).scrollTop();
  $(".jumbotron #button-pendaftaran").css({
    'transform':'translate(0px, '+wscroll+'%) scale(0.9)'
  });
  $(".jumbotron p").css({

   'transform':'translate('+ - wscroll /13+'%, 0px)',
   'font-style':'italic'
 });

  if (wscroll > $(".promosi").offset().top - 170) {

   $(".promosi .pa").each(function(i){

    setTimeout(function(){

      $(".promosi .pa").eq(i).addClass("muncul");

    },600 * (i+1));

  });
 }

 if (wscroll > $(".card").offset().top - 530) {

  $(".card").each(function(i){
    setTimeout(function(){
      $(".card").eq(i).addClass("terlihat_kembali");
    },700 * (i+1));
  });

}else{

  $(".card").removeClass("terlihat_kembali");
}

});

$("#sentuh").click(function(){
  $("#cart_shop").css({
    'width':340,
    'transition':'0.5s'
  });
});

$(".tutup").click(function(){
  $("#cart_shop").css({
    'width':0,
    'transition':'0.5s'
  });
});


    // ajax kategori// bagian ajax sistem

    $("#kategori").change(function(){
      var kategori=$(this).val();
      $.ajax({
        type:'POST',
        url:'kategori_barang.php',
        dataType:'JSON',
        data:'jenis_barang='+kategori,
        success:function(response){
          
          var createElementBaru="Data Untuk Kategori Ini saat ini Sedang Kosong Maaf 404 NOT FOUD";
          if (kategori =="All Produk") {
           document.location.href='index.php';
         }

         if (response.length== 0) {

          var closePesan="&times";

          setTimeout(function(event){

           $("#message").html("<span id='close_pesan'>"+closePesan+"</span><h4>Warning !!!</h4><h5 style='font-size:20px;'>"+createElementBaru+"</h5>").css({
            'transform':'scale(1)rotate(360deg)',
            'transform':'translate(0,0)',
            'display':'block',
            'transition':0.5
          });

         },300);
        }else{

          $(".container").empty();

          $.each(response,function(avIndex,avValue){
            $(".container").append("<div class='row' style='float:left; padding:0;'><div class='col-lg-3' id='long'><div class='card'><div class='card-image waves-effect waves-block waves-light'><p style='color:white;  font-weight: bold; width: 100%; background:rgb(1,1,107);'class='btn btn-danger'>"+avValue.nama_barang+"</p><p class='btn-info' style='border-radius: 50%; height: 50px; width: 50px; position: absolute; top: 20px; left: -5px; font-size:19px; text-align: right; line-height: 50px; background-color: rgb(1,1,107);''>"+avValue.diskon+"%</p><img src='pelapak_gambar/"+avValue.gambar+"'style='height: 250px; width: 250px;' id='gambar' class='img-thumbnail'></div><div class='card-content'><span class='card-title activator blue-text text-darken-4' style='font-size: 15px; font-weight: bold; color:white;'>"+avValue.jenis_barang+"<i class='material-icons flaticon-menu right'></i></span><a href='beli.php?id="+avValue.id_tambah+"'onclick='return confirm('Yakin Anda Ingin Melakukan Pembelian')' style='float:right;'><form action='' method='post'><button type='button' class='btn btn-info' name='tombol_beli' id='jual'><i class='pe-7s-cart' style='font-size: 20px; font-weight: bold; line-height: 40px;'> Beli Barang</i></button></form></a><button type='button'class='from-control' id='card' name='card_simpan' onclick='addCart("+avValue.id_tambah+")'><i class='flaticon-full-shoping-cart' style='height: 90px; margin-left: -21px;'></i>+</button><span style='color:blue;'><i class='pe-7s-cash'></i> Rp. "+avValue.harga_barang+"</span></div><div class='card-reveal'><span class='card-title grey-text text-darken-4'><i class='material-icons pe-7s-close-circle right'></i></span><br><p style='color: rgb(38,166,154);'>"+avValue.deskripsi_barang+"</p></div></div></div></div>");
          });

        } 
      }

    });
   });// tutup kategori barang//

    $("#message").click(function(){
     $(this).css({
      'display':'none'
    });
});// tutup warning//

    $(".masuk").on('keyup',function(){
      var loadAmbil= $(this).val();
      $(".hasil").html("Selamat Datang : "+" "+loadAmbil);
    });
  });
// data pencarian index

function mencari(inputan_data){

 if (inputan_data.length == 0) {

  $('.mod').fadeOut();
}else{

  $.post("cari.php", {tombol_cari:""+inputan_data+""},function(data_base){

   $('.mod').fadeIn();
   $('.mod').html(data_base);


 });
}
}

function addCart(id_tambah){

  var konfirmasi= confirm('Daftar Belanja Akan Di Tambahkan');
  if (konfirmasi == true) {
    $.ajax({

      url:'pelapak.php',
      type:'post',
      data:{id_tambah:id_tambah},
      success: function(response){
        var message= JSON.parse(response);
        $("#span_i").html(message);
        loadCart();

      }
      
    });

  }   
}
function loadCart(){

  $.ajax({
    url:'shoping.php',
    type:'POST',
    dataType:'JSON',
    data:'',
    success:function(value){
      $('#cart_shop').empty();
      var ElementNew= new String("Daftar Belanja");
      $('#cart_shop').prepend("<a href='javascript:void(0)' class='tutup'>&times</a><h5 id='judul'>"+ElementNew+"</h5>");
      $(".tutup").on('click',function(){
        $("#cart_shop").css({
          'width':0,
          'transition':'0.5s'
        });
      });
      $.each(value,function(indexArray,objectValue){
        $('#cart_shop').append("<br><br><div class='alert-danger text-center pull-right' style='transform:scale(0.9); border-radius:6px; width:96%; margin-bottom:8px;'><button type='submit' class='btn btn-danger' onclick='deleteData("+objectValue.id_add+")' id='tutup_b'>&times</button><span class='label label-info' id='stok'>Stok Barang : "+objectValue.stok_barang+"</span><input type='text' class='form-control' value='"+objectValue.nama_barang+"' style='transform:scale(0.8)'></input><input type='number' class='form-control' placeholder='Jumlah Pesanan' onkeyup='jumlah_pesanan("+objectValue.id_add+")' id='total'></input><input type='text' class='form-control' value='Rp."+objectValue.harga_barang+"' style='transform:scale(0.8)' id='semua'></input><button class='btn btn-danger' id='button'> Bayar</button></div>");

      });
    }
  });
}

function deleteData(id_add){
  $.ajax({
    url:'file_hapus/delete_cart.php',
    type:'post',
    data:{id_add:id_add},
    success:function(data){
      var pesanMessage=JSON.parse(data);
      $("#span_i").html(pesanMessage);
      loadCart();
    }
  });
}

function jumlah_pesanan(id_add){

  $.ajax({
    url:'penghitungan_pesanan.php',
    dataType:'JSON',
    type:'POST',
    data:{id_add:id_add},
    success:function(response){
     var total= $('#total').val();
     if (total.length > 0) {
      $.each(response,function(i,value){
        var daftarHarga= value.harga_barang;
        var explode= daftarHarga.match(/\d+/g); 
        console.log(explode.length);  
        var implode= explode.join().replace(/[^\d]+/g,"") * total;

        $('#semua').attr('value','Total Harga : Rp.'+implode);

      });

    }else if(total.length === 0){
      var d=new String('Jumlah Pesasan Tidak Boleh Kosong ');
      $('#semua').attr('value',d);
    }else if(typeof total === "string"){

      var p=new String('Karakter Tidak Boleh Huruf ');
      $('#semua').attr('value',p);
    }else{
      var a=new String('Jumlah Pesanan Kosong ');
      $('#semua').attr('value',a);
    }
  }// penutup successs;
 }); // penutup ajax;
}// penutup fucntion;




