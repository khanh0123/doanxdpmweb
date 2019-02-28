<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Session\DatabaseSessionHandler;
use Illuminate\Database\ConnectionInterface;
use Session;
use Config;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(ConnectionInterface $connection)
    {
        Session::extend('database', function($app) use ($connection) {
            $table   = Config::get('session.table');
            $minutes = Config::get('session.lifetime');
            return new DatabaseSessionHandler($connection, $table, $minutes);
        });
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // die;
        $this->app->session->extend('database', function ($app) {
            
            
            // die;
            $connectionName     = $app->config->get('session.connection');

            $databaseConnection = $app->app->db->connection($connectionName);

            $table = $databaseConnection->getTablePrefix() . $app->config['session.table'];
            return new DatabaseSessionHandler($databaseConnection, $table);
        });
    }
}