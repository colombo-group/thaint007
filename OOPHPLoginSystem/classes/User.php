<?php
	class User {
		private $_db,
				$_data,
				$_sessionName,
				$_cookieName,
				$_isLoggedIn;
                /**
                 * t?o csdl, session, cookie cho user
                 * @param type $user t�n user
                 */
		public function __construct($user = null) {
			$this->_db 			= Database::getInstance();
			$this->_sessionName = Config::get('session/sessionName');
			$this->_cookieName 	= Config::get('remember/cookieName');

			if (!$user) {
				if (Session::exists($this->_sessionName)) {
					$user = Session::get($this->_sessionName);

					if ($this->find($user)) {
						$this->_isLoggedIn = true;
					} else {
						self::logout();
					}
				}
			} else {
				$this->find($user);
			}
		}
                /**
                 * ch?nh s?a user
                 * @param type $fields d? li?u c?n ch?nh s?a
                 * @param type $id id c?a user
                 * @throws Exception
                 */
		public function update($fields = array(), $id = null) {

			if (!$id && $this->isLoggedIn()) {
				$id = $this->data()->ID;
			}

			if (!$this->_db->update('users', $id, $fields)) {
				throw new Exception("There was a problem updating your details");
			}
		}
                /**
                 * th�m user
                 * @param type $fields c�c th�ng tin user
                 * @throws Exception
                 */
		public function create($fields = array()) {
			if (!$this->_db->insert('users', $fields)) {
				throw new Exception("There was a problem creating your account");
			}
		}
                /**
                 * t�m ki?m 1 user theo id ho?c username
                 * @param type $user t�n user c?n t�m
                 * @return boolean
                 */
		public function find($user = null) {
			if ($user) {
				$fields = (is_numeric($user)) ? 'id' : 'username';	//Numbers in username issues
				$data 	= $this->_db->get('users', array($fields, '=', $user));

				if ($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}
                /**
                 * ki?m tra ??ng nh?p
                 * @param type $username t�n ??ng nh?p
                 * @param type $password m?t kh?u
                 * @param type $remember nh?
                 * @return boolean
                 */
		public function login($username = null, $password = null, $remember = false) {
			if (!$username && !$password && $this->exists()) {
				Session::put($this->_sessionName, $this->data()->ID);
			} else {
				$user = $this->find($username);
				if ($user) {
					if ($this->data()->password === Hash::make($password,$this->data()->salt)) {
						Session::put($this->_sessionName, $this->data()->ID);

						if ($remember) {
							$hash = Hash::unique();
							$hashCheck = $this->_db->get('usersSessions', array('userID','=',$this->data()->ID));

							if (!$hashCheck->count()) {
								$this->_db->insert('usersSessions', array(
									'userID' 	=> $this->data()->ID,
									'hash' 		=> $hash
								));
							} else {
								$hash = $hashCheck->first()->hash;
							}
							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookieExpiry'));
						}

						return true;
					}
				}
			}
			return false;
		}
                /**
                 * ki?m tra quy?n
                 * @param type $key l?u quy?n ng??i d�ng
                 * @return boolean
                 */
		public function hasPermission($key) {
			$group = $this->_db->get('groups', array('ID', '=', $this->data()->userGroup));
			if ($group->count()) {
				$permissions = json_decode($group->first()->permissions,true);

				if ($permissions[$key] == true) {
					return true;
				}
			}
			return false;
		}
            
		public function exists() {
			return (!empty($this->_data)) ? true : false;
		}
                /**
                 * ??ng xu?t
                 */
		public function logout() {
			$this->_db->delete('usersSessions', array('userID', '=', $this->data()->ID));
			Session::delete($this->_sessionName);
			Cookie::delete($this->_cookieName);
		}

		public function data() {
			return $this->_data;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}
	}
?>