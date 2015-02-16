<?php 

/**
* @file
*
* All Callblaster code is released under the GNU General Public License.
* See COPYRIGHT.txt and LICENSE.txt.
*
*....................
* www.nethram.com
*/

$controller='controller';
$application="application";
load_controller($controller,$application);

function load_controller($file,$dir){
	
	
	$pages=scandir($dir,0);
    		unset ($pages['0'],$pages['1']);
    			if (in_array($file.'.php', $pages)){
        		include ($dir.'/'.$file.'.php');}
				else{
					echo"No controller named ".$file." in directory".$dir;
					}
	}

?>

