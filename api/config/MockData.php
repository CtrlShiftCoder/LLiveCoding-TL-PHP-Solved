<?php

class MockData {
    public static $books = [
        "123456" => [
            "isbn" => "123456",
            "title" => "The Great Gatsby",
            "author" => "F. Scott Fitzgerald",
            "available" => true
        ],
        "789012" => [
            "isbn" => "789012",
            "title" => "To Kill a Mockingbird",
            "author" => "Harper Lee",
            "available" => true
        ]
    ];

    public static $loans = [
        [
            "loan_id" => 1,
            "isbn" => "123456",
            "status" => "active"
        ]
    ];
} 