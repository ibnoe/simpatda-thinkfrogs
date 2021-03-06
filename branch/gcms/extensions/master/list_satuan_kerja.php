<?
$expath = ".".str_replace("\\", "/", str_replace(realpath("."), "", dirname(__FILE__)))."/";
?>
<script>
var lastsel;
jQuery(document).ready(function(){ 
  jQuery("#htmlTable").jqGrid({
    url:'<?php echo $expath ?>master_request.php?sender=list_satuan_kerja',
	editurl:'<?php echo $expath ?>master_request.php?oper=edit',
    datatype: 'json',
    mtype: 'POST',
    colNames:['id','Instansi','Urusan','Bidang','Kode','Nama','NPWP','Bidang Tambahan'],
    colModel :[{
		name:'id'
		,index:'id'
		,width:20
        ,search:false
	}/*,{
		name:'check'
		,index:'check'
		,width:80
		,editable:true
        ,edittype:'checkbox'
       
	}*/,{
		name:'Intansi'
		,index:'Intansi'
		,width:200
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    },{
		name:'Urusan'
		,index:'Urusan'
		,width:200
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    },{
		name:'Bidang'
		,index:'Bidang'
		,width:200
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    },{
		name:'Kode'
		,index:'Kode'
		,width:150
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    },{
		name:'Nama'
		,index:'Nama'
		,width:200
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    },{
		name:'NPWP'
		,index:'NPWP'
		,width:150
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    },{
		name:'BidangTambahan'
		,index:'BidangTambahan'
		,width:150
		,align:'left'
		,editable:true
        ,edittype:'text'
        ,editoptions: {size:80, maxlength: 200}
        ,editrules: {required:true}
    }],
    pager: jQuery('#htmlPager'),
    height:350,
    rowNum:15,
    rowList:[15,30,45],
    shrinkToFit:false,
    sortname: 'id',
    sortorder: 'asc',
    viewrecords: true,
    caption: 'SKPD',
        onSelectRow: function(id){ 
            if(id && id!==lastsel){ 
                jQuery("#htmlTable").restoreRow(lastsel); 
                jQuery("#htmlTable").editRow(id,true); 
                lastsel=id; 
                }
             },
        gridComplete: function(){
                jQuery("#htmlTable").setGridWidth( document.width - 160 < 300?300:document.width - 160);
                return true;
            }
    }).navGrid('#htmlPager'
        ,{add:true,edit:false,del:true}
        ,{} // edit
        ,{height:120,  width:500} // add
        ,{} // del
        ,{} // search
        
        ).hideCol('id');  /*end of on ready event */ 
}
);


function ajaxdo_pilih_kelompok(bid){

        old_url = jQuery("#htmlTable").getGridParam("url");
        new_url = old_url + '?q=1&id_kelompok='+bid;
        jQuery("#htmlTable").setGridParam({url:new_url});
        jQuery("#htmlTable").trigger("reloadGrid");
        //jQuery("#htmlTable").setGridParam({url:old_url});

        jQuery.ajax({
           url:"<?php echo $expath ?>getnama.php",
           data:"bid=" +bid,
           success: function(html){            
                var indi = html;
                var nama = indi.split(';');
                for(var i=1; i<nama.length+1;i++){
                    var nama_ = nama[i-1].split(":");
                    if (trim(nama_[1]) == "") {
                        jQuery("#htmlTable").setLabel("indikator_"+i, "Indikator "+(i));
                    } else {
                        jQuery("#htmlTable").setLabel("indikator_"+i, nama_[1]);
                    }
                }
            }
        }
        );
        
    };
  
     
function hapusinfo(){
        el=document.getElementById("panel_1")
        el.style.display="none"

    };

function encrypt(eparams) {
    var sr = jQuery("#htmlTable").getGridParam('selrow');
    rowdata = jQuery("#htmlTable").getRowData(sr);
          return {id_kelompok: $( '#nid' ).val()};
};


function ajaxdo_proses(bid){
        var cdo='<?php echo $expath ?>asb.php?gid='+bid;
	//	alert( bid );
        ajax_do(cdo);
    }
    
