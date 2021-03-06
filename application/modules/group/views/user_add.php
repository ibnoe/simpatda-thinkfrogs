<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h4><legend id="bc" data-bind="text: title"></legend></h4>

<form id="frm" class="form-horizontal" method="post" action="<?php echo base_url(); ?>group/user_proses">
  <div class="control-group" data-bind="validationElement: username">
    <label class="control-label" for="inputUsername" >
      Username
    </label>
    <div class="controls">
      <input type="text" id="username" placeholder="Username" data-bind="value: username">
    </div>
  </div>
  <?php
  if(isset($data['ID']))
  {
  ?>
  <!--edit-->
  <!--<div data-bind="visible: mode() === 'edit'">
    <div class="control-group">
        <label class="control-label" for="inputPassword">
          Edit Password
        </label>
        <div class="controls">
          <input type="checkbox" data-bind="checked: displaypassword" />
        </div>
    </div>-->

    <!--<div data-bind="if: displaypassword">-->
      <!-- ko if: displaypassword -->
        <!--<div class="control-group" data-bind="validationElement: old_passwd">
          <label class="control-label" for="inputPassword" data-bind="validationElement: old_passwd">
            Password Lama
          </label>
          <div class="controls" data-bind="validationElement: old_passwd">
            <input type="password" id="old_passwd" placeholder="Password lama" data-bind="value: old_passwd">
          </div>
        </div>
      <div class="control-group" data-bind="validationElement: passwd">
          <label class="control-label" for="inputPassword" data-bind="validationElement: passwd">
            Password baru
          </label>
          <div class="controls">
            <input type="password" id="passwde" placeholder="Password" data-bind="value: passwd">
          </div>
        </div>
      <div class="control-group" data-bind="validationElement: repasswd">
        <label class="control-label" for="inputPassword" data-bind="validationElement: repasswd">
          Ulangi Password baru
        </label>
        <div class="controls">
          <input type="password" id="repasswde" placeholder="Ulangi Password" data-bind="value: repasswd">
        </div>
      </div>-->
      <!-- /ko -->
    <!--</div>
  </div>-->
  <?php
    }
  else
  {

  ?>
  <!--entri-->
  <div data-bind="visible: mode() === 'new'">
  <div class="control-group" data-bind="validationElement: passwd">
    <label class="control-label" for="inputPassword">
      Password
    </label>
    <div class="controls">
      <input type="password" id="passwd" placeholder="Password" data-bind="value: passwd">
    </div>
  </div>
  <div class="control-group" data-bind="validationElement: repasswd">
    <label class="control-label" for="inputPassword" data-bind="validationElement: repasswd">
      Ulangi Password
    </label>
    <div class="controls">
      <input type="password" id="repasswd" placeholder="Ulangi Password" data-bind="value: repasswd">
    </div>
  </div>
  </div>
  <?php
  }

  ?>
  <div class="control-group">
    <label class="control-label" for="inputName">
      Nama Operator
    </label>
    <div class="controls">
      <input type="text" id="name" placeholder="Nama Operator" data-bind="value: name">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputName">
      Icon
    </label>
    <div class="controls">
      <div class="fileupload fileupload-new" data-provides="fileupload">
        <div class="fileupload-new thumbnail" style="width: 50px; height: 50px;">
        <?php
          if(isset($data['ICON']))
          {

        ?>
            <img src="<?php echo base_url().'assets/img/user/'.$data['ICON']; ?>" />

        <?php

          }
          else
          {
        ?>
            <img src="http://www.placehold.it/50x50/EFEFEF/AAAAAA" />
        <?php
          }
        ?>

        </div>
        <?php
          if(isset($data['ICON']))
          {

        ?>
        <span data-bind="click: hapus_icon"><i class="icon-remove" title="hapus icon"></i></span>
        <?php
          }
        ?>
        <div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;">
        </div>
        <span class="btn btn-file">
          <span class="fileupload-new">
            Select image
          </span>
          <span class="fileupload-exists">
            Change
          </span>
          <input type="file" id="image" name="image" data-bind="value: image">
        </span>
        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">
          Remove
        </a>
      </div>ukuran terbaik 256 x 256
      </div>
  </div>
  <div class="control-group" data-bind="validationElement: email">
    <label class="control-label" for="inputEmail">
      Email
    </label>
    <div class="controls">
      <input type="email" id="email" placeholder="Email" data-bind="value: email">
    </div>
  </div>
  <div class="control-group" data-bind="validationElement: guser">
    <label class="control-label" for="inputGUser">
      Group User
    </label>
    <div class="controls">
    <select id="guser" data-bind="value: guser">
    <?php
      if(isset($data['ID']))
    {
      if($groups)
      {
        echo '<option value="" selected="selected">==Pilih Group==</option>';
        foreach($groups as $groups)
        {
          $selected = ($data['GROUP_ID'] == $groups['ID']) ? 'selected="selected"' : '';

                echo '<option value="'.$groups['ID'].'" '.$selected.'>'.$groups['NAME'].'</option>';
        }
      }
    }
    else
    {
      if($groups)
      {
        echo '<option value="">==Pilih Group==</option>';
        foreach($groups as $groups)
        {
          echo '<option value="'.$groups['ID'].'">'.$groups['NAME'].'</option>';
        }
      }
    }
    ?>
    </select>
    </div>
  </div>
  
  <div class="controls-row">
      <div class="control-group pull-left" data-bind="validationElement: kd_skpd" >
        
		<label class="control-label" for="idskpd">SKPD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<input type="hidden" class="span2" id="idskpd" readonly="1" data-bind="value: idskpd, executeOnEnter: pilih_skpd" required />
        <input type="text" class="span2" id="kd_skpd" readonly="1" data-bind="value: kd_skpd, executeOnEnter: pilih_skpd" required />
		
        <input type="text" class="span6" id="nama_skpd" readonly="1" data-bind="value: nama_skpd, executeOnEnter: pilih_skpd" required />
        <span class="add-on" data-bind="visible: !isEdit() && canSave(),  click: pilih_skpd" ><i class="icon-folder-open"></i></span>
        
      </div>
    </div>	
	
	<!--
	<div class="controls-row" >
      <label class="control-label span2" for="jabatan">Jabatan</label>
      <div class="controls">
        <div class="control-group pull-left span5"  data-bind="validationElement: jabatan" data-bind="value: jabatan">
          <select id="jabatan" class="span3" data-bind="options:opsiJabatan, optionsValue:'kode', optionsText:'uraian', value:jabatan" />
		  <option value="">Pilih</option>
		  </select>
        </div>
      </div>
    </div>
	-->
	
  <div class="control-group">
    <div class="controls">
  <input type="submit" id="save" value="Simpan" class="btn btn-primary" data-bind="enable: canSave, click: save" />
   <input type="button" id="save" value="Kembali" class="btn btn-primary" data-bind="click: back" />
    </div>
  </div>
