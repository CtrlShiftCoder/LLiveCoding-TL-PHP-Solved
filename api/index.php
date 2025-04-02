<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "config/MockData.php";
require_once "models/Book.php";
require_once "models/Loan.php";
require_once "controllers/BookController.php";
require_once "controllers/LoanController.php";
require_once "helpers/ApiHelper.php";

// Rate limiting
if (!ApiHelper::checkRateLimit($_SERVER['REMOTE_ADDR'])) {
    echo ApiHelper::jsonResponse(['message' => 'Too many requests'], 429);
    exit;
}

try {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    // Log request
    ApiHelper::logOperation('request', [
        'uri' => $uri,
        'method' => $method
    ]);

    switch (true) {
        case $uri === '/api/books' && $method === 'GET':
            $controller = new BookController();
            $controller->index();
            break;

        case $uri === '/api/books' && $method === 'POST':
            $controller = new BookController();
            $controller->store();
            break;

        case preg_match('/^\/api\/books\/(\w+)$/', $uri, $matches):
            $controller = new BookController();
            $isbn = $matches[1];
            
            switch ($method) {
                case 'GET':
                    $controller->show($isbn);
                    break;
                case 'PUT':
                    $controller->update($isbn);
                    break;
                case 'DELETE':
                    $controller->delete($isbn);
                    break;
                default:
                    throw new Exception('Method not allowed');
            }
            break;

        case $uri === '/api/books/search':
            $controller = new BookController();
            $controller->search();
            break;

        case $uri === '/api/loans' && $method === 'GET':
            $controller = new LoanController();
            $controller->activeLoans();
            break;

        case preg_match('/^\/api\/loans\/(\w+)$/', $uri, $matches):
            $controller = new LoanController();
            $isbn = $matches[1];
            
            switch ($method) {
                case 'POST':
                    $controller->create($isbn);
                    break;
                case 'PUT':
                    $controller->returnBook($isbn);
                    break;
                default:
                    throw new Exception('Method not allowed');
            }
            break;

        default:
            echo ApiHelper::jsonResponse(['error' => 'Route not found'], 404);
    }
} catch (Exception $e) {
    ApiHelper::logOperation('error', ['message' => $e->getMessage()]);
    echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
} 