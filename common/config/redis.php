<?php
    return [
        'class'    => 'yii\redis\Connection',
        'hostname' => 'localhost',
        'port'     => 6379,
        'database' => 0,
    ];

    /***
     * HOW TO START REDIS 

        1. bash [IN A CMD] 
        2. redis-server --daemonize yes
        3. redis-cli

        Source https://github.com/ServiceStack/redis-windows
     */
?>

