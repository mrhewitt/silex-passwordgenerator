<?php

namespace MarkHewitt\SilexPasswords;

/**
 *
 */
class PasswordGeneratorService {
	
	public function generate() {
		$pwgen = new Helpers\PWGen();
		return $pwgen->generate();
	}
	
    public function generateToken()
    {
        return rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
	}
	
	public function validate($pwd) {
		$errors = [];
		if ( strlen($pwd) < 8 ) {
			$errors['len'] = "Must be at least 8 characters long";
		}
        if ( !preg_match('/[a-z]/',$pwd) ) {
            $errors['lower'] = "Must have at least 1 lowercase letter";
        }
        if ( !preg_match('/[A-Z]/',$pwd) ) {
            $errors['upper'] = "Must have at least 1 uppercase letter";
        }
        if ( !preg_match('/\d/',$pwd) ) {
            $errors['digit'] = "Must have at least 1 digit";
        }
        if ( !preg_match('/\W/',$pwd) ) {
            $errors['spec'] = "Must have at least 1 special character";
        }

		return count($errors) > 0 ? $errors : true;
	}

    private function getRandomNumber()
    {
        // determine whether to use OpenSSL
        if (defined('PHP_WINDOWS_VERSION_BUILD') && version_compare(PHP_VERSION, '5.3.4', '<')) {
            $open_ssl = false;
        } else if (!function_exists('openssl_random_pseudo_bytes')) {
            $open_ssl = false;
        } else {
            $open_ssl = true;
        }
		
        $nbBytes = 32;

        // try OpenSSL
        if ($open_ssl) {
            $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);

            if (false !== $bytes && true === $strong) {
                return $bytes;
            }
        }

        return hash('sha256', uniqid(mt_rand(), true), true);
    }
}

