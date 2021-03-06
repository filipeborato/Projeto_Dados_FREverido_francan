<?php
    define("WEB_SERVER_HOST", "localhost");
    define("WEB_SERVER_PORT", "1349");
    define("WEB_SERVER_DOCROOT", "./");

    // Command that starts the built-in web server
    $command = sprintf(
        'php -S %s:%d -t %s router.php > /dev/null 2>&1 & echo $!',
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        WEB_SERVER_DOCROOT
    );

    // Execute the command and store the process ID
    $output = array();
    exec($command, $output);
    $pid = (int) $output[0];

    echo sprintf(
        '%s - Servidor web iniciado: %s:%d with PID %d',
        date('r'),
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        $pid
    ) . PHP_EOL;

    // Espero 1 segundo
    usleep(500000);

    // Kill the web server when the process ends
    register_shutdown_function(function () use ($pid) {
        echo sprintf('%s - Terminando servidor web con ID %d', date('r'), $pid) . PHP_EOL;
        exec('kill ' . $pid);
    });
