<?php
require_once "config/MockData.php";

class Book {
    // Propiedades
    private $isbn;
    private $title;
    private $author;
    private $available;
    private static $cache = [];

    // TODO: Implementar método para obtener todos los libros
    public function getAll(): array {
        return MockData::$books;
    }

    // TODO: Implementar método para obtener un libro por ISBN
    public function getByIsbn(string $isbn): ?array {
        return MockData::$books[$isbn] ?? null;
    }

    // TODO: Implementar método para crear un nuevo libro
    public function create(array $data): bool {
        // Validar datos requeridos
        if (empty($data['isbn']) || empty($data['title']) || empty($data['author'])) {
            throw new InvalidArgumentException('Missing required fields');
        }

        // Validar que el ISBN no exista
        if (isset(MockData::$books[$data['isbn']])) {
            throw new InvalidArgumentException('ISBN already exists');
        }

        // Crear nuevo libro
        MockData::$books[$data['isbn']] = [
            'isbn' => $data['isbn'],
            'title' => $data['title'],
            'author' => $data['author'],
            'available' => true
        ];

        return true;
    }

    // TODO: Implementar método para actualizar un libro
    public function update(string $isbn, array $data): bool {
        // Validar que el libro exista
        if (!isset(MockData::$books[$isbn])) {
            throw new InvalidArgumentException('Book not found');
        }

        // Actualizar campos permitidos
        $allowedFields = ['title', 'author'];
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                MockData::$books[$isbn][$field] = $data[$field];
            }
        }

        return true;
    }

    // TODO: Implementar método para eliminar un libro
    public function delete(string $isbn): bool {
        // Validar que el libro exista
        if (!isset(MockData::$books[$isbn])) {
            throw new InvalidArgumentException('Book not found');
        }

        // Validar que no tenga préstamos activos
        foreach (MockData::$loans as $loan) {
            if ($loan['isbn'] === $isbn && $loan['status'] === 'active') {
                throw new InvalidArgumentException('Cannot delete book with active loans');
            }
        }

        unset(MockData::$books[$isbn]);
        return true;
    }

    // DESAFÍO: Implementar búsqueda avanzada
    public function search(string $query): array {
        $query = strtolower($query);
        return array_filter(MockData::$books, function($book) use ($query) {
            return strpos(strtolower($book['title']), $query) !== false ||
                   strpos(strtolower($book['author']), $query) !== false;
        });
    }

    // DESAFÍO: Implementar sistema de caché
    public function getFromCache(string $isbn): ?array {
        if (isset(self::$cache[$isbn])) {
            return self::$cache[$isbn];
        }

        $book = $this->getByIsbn($isbn);
        if ($book) {
            self::$cache[$isbn] = $book;
        }

        return $book;
    }

    // DESAFÍO: Implementar paginación
    public function getPaginated(int $page = 1, int $limit = 10): array {
        $books = array_values(MockData::$books);
        $offset = ($page - 1) * $limit;
        return array_slice($books, $offset, $limit);
    }
} 