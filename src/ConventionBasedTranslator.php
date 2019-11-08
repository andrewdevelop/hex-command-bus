<?php 

namespace Core\Command;

use Core\Contracts\CommandTranslator;
use Core\Contracts\Command;
use Exception;

class ConventionBasedTranslator implements CommandTranslator
{

	/**
	 * Translate command class name to handler class name.
	 * @param  Command $command 
	 * @return string           
	 */
	public function translate(Command $command)
	{
		$namespaced_command_class = get_class($command);
		$parts = explode('\\', $namespaced_command_class);
		$parts_count = count($parts);

		if ($parts_count > 1) {
			// from: Services\User\Commands\RegisterUser 
			// to: Services\User\Handlers\RegisterUserHandler
			for ($i = 0; $i < $parts_count; $i++) {
				if ($i == $parts_count-2) {
					$parts[$i] = 'Handlers';
				}
				if ($i == $parts_count-1) {
					$parts[$i] = $parts[$i].'Handler';
				}
			}
			$handler_class = implode('\\', $parts);
		} else {
			// from: RegisterUser 
			// to: RegisterUserHandler
			$handler_class = $namespaced_command_class.'Handler';
		}

		if (class_exists($handler_class)) {
			return $handler_class;
		}

		throw new Exception("Handler $handler_class not found.");
	}

	
}