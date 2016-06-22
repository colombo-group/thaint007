<?php
	class Cookie {
                /**
                 * Ki?m tra s? t?n t?i c?a 1 coolie
                 * @param type $name tên cookie ki?m tra
                 * @return type n?u t?n t?i cookie tr? v? true, ng??c l?i tr? v? false
                 */
		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;
		}
                /**
                 * hàm tr? v? 1 cookie theo bi?n truy?n vào
                 * @param type $name tên cookie 
                 * @return type tr? v? giá tr? c?a cookie theo tên truy?n vào
                 */
		public static function get($name) {
			return $_COOKIE[$name];
		}
                /**
                 * cài ??t giá tr? và th?i gian cho cookie
                 * @param type $name tên cookie c?n cài ??t
                 * @param type $value giá tr? cookie
                 * @param type $expiry th?i gian t?n t?i
                 * @return boolean n?u có ?? tham s? truy?n vào thì tr? v? true, ng??c l?i tr? v? fail
                 */
		public static function put($name, $value, $expiry) {
			if (setcookie($name, $value, time()+$expiry, '/')) {
				return true;
			}
			return false;
		}
                /**
                 * Xóa cookie
                 * @param type $name tên cookie c?n xóa
                 */
		public static function delete($name) {
			self::put($name, '', time()-1);
		}
	}
?>