<?


#
# K-Nopaste - Free Nopaste-System
# Copyright (C) 2005-2006  Knut Ahlers
#
# This program is free software; you can redistribute it and/or modify it under the terms of the GNU General 
# Public License as published by the Free Software Foundation; either version 2 of the License, or (at your 
# option) any later version.
# 
# This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the 
# implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for 
# more details.
# 
# You should have received a copy of the GNU General Public License along with this program; if not, write to the 
# Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
#

/*
 * Mainscript to decide which module is loaded
*/

$content = "";

# Load configuration
if (is_file("config.php") && is_readable("config.php")) {
	include ("config.php");
} else {
	die("ERROR: CONFIGFILE NOT FOUND!<br />");
}

# Load pasteengine
if (is_file("classes/pastehandler.php") && is_readable("classes/pastehandler.php")) {
	include ("classes/pastehandler.php");
	$pengine = new pastehandler($config);
} else
	die("ERROR: Pasteengine not found. Renew your complete copy of K-Nopaste!");

# Generate main menuentries
$tl_links = "<span class=\"tl_links\"><a href=\"?\">Create new paste</a></span>";

# Get a list of pastes availiable
if (!is_dir($config->pastepath) || !is_writable($config->pastepath))
	die("ERROR: Pastedir is not availiable / writable. Please check!");
else {
	$pdir = dir($config->pastepath);
	$availfiles = array ();
	while ($file = $pdir->read()) {
		if(((filemtime($config->pastepath.$file) + ($config->pastetime * 3600)) < time()) && !is_dir($config->pastepath.$file))
			unlink($config->pastepath.$file); # Delete pastes which are too old
		else
			$availfiles[] = $file;
	}
}

# Try to get pastename and rise the action to generate the output
if ($_SERVER['QUERY_STRING'] != "") {
	if (in_array($_SERVER['QUERY_STRING'], $availfiles)) {
		$content = $pengine->create_pasteview($_SERVER['QUERY_STRING']);
		if ($config->usetextfile)
			$tl_links .= "<span class=\"tl_links\"><a href=\"?" . $_SERVER['QUERY_STRING'] . ".txt\">Download as text</a></span>";
	} else
		$content = "This paste does not longer exist. Pastes are stored for " . $config->pastetime . " hours.";
} else {
	if (isset ($_POST['paste']) && ($_POST['paste'] != "")) {
		# If wanted load geshi
		if (is_file("classes/geshi.php") && is_readable("classes/geshi.php")) {
			include ("classes/geshi.php");
		} else
		die("ERROR: Highlight-engine not found. Please get a newer copy of K-Nopaste!");
		$pengine->create_paste($_POST);
	} else
		$content = $pengine->create_pasteform();
}

# Set version of the script and create the sitetitle
$version = "K-Nopaste 3.0.0";
$title = $config->sitetitle . " ($version)";

# Insert content to template and display the site
$template = file_get_contents("templates/" . $config->template . ".html");
$template = str_replace("%title%", $title, $template);
$template = str_replace("%tl_links%", $tl_links, $template);
$template = str_replace("%mainlayer%", $content, $template);
$template = str_replace("%VERSION%", $version, $template);

echo $template;
?>
