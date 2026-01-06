<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class RepositoryServiceProvider extends ServiceProvider
{
    private string $repositoryNamespace = 'App\\Repositories';
    private string $interfaceNamespace = 'App\\Contracts\\Repositories';
    private string $interfacePath = 'Contracts/Repositories';

    /**
     * Register services.
     */
    public function register(): void
    {
        // Get all interface files
        $interfaceFiles = File::files(app_path($this->interfacePath));

        foreach ($interfaceFiles as $file) {
            $interface = $this->interfaceNamespace . '\\' . basename($file->getFilename(), '.php');
            $implementation = $this->repositoryNamespace . '\\' . str_replace('Interface', '', basename($file->getFilename(), '.php'));

            if (interface_exists($interface) && class_exists($implementation)) {
                $this->app->bind($interface, $implementation);
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
