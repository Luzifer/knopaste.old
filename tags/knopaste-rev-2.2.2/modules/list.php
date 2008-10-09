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

$allpastes = mysql_query("SELECT * FROM $mysql[4] ORDER BY id DESC");
$content .= "<table>";
$content .= "<tr><td></td><td><strong>ID</strong></td><td><strong>".ZEILEN."</strong></td><td><strong>".DATUM."</strong></td>";
$content .= "<td><strong>".NAME."</strong></td><td><strong>".DESC."</strong></td></tr>";
while($paste = mysql_fetch_assoc($allpastes)) {
	$content .= "<tr><td><a href=\"?module=show&amp;id=".$paste['id']."\">[".ANZEIGEN."]</a></td>";
	$content .= "<td>".$paste['id']."</td><td>".$paste['lin']."</td><td>".date("d.m.Y H:i", $paste['time'])."</td><td>".htmlentities($paste['name'])."</td>";
	$content .= "<td>".htmlentities($paste['des'])."</td></tr>";
}
$content .= "</table>";
?>
