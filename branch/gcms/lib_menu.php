<?

/* ========== LIBRARY UNTUK MENU dan sekitarnya =============================================================== */

/**
 * konversi dari mod dan func ke page
 */

/* -- internal use only -- */
function get_page_from_mod_int($mod, $func) {
  $csql="select m.* from ".PREFIX."frontmenus m where m.cfunction='".$func."'";
  $nresult=gcms_query($csql);
	$omenu=gcms_fetch_object($nresult);
  if (!$omenu->cfunction) {
    $csql="select m.* from ".PREFIX."frontmenus m where m.cfunction='m_".$mod."_".$func."'";
    $nresult=gcms_query($csql);
  	$omenu=gcms_fetch_object($nresult);
  }
  return $omenu;
}

function get_page_from_mod($mod, $func) {
  return get_page_from_mod_int($mod, $func)->nid;
}

/* menyusun menu */
function build_menu($omenu) {
  $nm = str_replace(".", "_", str_replace("-", "_", str_replace(" ", "_", stripslashes($omenu->cmenu))));
  if ($omenu->width == 0 ) $omenu->width = 'screen.availWidth';
  if ($omenu->height == 0) $omenu->height = 'screen.availHeight';
  if ($omenu->is_main == 1) return "index.php?page=".$omenu->nid;
  if ($omenu->is_main == 2) return "javascript:gcms_open_form('form.php?page=".$omenu->nid."','".$nm."',".$omenu->width.",".$omenu->height.")";
  if ($omenu->is_main == 3) return "javascript:gcms_open_form('page=".$omenu->nid."','".$omenu->cfunction."','".$nm."',".$omenu->width.",".$omenu->height.")";
  if ($omenu->is_main == 4) return "javascript:gcms_open_report('form.php?page=".$omenu->nid."','".$nm."',".$omenu->width.",".$omenu->height.")";
  else return "javascript:gcms_open_form('form.php?page=".$omenu->nid."','".$nm."',".$omenu->width.",".$omenu->height.")";
}

/* ambil menu link sesuai mod dan func */
function get_menu_link_from_mod($mod, $func) {
  $omenu = get_page_from_mod_int($mod, $func);
  if ($omenu->nid) return build_menu($omenu);
  else return "";
}

/**
 * Mengambil data menu
 */
function load_menu() {
 	$csql="select a.nid,a.bhide,a.cgroup from ".PREFIX."groupfrontmenus a order by a.nurut, a.cgroup";
	$nresult=gcms_query($csql);
  	$i = 0;
  	$menus = array();
	while($ogroup=gcms_fetch_object($nresult)) {
		if(b_admin(b_getuserlogin())){
			$cwhere="where a.nid_groupfrontmenus='".$ogroup->nid."' and a.BHIDE=0";
			
		}
		else{				 
			$cwhere="left join ".PREFIX."grantedfrontmenus as b on a.nid=b.nid_frontmenus
		       							where a.nid_groupfrontmenus='".$ogroup->nid."'  and 
			         					(b.nid_users='".b_getuserlogin()."' or a.bsecure=0)";		       							
		}
		//$csql="select a.* from ".PREFIX."frontmenus as a $cwhere order by a.nurut, a.cmenu";
		$csql="select a.nid,a.is_main,a.bsecure,a.bhide,a.cmenu,a.width,a.height,a.nid_header from ".PREFIX."frontmenus as a $cwhere order by a.nid_header, a.NURUT";
		
		$nresult2=gcms_query($csql); 
		if(gcms_fetch_row($nresult2)) {
			if($ogroup->bhide==0) {
        		$menus[$i][0] = str_replace(" ","&nbsp;",stripslashes($ogroup->cgroup));
        		$j = 1; $k=0; $id_lama=' '; $flag_g='';
				$nresult2=gcms_query($csql);
				while ($omenu=gcms_fetch_object($nresult2)) {	
					if($omenu->bsecure and b_logged() and $omenu->bhide==0) {
						$nm = str_replace(".", "_", str_replace("-", "_", str_replace(" ", "_", stripslashes($omenu->cmenu))));
            			if (!$omenu->width) $omenu->width = 700;
            			if (!$omenu->height) $omenu->height = 500;
						if (!empty($omenu->nid_header)){
							if($omenu->nid_header!=$id_lama){
								if($flag_g==1) $j++;																
								$k=0;
								$nama_skpd = b_fetch("select cname from g_subgroupfrontmenus where nid=$omenu->nid_header");
								$menus[$i][$j][$k]=$nama_skpd;
								
								$flag_g=1;
							}
							$k++;
							$id_lama = $omenu->nid_header;
							if ($omenu->is_main) {
								$menus[$i][$j][$k][0]="index.php?page=".$omenu->nid;
							}else{
								$menus[$i][$j][$k][0]="javascript:gcms_open_form('form.php?page=".$omenu->nid."','".$nm."',".$omenu->width.",".$omenu->height.")";
							}
							$menus[$i][$j][$k][1]=stripslashes($omenu->cmenu);					
						}else{
            				if ($omenu->is_main) {
              					$menus[$i][$j][0] = "index.php?page=".$omenu->nid;
            				}else {
              					$menus[$i][$j][0] = "javascript:gcms_open_form('form.php?page=".$omenu->nid."','".$nm."',".$omenu->width.",".$omenu->height.")";
            				}
            				$menus[$i][$j][1] = stripslashes($omenu->cmenu);
							$j++;
							$flag_g=0;
						}
          			}
				}	
				//echo "</ul></td></tr></table><!--[if lte IE 6]></a><![endif]--></li>"; 
        		$i ++;
			}
		}
	}
  	return $menus; 
}


