<?php
    class Product 
    {
        private $conn;
        private $table = 'products';

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
            // $query = 'SELECT 
            // C.name as product_name,
            // p.id,
            // p.category_id,
            // p.sku,
            // p.product_name,
            // p.size,
            // p.height,
            // p.width,
            // p.length,
            // p.weight,
            // p.created_at
            // FROM
            // ' . $this->table . ' p 
            // LEFT JOIN 
            // categories c ON p.category_id = c.id
            // ORDER BY
            // p.created_at DESC';

            $query = 'SELECT * FROM ' . $this->table;

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single()
        {
            // $query = 'SELECT 
            // C.name as category_name,
            // p.id,
            // p.category_id,
            // p.title,
            // p.author,
            // p.created_at
            // FROM
            // ' . $this->table . ' p 
            // LEFT JOIN 
            // categories c ON p.category_id = c.id
            // WHERE
            // p.id = ?
            // LIMIT 0,1';


            $query = 'SELECT * FROM ' . $this->table . ' WHERE products.id = ? LIMIT 0,1';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->sku = $row['sku'];
            $this->product_name = $row['product_name'];
            $this->size = $row['size'];
            $this->category_id = $row['category_id'];
            $this->height = $row['height'];
            $this->width = $row['width'];
            $this->length = $row['length'];
            $this->weight = $row['weight'];
            // return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . '
                SET 
                    sku = :sku,
                    category_id = :category_id,
                    product_name = :product_name,
                    size = :size,
                    height = :height,
                    width = :width,
                    length = :length,
                    weight = :weight
            ';

            $stmt = $this->conn->prepare($query);

            $this->sku = htmlspecialchars(strip_tags($this->sku));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->product_name = htmlspecialchars(strip_tags($this->product_name));
            $this->size = htmlspecialchars(strip_tags($this->size));
            $this->height = htmlspecialchars(strip_tags($this->height));
            $this->width = htmlspecialchars(strip_tags($this->width));
            $this->length = htmlspecialchars(strip_tags($this->length));
            $this->weight = htmlspecialchars(strip_tags($this->weight));

            $stmt->bindParam(':sku', $this->sku);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':product_name', $this->product_name);
            $stmt->bindParam(':size', $this->size);
            $stmt->bindParam(':height', $this->height);
            $stmt->bindParam(':width', $this->width);
            $stmt->bindParam(':length', $this->length);
            $stmt->bindParam(':weight', $this->weight);

            if($stmt->execute()) {
                return true;
            }

            printf("Error: %s. \n", $stmt->error);

            return false;
            
        }
    }
