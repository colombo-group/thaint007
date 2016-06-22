<?php
	class Validate {
		private $_passed = false,
				$_errors = array(),
				$_db = null;
            
		public function __construct() {
			$this->_db = Database::getInstance();
		}
                /**
                 * ki?m tra
                 * @param type $source ngu?n ki?m tra
                 * @param type $items m?c ki?m tra
                 * @return \Validate
                 */
		public function check($source, $items = array()) {
			foreach ($items as $item => $rules) {
				foreach ($rules as $rule => $rule_value) {
					$value 	= trim($source[$item]);
					$item 	= escape($item);
					
					if ($rule === 'required' && empty($value)) {
						$this->addError("{$item} is required");	//ToDo: Pick up 'name' value
					} else if (!empty($value)) {
						switch ($rule) {
							case 'min':
								if (strlen($value) < $rule_value) {
									$this->addError("{item} must be a minimum of {$rule_value} characters");
								}
								break;
							case 'max':
								if (strlen($value) > $rule_value) {
									$this->addError("{item} must be no longer than {$rule_value} characters");
								}
								break;
							case 'matches':
								if ($value != $source[$rule_value]) {
									$this->addError("{$rule_value} must match {$item}");
								}
								break;
							case 'unique':
								$check = $this->_db->get($rule_value,array($item, '=' , $value));
								if ($check->count()) {
									$this->addError("{$item} already exists");
								}
								break;
						}
					}
				}
			}

			if (empty($this->_errors)) {
				$this->_passed = true;
			}

			return $this;
		}
                /**
                 * thêm l?i m?i vào danh sách
                 * @param type $error
                 */
		private function addError($error) {
			$this->_errors[] = $error;
		}
                /**
                 * danh sách l?i
                 * @return type
                 */
		public function errors() {
			return $this->_errors;
		}
                /**
                 * thông qua
                 * @return type
                 */
		public function passed() {
			return $this->_passed;
		}
	}
?>