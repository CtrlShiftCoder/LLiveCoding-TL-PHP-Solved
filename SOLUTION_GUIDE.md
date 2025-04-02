# Guía de Solución: API de Biblioteca

## Descripción General
Este documento explica los detalles de implementación y las metodologías utilizadas para resolver el ejercicio de la API de Biblioteca. La solución demuestra varios niveles de experiencia en el desarrollo de APIs usando PHP.

## Arquitectura y Patrones de Diseño

### 1. Patrón MVC
- **Modelos**: Las clases Book y Loan manejan los datos y la lógica de negocio
- **Controladores**: Manejan el procesamiento de solicitudes y formato de respuestas
- **Datos Mock**: Simula la capa de base de datos con almacenamiento en memoria

### 2. Principios SOLID Aplicados
- **Responsabilidad Única**: Cada clase tiene un propósito específico
- **Abierto/Cerrado**: Nueva funcionalidad agregada mediante extensión (búsqueda, paginación)
- **Segregación de Interfaces**: Métodos agrupados por funcionalidad relacionada
- **Inversión de Dependencias**: Los controladores dependen de abstracciones

## Características de Implementación

### 1. Características Básicas (Nivel Junior)
```php
// Ejemplo de operación CRUD básica
public function getAll(): array {
    return MockData::$books;
}
```

### 2. Características Intermedias (Nivel Mid)
```php
// Ejemplo de validación de datos
public function create(array $data): bool {
    if (empty($data['isbn']) || empty($data['title'])) {
        throw new InvalidArgumentException('Faltan campos requeridos');
    }
    // ... implementación
}
```

### 3. Características Avanzadas (Nivel Senior)
```php
// Implementación de caché
public function getFromCache(string $isbn): ?array {
    if (isset(self::$cache[$isbn])) {
        return self::$cache[$isbn];
    }
    // ... implementación
}
```

## Mejores Prácticas Implementadas

### 1. Manejo de Errores
- Formato de respuesta de error consistente
- Códigos de estado HTTP apropiados
- Manejo de excepciones en múltiples niveles
- Mensajes de error detallados

### 2. Validación de Entrada
```php
// Ejemplo de validación de entrada
if (!isset(MockData::$books[$isbn])) {
    throw new InvalidArgumentException('Libro no encontrado');
}
```

### 3. Estandarización de Respuestas
```php
// Respuesta JSON estandarizada
public static function jsonResponse($data, int $code = 200): string {
    return json_encode([
        'status' => $code < 400 ? 'success' : 'error',
        'data' => $data,
        'timestamp' => time()
    ]);
}
```

### 4. Medidas de Seguridad
- Implementación de límite de velocidad
- Sanitización de entrada
- Seguridad en mensajes de error
- Estructura de control de acceso

## Optimizaciones de Rendimiento

### 1. Sistema de Caché
- Caché en memoria para libros frecuentemente accedidos
- Invalidación de caché en actualizaciones
- Tiempos de búsqueda eficientes

### 2. Implementación de Búsqueda
```php
public function search(string $query): array {
    $query = strtolower($query);
    return array_filter(MockData::$books, function($book) use ($query) {
        return strpos(strtolower($book['title']), $query) !== false ||
               strpos(strtolower($book['author']), $query) !== false;
    });
}
```

### 3. Paginación
```php
public function getPaginated(int $page = 1, int $limit = 10): array {
    $offset = ($page - 1) * $limit;
    return array_slice($books, $offset, $limit);
}
```

## Monitoreo y Registro

### 1. Registro de Solicitudes
```php
public static function logOperation(string $operation, array $data): void {
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'operation' => $operation,
        'data' => $data,
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
    // ... implementación
}
```

### 2. Límite de Velocidad
```php
public static function checkRateLimit(string $ip): bool {
    $minute = date('YmdHi');
    if (!isset(self::$requestCount[$ip][$minute])) {
        self::$requestCount[$ip] = [$minute => 1];
        return true;
    }
    // ... implementación
}
```

## Organización del Código

### 1. Estructura de Archivos
```
api/
├── config/
│   └── MockData.php      # Almacenamiento de datos
├── models/
│   ├── Book.php          # Operaciones de libros
│   └── Loan.php          # Operaciones de préstamos
├── controllers/
│   ├── BookController.php # Manejo de solicitudes
│   └── LoanController.php # Manejo de préstamos
├── helpers/
│   └── ApiHelper.php     # Funciones de utilidad
└── index.php             # Punto de entrada
```

### 2. Convenciones de Nomenclatura
- Nombres de métodos claros y descriptivos
- Nomenclatura consistente de variables
- Uso apropiado de type hinting en PHP
- Comentarios PHPDoc donde sea necesario

## Consideraciones de Prueba
- Lógica de negocio aislada para facilitar pruebas
- Contratos claros de entrada/salida
- Escenarios de error cubiertos
- Casos límite manejados


## Conclusión
Esta implementación demuestra varios niveles de experiencia en desarrollo PHP, desde operaciones CRUD básicas hasta características avanzadas como caché y límite de velocidad. El código está organizado, es mantenible y sigue las mejores prácticas modernas de PHP.

## Evaluación de Niveles

### Nivel Junior
- Implementación básica de CRUD
- Manejo simple de errores
- Seguimiento de estructura básica

### Nivel Mid
- Validaciones robustas
- Manejo adecuado de respuestas HTTP
- Implementación de búsqueda básica

### Nivel Senior
- Implementación de caché
- Sistema de rate limiting
- Logging avanzado
- Arquitectura escalable
- Consideraciones de seguridad 