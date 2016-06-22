<?php
	class Input {
                /**
                 * ki?m tra hành ??ng
                 * @param type $type ki?u hành ??ng
                 * @return boolean
                 */
		public static function exists($type = 'post') {
			switch ($type) {
				case 'post':
					return (!empty($_POST)) ? true : false;
					break;
				case 'get':
					return (!empty($_GET)) ? true : false;
					break;
				default:
					return false;
					break;
			}
		}
                /**
                 * tr? v? hành ??ng
                 * @param type $item bi?n c?n tr? v? hành ??ng
                 * @return string
                 */
		public static function get($item) {
			if (isset($_POST[$item])) {
				return $_POST[$item];
			} else if (isset($_GET[$item])) {
				return $_GET[$item];
			}
			return '';
		}
	}
?>