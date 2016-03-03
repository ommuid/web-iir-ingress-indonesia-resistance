<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends OUserIdentity
{
	public $email;
	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        if($this->token != null)
            $userToken = Users::model()->findByAttributes(array('salt'=>$this->token));   
			
		if(preg_match('/@/',$this->username)) //$this->username can filled by username or email
			$record = Users::model()->findByAttributes(array('email' => $this->username));
		else 
			$record = Users::model()->findByAttributes(array('username' => $this->username));
			
		if($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if($this->token == null && $record->password !== Users::hashPassword($record->salt,$this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			if($this->token !== null && $userToken == null) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				$this->_id = $record->user_id;
				$this->setState('level', $record->level_id);
				$this->setState('profile', $record->profile_id);
				$this->setState('language', $record->language_id);
				$this->email = $record->email;
				$this->setState('fname', $record->first_name);
				$this->setState('lname', $record->last_name);
				$this->setState('displayname', $record->displayname);
				$this->setState('username', $record->username);
				$this->setState('photo', $record->photo_id != 0 ? $record->photo->photo : 0);
				$this->setState('status', $record->status_id);
				$this->setState('enabled', $record->enabled);
				$this->setState('verified', $record->verified);
				$this->setState('creation_date', $record->creation_date);
				$this->setState('lastlogin_date', $record->lastlogin_date);
				$this->errorCode = self::ERROR_NONE;
			}
		}
		return !$this->errorCode;

	}

	public function getId() {
		return $this->_id;
	}

}