<?php
	$arquivo = isset($_POST['arquivo']) ? $_POST['arquivo'] : "";
	unlink('BACKUP_DIR/'.$arquivo);
	
	$path = new DirectoryIterator('BACKUP_DIR/');
	$files = array();
	foreach($path as $directory) {
		if($directory->isDot()) continue;
			$files[$directory->getCTime()] = $directory->__toString();
	}
	krsort($files);
	foreach($files as $k => $v) {
		echo '<tr>';
			echo '<td>'.$v.'</td>';
			echo '<td><input type="radio" id="arquivo" name="arquivo" value="'.$v.'"></td>';
		echo '</tr>';
	}
?>