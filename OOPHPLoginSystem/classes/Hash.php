<?php
	class Hash {
                /**
                 * th?c hiên b?m 1 chu?i
                 * @param type $string chu?i c?n b?m
                 * @param type $salt chu?i thêm vào
                 * @return type
                 */
		public static function make($string, $salt = '') {
			return hash('sha256', $string.$salt);
		}
                /**
                 * chu?i thêm vào
                 * @param type $length ?? dài chu?i
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