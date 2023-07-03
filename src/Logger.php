<?php

class Logger {
    public static function report(LogLevel $level, string $message): void {
        $dateTime = new DateTime();
        $dateTime = $dateTime->format('H:i:s d.m.Y');
        echo "[{$level->toString()}, $dateTime]: {$message}"; // TODO: store in database [or a file if the db fails] instead of printing
        if ($level == LogLevel::CriticalError)
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