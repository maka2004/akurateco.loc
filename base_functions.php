<?php
if (!function_exists('dd')) {
        function dd($object) {
            echo '<pre>';
            $trace = debug_backtrace();
            print_r($trace[0]['file'] . ': ' . $trace[0]['line']);
            echo '<br><br>';
            $caller = $trace[1];
            echo "Called by '{$caller['function']}'";
            if (isset($caller['class'])) {
                echo " in class {$caller['class']}'";
            }
            echo '<br>';
            if (!ob_get_level()) {
                ob_clean();
            }

            print_r($object);
            echo '</pre>';
            exit;
        }
    }

if (!function_exists('dd_console')) {
    function dd_console($object) {
        $trace = debug_backtrace();
        print_r($trace[0]['file'] . ': ' . $trace[0]['line']);
        echo "\r\n\r\n";
        $caller = $trace[1];
        echo "Called by '{$caller['function']}'";
        if (isset($caller['class'])) {
            echo " in class {$caller['class']}'";
        }
        echo "\r\n";

        print_r($object);
        echo "\r\n";
        exit;
    }
}

if (!function_exists('logFile')) {
    function logFile($object)
    {
        $fileName = __DIR__ . '/../runtime/debug/app_log.log';
        ob_start();
        print_r($object);
        $text = ob_get_clean();

        $handle = fopen($fileName, 'a');
        $trace = debug_backtrace();
        $fileLine = $trace[0]['file'] . ' : ' . $trace[0]['line'];
        fwrite($handle, PHP_EOL . '--- ' . date('d-m-Y, H:i:s', time()) . ' ' . $fileLine . ' ---' . PHP_EOL);
        fwrite($handle, $text);

        fclose($handle);
    }
}