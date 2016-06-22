<?php
	class Session {
                /**
                 * ki?m tra s? t?n t?i c?a session
                 * @param type $name t�n session
                 * @return type n?u t?n t?i session c?n ki?m tra th� tr? v? true, ng??c l?i tr? v? fasle
                 */
		public static function exists($name) {
			return (isset($_SESSION[$name])) ? true : false;
		}
                /**
                 * set gi� tr? cho session
                 * @param type $name t�n session c?n set gi� tr?
                 * @param type $value gi� tr? truy?n v�o cho session
                 * @return type tr? v? session $name c� gi� tr? l� $value
                 */
		public static function put($name, $value) {
			return $_SESSION[$name] = $value;
		}
                /**
                 * l?y gi� tr? c?a session
                 * @param type $name t�n session c?n l?y
                 * @return type tr? v? gi� tr? c?a session
                 */
		public static function get($name) {
			return $_SESSION[$name];
		}
                /**
                 * x�a session
                 * @param type $name n?u session t?n t?i th� x�a session
                 */
		public static function delete($name) {
			if (self::exists($name)) {
				unset($_SESSION[$name]);
			}
		}
                /**
                 * ??t session v�o flash
                 * @param type $name t�n session
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