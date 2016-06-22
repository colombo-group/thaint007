<?php
	class Database {
		private static $_instance = null;
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;
                /**
                 * Hàm k?t n?i csdl
                 */
		private function __construct() {
			try {
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
                /**
                 * 
                 * @return type
                 */
		public static function getInstance() {
			if (!isset(self::$_instance)) {
				self::$_instance = new Database();
			}
			return self::$_instance;
		}
                /**
                 * th?c hi?n các câu l?nh sql
                 * @param type $sql câu l?nh sql
                 * @param type $params các tham s? truy?n vào
                 * @return \Database tr? v? true n?u truy v?n thành công, ng??c l?i tr? v? fasle
                 */
		public function query($sql, $params = array()) {
			$this->_error = false;
			if ($this->_query = $this->_pdo->prepare($sql)) {
				$x = 1;
				if (count($params)) {
					foreach ($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}

				if ($this->_query->execute()) {
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count	= $this->_query->rowCount();
				} else {
					$this->_error = true;
				}
			}

			return $this;
		}
                /**
                 * th?c hi?n các câu truy v?n
                 * @param type $action ho?t ??ng truy v?n
                 * @param type $table b?ng c?n truy v?n
                 * @param type $where ?i?u ki?n
                 * @return boolean|\Database tr? v? ho?t ??ng n?u câu lênh sql ?úng ho?c fasle n?u $where!=3
                 */
		public function action($action, $table, $where = array()) {
			if (count($where) === 3) {	//Allow for no where
				$operators = array('=','>','<','>=','<=','<>');

				$field		= $where[0];
				$operator	= $where[1];
				$value		= $where[2];

				if (in_array($operator, $operators)) {
					$sql = "{$action} FROM {$table} WHERE ${field} {$operator} ?";
					if (!$this->query($sql, array($value))->error()) {
						return $this;
					}
				}
			}
			return false;
		}
                /**
                 * th?c hi?n l?y d? li?u t? csdl
                 * @param type $table tên b?ng c?n l?y
                 * @param type $where ?i?u ki?n
                 * @return type tr? v? hành ??ng th?c hi?n câu l?nh select
                 */
		public function get($table, $where) {
			return $this->action('SELECT *', $table, $where); //ToDo: Allow for specific SELECT (SELECT username)
		}
                /**
                 * xóa 1 tr??ng thông tin trong b?ng
                 * @param type $table tên b?ng
                 * @param type $where ?i?u ki?n
                 * @return type tr? v? hành ??ng th?c hi?n câu l?nh delete
                 */
		public function delete($table, $where) {
			return $this->action('DELETE', $table, $where);
		}
                /**
                 * thêm d? li?u vào csdl
                 * @param type $table tên b?ng c?n thêm
                 * @param type $fields các d? li?u c?n thêm
                 * @return boolean n?u không t?n t?i l?i thì tr? v? true, n?u k t?n t?i giá tr? $fields tr? v? false
                 */
		public function insert($table, $fields = array()) {
			if (count($fields)) {
				$keys 	= array_keys($fields);
				$values = null;
				$x 		= 1;

				foreach ($fields as $field) {
					$values .= '?';
					if ($x<count($fields)) {
						$values .= ', ';
					}
					$x++;
				}

				$sql = "INSERT INTO {$table} (`".implode('`,`', $keys)."`) VALUES({$values})";

				if (!$this->query($sql, $fields)->error()) {
					return true;
				}
			}
			return false;
		}
                /**
                 * s?a d? li?u trong csdl
                 * @param type $table tên b?ng c?n s?a
                 * @param type $id id tr??ng d? li?u c?n s?a
                 * @param type $fields d? li?u c?n s?a
                 * @return boolean n?u không t?n t?i l?i thì tr? v? true, ng??c l?i tr? v? false
                 */
		public function update($table, $id, $fields = array()) {
			$set 	= '';
			$x		= 1;

			foreach ($fields as $name => $value) {
				$set .= "{$name} = ?";
				if ($x<count($fields)) {
					$set .= ', ';
				}
				$x++;
			}

			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
			
			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
			return false;
		}
                /**
                 * th?c hi?n l?y k?t qu?
                 * @return type tr? v? k?t qu?
                 */
		public function results() {
			return $this->_results;
		}
                /**
                 * l?y k?t qu? ??u tiên
                 * @return type tr? v? k?t qu? ??u tiên
                 */
		public function first() {
			return $this->_results[0];
		}
                /**
                 * l?y thông báo l?i
                 * @return type tr? v? thông báo l?i
                 */
		public function error() {
			return $this->_error;
		}
                /**
                 * l?y giá tr?
                 * @return type tr? v? giá tr?
                 */
		public function count() {
			return $this->_count;
		}
	}
?>