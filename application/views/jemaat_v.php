<div class="container">  
    <hr>
    
    <div class="pull-right"><a href="<?php echo base_url();?>jemaat/insertJemaatView" class="btn btn-sm btn-success" ><span class="fa fa-plus"></span>Tambah Data Jemaat</a></div>
    <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th>Nama</th>
              <th>Nama Panggilan</th>
              <th>Komsel</th>
              <th>Alamat</th>
              <th>Jenis Kelamin</th>
              <th>No. HP</th>
              <th>No. WA</th>
              <th>Tanggal Lahir</th>
              <th>Email</th>
              <th>Aksi</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
          <th>Nama</th>
              <th>Nama Panggilan</th>
              <th>Komsel</th>
              <th>Alamat</th>
              <th>Jenis Kelamin</th>
              <th>No. HP</th>
              <th>No. WA</th>
              <th>Tanggal Lahir</th>
              <th>Email</th>
              
          </tr>
      </tfoot>
  </table>
  

  <!-- MODAL EDIT -->
  <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title" id="myModalLabel">Edit Jemaat</h3>
                </div>
                <form class="form-horizontal">
                <?php  echo form_hidden('idanggota', ''); ?>
                    <div class="modal-body mx-3">
                    
                        <div class ="md-form mb-5">
                            <label for="namajemaat">Nama Jemaat</label>
                            <?php echo form_input(array(
                                'type'=>'text',
                                'name'=>'namajemaat',
                                'class'=>"form-control",
                                'style'=>"width:335px;"
                            ));  ?> <label for="namajemaaterror" class='namajemaaterror'></label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="namapanggilan">Nama Panggilan</label>
                            <?php echo form_input(array(
                                'type'=>'text',
                                'name'=>'namapanggilan',
                                'class'=>"form-control",
                                'style'=>"width:335px;"
                            ));  ?> <label for="namapanggilanerror" class ='namapanggilanerror'></label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="komsel">Komsel</label></br>
                            <?php echo form_dropdown('komsel', $datakomsel, '', array(
                                'class'=>"form-control komsel input-large",
                                'style'=>"width:335px;"
                            ));  ?> <label for="komselerror" class ='komselerror'></label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="alamat">Alamat</label>
                            <?php echo form_input(array(
                                'type'=>'text',
                                'name'=>'alamat',
                                'class'=>"form-control",
                                'style'=>"width:335px;"
                            ));  ?> <label for="alamaterror" class ='alamaterror'></label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="jeniskelamin">Jenis Kelamin</label>
                            <label class ='radio-inline'>
                                <?php echo form_input(array(
                                    'type'=>'radio',
                                    'name'=>'jeniskelamin',
                                    'value'=> 'PRIA',
                                    'class'=>"input_check_radio"
                                ));  ?>
                            Pria</label>
                            <label class ='radio-inline'>
                                <?php echo form_input(array(
                                    'type'=>'radio',
                                    'name'=>'jeniskelamin',
                                    'value'=> 'WANITA',
                                    'class'=>"input_check_radio"
                                ));  ?> 
                            Wanita</label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="nohp">No Hp</label>
                            <?php echo form_input(array(
                                'name'=>'nohp',
                                'type'=>'text',
                                'id'=>'nohp',
                                'class'=>"form-control",
                                'style'=>"width:335px;"
                            ));  ?> <label for="nohperror" class='nohperror'></label>
                        </div>

                        <div class ="md-form mb-5">
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
                            ));?> Sama dengan No HP <label for="nowaerror" class ='nowaerror'></label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="tgllahir">Tanggal Lahir</label>
                            <?php echo form_input('tgllahir', '',array(
                                'type'=>'text',
                                'class'=>"tanggal form-control",
                                'style'=>"width:335px;"
                            ));  ?> <label for="tgllahirerror" class ='tgllahirerror'></label>
                        </div>

                        <div class ="md-form mb-5">
                            <label for="email">Email</label>
                            <?php echo form_input(array(
                                'type'=>'text',
                                'name'=>'email',
                                'class'=>"form-control",
                                'style'=>"width:335px;"
                            ));  ?> <label for="emailerror" class ='emailerror'></label>
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
 /**
  * Gunaknan ini jika TIDAK ingin menggunakan pencarian perkolom
  */
  // $(document).ready(function() {
  //    $('#example').DataTable({
  //        "processing": true,
  //        "serverSide": true,
  //        "ajax": {
  //            "url": "<?php echo base_url('karyawan/datatables_ajax');?>",
  //            "type": "POST"
  //        }
  //    });
  //  });
    
  
  /**
   * Gunaknan ini jika ingin menggunakan pencarian perkolom 
   */

   
  
  function edit_jemaat(idJemaat){
      $(document).ready(function(){
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('jemaat/editJemaat');?>",
            data : {idAnggota : idJemaat},
            dataType : "JSON",
            success: function (data){
                $.each(data, function(Nama){
                    $('#ModalaEdit').modal('show');
                    $('[name ="idanggota"]').val(idJemaat);
                    $('[name ="namajemaat"]').val(data.Nama);
                    $('[name ="namapanggilan"]').val(data.Nama_Panggilan);
                    $('[name ="komsel"]').val(data.Komsel).trigger('change');;
                    $('[name ="alamat"]').val(data.Alamat);
                    
                    $('[name ="nohp"]').val(data.No_HP);
                    $('[name ="nowa"]').val(data.No_WA);
                    $('[name ="tgllahir"]').val(data.TGL_Lahir);
                    $('[name ="email"]').val(data.Email);

                    if(data.JenisKelamin == 'PRIA'){
                        $('[name ="jeniskelamin"][value ="PRIA"]').prop('checked',true);
                    }else{
                        $('[name ="jeniskelamin"][value ="WANITA"]').prop('checked',true);
                    }
                    
                    $('.namajemaaterror').html('');
                    $('.namapanggilanerror').html('');
                    $('.alamaterror').html('');
                    $('.nohperror').html('');
                    $('.emailerror').html('');
        
                });
                    
            }
        });
    });
   }
   var cekbox = false;
  $(document).ready(function() {
    $('[name ="nohp"]').keypress(function(data){
        if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
            {
                $(".nohperror").html("isikan angka").show().fadeOut("slow");
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



    $('#btn_update').on('click',function(){
        var idjemaat = $('[name ="idanggota"]').val();
        var namajemaat = $('[name ="namajemaat"]').val();
        if(namajemaat.length<=0){
            $('.namajemaaterror').html('Nama Tidak boleh kosong');
            return false;
        }
        var namapanggilan = $('[name ="namapanggilan"]').val();
        if(namapanggilan.length<=0){
            $('.namapanggilanerror').html('Nama Panggilan Tidak boleh kosong');
            return false;
        }
        var komsel = $('[name ="komsel"]').val();
        var alamat = $('[name ="alamat"]').val();
        if(alamat.length<=0){
            $('.alamaterror').html('Alamat Tidak boleh kosong');
            return false;
        }
        var nohp = $('[name ="nohp"]').val();
        if(nohp.length<=0){
            $('.nohperror').html('No Hp Tidak boleh kosong');
            return false;
        }
        var nowa = $('[name ="nowa"]').val();
        var tgllahir = $('[name ="tgllahir"]').val();
        var email = $('[name ="email"]').val();
        if(email.length<=0){
            $('.emailerror').html('Email Tidak boleh kosong');
            return false;
        }
        var jeniskelamin = $('[name ="jeniskelamin"]:checked').val();
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url('jemaat/doEditJemaat')?>",
            dataType : "JSON",
            data : {idanggota:idjemaat , namajemaat:namajemaat, namapanggilan:namapanggilan, 
                komsel:komsel, alamat:alamat, jeniskelamin:jeniskelamin, nohp:nohp
                , nowa:nowa, tgllahir:tgllahir, email:email},
            success: function(data){
                $('[name ="idanggota"]').val("");
                $('[name ="namajemaat"]').val("");
                $('[name ="namapanggilan"]').val("");
                $('[name ="komsel"]').val("");
                $('[name ="alamat"]').val("");
                $('[name ="nohp"]').val("");
                $('[name ="nowa"]').val("");
                $('[name ="tgllahir"]').val("");
                $('[name ="email"]').val("");
                
                $('#ModalaEdit').modal('hide');
                location.reload();
            }
        });
        return false;
    });


    
    $('.tanggal').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        });
        
        $('#samehp')
        .click(function(){
            var nohp = $('#nohp').val();
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
                    $('#nowa').val($('#nohp').val());        
                }else{
                    $('#nowa').val('');
                }
            }
        });
        

        $('#nowa').keyup(function(event){
            if($(this).val() != $('#nohp').val()){
                $('#samehp').prop("checked", false);
            }else{
                $('#samehp').prop("checked", true);
            }
        });
        
        $('.komsel').select2({

        });






    function reloadDataTabel(){
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            language: {
                    infoEmpty: "No records available - Got it?",
                    emptyTable:"No data available in table"
                },
            "ajax": {
                "url": "<?php echo base_url('jemaat/datatables_ajax');?>",
                "type": "POST"
            }
        });
    }    
    
    
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
                        "url": "<?php echo base_url('jemaat/datatables_ajax');?>",
                        "type": "POST"
                    }
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
} );
  </script>
