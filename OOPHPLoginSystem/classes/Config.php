<?php
	class Config {
            /**
             * hàm tr? v? c?a l?p Config
             * @param type $path
             * @return boolean n?u ?úng tr? v? giá tr? c?a $config, ng??c l?i tr? v? false
             */
		public static function get($path = null) {
			if ($path) {
				$config = $GLOBALS['config'];
				$path	= explode('/', $path);

				foreach ($path as $bit) {
					if (isset($config[$bit])) {
						$config = $config[$bit];
					}
				}

				return $config;
			}
			
			return false;
		}
	}
?>