/** 
 * ambil path dari page yang bersangkutan
 */

// berdasarkan nama modul
function menu_get_path3($cname) {
		$csql="select cpath from ".PREFIX."moduls";
		$nresult=gcms_query($csql);
		while($opath=gcms_fetch_object($nresult)) {
			$ainfo=b_readinit(translate_modul_path(str_replace(".php",".init.php",strtolower($opath->cpath))));
			if (strtolower($ainfo['name']) == strtolower($cname)) return strtolower($opath->cpath);
		}
}

// berdasarkan potongan nama
function menu_get_path2($ctemp) {
  	$csql="select cpath from ".PREFIX."moduls";
	
	$nresult=gcms_query($csql);
    while($xpage = gcms_fetch_object($nresult)) {
      $a = substr($xpage->cpath, strrpos($xpage->cpath, "/") + 1);
      $a = substr($a, 0, strrpos($a, "."));
      if (strpos($ctemp, $a) === 0) {
        $ctemp = $a;
      };
    }
	$csql="select cpath from ".PREFIX."moduls where cpath like '%".$ctemp.".php'";
	
	return strtolower(b_fetch($csql));
	
}

// berdasarkan page
function menu_get_path($cpage) {
	if(b_antisqlinjection($cpage) and $cpage<>"") {
		if(b_admin(b_getuserlogin()))
			$csql="select m.*, 4 as lvl from ".PREFIX."frontmenus m where m.nid='".$cpage."'";
		else
			$csql="select a.*, b.nstatus as level from ".PREFIX."frontmenus as a
		       left join ".PREFIX."grantedfrontmenus as b on a.nid=b.nid_frontmenus
		       where a.nid='".$cpage."' and 
		       (b.nid_users='".b_getuserlogin()."' or a.bsecure=0)";
		
		$nresult=gcms_query($csql);
		$opage=gcms_fetch_object($nresult);	
		// get user level
		define('USERLEVEL',$opage->lvl);
		// get path extension
		$ctemp=substr($opage->cfunction,2,strlen($opage->cfunction)-2);
		
		return menu_get_path2($ctemp);
		//echo menu_get_path2($ctemp);
		
	}
	else return "";
}

/**
 * Mendapatkan init pada <head></head> berdasarkan menu yang dipilih
 *
 * @param string $cpage
 */

function menu_get_init2($path) {
    menu_get_dependencies2($path);
		$initfile=translate_modul_path(str_replace(".php",".init.php",$path));
		$GLOBALS['bv_pathextension']=dirname($initfile)."/";
		define('PATHEXTENSION',dirname($initfile)."/");
		b_include($initfile);
}

function menu_get_init($cpage) {
  $path = menu_get_path($cpage);
	if($path) {
    menu_get_init2($path);
	  menu_load_lib($path);
  }
}

function menu_get_init_by_mod($mod) {
  $path = menu_get_path2($mod);
	if($path) {
    menu_get_init2($path);
	  menu_load_lib($path);
  }
}

/* load library */
function menu_load_lib($path) {
		$libfile=translate_modul_path(str_replace(".php",".lib.php",$path));
		if (!is_file ($libfile)) return "" ;
		require_once($libfile);
}

