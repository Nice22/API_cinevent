<?php

// Example usage: logMessage('This is a log message.');
function logMessage($message) {
    $logFile = 'app.log';

    $formattedMessage = date('[Y-m-d H:i:s]') . ' ' . $message . "\n";

    file_put_contents($logFile, $formattedMessage, FILE_APPEND);
}

?>
