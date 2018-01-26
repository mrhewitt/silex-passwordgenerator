<?php

namespace MarkHewitt\SilexPasswords;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

class PasswordGeneratorServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
       $app['password.generator'] = function() use ($app) {
										return new PasswordGeneratorService();
									};
	}
	
}