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
		if ( strlen($pwd) < 8 ) {
			return "Must be at least 8 characters long";
		} else {
		
		}

		return true;
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

