<?php

class ApiHelper {
    private static $requestCount = [];
    private static $rateLimit = 100; // requests per minute
    private static $logFile = 'api.log';
    
    // DESAFÍO: Implementar rate limiting
    public static function checkRateLimit(string $ip): bool {
        $minute = date('YmdHi');
        
        if (!isset(self::$requestCount[$ip][$minute])) {
            self::$requestCount[$ip] = [$minute => 1];
            return true;
        }

        if (self::$requestCount[$ip][$minute] >= self::$rateLimit) {
            return false;
        }

        self::$requestCount[$ip][$minute]++;
        return true;
    }
    
    // DESAFÍO: Implementar logging
    public static function logOperation(string $operation, array $data): void {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'operation' => $operation,
            'data' => $data,
            'ip' => $_SERVER['REMOTE_ADDR']
        ];

        file_put_contents(
            self::$logFile, 
            json_encode($logEntry) . "\n", 
            FILE_APPEND
        );
    }
    
    // DESAFÍO: Implementar respuestas estandarizadas
    public static function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode($data, JSON_PRETTY_PRINT);
    }
} 