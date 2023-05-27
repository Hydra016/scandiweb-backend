<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

$product->sku = $data->sku;
$product->category_id = $data->category_id;
$product->product_name = $data->product_name;
$product->size = $data->size;
$product->height = $data->height;
$product->width = $data->width;
$product->length = $data->length;
$product->weight = $data->weight;

if($product->create()) {
    echo json_encode(
        array('message' => 'Post Created')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}
?>