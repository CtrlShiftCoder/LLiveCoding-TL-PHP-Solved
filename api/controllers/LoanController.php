<?php
require_once "helpers/ApiHelper.php";
require_once "models/Loan.php";

class LoanController {
    private $loan;

    public function __construct() {
        $this->loan = new Loan();
    }

    // Implementar método para crear un nuevo préstamo
    public function create(string $isbn) {
        try {
            $this->loan->create($isbn);
            echo ApiHelper::jsonResponse([
                'message' => 'Loan created successfully',
                'isbn' => $isbn
            ], 201);
        } catch (InvalidArgumentException $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // Implementar método para devolver un libro
    public function returnBook(string $isbn) {
        try {
            $this->loan->returnBook($isbn);
            echo ApiHelper::jsonResponse([
                'message' => 'Book returned successfully',
                'isbn' => $isbn
            ]);
        } catch (InvalidArgumentException $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    // Implementar método para listar préstamos activos
    public function activeLoans() {
        try {
            $loans = $this->loan->getActiveLoans();
            echo ApiHelper::jsonResponse([
                'loans' => $loans,
                'total' => count($loans)
            ]);
        } catch (Exception $e) {
            echo ApiHelper::jsonResponse(['error' => $e->getMessage()], 500);
        }
    }
} 