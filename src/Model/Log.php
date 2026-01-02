<?php

namespace App\Model;

use App\Config\Database;
use PDOException;

class Log
{
    public static function save(string $level, string $url, ?string $method = null, ?int $statusCode = null): bool
    {
        try {
            $pdo = Database::getConnection();

            $method = $method ?? $_SERVER['REQUEST_METHOD'];
            $statusCode = $statusCode ?? http_response_code();

            $sql = "INSERT INTO logs_api (levelLog, requestUrlLog, methodRequestLog, statusCodeLog) 
                    VALUES (:level, :url, :method, :status)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':level', $level);
            $stmt->bindValue(':url', $url);
            $stmt->bindValue(':method', $method);
            $stmt->bindValue(':status', $statusCode);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Erro ao salvar log no banco: " . $e->getMessage());
            return false;
        }
    }
}