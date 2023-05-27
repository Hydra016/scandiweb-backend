<?php
    class Product 
    {
        private $conn;
        private $table = 'posts';

        public $id;
        public $sku;
        public $category_id;
        public $product_name;
        public $size;
        public $height;
        public $width;
        public $length;
        public $weight;
        public $created_at;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read() 
        {
            $query = 'SELECT 
            C.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.author,
            p.created_at
            FROM
            ' . $this->table . ' p 
            LEFT JOIN 
            categories c ON p.category_id = c.id
            ORDER BY
            p.created_at DESC';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }
