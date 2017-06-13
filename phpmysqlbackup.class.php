<?php

/**
 * PHP MySQL Database backup
 *
 * @package phpmysqlbackup
 * @author Hamid Samak <hamidreza.samak@gmail.com>
 * @copyright 2017 Hamid Samak
 * @license MIT
 */
class PHPMySQLBackup {
	public $file; // backup file name
	public $path = null; // backup file path
	public $compress = false; // gzip file compression
	public $drop_if_exists = true; // add DROP TABLE to queries
	public $tables = array(); // tables list to backup (empty array means all tables)

	public $error; // error debug

	private $db; // database connection

	public function PHPMySQLBackup($hostname, $username, $password, $database) {
		$this->db = mysqli_connect($hostname, $username, $password, $database);

		$this->file = 'backup-' . $database . '-' . date('YmdHis') . '.sql';
	}

	private function query($query) {
		$result = $this->db->query($query);
		$rows = array();

		while ($row = $result->fetch_assoc())
			$rows[] = $row;

		return count($rows) == 1 ? current($rows) : $rows;
	}

	public function backup() {
		$file_path = __DIR__ . DIRECTORY_SEPARATOR . $this->path . $this->file;

		file_put_contents($file_path, '');

		$tables = $this->query('SHOW TABLES');

		foreach ($tables as $row) {
			$table = current($row);

			if (count($this->tables) > 0 && in_array($table, $this->tables) === false)
				continue;

			if ($this->drop_if_exists === true)
				file_put_contents($file_path, 'DROP TABLE `' . $table . '` IF EXISTS;' . "\n\n", FILE_APPEND);

			$create_table = $this->query('SHOW CREATE TABLE `' . $table . '`');
			$create_table = next($create_table);

			file_put_contents($file_path, $create_table . ";\n\n", FILE_APPEND);

			$result = $this->db->query('SELECT * FROM `' . $table . '`');

			if ($result === false) {
				$this->error = $this->db->error;

				return false;
			}

			while ($row = $result->fetch_assoc()) {
				if (isset($columns) === false) {
					$columns = array_keys($row);
					$columns = array_map(function($value) { return '`' . $value . '`'; }, $columns);
				}

				if (isset($values) === false) {
					$values = array_values($row);
					$values = array_map(function($value) { return is_null($value) ? 'NULL' : '\'' . str_replace(array('\'', "\r", "\n", "\t"), array('\\\'', '\\\r', '\\\n', '\\\t'), $value) . '\''; }, $values);
				}

				file_put_contents($file_path, 'INSERT INTO `' . $table . '` (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')' . ";\n", FILE_APPEND);

				if (isset($columns, $values))
					unset($columns, $values);
			}

			file_put_contents($file_path, "\n", FILE_APPEND);
		}

		if ($this->compress === true)
			file_put_contents($file_path, gzencode(file_get_contents($file_path)));

		return $this->file;
	}
}

?>