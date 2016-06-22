<?php
	class Cookie {
                /**
                 * Ki?m tra s? t?n t?i c?a 1 coolie
                 * @param type $name t�n cookie ki?m tra
                 * @return type n?u t?n t?i cookie tr? v? true, ng??c l?i tr? v? false
                 */
		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;
		}
                /**
                 * h�m tr? v? 1 cookie theo bi?n truy?n v�o
                 * @param type $name t�n cookie 
                 * @return type tr? v? gi� tr? c?a cookie theo t�n truy?n v�o
                 */
		public static function get($name) {
			return $_COOKIE[$name];
		}
                /**
                 * c�i ??t gi� tr? v� th?i gian cho cookie
                 * @param type $name t�n cookie c?n c�i ??t
                 * @param type $value gi� tr? cookie
                 * @param type $expiry th?i gian t?n t?i
                 * @return boolean n?u c� ?? tham s? truy?n v�o th� tr? v? true, ng??c l?i tr? v? fail
                 */
		public static function put($name, $value, $expiry) {
			if (setcookie($name, $value, time()+$expiry, '/')) {
				return true;
			}
			return false;
		}
                /**
                 * X�a cookie
                 * @param type $name t�n cookie c?n x�a
                 */
		public static function delete($name) {
			self::put($name, '', time()-1);
		}
	}
?>