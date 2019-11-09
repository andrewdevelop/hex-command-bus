<?php

namespace Core\Command;

use Illuminate\Support\ServiceProvider;
use Core\Contracts\CommandTranslator;
use Core\Contracts\CommandBus;
use Core\Command\ConventionBasedTranslator;
use Core\Command\DefaultCommandBus;

class CommandBusServiceProvider extends ServiceProvider
{
    
    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = true;


    /**
     * Register the service.
     * @return void
     */
    public function register()
    {		
		$this->app->singleton(CommandTranslator::class, ConventionBasedTranslator::class);
		$this->app->singleton(CommandBus::class, DefaultCommandBus::class);
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
        	CommandTranslator::class, 
        	CommandBus::class
        ];
    }
}