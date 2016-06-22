<?php
	class Session {
                /**
                 * ki?m tra s? t?n t?i c?a session
                 * @param type $name tên session
                 * @return type n?u t?n t?i session c?n ki?m tra thì tr? v? true, ng??c l?i tr? v? fasle
                 */
		public static function exists($name) {
			return (isset($_SESSION[$name])) ? true : false;
		}
                /**
                 * set giá tr? cho session
                 * @param type $name tên session c?n set giá tr?
                 * @param type $value giá tr? truy?n vào cho session
                 * @return type tr? v? session $name có giá tr? là $value
                 */
		public static function put($name, $value) {
			return $_SESSION[$name] = $value;
		}
                /**
                 * l?y giá tr? c?a session
                 * @param type $name tên session c?n l?y
                 * @return type tr? v? giá tr? c?a session
                 */
		public static function get($name) {
			return $_SESSION[$name];
		}
                /**
                 * xóa session
                 * @param type $name n?u session t?n t?i thì xóa session
                 */
		public static function delete($name) {
			if (self::exists($name)) {
				unset($_SESSION[$name]);
			}
		}
                /**
                 * ??t session vào flash
                 * @param type $name tên session
                 * @param type $string 
                 * @return type
                 */
		public static function flash($name, $string = '') {
			if (self::exists($name)) {
				$session = self::get($name);
				self::delete($name);
				return $session;
			} else {
				self::put($name, $string);
			}
		}
	}	
?>