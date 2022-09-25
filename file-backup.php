<?php
	$files = scandir('BACKUP_DIR', SCANDIR_SORT_DESCENDING);
	$newest_file = $files[0];
	echo 'BACKUP_DIR/'.$newest_file;
?>