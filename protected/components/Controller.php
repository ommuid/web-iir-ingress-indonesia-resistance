<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = 'default';

	/**
	 * admin controller
	 */
	public $trashOption = false;
	public $searchOption = false;

	/**
	 * front controller
	 *
	 * Dialog Condition
	 ** example (action in controller)
	 **
	 ** $this->dialogDetail = true;
	 ** $this->dialogWidth = int; int => ???
	 ** $this->dialogGroundUrl = url;
	 *
	 */
	public $dialogDetail = false;
	public $dialogWidth = '';
	public $dialogGroundUrl = '';
	
	/**
	 * Other Content
	 ** example (action in controller)
	 **
	 ** $this->contentOther = true;
	 ** $this->contentAttribute=array(
	 ** 	array('type' => 0, 'id' => '1', 'data' => '1'),			//content
	 ** 	array('type' => 1, 'id' => '2', 'url' => '2'),			//render partial
	 ** );
	 *
	 */
	public $contentType = false;
	public $contentOther = false;
	public $contentAttribute = array();

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();

	/**
	 * custom variable
	 */
	public $pageGuest = false;
	public $dialogFixed = false;
	public $dialogFixedClosed = array();
	public $ownerId = '';
	
	public $adsSidebar = true;

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	public $pageDescription;
	public $pageMeta;
	public $pageImage;

	public function render($view, $data = null, $return = false) {
		if ($this->beforeRender($view)) {
			/**
			 * set Language
			 */
			if(isset($_GET['lang'])) {
				Yii::app()->session['language'] = $_GET['lang'];
			}
			
			/**
			 * Custom condition
			 ** 
			 * guest page
			 * replace timthumb url
			 * registers all meta tags
			 * set current date
			 * unset session user_id (after register)
			 * set theme is active
			 * Set comment plugin_id
			 * Set owner and user info
			 *
			 */
			// guest page
			if($this->dialogFixed == true) {
				$this->pageGuest = true;
			}
			// replace timthumb url
			if(!isset(Yii::app()->session['timthumb_url_replace']) && Yii::app()->params['timthumb_url_replace'] == 1) {
				Yii::app()->session['timthumb_url_replace'] = Yii::app()->params['timthumb_url_replace_website'];
			}
			// registers all meta tags
			if(!Yii::app()->request->isAjaxRequest) {
				$meta = OmmuMeta::model()->findByPk(1,array(
					'select' => 'office_on, google_on, twitter_on, facebook_on'
				));
				if($meta->office_on == 1)
					Yii::app()->meta->renderGoogleOwnerMetaTags();
				if($meta->google_on == 1)
					Yii::app()->meta->renderGooglePlusMetaTags();
				if($meta->facebook_on == 1)
					Yii::app()->meta->renderFacebookMetaTags();
				if($meta->twitter_on == 1)
					Yii::app()->meta->renderTwitterMetaTags();
			}
			// set current date
			if(!isset(Yii::app()->session['statistic_current_date']) || (isset(Yii::app()->session['statistic_current_date']) && Yii::app()->session['statistic_current_date'] != date('Y-m-d'))) {
				Yii::app()->session['statistic_current_date'] = date('Y-m-d');
			}
			
			// unset session user_id (after register)
			$module = strtolower(Yii::app()->controller->module->id);
			$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
			$currentModuleAction = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			if(isset(Yii::app()->session['signup_user_id']) && ($currentModule != 'users/signup' || $currentModuleAction == 'users/signup/success')) {
				unset(Yii::app()->session['signup_user_id']);
			}
			
			// set theme is active
			if(!Yii::app()->request->isAjaxRequest) {
				Yii::app()->session['theme_active'] = Yii::app()->theme->name;
				if($this->dialogDetail == true)
					Yii::app()->session['current_url'] = $this->dialogGroundUrl;
			}

			/**
			 * Set comment plugin_id
			 */
			$module = strtolower(Yii::app()->controller->module->id);
			if (!empty($module)) {
				$plugin = OmmuPlugins::model()->findByAttributes(array('folder' => $module), array(
					'select' => 'plugin_id, model',
				));
				Yii::app()->params['plugin'] = $plugin->plugin_id;
				Yii::app()->params['model'] = $plugin->model;
				Yii::app()->params['path'] = 'public/'.$module.'/';
			} else {
				Yii::app()->params['plugin'] = 0;
			}

			/**
			 * Set owner and user info
			 */
			if (empty($this->ownerId)) {
				$owner = !Yii::app()->user->isGuest ? 'Hi, '.Yii::app()->user->displayname : 'Hi, Guest';
				Yii::app()->params['owner_id'] = '';
			} else {
				$user = Users::model()->findByPk($this->ownerId, array(
					'select' => 'displayname',
				));
				$owner = $user->displayname;
				Yii::app()->params['owner_id'] = $this->ownerId;
			}
			Yii::app()->params['owner'] = $owner;
			
			parent::render($view, $data, $return);
		}
	}
 
	/**
	 * Meta description and keyword generate
	 */
	protected function beforeRender($view)
	{
		$model = OmmuSettings::model()->findByPk(1,array(
			'select' => 'site_title, site_keywords, site_description'
		));
		if(!Yii::app()->request->isAjaxRequest) {

			if(parent::beforeRender($view)) {
				// Ommu custom description and keyword
				if (!empty($this->pageDescription)) {
					$description = $this->pageDescription;
				} else {
					$description = $model->site_description;
				}
				Yii::app()->clientScript->registerMetaTag(Utility::hardDecode($description), 'description');
		
				if (!empty($this->pageMeta)) {
					$keywords = $model->site_keywords.','.$this->pageMeta;
				} else {
					$keywords = $model->site_keywords;
				}
				Yii::app()->clientScript->registerMetaTag(Utility::hardDecode($keywords), 'keywords');
				
				/**
				 * Facebook open graph and all custom metatags
				 * @title
				 * @description
				 * @image
				 */ 
				// title
				Yii::app()->meta->googlePlusTags['name'] = 
				Yii::app()->meta->facebookTags['og:title'] = 
				Yii::app()->meta->twitterTags['twitter:title'] = 
				CHtml::encode($this->pageTitle).' | '.$model->site_title; 
				// description
				Yii::app()->meta->googlePlusTags['description'] = 
				Yii::app()->meta->facebookTags['og:description'] = 
				Yii::app()->meta->twitterTags['twitter:description'] = 
				$description; 	
				// image
				if (!empty($this->pageImage)) {
					Yii::app()->meta->facebookTags['og:image'] = 
					Yii::app()->meta->googlePlusTags['image'] = 
					Yii::app()->meta->twitterTags['twitter:image:src'] = 
					Utility::getProtocol().'://'.Yii::app()->request->serverName.$this->pageImage; 
				}
			}
			
		} else {
			$this->pageDescription = $this->pageDescription != '' ? $this->pageDescription : $model->site_description;
			$this->pageMeta = $this->pageMeta != '' ? $model->site_keywords.', '.$this->pageMeta : $model->site_keywords;
		}
		$this->pageTitle = $this->pageTitle != '' ? $this->pageTitle : 'Titlenya Lupa..';
		return true;
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->pageGuest = true;
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('/site/front_error', $error);
		} else {
			$this->render('/site/front_error', $error);
		}
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */	
	protected function _checkAuth()  {
		//check login token
		if(isset($_POST['token'])){	
			$model		= Users::model()->findByAttributes(array('salt'=>$_POST['token']));
			$user		= Users::model()->findByPk($model->user_id);
			$username	= $user->username;
			$password	= null;
			
		} else {
			// Check if we have the USERNAME and PASSWORD HTTP headers set?
			if(!(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']))) {
				// Error: Unauthorized
				$this->_sendResponse(401);
			}
			$username = $_SERVER['PHP_AUTH_USER'];
			$password = $_SERVER['PHP_AUTH_PW'];
			// Find the user
			if(preg_match('/@/',$username)){
				$user=Users::model()->find('LOWER(email)=?',array(strtolower($username)));
			} else {
				$user=Users::model()->find('LOWER(username)=?',array(strtolower($username)));
			}
		}
		
		if ($user===null) {
			// Error: Unauthorized
			$this->_sendResponse(401, 'Error: User Name is invalid');
		} else {
			$model=new LoginFormAdmin;
			$model->email = $username;
			$model->password = $password;
			
			if(isset($_POST['token'])) { //login with token
				$model->token = $_POST['token'];
			}
			if(!$model->login()) {
				$this->_sendResponse(401, 'Error: password is invalid');
			}
		}
	}

    protected function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if($body != '')
        {
            // send the body
            echo $body;
        }
        // we need to create the body if none is passed
        else
        {
            // create some body messages
            $message = '';
            switch($status)
            {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
    </head>
    <body>
        <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
        <p>' . $message . '</p>
        <hr />
        <address>' . $signature . '</address>
    </body>
    </html>';

            echo $body;
        }
        Yii::app()->end();
    }

    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}