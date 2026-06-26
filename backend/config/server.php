<?php
use Illuminate\Database\Capsule\Manager as Connection;

class connectionDb {
    
    public function __construct()
    {
        $connection = new Connection();
        $connection->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'licitaciones',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);
        // Make this Capsule instance available globally via static methods... (optional)
        $connection->setAsGlobal();
        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $connection->bootEloquent();
    }
}