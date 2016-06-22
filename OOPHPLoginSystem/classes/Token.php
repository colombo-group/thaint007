<?php
	class Token {
                /**
                 * t?o 1 token
                 * @return type
                 */
		public static function generate() {
			return Session::put(Config::get('session/tokenName'), md5(uniqid()));
		}
                /**
                 * ki?m tra token
                 * @param type $token token c?n ki?m tra
                 * @return boolean
                 */
		public static function check($token) {
			$tokenName = Config::get('session/tokenName');

			if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
				Session::delete($tokenName);
				return true;
			} else {
				return false;
			}
		}
	}
?>