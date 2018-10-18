<div class="container">  
    <hr>
    <div class="pull-right"><a href="#" onClick ="input_hargadagang()" class="btn btn-sm btn-success" ><span class="fa fa-plus"></span>Tambah Harga Dagangan Supplier</a></div>
    <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th>Nama Supplier</th>
              <th>Nama Dagangan</th>
              <th>Harga HPP</th>
              <th>Harga Jual</th>
              <th>Tanggal</th>
              <th></th>
          </tr>
      </thead>
      <tfoot>
          <tr>
                <th>Nama Supplier</th>
                <th>Nama Dagangan</th>
                <th>Harga HPP</th>
                <th>Harga Jual</th>
                <th>Tanggal</th>
                <th></th>
          </tr>
      </tfoot>
  </table>

<!-- MODAL Input -->
<div class="modal fade" id="ModalInput"  role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Harga Dagang</h3>
            </div>
            <form class="form-horizontal">
            <div class="modal-body mx-3">
                
                <div class ="md-form mb-5 ">
                    <?php echo form_dropdown('dagangan', $dagangan, '', array(
                                    'class'=>"form-control dagangan"
                                ));  ?> <label for="daganganerror"></label>
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
                    <label for="tglawal">Tanggal Efektif</label>
                    <?php echo form_input('tglawal', '',array(
                        'type'=>'text',
                        'class'=>"tglawal form-control"
                    ));  ?> <label for="tglawalerror"></label>
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

<!-- Modal nonaktif -->
<div class="modal fade" id="modalNonaktif" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Nonaktif harga</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <div class ="md-form mb-5">
            <label for="tglakhir">Tanggal Terakhir</label>
                <?php echo form_input('tglakhir', '',array(
                    'type'=>'text',
                    'class'=>"tglakhir form-control"
                ));  ?> <label for="tglakhirerror"></label>
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
    var tabel;
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

    function hilangTitk(str){
        return str.split('.').join('');
    }
    
    function input_hargadagang(){
        $(document).ready(function(){
            $('#ModalInput').modal('show');
        });
    }

    function nonaktif(id, no){
        $(document).ready(function() {
            var row = tabel.rows(no).data();
            var tglawl = new Date((row[0][4]));
            $('.tglakhir').datepicker({
                format: "yyyy-mm-dd",
                numberOfMonths: 3,
                autoclose:true,
                minDate: tglawl
            }).datepicker('setDate', tglawl);;
            
            $('#modalNonaktif').modal('show');
        
        });
        
    }

     $(document).ready(function() {
        $('.tglawal').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        }).datepicker('setDate', 'today');

        

        $('.dagangan').select2();

        tabel = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('Hargadagang/datatables_ajax');?>",
                "type": "POST"
            },
            columnDefs: [
                {
                    targets: 5,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center'
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center'
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center'
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center'
                }
            ]
        });
        
        $('[name ="hargahpp"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".hargahpperror").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $('[name ="hargajual"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".hargajualerror").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $('#btn_input').on('click',function(){
            var iddagang = $('[name ="dagangan"]').val();
            if(iddagang.length<=0){
                $('.iddagangerror').html('Supplier Tidak boleh kosong').show().fadeOut("slow");
                return false;
            }

            var hargahpp = hilangTitk($('[name ="hargahpp"]').val());
            if(hargahpp.length<=0 || hargahpp == 0){
                $('.hargahpperror').html('Harga HPP tidak boleh kosong').show().fadeOut("slow");
                return false;
            }

            var hargajual = hilangTitk($('[name ="hargajual"]').val());
            if(hargajual.length<=0 || hargajual == 0){
                $('.hargajualerror').html('Harga Jual tidak boleh kosong').show().fadeOut("slow");
                return false;
            }
            if(hargahpp > hargajual){
                $('.hargahpperror').html('Harga HPP tidak boleh lebih besar dari harga jual').show().fadeOut("slow");
                $('.hargajualerror').html('Harga Jual tidak boleh lebih kecil dari harga jual').show().fadeOut("slow");
                return false;
            }
            var tglawal = $('[name ="tglawal"]').val();
            if(tglawal.length<=0){
                $('.tglawalerror').html('Tanggal efektif tidak boleh kosong').show().fadeOut("slow");
                return false;
            }
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Hargadagang/saveHarga')?>",
                dataType : "JSON",
                data : {iddagang:iddagang, hargahpp:hargahpp, 
                    hargajual:hargajual, tglawal:tglawal},
                success: function(data){
                    $.each(data, function(Nama){

                        $('[name ="hargahpp"]').val("");
                        $('[name ="hargajual"]').val("");                        
                        $('#ModalInput').modal('hide');
                        $('[name ="result"]').html(data.res);
                        $('[name ="mdt"]').html("Perhatian");
                        $('#modalPopup').modal('show');
                        tabel.ajax.reload();
                    });
                    
                }
            });
            

            return false;
        });


     });
</script>