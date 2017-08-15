<?php
/**
 * Class for extending the WP_Error class
 * for global use with VTCore Classes
 *
 * @author jason.xie@victheme.com
 *
 */
class VTCore_Wordpress_Factory_Messages
extends WP_Error {

	public function setError($message) {
		$this->add('VTCoreErrors', $message);
	}

	public function setMessage($message) {
		$this->add('VTCoreMessages', $message);
	}

	public function setNotice($message) {
		$this->add('VTCoreNotices', $message);
	}

	public function getError() {
		return $this->get_error_messages('VTCoreErrors');
	}

	public function getMessage() {
		return $this->get_error_messages('VTCoreMessages');
	}

	public function getNotice() {
		return $this->get_error_messages('VTCoreNotices');
	}

	public function isError() {
	  $errors = $this->getError();
		return !empty($errors);
	}

	public function render() {
	  return array_merge($this->getError(), $this->getMessage(), $this->getNotice());
	}
}