<?php 
include_once '../../config/Database.php';
include_once '../../models/Product.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$result = $product->read();

$num = $result->rowCount();


// public $id;
//         public $sku;
//         public $category_id;
//         public $product_name;
//         public $size;
//         public $height;
//         public $width;
//         public $length;
//         public $weight;
//         public $created_at;

if(isset($_GET['id'])) {

    $product->id = $_GET['id'];
    $product->read_single();

    $product_arr = array(
        'id' => $product->id,
        'sku' => $product->sku,
        'product_name' => $product->product_name,
        'size' => $product->size,
        'category_id' => $product->category_id,
        'height' => $product->height,
        'width' => $product->width,
        'length' => $product->length,
        'weight' => $product->weight
    );

    print_r(json_encode($product_arr));
} else {
    if($num > 0) {
        $products_arr = array();
        $products_arr['data'] = array();
    
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
    
            $product_item = array(
                'id' => $id,
                'category_id' => $category_id,
                'product_name' => $product_name,
                'size' => $size,
                'height' => $height,
                'width' => $width,
                'length' => $length,
                'weight' => $weight
            );
    
        array_push($products_arr['data'], $product_item);    
        }
    
        echo json_encode($products_arr);
    } else {
        echo json_encode(
            array('message' => 'No products Found')
        );
    }
    
}

