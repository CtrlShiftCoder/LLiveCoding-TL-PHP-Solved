# Ejercicio Live Coding: API REST de Biblioteca

## Descripción
Implementar una API REST simple para gestionar libros y préstamos de una biblioteca, usando datos en memoria (sin base de datos).

## Estructura del Proyecto
```
├── api/
│   ├── config/
│   │   └── MockData.php          # Datos de ejemplo en memoria
│   ├── controllers/
│   │   ├── BookController.php    # Controlador de libros
│   │   └── LoanController.php    # Controlador de préstamos
│   ├── helpers/
│   │   └── ApiHelper.php         # Utilidades y funciones comunes
│   ├── models/
│   │   ├── Book.php             # Modelo de libros
│   │   └── Loan.php             # Modelo de préstamos
│   └── index.php                 # Punto de entrada de la API
├── README.md                     # Instrucciones del ejercicio
└── SOLUTION_GUIDE.md            # Guía de solución y explicación
```

## Endpoints a Implementar

### Libros
```
GET    /api/books          - Listar libros
GET    /api/books/{isbn}   - Obtener libro
POST   /api/books          - Crear libro
PUT    /api/books/{isbn}   - Actualizar libro
DELETE /api/books/{isbn}   - Eliminar libro
GET    /api/books/search   - Buscar libros (Desafío)
```

### Préstamos
```
POST   /api/loans/{isbn}   - Prestar libro
PUT    /api/loans/{isbn}   - Devolver libro
GET    /api/loans          - Ver préstamos activos
```

## Tareas a Completar

### 1. Implementar Modelo Book
- Método getAll() - Retornar todos los libros
- Método getByIsbn() - Buscar libro por ISBN
- Método create() - Crear nuevo libro
- Método update() - Actualizar libro existente
- Método delete() - Eliminar libro

### 2. Implementar Modelo Loan
- Método create() - Crear préstamo
- Método returnBook() - Procesar devolución
- Método getActiveLoans() - Listar préstamos activos

### 3. Implementar Controllers
- Métodos CRUD en BookController
- Métodos de préstamo en LoanController

### 4. Implementar Routing
- Configurar rutas en index.php
- Manejar métodos HTTP
- Retornar respuestas JSON

## Ejemplo de Respuestas

### Libro
```json
{
    "isbn": "123456",
    "title": "The Great Gatsby",
    "author": "F. Scott Fitzgerald",
    "available": true
}
```

### Préstamo
```json
{
    "loan_id": 1,
    "isbn": "123456",
    "status": "active"
}
```

## Criterios de Evaluación
1. Funcionamiento correcto de endpoints
2. Manejo de errores básico
3. Código limpio y organizado
4. Uso correcto de POO

## Tiempo Estimado
- 45-60 minutos

## Consejos
- Usar MockData.php para los datos
- Mantener la solución simple
- Enfocarse en la funcionalidad básica

## Desafíos Extra (Evaluación de Seniority)

### Nivel 1 - Básico (Junior)
- Implementar todos los endpoints básicos
- Manejar errores simples
- Seguir la estructura propuesta

### Nivel 2 - Intermedio (Mid)
- Implementar validaciones de datos
- Manejar respuestas HTTP correctamente (200, 201, 404, etc.)
- Implementar un sistema simple de búsqueda de libros por título o autor

### Nivel 3 - Avanzado (Senior)
- Implementar un sistema de caché para los libros más consultados
- Agregar paginación en el listado de libros
- Implementar un sistema de rate limiting simple
- Agregar logging de operaciones

