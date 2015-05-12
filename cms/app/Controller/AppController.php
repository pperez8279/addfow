<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $layout = 'cms';

	public $components  = array(
		// 'DebugKit.Toolbar',
		'Session',
		'Auth' => array(
			'authenticate' => array(
				'all' => array('userModel' => 'BackendUser'),
		        'Form' => array(
		            'fields' => array('username' => 'email', 'password' => 'password')
		        )
		    ),
		    'loginAction' => array(
		    	'controller' => 'backend_users',
		    	'action' => 'login'
		    ),
			'loginRedirect' => array(
				'controller' => 'dashboards',
				'action' => 'index'
				),
			'logoutRedirect' => '/'
			)
		);

	public function beforeFilter() {
		$this->Auth->allow('login');
	}
}