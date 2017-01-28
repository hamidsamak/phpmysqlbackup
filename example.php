<?php

require_once 'phpmysqlbackup.class.php';

$phpmybackup = new PHPMyBackup('localhost', 'root', '', 'database');

$phpmybackup->backup();

?>