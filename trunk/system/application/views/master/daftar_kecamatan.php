<?php
$value="'':''";
?>
<script type="text/javascript"> 
var lastsel;
jQuery(document).ready(function(){ 
	jQuery("#htmlTable").jqGrid({
		url:'<?php echo site_url('master/kecamatan/daftar')?>', 
		editurl:'<?php echo site_url('master/kecamatan/daftar')?>', 
		datatype: 'json',
		mtype: 'POST',
		colNames:['id', 'Kode', 'Nama' ],
		colModel :[{
			 name:'id'
			,index:'id'
			,search:false
			,width:20
		},{
			name:'camat_kode'
			,index:'camat_kode'
			,width:50
			,editable:true
			,edittype:'text'
			,editoptions: {size:10, maxlength: 10}
			,editrules: {required:true}
		},{
			name:'camat_nama'
			,index:'camat_nama'
			,width:200
			,editable:true
			,edittype:'text'
			,editoptions: {size:50, maxlength: 50}
			,editrules: {required:true}
		}],
		rowNum:10, 
		rowList:[10,20,30], 		
		pager: jQuery('#htmlPager'),
		height:300,
		viewrecords: true, 
		multiselect: true,
		altrow: true,
		rownumbers: true, 
		sortorder: "asc", 
		width: 800,
		height: 230,
		caption:"Daftar Kecamatan",
        onSelectRow: function(id){ }
    }).navGrid('#htmlPager'
        ,{view:true,add:true,edit:true,del:true,viewtext:"Lihat",searchtext:"Cari",addtext:"Tambah",deltext:'Hapus',edittext:'Ubah',refreshtext:'Refresh'}
        ,{closeOnEscape:true, width:600,afterSubmit:checkError} // edit
        ,{closeOnEscape:true, width:600,afterSubmit:checkError} // add
        ,{closeOnEscape:true,reloadAfterSubmit:false,afterSubmit:checkError} // del 
        ,{closeOnEscape:true,closeAfterSearch: true} // multipleSearch:true,		
    ).hideCol('id');
	
	function checkError(response, postdata) {
		var success = true;
		var message = ""
		var json = eval('(' + response.responseText + ')');
		if(json.errors) {
			success = false;
			for(i=0; i < json.errors.length; i++) {
				message += json.errors[i];
			}
		}
		var new_id = json.id;
		return [success,message,new_id];
	}	

});
</script>
<table id="htmlTable" class="scroll"></table>
<div id="htmlPager" class="scroll"></div>