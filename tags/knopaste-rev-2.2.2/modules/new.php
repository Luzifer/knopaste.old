<?
//
// K-Nopaste - Free Nopaste-System
// Copyright (C) 2005  Knut Ahlers
//
// This program is free software; you can redistribute it and/or modify it under the terms of the GNU General 
// Public License as published by the Free Software Foundation; either version 2 of the License, or (at your 
// option) any later version.
// 
// This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the 
// implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for 
// more details.
// 
// You should have received a copy of the GNU General Public License along with this program; if not, write to the 
// Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
// 

if(($paste == "") && ($_FILES['file']['tmp_name'] == "")) {
	$title = TI_NEW;
	$content = NEWPASTE;
	$content .= "<form enctype=\"multipart/form-data\" action=\"index.php\" method=\"post\"><table>";
	$content .= "<tr><td>".NAME.":</td><td><input type=\"text\" name=\"name\" value=\"$KNopasteNAME\" /></td></tr>";
	$content .= "<tr><td>IP:</td><td>$REMOTE_ADDR</td></tr>";
	$content .= "<tr><td>".DESC.":</td><td><input type=\"text\" name=\"des\" /></td></tr>";
	$content .= "<tr><td>".QCFILE.":</td><td><input type=\"file\" name=\"file\" /></td></tr>";
	$content .= "<tr><td>".HLLANG.":</td><td><select name=\"lang\" size=\"1\">";
	
	$ava = file("ava_lang");
	foreach($ava as $lang) {
		$content .= "<option value=\"$lang\">$lang</option>";
	}
	
	$content .= "</select></td></tr>";
	$content .= "<tr><td>Paste:</td><td><textarea rows=\"20\" cols=\"120\" name=\"paste\"></textarea></td></tr>";
	$content .= "<tr><td></td><td><input type=\"submit\" value=\"".SUBMIT."\" /><input type=\"hidden\" name=\"module\" value=\"new\" /> ".NEWWARN."</td></tr>";
	
	$content .= "</table>";
	$content .= "</form>";
} else {
	$title = "Neuer Paste";
	if($name != "") setcookie("KNopasteNAME", "$name", time()+31536000);
	$tl_links = "<span class=\"tl_links_a\">New</span> ++ <span class=\"tl_links_de\">".ANZEIGEN."</span> ++ <span class=\"tl_links_de\">Hilight</span> ++ <span class=\"tl_links_de\">Download</span> ++ <a href=\"index.php?module=list\">List</a> ++ <a href=\"index.php?module=impressum\">Impressum</a>";
	$content = "".NEW1.":<br /><br />";
	if($_FILES['file']['tmp_name'] != "") {
		$content .= "".NEW2."<br />";
		$content .= "".NEW3."";
		$paste = "";
		$paste = file_get_contents($_FILES['file']['tmp_name']);
		if($paste != "") $content .= "".ERFOLG.".<br />"; else $content .= "".FEHLS."!<br />";
		
		$content .= "".NEW4."<br />";
		$posthash = md5(time());
		
		$content .= "".NEW5."";
		$p = fopen("pastes/$posthash", "w");
		if(fputs($p, $paste)) $content .= "".ERFOLG.".<br />"; else $content .= "".FEHLS."!<br />";
		fclose($p);
		
		$content .= "".NEW6."<br />";
		$nums = substr_count($paste, "\n") + 1;
		
		if($nums > 20000) $content .= "".NEW7."<br />";
		else {	
			if($name == "") $name = EMPTYNAME;
			if($des == "") $des = EMPTYDES;
			
			$content .= NEW8;
			$qry = "INSERT INTO $mysql[4] (ip,name,time,des,entryfile,lang_hi,lin) ";
			$qry .= "VALUES ('$REMOTE_ADDR','$name','".time()."','$des','$posthash','$lang','$nums');";
			if(mysql_query($qry)) $content .= ERFOLG.".<br />"; else $content .= FEHLS.". ".ERROR.":<br />".mysql_error();
			
			$content .= NEW9;
			$l = mysql_fetch_row(mysql_query("SELECT id FROM $mysql[4] WHERE entryfile = '$posthash'"));
			$content .= "$l[0]<br />";
			
			$content .= NEW10.": <a href=\"index.php?module=show&amp;id=$l[0]\">http://".$SERVER_NAME.$PHP_SELF."?module=show&amp;id=$l[0]</a>";
		}
		
	} else {
		$content .= NEW2."<br />";
		$paste = stripcslashes($paste);
		
		$content .= NEW4."<br />";
		$posthash = md5(time());
		
		$content .= NEW5."";
		$p = fopen("pastes/$posthash", "w");
		if(fputs($p, $paste)) $content .= ERFOLG.".<br />"; else $content .= FEHLS."!<br />";
		fclose($p);
		
		$content .= NEW6."<br />";
		$nums = substr_count($paste, "\n") + 1;
		
		if($nums > 20000) $content .= NEW7."<br />";
		else {
			if($name == "") $name = EMPTYNAME;
			if($des == "") $des = EMPTYDES;
			
			$content .= NEW8;
			$qry = "INSERT INTO $mysql[4] (ip,name,time,des,entryfile,lang_hi,lin) ";
			$qry .= "VALUES ('$REMOTE_ADDR','$name','".time()."','$des','$posthash','$lang','$nums');";
			if(mysql_query($qry)) $content .= ERFOLG.".<br />"; else $content .= FEHLS.". ".ERROR.":<br />".mysql_error();
			
			$content .= NEW9;
			$l = mysql_fetch_row(mysql_query("SELECT id FROM $mysql[4] WHERE entryfile = '$posthash'"));
			$content .= "$l[0]<br />";
			
			$content .= NEW10.": <a href=\"index.php?module=show&amp;id=$l[0]\">http://".$SERVER_NAME.$PHP_SELF."?module=show&amp;id=$l[0]</a>";
		}
	}
}
?>
