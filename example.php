<?php

require_once 'phpmysqlbackup.class.php';

$phpmysqlbackup = new PHPMySQLBackup('localhost', 'root', '', 'database');

$phpmysqlbackup->backup();

?>