/**
 * ambil dependensi modul - baik init maupun lib-nya
 */
function menu_get_dependencies2($cpath) {
	$ainfo=b_readinit(translate_modul_path(str_replace(".php",".init.php",strtolower($cpath))));
	if(trim($ainfo['dependency'])<>"") {
		$adependency=explode(",",$ainfo['dependency']);
		foreach($adependency as $cmodul) {
      if (trim($cmodul)) {
        $path = menu_get_path3(trim($cmodul));
        menu_get_init2($path);    
    	  menu_load_lib($path);
      }
    }
	}
}

function menu_get_dependencies($cpage) {
  $path = menu_get_path($cpage);
  if ($path) menu_get_dependencies2($path);
}

/**
 * Mendapatkan content berdasarkan menu yang dipilih
 *
 * @param string $cpage
 */

/* ambil fungsinya */
function menu_get_func($cpage) {
  if(b_antisqlinjection($cpage) and $cpage<>"") {
	  $csql="select m.* from ".PREFIX."frontmenus m where m.nid='".$cpage."'";
		$nresult=gcms_query($csql);
		$opage=gcms_fetch_object($nresult);	

		// get user level - dummy : TO BE DELETED !!!
    define('USERLEVEL', 4);
    // ------------------------------

	  $aparam=explode(",",stripslashes($opage->cparam));
		$cparam=(count($aparam)>1)?$aparam:stripslashes($opage->cparam);

		return  array($opage->cfunction, $cparam);
	}
  else return "";
}

/* berdasar page */
function menu_get_content($cpage) {
  $path = menu_get_path($cpage);
	if($path) {
		$GLOBALS['bv_pathextension']=dirname($path)."/";
		define('PATHEXTENSION',dirname($path)."/");
    menu_load_lib($path);
    $func = menu_get_func($cpage);
		if(function_exists($func[0])) call_user_func($func[0], $func[1]);
	}
}

/* ambil konten berdasar mod dan func */
function menu_get_content_by_mod($mod, $func) {
  $path = menu_get_path2($mod);
	if($path) {
		$GLOBALS['bv_pathextension']=dirname($path)."/";
		define('PATHEXTENSION',dirname($path)."/");
    menu_load_lib($path);
		if(function_exists($func)) call_user_func($func, "");
		else if(function_exists("m_".$mod."_".$func)) call_user_func("m_".$mod."_".$func, "");
	}
}

/**
 * Mendapatkan title berdasarkan menu yang dipilih
 *
 * @param string $cpage
 * @return unknown
 */
function menu_get_title($cpage) {
	if(b_antisqlinjection($cpage) and $cpage<>"") {
		if(b_admin(b_getuserlogin()))
			$csql="select * from ".PREFIX."frontmenus where nid='".$cpage."'";
		else
			$csql="select a.* from ".PREFIX."frontmenus as a
		       left join ".PREFIX."grantedfrontmenus as b on a.nid=b.nid_frontmenus
		       where a.nid='".$cpage."' and 
		       (b.nid_users='".b_getuserlogin()."' or a.bsecure=0)";
		$nresult=gcms_query($csql);
		$opage=gcms_fetch_object($nresult);
		if($opage->nid_header!='') $csql="select cname from ".PREFIX."subgroupfrontmenus where nid='".$opage->nid_header."'";
		else $csql="select cgroup from ".PREFIX."groupfrontmenus where nid='".$opage->nid_groupfrontmenus."'";
		$creturn=b_fetch($csql)." - ".$opage->cmenu;
		return $creturn;	
	}
}

/**
 * Mendapatkan hasil request berdasarkan menu yang dipilih
 *
 * @param string $cpage
 */
function menu_get_request($cpage) {
	
	$path = menu_get_path($cpage);

	if($path) {
		$reqfile=translate_modul_path(str_replace(".php",".request.php",$path));
		include $reqfile;
	}
}

function ajax_request($cpage){
	$path = menu_get_path($cpage);
	if($path) {
		$reqfile=translate_modul_path(str_replace(".php",".asyc.php",$path));
    	include $reqfile;
	}
}

function menu_get_request_by_mod($mod) {
  $path = menu_get_path2($mod);
	if($path) {
		$reqfile=translate_modul_path(str_replace(".php",".request.php",$path));
    include $reqfile;
	}
}



?>