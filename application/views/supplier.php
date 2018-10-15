<div class="container">  
    <hr>
    
    <div class="pull-right"><a href="#" onClick ="input_supplier()" class="btn btn-sm btn-success" ><span class="fa fa-plus"></span>Tambah Data Supplier</a></div>
    <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No. Telp</th>
              <th>No. WA</th>
              <th></th>
          </tr>
      </thead>
      <tfoot>
          <tr>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No. Telp</th>
              <th>No. WA</th>
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
                <h3 class="modal-title" id="myModalLabel">Input Supplier</h3>
            </div>
            <form class="form-horizontal">
            <div class="modal-body">
                
                <div class ="form-group">
                    <label for="namasupplier">Nama Supplier</label>
                    <?php echo form_input(array(
                        'type'=>'text',
                        'name'=>'namasupplier',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="namasuppliererror" class='namasuppliererror'></label>
                </div>

                <div class ="form-group">
                    <label for="alamat">Alamat</label>
                    <?php echo form_input(array(
                        'type'=>'text',
                        'name'=>'alamat',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="alamaterror" class ='alamaterror'></label>
                </div>

                <div class ="form-group">
                    <label for="notelp">No Telepon</label>
                    <?php echo form_input(array(
                        'name'=>'notelp',
                        'type'=>'text',
                        'id'=>'notelp',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="notelperror" class='notelperror'></label>
                </div>

                <div class ="form-group">
                    <label for="nowa">No WA</label>
                    <?php echo form_input('nowa','',array(
                        'type'=>'text',
                        'id'=>'nowa',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    )); 
                    echo form_input(array(
                        'type'=> "checkbox",
                        'id' =>'samehp'
                    ));?> Sama dengan No Telepon <label for="nowaerror" class ='nowaerror'></label>
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

        <!-- MODAL EDIT -->
  <div class="modal fade" id="ModalEdit"  role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Supplier</h3>
            </div>
            <form class="form-horizontal">
            <?php  echo form_hidden('idsupp', ''); ?>
                <div class="modal-body">
                
                <div class ="form-group">
                    <label for="namasupplier">Nama Supplier</label>
                    <?php echo form_input(array(
                        'type'=>'text',
                        'name'=>'namasupplieredit',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="namasuppliererroredit" class='namasuppliererroredit'></label>
                </div>

                <div class ="form-group">
                    <label for="alamat">Alamat</label>
                    <?php echo form_input(array(
                        'type'=>'text',
                        'name'=>'alamatedit',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="alamaterroredit" class ='alamaterroredit'></label>
                </div>

                <div class ="form-group">
                    <label for="notelp">No Telepon</label>
                    <?php echo form_input(array(
                        'name'=>'notelpedit',
                        'type'=>'text',
                        'id'=>'notelpedit',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="notelperroredit" class='notelperroredit'></label>
                </div>

                <div class ="form-group">
                    <label for="nowa">No WA</label>
                    <?php echo form_input('nowaedit','',array(
                        'type'=>'text',
                        'id'=>'nowaedit',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    )); 
                    echo form_input(array(
                        'type'=> "checkbox",
                        'id' =>'samehpedit'
                    ));?> Sama dengan No Telepon <label for="nowaerroredit" class ='nowaerroredit'></label>
                </div>
 
                </div>
 
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="btn_update">Update</button>
                </div>
            </form>
            </div>
            </div>
        </div>
        <!--END MODAL EDIT-->

<script type="text/javascript">
    function input_supplier(){
        $(document).ready(function(){
            $('#ModalInput').modal('show');
        });
    }

    function edit_supplier(idSupp){
      $(document).ready(function(){
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('Supplier/editSupplier');?>",
            data : {idSupp : idSupp},
            dataType : "JSON",
            success: function (data){
                $.each(data, function(Nama){
                    $('#ModalEdit').modal('show');
                    $('[name ="idsupp"]').val(idSupp);
                    $('[name ="namasupplieredit"]').val(data.Nama);
                    $('[name ="alamatedit"]').val(data.Alamat);
                    
                    $('[name ="notelpedit"]').val(data.No_Telp);
                    $('[name ="nowaedit"]').val(data.No_WA);
                    
                    $('.namasupplieredit').html('');
                    $('.alamatedit').html('');
                    $('.notelpedit').html('');
                    $('.nowaedit').html('');
        
                });
                    
            }
        });
    });
   }

   $(document).ready(function() {
    var cekbox = false;
    var cekboxedit = false;
    var tabel;
        $('[name ="notelp"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".notelperror").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $('[name ="nowa"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".nowaerror").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $('[name ="notelpedit"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".notelperroredit").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $('[name ="nowaedit"]').keypress(function(data){
            if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                    $(".nowaerroredit").html("isikan angka").show().fadeOut("slow");
                    return false;
                }
        });

        $('#samehp')
        .click(function(){
            var nohp = $('#notelp').val();
            if(!nohp){
                cekbox = false;
            }else{   
                cekbox = true;
            }
        })
        .change(function() {
            if(cekbox == false){
                alert('isi no hp dulu');
                $(this).prop("checked", false);
            }else{
                if(this.checked) {
                    $(this).prop("checked");
                    $('#nowa').val($('#notelp').val());        
                }else{
                    $('#nowa').val('');
                }
            }
        });
        
        $('#samehpedit')
        .click(function(){
            var nohp = $('#notelpedit').val();
            if(!nohp){
                cekboxedit = false;
            }else{   
                cekboxedit = true;
            }
        })
        .change(function() {
            if(cekboxedit == false){
                alert('isi no hp dulu');
                $(this).prop("checked", false);
            }else{
                if(this.checked) {
                    $(this).prop("checked");
                    $('#nowaedit').val($('#notelpedit').val());        
                }else{
                    $('#nowaedit').val('');
                }
            }
        });



        $('#nowa').keyup(function(event){
            if($(this).val() != $('#notelp').val()){
                $('#samehp').prop("checked", false);
            }else{
                $('#samehp').prop("checked", true);
            }
        });

        $('#nowaedit').keyup(function(event){
            if($(this).val() != $('#notelpedit').val()){
                $('#samehpedit').prop("checked", false);
            }else{
                $('#samehpedit').prop("checked", true);
            }
        });
        
        $('#btn_input').on('click',function(){
            var namasupp = $('[name ="namasupplier"]').val();
            if(namasupp.length<=0){
                $('.namasuppliererror').html('Nama Tidak boleh kosong');
                return false;
            }
            
            var alamat = $('[name ="alamat"]').val();
            var nohp = $('[name ="notelp"]').val();
            var nowa = $('[name ="nowa"]').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Supplier/doInputJemaat')?>",
                dataType : "JSON",
                data : { namasupp:namasupp, alamat:alamat, notelp:nohp, nowa:nowa,},
                success: function(data){
                    $.each(data, function(Nama){
                        if(data.res == 1){
                            $('[name ="namasupplier"]').val("");
                            $('[name ="alamat"]').val("");
                            $('[name ="notelp"]').val("");
                            $('[name ="nowa"]').val("");                    
                            $('#ModalInput').modal('hide');
                            tabel.ajax.reload();
                        }
                    });
                }
            });
            return false;
        });


        $('#btn_update').on('click',function(){
            var idsupp = $('[name ="idsupp"]').val();
            var namasupp = $('[name ="namasupplieredit"]').val();
            if(namasupp.length<=0){
                $('.namasuppliererroredit').html('Nama Tidak boleh kosong');
                return false;
            }
            
            var alamat = $('[name ="alamatedit"]').val();
            var nohp = $('[name ="notelpedit"]').val();
            var nowa = $('[name ="nowaedit"]').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Supplier/doEditSupplier')?>",
                dataType : "JSON",
                data : {idsupp:idsupp , nama:namasupp, alamat:alamat, notelp:nohp, nowa:nowa,},
                success: function(data){
                    if(data.res == 1){
                        $('[name ="idsupp"]').val("");
                        $('[name ="namasupplieredit"]').val("");
                        $('[name ="alamatedit"]').val("");
                        $('[name ="notelpedit"]').val("");
                        $('[name ="nowaedit"]').val("");                    
                        $('#ModalEdit').modal('hide');
                        tabel.ajax.reload();
                    }
                }
            });
            return false;
        });

    // DataTable
    tabel = $('#example').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url('supplier/datatables_ajax');?>",
                        "type": "POST"
                    },
                    columnDefs: [{
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        className: 'dt-body-center'
                    }]
                });


   });
</script>