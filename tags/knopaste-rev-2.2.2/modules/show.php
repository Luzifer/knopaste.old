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

$paste = mysql_fetch_assoc(mysql_query("SELECT * FROM $mysql[4] WHERE id = $id"));

$content .= date("d.m.Y H:i", $paste['time'])." ".VON." ".htmlentities($paste['name'])."<br />";
$content .= htmlentities($paste['des'])."<br />";

$content .= "<table>";
$content .= "<tr><td valign=\"top\" class=\"rightline\"><pre>";
	$numbers = file_get_contents("numern.txt");
	$content .= substr($numbers, 0, strpos($numbers, $paste['lin'])+strlen($paste['lin']));
$content .= "</pre></td><td valign=\"top\"><pre>";
	
	$content .= htmlentities(file_get_contents("pastes/".$paste['entryfile']));
$content .= "</pre></td></tr>";
$content .= "</table>";
?>
