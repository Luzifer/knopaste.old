<?php


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
 * Class to handle pastes and to generate the pasteform
 */

class pastehandler {
	private $config;

	public function __construct($conf) {
		/*
		 * Assign global config-object to the local version
		 */
		$this->config = $conf;
	}

	private function generate_hashname() {
		/*
		 * Generates a short (6 letter) name for the pastes
		 */
		return substr(base64_encode(md5(time())), 0, 6);
	}

	public function create_pasteview($pastename) {
		/*
		 * Generates a html-output from the pastefiles
		 */
		if (preg_match("/^.*\.txt$/", $pastename)) {
			# If the textversion of the paste is wanted show it!
			header("Content-Type: text/plain");
			echo file_get_contents($this->config->pastepath . $pastename);
			die();
		} else {
			# Put out the html-version of the paste
			return file_get_contents($this->config->pastepath . $pastename);
		}
	}
	public function create_paste($values) {
		/*
		 * Generates the pastefile from input
		 */
		$thispastename = $this->generate_hashname();
		if ($this->config->usetextfile) {
			file_put_contents($this->config->pastepath . "$thispastename.txt", rtrim(stripcslashes($values['paste'])));
		}
		$entry = "";
		$paste = rtrim(stripcslashes($values['paste']));
		$path = "classes/geshi/";
		$geshi = new GeSHi($paste, $values['lang'], $path);
		$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
		$entry = $geshi->parse_code();
		$entry = str_replace("</span></div>", "</span>&nbsp;</div>", $entry);
		file_put_contents($this->config->pastepath . "$thispastename", $entry);
		header("Location: ?$thispastename");
	}

	public function create_pasteform() {
		/*
		 * Returns html-code for the pasteform
		 */
		$form = "<form action=\"?\" method=\"post\">" .
		"<table style=\"width: 100%;\">";

		$form .= "<tr><td style=\"width: 50px;\">Syntax:</td><td><select name=\"lang\" size=\"1\">";
		$langdir = dir("./classes/geshi/");
		$langarray = array ();
		while ($file = $langdir->read()) {
			if (preg_match("/^.*\.php$/", $file)) {
				$lang = substr($file, 0, strlen($file) - 4);
				$langarray[] = $lang;
			}
		}
		sort($langarray); # ...sort them...
		foreach ($langarray as $lang) {
			if ($lang != "text")
				$form .= "<option value=\"$lang\">$lang</option>\n"; # ...and put them into a listbox
			else
				$form .= "<option value=\"$lang\" selected>$lang</option>\n"; # ...and put them into a listbox
		}
		$form .= "</select></td></tr>";

		$form .= "<tr><td>Paste:</td><td><textarea rows=\"25\" cols=\"10\" name=\"paste\" style=\"width: 100%; height: 100%;\"></textarea></td></tr>" .
		"<tr><td></td><td><input type=\"submit\" value=\"Submit\" /></td></tr>" .
		"</table>" .
		"</form>";
		return $form;
	}
}
?>
