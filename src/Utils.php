<?php
require_once 'Logger.php';

class Utils {
    public static function initialized(mixed ...$variables): bool {
        foreach($variables as $variable)
            if (!isset($variable) || empty($variable)) {
                $uninitializedVariable = print_r($variable, true);
                Logger::report(LogLevel::Info, "An attempt to use an endpoint with the uninitialized variable has been detected: $uninitializedVariable");
                return false;
            }
        return true;
    }

    public static function getJSONInputAsArray(): array {
        return (array) json_decode(file_get_contents('php://input'), true);
    }

    public static function getCurrentTimeAsFloat(): float { // It is insensitive to 32-bit integer overflow.
        $now = new DateTime();
        return (float) $now->format("U");
    }
}