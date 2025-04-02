<?php
require_once "helpers/ApiHelper.php";

class BookController {
    private $book;

    public function __construct() {
        $this->book = new Book();
    }

    // TODO: Implementar método para listar libros
    public function index() {
        try {
            $books = $this->book->getAll();
            echo ApiHelper::jsonResponse($books);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // TODO: Implementar método para obtener un libro
    public function show(string $isbn) {
        try {
            $book = $this->book->getFromCache($isbn);
            if (!$book) {
                echo ApiHelper::jsonResponse(['error' => 'Book not found'], 404);
                return;
            }
            echo ApiHelper::jsonResponse($book);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // TODO: Implementar método para crear un libro
    public function store() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->book->create($data);
            echo ApiHelper::jsonResponse(['message' => 'Book created successfully'], 201);
        } catch (InvalidArgumentException $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // TODO: Implementar método para actualizar un libro
    public function update(string $isbn) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->book->update($isbn, $data);
            echo ApiHelper::jsonResponse(['message' => 'Book updated successfully']);
        } catch (InvalidArgumentException $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // TODO: Implementar método para eliminar un libro
    public function delete(string $isbn) {
        try {
            $this->book->delete($isbn);
            echo ApiHelper::jsonResponse(['message' => 'Book deleted successfully']);
        } catch (InvalidArgumentException $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // DESAFÍO: Implementar búsqueda avanzada
    public function search() {
        try {
            $query = $_GET['q'] ?? '';
            $page = (int)($_GET['page'] ?? 1);
            $limit = (int)($_GET['limit'] ?? 10);

            $books = $this->book->search($query);
            $paginatedBooks = $this->book->getPaginated($page, $limit);

            echo ApiHelper::jsonResponse([
                'books' => $paginatedBooks,
                'total' => count($books),
                'page' => $page,
                'limit' => $limit
            ]);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }
} 