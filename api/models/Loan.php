<?php
require_once "config/MockData.php";

class Loan {
    // Propiedades
    private $loans = [];
    private $loan_id;
    private $isbn;
    private $status;

    // TODO: Implementar método para crear un préstamo
    public function create($isbn) {
        if (empty($isbn)) {
            throw new InvalidArgumentException('ISBN cannot be empty');
        }
        
        // Simular almacenamiento
        $this->loans[] = [
            'isbn' => $isbn,
            'date' => date('Y-m-d H:i:s'),
            'status' => 'active'
        ];
        
        return true;
    }

    // TODO: Implementar método para devolver un libro
    public function returnBook($isbn) {
        if (empty($isbn)) {
            throw new InvalidArgumentException('ISBN cannot be empty');
        }
        
        foreach ($this->loans as &$loan) {
            if ($loan['isbn'] === $isbn && $loan['status'] === 'active') {
                $loan['status'] = 'returned';
                return true;
            }
        }
        
        throw new InvalidArgumentException('Active loan not found for this ISBN');
    }

    // TODO: Implementar método para obtener préstamos activos
    public function getActiveLoans() {
        return array_filter($this->loans, function($loan) {
            return $loan['status'] === 'active';
        });
    }
} 