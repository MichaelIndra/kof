<div class="container">  
    <hr>
    
    <div class="pull-right"><a href="#" onClick ="input_dagangan()" class="btn btn-sm btn-success" ><span class="fa fa-plus"></span>Tambah Data Dagangan Supplier</a></div>
    <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
              <th>Nama Supplier</th>
              <th>Nama Dagangan</th>
              <th>Keterangan</th>
              <th>Pok</th>
              <th></th>
          </tr>
      </thead>
      <tfoot>
          <tr>
                <th>Nama Supplier</th>
                <th>Nama Dagangan</th>
                <th>Keterangan</th>
                <th>Pok</th>
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
            <div class="modal-body mx-3">
                
                <div class ="md-form mb-5 ">
                <?php echo form_dropdown('supplier', $supplier, '', array(
                                    'class'=>"form-control supplier"
                                ));  ?> <label for="suppliererror"><?php echo form_error('supplier'); ?></label>
                </div>

                <div class ="md-form mb-5">
                    <label for="namadagangan">Nama Dagangan</label>
                    <?php echo form_input(array(
                        'type'=>'text',
                        'name'=>'namadagangan',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="namadaganganerror" class ='namadaganganerror'></label>
                </div>

                <div class ="md-form mb-5">
                    <label for="keterangan">Keterangan</label>
                    <?php echo form_input(array(
                        'type'=>'text',
                        'name'=>'keterangan',
                        'class'=>"form-control",
                        'style'=>"width:335px;"
                    ));  ?> <label for="keteranganerror" class ='keteranganerror'></label>
                </div>

                <div class ="md-form mb-5">
                    <label for="pok">Pok</label>
                    <?php  echo form_input(array(
                            'type'=> "checkbox",
                            'id' =>'pok'
                        ));?>
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
            <?php  echo form_hidden('iddagang', ''); ?>
                <div class="modal-body mx-3">
                    <div class ="md-form mb-5 ">
                    <?php echo form_input(array(
                            'type'=>'text',
                            'name'=>'namasupplieredit',
                            'class'=>"form-control",
                            'readonly'=>'true',
                            'style'=>"width:335px;"
                        ));  ?> <label for="suppliererror"><?php echo form_error('supplier'); ?></label>
                    </div>

                    <div class ="md-form mb-5">
                        <label for="namadaganganedit">Nama Dagangan</label>
                        <?php echo form_input(array(
                            'type'=>'text',
                            'name'=>'namadaganganedit',
                            'class'=>"form-control",
                            'style'=>"width:335px;"
                        ));  ?> <label for="namadaganganerroredit" class ='namadaganganerroredit'></label>
                    </div>

                    <div class ="md-form mb-5">
                        <label for="keteranganedit">Keterangan</label>
                        <?php echo form_input(array(
                            'type'=>'text',
                            'name'=>'keteranganedit',
                            'class'=>"form-control",
                            'style'=>"width:335px;"
                        ));  ?> <label for="keteranganerroredit" class ='keteranganerroredit'></label>
                    </div>

                    <div class ="md-form mb-5">
                        <label for="pokedit">Pok</label>
                        <?php  echo form_input(array(
                                'type'=> "checkbox",
                                'id' =>'pokedit'
                            ));?>
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



<script>
    var tabel;
    function input_dagangan(){
        $(document).ready(function(){
            $('#ModalInput').modal('show');
        });
    }

    function edit_dagangan(idDagang){
      $(document).ready(function(){
            $.ajax({
                type : "POST",
                url : "<?php echo base_url('Dagangan/editDagangan');?>",
                data : {idDagang : idDagang},
                dataType : "JSON",
                success: function (data){
                    $.each(data, function(Nama){
                        $('#ModalEdit').modal('show');
                        $('[name ="iddagang"]').val(idDagang);
                        $('[name ="namasupplieredit"]').val(data.Nama);
                        $('[name ="namadaganganedit"]').val(data.Nama_Dagangan);
                        $('[name ="keteranganedit"]').val(data.Keterangan);
                        //pok
                        if(data.Pok == "T"){
                            $('[id ="pokedit"]').prop("checked", true);
                        }else{
                            $('[id ="pokedit"]').prop("checked", false);
                        }

                    });
                        
                }
            });
        });
   }

    $(document).ready(function() {

        $('.supplier').select2({

        });

        $('#btn_input').on('click',function(){
            var idsupp = $('[name ="supplier"]').val();
            if(idsupp.length<=0){
                $('.namasuppliererror').html('Nama Supplier Tidak boleh kosong');
                return false;
            }
            
            var namadagangan = $('[name ="namadagangan"]').val();
            if(namadagangan.length<=0){
                $('.namadaganganerror').html('Nama Dagangan Tidak boleh kosong');
                return false;
            }

            var keterangan = $('[name ="keterangan"]').val();
            var cekpok = $('[id ="pok"]:checked').length;
            
            
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Dagangan/doInputDagangan')?>",
                dataType : "JSON",
                data : { idsupp:idsupp, namadagangan:namadagangan, keterangan:keterangan, cekpok:cekpok},
                success: function(data){
                    $.each(data, function(Nama){
                        if(data.res == 1){
                            $('[name ="namasupplier"]').val("");
                            $('[name ="namadagangan"]').val("");
                            $('[name ="keterangan"]').val("");
                            $('#ModalInput').modal('hide');
                            tabel.ajax.reload();
                        }
                    });
                }
            });
            return false;
        });

        $('#btn_update').on('click',function(){
           
            var idDagang = $('[name ="iddagang"]').val();
            var namadagangan = $('[name ="namadaganganedit"]').val();
            if(namadagangan.length<=0){
                $('.namadaganganerroredit').html('Nama Dagangan Tidak boleh kosong');
                return false;
            }

            var keterangan = $('[name ="keteranganedit"]').val();
            var cekpok = $('[id ="pokedit"]:checked').length;
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Dagangan/doEditDagangan')?>",
                dataType : "JSON",
                data : {iddagang:idDagang , namadagangan:namadagangan, keterangan:keterangan, cekpok:cekpok},
                success: function(data){
                    if(data.res == 1){
                        $('[name ="namasupplier"]').val("");
                        $('[name ="namadagangan"]').val("");
                        $('[name ="keteranganedit"]').val("");             
                        $('#ModalEdit').modal('hide');
                        tabel.ajax.reload();
                    }
                }
            });
            return false;
        });

        tabel = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('dagangan/datatables_ajax');?>",
                "type": "POST"
            },
            columnDefs: [
                {
                    targets     : 2,
                    searchable  : false,
                    orderable   : false,
                    
                },
                {
                    targets     : 3,
                    searchable  : false,
                    orderable   : false,
                    
                },
                {
                    targets     : 4,
                    searchable  : false,
                    orderable   : false,
                    className   : 'dt-body-center'
                }
            ]
        });

        $('#example tfoot th').each( function () {
            var title = $(this).text();
            var inp   = '<input type="text" class="form-control" placeholder="Search '+ title +'" />';
            $(this).html(inp);
        });

        tabel.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            });
        });


    });    
  
</script>
