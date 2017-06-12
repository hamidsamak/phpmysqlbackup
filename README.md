# PHP MySQL Backup

PHP MySQL Database Backup is a very simple and clean class for creating backup from MySQL databases.



### Example
```php
require_once 'phpmysqlbackup.class.php';
$phpmybackup = new PHPMyBackup('localhost', 'root', '', 'database');
$phpmybackup->backup();
```


### Options

1. Custom backup file name
```php
$phpmybackup->file = 'custom-file-name.sql';
```

2. GZip compression
```php
$phpmybackup->compress = true;
```

3. Add `DROP TABLE IF EXISTS` query before `CREATE TABLE`
```php
$phpmybackup->drop_if_exists = true;
```

4. Custom table to backup
```php
$phpmybackup->tables = array('table_1', 'table_2');
```

5. Backup file path
```php
$phpmybackup->path = 'backup-dir/';
```
