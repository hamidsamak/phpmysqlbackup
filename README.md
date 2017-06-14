# PHP MySQL Backup

PHP MySQL Database Backup is a very simple and clean class for creating backup from MySQL databases.



### Example
```php
require_once 'phpmysqlbackup.class.php';
$phpmysqlbackup = new PHPMySQLBackup('localhost', 'root', '', 'database');
$phpmysqlbackup->backup();
```


### Options

1. Custom backup file name
```php
$phpmysqlbackup->file = 'custom-file-name.sql';
```

2. GZip compression
```php
$phpmysqlbackup->compress = true;
```

3. Add `DROP TABLE IF EXISTS` query before `CREATE TABLE`
```php
$phpmysqlbackup->drop_if_exists = true;
```

4. Custom table to backup
```php
$phpmysqlbackup->tables = array('table_1', 'table_2');
```

5. Backup file path
```php
$phpmysqlbackup->path = 'backup-dir/';
```
