<?php
$pid = pcntl_fork();

if ($pid == -1) {
    die("Could not fork.");
} elseif ($pid) {
    exit();
} else {
    if (posix_setsid() == -1) {
        die("Could not set session id.");
    }

    chdir('/');

    // Закрываем стандартные потоки ввода/вывода/ошибок
    fclose(STDIN);
    fclose(STDOUT);
    fclose(STDERR);

    // Открываем новые потоки ввода/вывода/ошибок (по желанию)
    $stdin = fopen('/dev/null', 'r');
    $stdout = fopen('/var/log/output.log', 'ab');
    $stderr = fopen('/var/log/error.log', 'ab');

    // Основной цикл демона
    while (true) {
        // полезный код
        sleep(1);
    }
}

