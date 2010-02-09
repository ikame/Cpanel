<?php
	/**
	* 
	*/
	class UsersController extends CpanelAppController {
		var $uses = array('Cpanel.CpanelUser');
		
		function beforeFilter() {
			$this->Auth->userModel = 'CpanelUser';
		}
		
		/**
		 * 
		 */
		function setup() {
			if (!ClassRegistry::getObject('Cpanel')->setupMode) {
				$this->redirect(array('action' => 'login'));
			}
			
			if (!empty($this->data)) {
				if ($this->CpanelUser->setup($this->data)) {
					$this->Session->setFlash(__('The Root account has been created, now you can login.', true));
					$this->redirect(array('action' => 'login'));
				}
					$this->Session->setFlash(__('The Root account can\'t be created. Check if you fill the form correctly.', true));
					$this->data['User']['password'] = $this->data['User']['repassword'] = '';
			}
		}
		
		function account() {
			if (!empty($this->data)) {
				if ($this->CpanelUser->update($this->data)) {
					$this->Session->setFlash(__('Changes Saved', true), $this->success);
				} else {
					$this->Session->setFlash(__('Changes not saved', true), $this->failure);
				}
				
				unset($this->data['CpanelUser']);
			}
			
			$username = $this->Session->read('CpanelUser.username');
			
			$this->set(compact('username'));
		}
		
		/**
		 * 
		 */
		function login() {
			if ($this->Auth->user('id')) {
				$this->redirect(array('controller' => 'control_panel', 'action' => 'dashboard'));
			}
		}
		
		/**
		 * 
		 */
		function logout() {
			$this->redirect($this->Auth->logout());
		}
	}
?>