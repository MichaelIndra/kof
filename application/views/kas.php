


<div class="container">  
    <hr>
    
    <div class="pull-right"><button class="btn btn-info" id="btn_input">Input Kas</button></div>
    <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th>ID Transaksi</th>
              <th>Nama</th>
              <th>Jumlah</th>
              <th>Tanggal Transaksi</th>
              <th>Tanggal Input</th>
              <th>Keterangan</th>
              <th>Cash Flow</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
            <th>ID Transaksi</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Tanggal Transaksi</th>
            <th>Tanggal Input</th>
            <th>Keterangan</th>
            <th>Cash Flow</th>  
          </tr>
      </tfoot>
  </table>


  <!-- MODAL EDIT -->
  <div class="modal fade" id="ModalaEdit"  role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Input Data Kas</h3>
            </div>
            <form class="form-horizontal">
                <div class="modal-body mx-3">

                    <div class ="md-form mb-5">
                        <label for="cashflow">Cash Flow</label></br>
                        <?php echo form_dropdown('cashflow', $masterkas, '', array(
                            'class'=>"form-control cashflow input-large",
                            'style'=>"width:335px;"
                        ));  ?> <label for="cashflowerror" class ='cashflowerror'></label>
                    </div>

                    <div class ="md-form mb-5">
                        <label for="Jumlah">Jumlah</label>
                        <?php echo form_input(array(
                            'type'=>'text',
                            'id'=>'jml',
                            'name'=>'jumlah',
                            'class'=>"form-control uang",
                            'style'=>"width:335px;"
                        ));  ?> <label for="jumlaherror" class='jumlaherror'></label>
                    </div>

                <div class ="md-form mb-5">
                    <label for="tgltransaksi">Tanggal Transaksi</label>
                    <?php echo form_input('tgltransaksi', '',array(
                        'type'=>'text',
                        'class'=>"tgltransaksi form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="tgltransaksierror" class ='tgltransaksierror'></label>
                </div>

                <div class ="md-form mb-5">
                    <label for="email">Keterangan</label>
                    <?php echo form_input(array(
                        'type'=>'textarea',
                        'name'=>'keterangan',
                        'rows'=>'50',
                        'cols'=>'80',
                        'class'=>"form-control col-xs-12",
                        'style'=>"height:75%"
                    ));  ?> <label for="keteranganerror" class ='keteranganerror'></label>
                </div>
 
                </div>
 
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_save">Simpan</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <!--END MODAL EDIT-->
<style type="text/css">
    .uang{
        text-align :right;
    }
</style>
<script type="text/javascript">
    

	// /* Tanpa Rupiah */
	var tanpa_rupiah = document.getElementById('jml');
	tanpa_rupiah.addEventListener('keyup', function(e)
	{
		tanpa_rupiah.value = formatRupiah(this.value);
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






    $(document).ready(function(){

        $("#btn_input").on('click',function(){
            $("#ModalaEdit").modal('show');
        });

        $('.cashflow').select2({});
        $('.tgltransaksi').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        });
        

        $('[name ="jumlah"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".jumlaherror").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $("#btn_save").on('click', function(){
            var jumlah = $('[name ="jumlah"]').val();
            if(jumlah.length<=0 || jumlah == 0){
                $('.jumlaherror').html('Jumlah uang tidak boleh kosong').show().fadeOut("slow");
                return false;
            }
            var tgltransaksi = $('[name ="tgltransaksi"]').val();
            if(tgltransaksi == null ){
                $('.tgltransaksierror').html('Tanggal transaksi tidak boleh kosong').show().fadeOut("slow");

                return false;
            }
            var keterangan = $('[name ="keterangan"]').val();
            if(keterangan.length <= 0){
                keterangan = '-';
            }
            var cashflow = $('[name ="cashflow"]').val(); 
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Kas/saveKas')?>",
                dataType : "JSON",
                data : {Jumlah:jumlah, TanggalTransaksi:tgltransaksi, 
                    Keterangan:keterangan, KodeCashFlow:cashflow},
                success: function(data){
                   
                    
                }
            });
            $('[name ="jumlah"]').val("");
            $('[name ="tgltransaksi"]').val("");
            $('[name ="keterangan"]').val("");
            
            $('#ModalaEdit').modal('hide');
            location.reload();
        return false;



        });


        // Setup - add a text input to each footer cell
        $('#example tfoot th').each( function () {
            var title = $(this).text();
            var inp   = '<input type="text" class="form-control" placeholder="Search '+ title +'" />';
            $(this).html(inp);
        } );
        
        // DataTable
        var table = $('#example').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "<?php echo base_url('Kas/datatables_ajax');?>",
                            "type": "POST"
                        },
                        columnDefs : [
                            { targets : 2 , render: $.fn.dataTable.render.number( ',', '.', 0 ), className: 'dt-body-right'}
                        ]
                    });
    
        // Apply the search
        table.columns().every( function () {
            var that = this;
    
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        // jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        //     "currency-pre": function ( a ) {
        //         a = (a==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
        //         return parseFloat( a );
        //     },

        //     "currency-asc": function ( a, b ) {
        //         return a - b;
        //     },

        //     "currency-desc": function ( a, b ) {
        //         return b - a;
        //     }
        // } );



    });
</script>