function printReport(){
        var nameFile,template;
                nameFile="ASB";
                template="ASB.fr3";
        var key = "id="+document.getElementById('nid').value;
        var att = 1;
            fastReportStart(nameFile, template, 'pdf', key, att);
    }    
    
function printDaftar(){
        var nameFile,template;
                nameFile="LIST_ASB";
                template="LIST_ASB.fr3";
        var key = "id="+document.getElementById('nid').value;
        var att = 1;
            fastReportStart(nameFile, template, 'pdf', key, att);
    }

function customFormat(cData){
    cData = cData + "";
    var so = opsiSKPD.split(';');
    var sv = [];
    var ret = '';
    for(var i=0; i<so.length;i++){
        sv = so[i].split(":");
        if($.trim(sv[0]) == $.trim(cData)) {
            ret = sv[1];
            break;
        }
        if($.trim(sv[1]) == $.trim(cData)) {
            ret = sv[1];
            break;
        }
    }
    return ret;
}

var updateTotal = function(id){
     jQuery('#'+id+"_"+"pegawai").change(function(){
        var modal = 0;
        var barang = 0;
        modal = jQuery("#"+id+"_modal").val();
        barang = jQuery("#"+id+"_barang_jasa").val();
        
        jQuery("#htmlTable").setCell(id, 'total', parseFloat(this.value) + parseFloat(modal) + parseFloat(barang));
     }
     );
     jQuery('#'+id+"_"+"barang_jasa").change(function(){
        var modal = 0;
        var barang = 0;
        modal = jQuery("#"+id+"_modal").val();
        pegawai = jQuery("#"+id+"_pegawai").val();
        
        jQuery("#htmlTable").setCell(id, 'total', parseFloat(this.value) + parseFloat(modal) + parseFloat(pegawai));
     }
     );
     jQuery('#'+id+"_"+"modal").change(function(){
        var modal = 0;
        var barang = 0;
        pegawai = jQuery("#"+id+"_pegawai").val();
        barang = jQuery("#"+id+"_barang_jasa").val();
        
        jQuery("#htmlTable").setCell(id, 'total', parseFloat(this.value) + parseFloat(pegawai) + parseFloat(barang));
     }
     );
}

function ajaxdo_set_label (bid){
 jQuery("#htmlTable").setCell(id_kelompok, 'indikator_1', parseFloat(this.value));

}
</script>

<?php 
//echo $_REQUEST['page'];
//$id = isset($_POST['nid'])?$_POST['nid']:getFirstKelompok();

$asb = array();
?>
<form action="" method="POST">
        <table>	
		<input type='hidden' name='csubmit' value='new'>
            <tr>
  		    <td><b>Satuan Kerja : &nbsp;</b></td>	
			  <td><select id="nid" name="nid" title="Kelompok" width onChange="ajaxdo_pilih_kelompok(this.value);hapusinfo()">
              <?php echo getKel($id, $indi); 
              ?>                        
  
			  </select>
                </td>			
            </tr>

		</table>
        <br></br>

<table id="htmlTable" class="scroll"></table>
<div id="htmlPager" class="scroll"></div>

   <div id="container_ss">
    <div id="panel_1" name ="panel_1" style = "display : hide;">
    
    <?php
    
    if(isset($_POST['proses'])) {
             ?>
        
            <div id="panel_2" >
            <?php 
            $ListSatuanKerja = getListSatuanKerja($id);              
            echo TampilSatuanKerja($ListSatuanKerja); 
            ?></div> <!-- panel_2 -->
        
    </div><!-- panel_1 -->
        <?php
        }  
       
     ?>
    
</div><!-- container -->
</form>
<script>
function func_Baru(){
//alert('baru');
gcms_open_form("form.php?page="+<?=$_REQUEST['page']?>+'&action=tambah',"MasterSatuanKerja",600,800);
//gcms_open_form("form.php?action=edit&id="+oRecord.getData("id")+'&page='+oRecord.getData("edit1")+'&spbu='+oRecord.getData("idspbu"),"rincian",600,800);
}
function func_Edit(){
alert('Edit');
}
function func_Hapus(){
alert('Hapus');
}
function func_Cetak(){
alert('Cetak');
}
function func_Simpan(){
alert('Simpan');
}
function func_Keluar(){
alert('keluar');
}
</script>