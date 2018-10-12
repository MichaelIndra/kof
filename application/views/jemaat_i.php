<div class="container">
    <header>
      <h2><?php echo $judul ?></h2>
    </header>
    <hr>

  <?php if (isset($error)){echo $error; } ?>
<?php echo form_open('jemaat/insertJemaatData'); ?>

<script type="text/javascript">
var cekbox = false;
    $(document).ready(function () {
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

        $('#nowa').keyup(function(event){
            if($(this).val() != $('#nohp').val()){
                $('#samehp').prop("checked", false);
            }else{
                $('#samehp').prop("checked", true);
            }
        });
        
        $('.komsel').select2({

        });
    

    });

</script>

<div class ="form-group">
    <label for="namajemaat">Nama Jemaat</label>
    <?php echo form_input(array(
        'type'=>'text',
        'name'=>'namajemaat',
        'value'=> set_value('namajemaat'),
        'class'=>"form-control"
    ));  ?> <label for="namajemaaterror"><?php echo form_error('namajemaat'); ?></label>
</div>

<div class ="form-group">
    <label for="namapanggilan">Nama Panggilan</label>
    <?php echo form_input(array(
        'type'=>'text',
        'name'=>'namapanggilan',
        'value'=> set_value('namapanggilan'),
        'class'=>"form-control"
    ));  ?> <label for="namapanggilanerror"><?php echo form_error('namapanggilan'); ?></label>
</div>

<div class ="form-group">
    <label for="komsel">Komsel</label>
    <?php echo form_dropdown('komsel', $datakomsel, '', array(
        'class'=>"form-control komsel"
    ));  ?> <label for="komselerror"><?php echo form_error('komsel'); ?></label>
</div>

<div class ="form-group">
    <label for="alamat">Alamat</label>
    <?php echo form_input(array(
        'type'=>'text',
        'name'=>'alamat',
        'value'=> set_value('alamat'),
        'class'=>"form-control"
    ));  ?> <label for="alamaterror"><?php echo form_error('alamat'); ?></label>
</div>

<div class ="form-group">
    <label for="jeniskelamin">Jenis Kelamin</label>
    <label class ='radio-inline'>
        <?php echo form_input(array(
            'type'=>'radio',
            'name'=>'jeniskelamin',
            'value'=> 'PRIA',
            'class'=>"input_check_radio",
            'checked' =>'checked'
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

<div class ="form-group">
    <label for="nohp">No Hp</label>
    <?php echo form_input(array(
        'name'=>'nohp',
        'type'=>'text',
        'id'=>'nohp',
        'value'=> set_value('nohp'),
        'class'=>"form-control"
    ));  ?> <label for="nohperror " class='nohperror'><?php echo form_error('nohp'); ?></label>
</div>

<div class ="form-group">
    <label for="nowa">No WA</label>
    <?php echo form_input('nowa',set_value('nowa'),array(
        'type'=>'text',
        'id'=>'nowa',
        'class'=>"form-control"
    )); 
    echo form_input(array(
        'type'=> "checkbox",
        'id' =>'samehp'
    ));?> Sama dengan No HP <label for="nowaerror" class='nowaerror'><?php echo form_error('nowa'); ?></label>
</div>

<div class ="form-group">
    <label for="tgllahir">Tanggal Lahir</label>
    <?php echo form_input('tgllahir', set_value('tgllahir'),array(
        'type'=>'text',
        'class'=>"tanggal form-control"
    ));  ?> <label for="tgllahirerror"><?php echo form_error('tgllahir'); ?></label>
</div>

<div class ="form-group">
    <label for="email">Email</label>
    <?php echo form_input(array(
        'type'=>'text',
        'name'=>'email',
        'value'=> set_value('email'),
        'class'=>"form-control"
    ));  ?> <label for="emailerror"><?php echo form_error('email'); ?></label>
</div>

<div class ="form-group">
    <?php echo form_submit('submit','Simpan Data Jemaat', array( 'class'=>'btn btn-danger')); ?>
    <a href="<?php echo base_url();?>jemaat/" class="btn btn-sm btn-info" ><span class="fa fa-plus"></span>Kembali</a>
</div>


<!-- <table>
    <tr>
        <td>Nama Jemaat</td>
        <td><?php echo form_input(array(
                            'type'=>'text',
                            'name'=>'namajemaat',
                            'value'=> set_value('namajemaat')
                            ));  ?></td>
        <td><?php echo form_error('namajemaat'); ?> </td>
    </tr>
    <tr>
        <td>Nama Panggilan</td>
        <td><?php echo form_input('namapanggilan',set_value('namapanggilan'),array());  ?></td>
        <td><?php echo form_error('namapanggilan'); ?> </td>
    </tr>
    <tr>
        <td>Komsel</td>
        <td><?php echo form_input('komsel',set_value('komsel'),array()); ?></td>
        <td><?php echo form_error('komsel'); ?> </td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td><?php echo form_input('alamat',set_value('alamat'),array());?></td>
        <td><?php echo form_error('alamat'); ?> </td>
    </tr>
    <tr>
        <td>No HP</td>
        <td><?php echo form_input('nohp',set_value('nohp'),array( 'id'=>'nohp')); ?></td>
        <td><?php echo form_error('nohp'); ?> </td>
    </tr>
    <tr>
        <td>No WA</td>
        <td><?php echo form_input('nowa',set_value('nowa') ,array( 'id'=>'nowa'));  ?> <input type="checkbox" id="samehp" />Sama dengan No HP </td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td><?php echo form_input('tgllahir',set_value('tgllahir'),array('class'=>'tanggal')); ?></td>
        <td><?php echo form_error('tgllahir'); ?> </td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo form_input('email',set_value('email'),array()); ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo form_submit('submit','Simpan Data Jemaat', array( 'class'=>'btn btn-danger')); ?></td>
    </tr>
</table> -->
<?php echo form_close(); ?>