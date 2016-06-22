<?php
	class Hash {
                /**
                 * th?c hi�n b?m 1 chu?i
                 * @param type $string chu?i c?n b?m
                 * @param type $salt chu?i th�m v�o
                 * @return type
                 */
		public static function make($string, $salt = '') {
			return hash('sha256', $string.$salt);
		}
                /**
                 * chu?i th�m v�o
                 * @param type $length ?? d�i chu?i
                 * @return type
                 */
		public static function salt($length) {
			return mcrypt_create_iv($length);
		}
             
		public static function unique() {
			return self::make(uniqid());
		}
	}
?>