<?php

	$path = dirname(__FILE__);
	$tmpfile = fopen('cron.txt', 'w');
	$cron = "* * * * * /usr/bin/php -f " . $path . "/checkexpiry.php" . " &> /dev/null";
	fwrite($tmpfile, $cron);
	exec('crontab cron.txt');
	fclose($tmpfile);
	unlink('cron.txt');

?>