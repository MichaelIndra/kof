<script>

    function inputAbsen(idAnggota, nama){
        $(document).ready(function() {
            var tanggal = $('.tanggal').val();
            if(!tanggal){
                alert('Tanggal harus diisi terlebih dahulu');
                $('.tanggal').focus();
            }else{
                $.ajax({
                    type : "POST",
                        url : "<?php echo base_url('absensi/saveAbsen');?>",
                        data : {idanggota : idAnggota, tanggal : tanggal, nama, nama},
                        dataType : "JSON",
                        success: function (data){
                            $.each(data, function(Nama){
                            
                
                        });
                    }
                });
            }
        });
    }
    $(document).ready(function() {
           $('#example').DataTable({
               "processing": true,
               "serverSide": true,
               language: {
                    infoEmpty: "No records available - Got it?",
                },
               "ajax": {
                   "url": "<?php echo base_url('absensi/datatables_ajax');?>",
                   "type": "POST"
               },
               columnDefs: [{
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center'
                    
                }]
           });
         
           
           $('.tanggal').datepicker({
                format: "yyyy-mm-dd",
                autoclose:true
                
            }).datepicker('setDate', 'today'); 
    });
    
</script>


<div class="container">
    <hr>

  <?php if (isset($error)){echo $error; } ?>
    <div class ="form-group">
        <?php echo form_input('tglibadah', "",array(
            'type'=>'text',
            'class'=>"tanggal form-control",
            'placeholder' => 'Tanggal Ibadah'
        ));  ?>
    </div>
  <table id="example" class="display" cellspacing="0" width="100%">
      <thead>
          <tr>
              
              <th>Nama</th>
              <th>Komsel</th>
              <th>Alamat</th>
              <th></th>
              
          </tr>
      </thead>
      <tfoot>
          <tr>
            
            <th>Nama</th>
            <th>Komsel</th>
            <th>Alamat</th>  
            <th></th>
          </tr>
      </tfoot>
  </table>