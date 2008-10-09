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

if(!@include("config.php")) $content = "ERROR: CONFIGFILE NOT FOUND!<br />";
if(!@include("languages/$lang.php")) $content = "ERROR: LANGUAGEFILE NOT FOUND!<br />";
$version = "K-Nopaste 2.2.2";

mysql_connect($mysql[0], $mysql[1], $mysql[2]);
mysql_select_db($mysql[3]);

switch($module) {
case "new":
	include("modules/new.php");
	break;
case "show":
	if(!is_numeric($id) || !$id) header("Location: index.php?module=list");
	include("modules/show.php");
	$title = TI_SHOW;
	break;
case "download":
	if(!is_numeric($id) || !$id) header("Location: index.php?module=list");
	$content .= C_DL;
	include("modules/download.php");
	$title = TI_DL;
	break;
case "hilight":
	if(!is_numeric($id) || !$id) header("Location: index.php?module=list");
	$content .= C_HL;
	include("modules/hilight.php");
	$title = TI_HL;
	break;
case "list":
	$content .= C_LIST;
	include("modules/list.php");
	$title = TI_LIST;
	break;
case "impressum":
	$content .= nl2br(file_get_contents("impressum.txt"));
	$title = IMPR;
	break;
default: header("Location: index.php?module=new");
}

$tl_links = "<span class=\"tl_links\"><a href=\"index.php?module=new\">".NEU."</a></span>";
$tl_links .= "<span class=\"tl_links\"><a href=\"index.php?module=show&amp;id=$id\">".ANZEIGEN."</a></span>";
$tl_links .= "<span class=\"tl_links\"><a href=\"index.php?module=hilight&amp;id=$id\">".HL."</a></span>";
$tl_links .= "<span class=\"tl_links\"><a href=\"index.php?module=download&amp;id=$id\">".DOW."</a></span>";
$tl_links .= "<span class=\"tl_links\"><a href=\"index.php?module=list\">".LIS."</a></span>";
$tl_links .= "<span class=\"tl_links\"><a href=\"index.php?module=impressum\">".IMPR."</a></span>";
			 

$template = file_get_contents("templates/activated");
$template = str_replace("%title%", $title, $template);
$template = str_replace("%tl_links%", $tl_links, $template);
$template = str_replace("%mainlayer%", $content, $template);
$template = str_replace("%VERSION%", $version, $template);
echo $template;
?>
