<?php
declare(ticks=1);

function signalHandler($signal): void
{
    switch ($signal) {
        case SIGTERM:
            // Обработка задач остановки
            exit;
        case SIGINT:
            // обработка CTRL+C
            break;
        case SIGHUP:
            // обработка задач перезапуска
            break;
        default:
            echo "Получен сигнал $signal...\n";
    }
}

function isDaemonActive($pid_file): bool
{
    if (is_file($pid_file)) {
        $pid = file_get_contents($pid_file);

        if (posix_kill($pid, 0)) {
            //демон уже запущен
            return true;
        } else {
            //pid-файл есть, но процесса нет
            if (!unlink($pid_file)) {
                return false;
            }
        }
    }
    return false;
}

if (isDaemonActive('/tmp/my_pid_file.pid')) {
    echo 'Демон уже запущен';
    exit;
}

pcntl_signal(SIGTERM, "signalHandler");
pcntl_signal(SIGHUP, "signalHandler");
pcntl_signal(SIGINT, "signalHandler");

$pid = pcntl_fork();

if ($pid == -1) {
    die("Could not fork.");
} elseif ($pid) {
    exit();
} else {
    if (posix_setsid() == -1) {
        die("Could not set session id.");
    }

    file_put_contents('/tmp/my_pid_file.pid', getmypid());

    chdir('/');

    fclose(STDIN);
    fclose(STDOUT);
    fclose(STDERR);

    $stdin = fopen('/dev/null', 'r');
    $stdout = fopen('/var/log/output.log', 'ab');
    $stderr = fopen('/var/log/error.log', 'ab');

    while (true) {
        // Полезный код
    }
}

