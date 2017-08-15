<?php
/**
 * Text validation class for testing if text is a valid email address
 *
 * @author jason.xie@victheme.com
 */
class VTCore_Validator_Email
  extends VTCore_Validator_Base {

  public function validateText() {

    if ($this->getText() === '') {
      return true;
    }

    $atIndex = strrpos($this->getText(), '@');

    if (is_bool($atIndex) && !$atIndex) {
      return false;
    }

    else {
      $email = $this->getText();
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);

      if ($localLen < 1 || $localLen > 64) {
        return false;
      }

      // Check domain length
      elseif ($domainLen < 1 || $domainLen > 255) {
        return false;
      }

      // Check local part starts or ends with '.'
      elseif ($local[0] == '.' || $local[$localLen-1] == '.') {
        return false;
      }

      // Check local part has two consecutive dots
      elseif (preg_match('/\\.\\./', $local)) {
        return false;
      }

      // character not valid in domain part
      elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
        return false;
      }

      // Check domain part has two consecutive dots
      elseif (preg_match('/\\.\\./', $domain)) {
        return false;
      }

      // Check character not valid in local part unless local part is quoted
      elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
        if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
          return false;
        }
      }

      // Check DNS
      if (!(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
        return false;
      }
    }
    return true;
  }
}