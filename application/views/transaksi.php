<div class="container">  
    <hr>
    <div class="pull-left"><a href="#" onClick ="input_stok()" class="btn btn-sm btn-success" ><span class="fa fa-plus"></span>Tambah Stok</a></div>
    
    <!-- MODAL Input -->
    <div class="modal fade" id="ModalInputStok"  role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Harga Dagang</h3>
            </div>
            <form class="form-horizontal">
            <div class="modal-body mx-3">
                
                <div class ="md-form mb-5 ">
                    <label for="iddagang">Cari dagangan</label>
                    <?php echo form_input(array(
                        'name'  => 'iddagang',
                        'type'  => 'text',
                        'id'    => 'iddagang',
                        'class' => "form-control",
                        'style' => "width:335px;"
                    ));  ?>
                    <label for="iddagangerror"></label>
                </div>

                <div class ="md-form mb-5">
                    <label for="supplier">Supplier</label>
                    <?php echo form_input(array(
                        'name'=>'supplier',
                        'type'=>'text',
                        'id'=>'supplier',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="suppliererror" class='suppliererror'></label>
                </div>
               
                <div class ="md-form mb-5">
                    <label for="hargahpp">Harga HPP</label>
                    <?php echo form_input(array(
                        'name'=>'hargahpp',
                        'type'=>'text',
                        'id'=>'hargahpp',
                        'class'=>"form-control uang",
                        'style'=>"width:335px;"
                    ));  ?> <label for="hargahpperror" class='hargahpperror'></label>
                </div>
                
                <div class ="md-form mb-5">
                    <label for="hargajual">Harga Jual</label>
                    <?php echo form_input(array(
                        'name'=>'hargajual',
                        'type'=>'text',
                        'id'=>'hargajual',
                        'class'=>"form-control uang",
                        'style'=>"width:335px;"
                    ));  ?> <label for="hargajual" class='hargajualerror'></label>
                </div>

                <div class ="md-form mb-5">
                    <label for="tglstok">Tanggal Stok</label>
                    <?php echo form_input('tglstok', '',array(
                        'type'=>'text',
                        'class'=>"tglstok form-control"
                    ));  ?> <label for="tglstokerror"></label>
                </div>
                
                <div class ="md-form mb-5">
                    <label for="stok">Stok</label>
                    <?php echo form_input(array(
                        'name'=>'stok',
                        'type'=>'text',
                        'id'=>'stok',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="stokerror" class='stokerror'></label>
                </div>    
                    
            </div>
 
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_input">Simpan</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <!--END MODAL Input-->
<!-- Modal Popup -->
<div class="modal fade" id="modalPopup" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" name ="mdt"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <div class ="md-form mb-5">
                <label name="result"></label>
            </div>  
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<style type="text/css">
    .uang{
        text-align :right;
    }
</style>    
<script>
    var option;var iddagangfinal;
    var hargahpp = document.getElementById('hargahpp');
	hargahpp.addEventListener('keyup', function(e)
	{
		hargahpp.value = formatRupiah(this.value);
	});
    
    var hargajual = document.getElementById('hargajual');
	hargajual.addEventListener('keyup', function(e)
	{
		hargajual.value = formatRupiah(this.value);
	});
	
	function formatRupiah(angka, prefix)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
    function input_stok(){
        $(document).ready(function(){
            $('#ModalInputStok').modal('show');
        });
        
    }
    $(document).ready(function(){
        $('[name ="stok"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".stokerror").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });
        $('#btn_input').on('click',function(){
            var tglstok = $('[name ="tglstok"]').val();
            if(tglstok.length<=0){
                $('.tglstokerror').html('Tanggal stok tidak boleh kosong').show().fadeOut("slow");
                return false;
            }
            
            var stok = $('[name ="stok"]').val();
            if(stok.length<=0){
                $('.stokerror').html('Stok boleh kosong').show().fadeOut("slow");
                return false;
            }
            
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Transaksi/saveStok')?>",
                dataType : "JSON",
                data : {Stok_Awal:stok, Tanggal_Stok:tglstok, ID_Dagang : iddagangfinal},
                success: function(data){
                    $.each(data, function(Nama){
                        if(data.res == 1){
                            $('[name ="iddagang"]').val("");
                            $('[name ="supplier"]').val("");
                            $('[name ="hargahpp"]').val("");
                            $('[name ="hargajual"]').val("");
                            $('[name ="stok"]').val("");
                            $('#ModalInputStok').modal('hide');
                            // tabel.ajax.reload();
                        }    
                    });    
                }
            });

            return false;
        });



        option = {
            url     : "<?php echo base_url('Transaksi/search');?>",
            getValue : "Nama_Dagangan",
            template :{
                type :"custom",
                method : function(value, item){
                            return item.Nama_Dagangan + " || "+item.Nama+" || "+item.Harga_Hpp;
                        }
            },
            list:{
                match:{enabled:true},
                onSelectItemEvent: function() {
                    var namasuplier = $("#iddagang").getSelectedItemData().Nama;
                    var iddagang = $("#iddagang").getSelectedItemData().ID_Dagang;
                    var hargahpp = $("#iddagang").getSelectedItemData().Harga_Hpp;
                    var hargajual = ($("#iddagang").getSelectedItemData().Harga_Jual);
                    $("#supplier").val(namasuplier).trigger("change");
                    $("#hargajual").val(hargajual).trigger("change");
                    $("#hargahpp").val(hargahpp).trigger("change");
                    iddagangfinal = iddagang;
                    
                }
            }
        };
        $("#iddagang").easyAutocomplete(option);
        $('.tglstok').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        }).datepicker('setDate', 'today');

        
    });
</script>