</form>
<script>
  var last;
  var purge = new Array();

  function refresh (timeoutPeriod)
  {
    refresh = setTimeout(function(){window.location.reload(true);},timeoutPeriod);
  }

  //ko
  ko.validation.init({
    insertMessages: true,
    decorateElement: true,
    errorElementClass: 'error',
  });

  var ModelUser = function (){
    var self = this;
    self.modul = 'User';
    self.akses_level = ko.observable(03);
    self.id = ko.observable('<?php echo isset($data['ID'])?$data['ID']:0 ?>');
    self.username = ko.observable('<?php echo isset($data['USERNAME'])?$data['USERNAME']:'' ?>')
      .extend({
        required: {params: true, message: 'Username tidak boleh kosong'}
      });
    self.email = ko.observable('<?php echo isset($data['EMAIL'])?$data['EMAIL']:'' ?>')
      .extend({
        required: {params: true, message: 'Email tidak boleh kosong'},
        email: {params: true, message: 'Alamat Email tidak valid'}
      });
    self.name = ko.observable('<?php echo isset($data['NAME'])?$data['NAME']:'' ?>');
    self.image = ko.observable('');
    self.url = '<?php echo base_url()."group/upload"; ?>';
    <?php
    if(!isset($data['ID']))
    {
    ?>
    self.passwd = ko.observable('')
      .extend({
        required: {params: true, message: 'Password tidak boleh kosong'},
    minLength: {params: 8, message: 'Password minimal 8 karakter'},
      });
    self.repasswd = ko.observable('')
      .extend({
        required: {params: true, message: 'Ulangi Password tidak boleh kosong'},
        equal: {params: self.passwd, message: 'Password harus sama'},
      });
    <?php
    }
    ?>
    self.status = ko.observable('<?php echo isset($data['STATUS'])?$data['STATUS']:'1' ?>');
    self.guser = ko.observable('<?php echo isset($data['GROUP_ID']) ? $data['GROUP_ID']:'' ?>')
      .extend({
        required: {params: true, message: 'Pilih Group'},
      });
	
	//self.jabatan = ko.observable('<?php echo isset($data['ID_JABATAN']) ? $data['ID_JABATAN'] : 0 ?>')

	
	self.idskpd = ko.observable('<?php echo isset($data['ID_SKPD']) ? $data['ID_SKPD'] : 0 ?>')
    self.kd_skpd = ko.observable('<?php echo isset($data['KODE_SKPD']) ? $data['KODE_SKPD'] : '' ?>')
      .extend({
        required: {params: true, message: 'Kode SKPD tidak boleh kosong'},
      });
    self.nama_skpd = ko.observable('<?php echo isset($data['NAMA_SKPD']) ? $data['NAMA_SKPD'] : '' ?>')
      .extend({
        required: {params: true, message: 'Nama SKPD tidak boleh kosong'},
    });  
	  
    self.displaypassword = ko.observable(false);
    <?php
    if(isset($data['ID']))
    {
    ?>
  /*self.old_passwd = ko.observable('')
    .extend({
      required: {params: true, message: 'Password Lama tidak boleh kosong', onlyIf: self.displaypassword},
        });
  self.passwd = ko.observable('')
    .extend({
      required: {params: true, message: 'Password baru tidak boleh kosong', onlyIf: self.displaypassword},
      minLength: {params: 8, message: 'Password minimal 8 karakter'},
        });
  self.repasswd = ko.observable('')
    .extend({
      required: {params: true, message: 'Ulangi Password baru tidak boleh kosong', onlyIf: self.displaypassword},
      equal: {params: self.passwd, message: 'Password harus sama'},
        });    */

  <?php
    }
  ?>

    self.mode = ko.computed(function(){
      return self.id() > 0 ? 'edit' : 'new';
    });

    self.title = ko.computed(function(){
      return (self.mode() === 'edit' ? 'Edit ' : 'Entri ') + self.modul;
    });

   self.isEdit = ko.computed(function(){
      return self.mode() === 'edit';
    });

  self.isEnable = ko.computed(function(){
      return self.mode() === 'edit';
    });

    self.canSave = ko.computed(function(){
      return self.akses_level() >= 3;
    });

    self.errors = ko.validation.group(self);
  }

  var App = new ModelUser();

  App.back = function(){
    location.href = root+modul;
  }

  App.save = function(){
    var $frm = $('#frm'),
      data = JSON.parse(ko.toJSON(App));

    if (!App.isValid()) {
      App.errors.showAllMessages();;
      return ;
    }

    var file = document.getElementById('image').files[0];
    var formData = new FormData($('form#frm')[0]);

    //tanpa image
    if(App.image() == "")
    {
      $.ajax(
            {
              url: $frm.attr('action'),
              type: 'post',
              dataType: 'json',
              data: data,
              success: function(res, xhr)
              {
                if (res.id) App.id(res.id);

                $.pnotify(
                  {
                    title: res.isSuccess ? 'Sukses' : 'Gagal',
                    text: res.message,
                    type: res.isSuccess ? 'info' : 'error'
                  });
              }
            });
    }
    //dengan image
    else
    {
      $.ajax(
        {
          url: App.url,
          type: 'post',
          dataType: 'json',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function(res)
          {
            $.pnotify(
              {
                title: res.isSuccess ? 'Sukses' : 'Gagal',
                text: res.message,
                type: res.isSuccess ? 'info' : 'error'
              });
            if(res.isSuccess == true)
            {
              $.ajax(
                {
                  url: $frm.attr('action'),
                  type: 'post',
                  dataType: 'json',
                  data: $.extend(data,{icon:res.filename}),
                  success: function(res, xhr)
                  {
                    if (res.id) App.id(res.id);

                    $.pnotify(
                      {
                        title: res.isSuccess ? 'Sukses' : 'Gagal',
                        text: res.message,
                        type: res.isSuccess ? 'info' : 'error'
                      });
                  }
                });
            }

          }
        });
    }
  }
	
	/*
    //Ditambah Singo Untuk Pilih Jabatan SKPD
  App.pilih_skpd = function(){
    if (!App.canSave() || App.isEdit()) { return; }
    var option = {multi:0, mode:'skpd'};
    Dialog.pilihSKPD(option, function(obj, select){
      var rs = $(obj).jqGrid('getRowData', select[0].id);
      App.idskpd(rs.id);
      App.kd_skpd(rs.kode);
      App.nama_skpd(rs.nama);
	  
	  $.getJSON(root+'group/get_jabatan_skpd/'+rs.id, function(data){
          if (data != null) {
			
            
            $.each(data, function(i,val) {
              var html = '<option value="'+i+'">'+val+'</option>';
			  $("#jabatan").append(html);
            });
			
          }
        });
	  
    });
  }
  //Ditambah Singo Untuk Pilih Jabatan SKPD
	*/
  
    //Ditambah Singo Untuk Pilih SKPD
  App.pilih_skpd = function(){
    if (!App.canSave() || App.isEdit()) { return; }
    var option = {multi:0, mode:'skpd'};
    Dialog.pilihSKPD(option, function(obj, select){
      var rs = $(obj).jqGrid('getRowData', select[0].id);
      App.idskpd(rs.id);
      App.kd_skpd(rs.kode);
      App.nama_skpd(rs.nama);
	  
	  $.getJSON(root+'group/get_jabatan_skpd/'+rs.id, function(data){
          if (data != null) {
			
            
            $.each(data, function(i,val) {
              var html = '<option value="'+i+'">'+val+'</option>';
			  $("#jabatan").append(html);
            });
			
          }
        });
	  
    });
  }
  //Ditambah Singo Untuk Pilih SKPD 	
  
  App.hapus_icon = function(){
    var agree=confirm("Apakah Anda yakin akan menghapus icon?");
    if(agree)
    {
      $.ajax(
            {
              url: '<?php echo base_url()?>group/icon',
              type: 'post',
              dataType: 'json',
              data: {id:App.id()},
              success: function(res, xhr)
              {
                if (res.id) App.id(res.id);

                $.pnotify(
                  {
                    title: res.isSuccess ? 'Sukses' : 'Gagal',
                    text: res.message,
                    type: res.isSuccess ? 'info' : 'error'
                  });
                  refresh('2400');
              }
            });
    }

  }

  ko.applyBindings(App);

</script>