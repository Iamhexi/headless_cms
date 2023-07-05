<?php
require_once '../../Configuration.php';

class Logger {
    public static function report(LogLevel $level, string $message): void {
        
        $dateTime = new DateTime();
        $dateTime = $dateTime->format('H:i:s d.m.Y');
        if (Configuration::DEBUG_MODE === true) {
            // header('Content-Type: plain/text');
            echo "[{$level->toString()}, $dateTime]: {$message}"; 
        } else {
            // TODO: save logs to some file
            // store in database [or a file if the db fails] instead of printing
        }

        if ($level === LogLevel::CriticalError)
            exit();
    }
}

enum LogLevel {
    case DebugInfo;
    case Info;
    case Warning;
    case Error;
    case CriticalError;

    public function toString(): string {
        return match($this) {
            LogLevel::DebugInfo => 'Debug information',
            LogLevel::Info => 'Information',
            LogLevel::Warning => 'Warning',
            LogLevel::Error => 'Error',
            LogLevel::CriticalError => 'Critical error'
        };
    }
}