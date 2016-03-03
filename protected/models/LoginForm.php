<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('email', 'required', 'on'=>'loginemail, loginpassword'),
			array('password', 'required', 'on'=>'loginpassword'),
			array('email', 'email'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
			array('email, password', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'password' => 'Password',
			'rememberMe' => 'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		// we only want to authenticate when no input errors
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();

			switch($this->_identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					Yii::app()->user->login($this->_identity);
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('email','Email address is incorrect.');
					break;
			}
		}
	}

	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		if(parent::beforeValidate()) {	
			if($this->password != '') {
				$user = Users::model()->findByAttributes(array('email' => $this->email));
				if($user !== null && $user->password !== Users::hashPassword($user->salt,$this->password)) {
					$this->addError('password', 'Password is incorrect.');
				}
			}
		}
		return true;
	}
}
