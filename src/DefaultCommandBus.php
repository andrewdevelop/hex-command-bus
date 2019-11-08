<?php 

namespace Core\Command;

use Core\Contracts\CommandBus as Contract;
use Core\Contracts\Command;
use Core\Contracts\CommandHandler;
use Core\Contracts\CommandTranslator;
use Illuminate\Contracts\Container\Container;

class DefaultCommandBus implements Contract
{
	/**
	 * DI Container.
	 * @var \Illuminate\Contracts\Container\Container
	 */
	private $container;

	/**
	 * Class translator.
	 * @var \Core\Contracts\CommandTranslator
	 */
	private $translator;

	/**
	 * @todo Add middlewares for validating and other stuff.
	 * @var array
	 */
	private $middlewares = [];

	/**
	 * Bus constructor.
	 * @param Container         $container 
	 * @param CommandTranslator $translator   
	 */
	public function __construct(Container $container, CommandTranslator $translator)
	{
		$this->container = $container;
		$this->translator = $translator;
	}

	/**
	 * Execute a command.
	 * @param  \Core\Contracts\Command $command 
	 * @return mixed
	 */
    public function execute(Command $command)
    {
    	$handler = $this->resolveCommandHandler($command);
    	return call_user_func([$handler, 'handle'], $command);
    }

    /**
     * Make a command handler instance.
     * @param  \Core\Contracts\Command $command
     * @return \Core\Contracts\CommandHandler
     */
    public function resolveCommandHandler(Command $command)
    {
    	$handler_class = $this->translator->translate($command);
    	return $this->container->make($handler_class);
    }
}