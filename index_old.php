<?php
// Define your location project directory in htdocs (EX THE FULL PATH: D:\xampp\htdocs\x-kang\simple-routing-with-php)
// /x-kang/simple-routing-with-php
$project_location = "/ruangterbukahijau";
$me = $project_location;


// For get URL PATH
$request = $_SERVER['REQUEST_URI'];

echo "Farhan123 <br />";
echo $request . "<br />";

$urlParam = explode('?', $request);
$urlParam = $urlParam[1];
print_r($urlParam[1]);

// if($urlParam !=== "") {

// } 
switch ($request) {
    case $me . '/test':
        require "front-end/view/test.html";
        break;
    case $me . '/login':
        require "front-end/view/login/index.php";
        break;
    case $me . '/register':
        require "front-end/view/register/index.php";
        break;
    case $me . '/listing/{.*}':
        require "front-end/view/listing/index.php";
        break;
    case $me . '/detail':
        require "front-end/view/detail/index.php";
        break;
    case $me . '/detail-edit':
        require "front-end/view/detail/admin/edit.php";
        break;
    case $me . '/detail-setmap':
        require "front-end/view/detail/admin/setmap.php";
        break;
        // Back-end
    case $me . '/api/register':
        require "back-end/register/register.php";
        break;
    case $me . '/api/authenticate':
        require "back-end/login/authenticate.php";
        break;
    default:
        http_response_code(404);
        require "front-end/view/notfound/index.php";
        break;
}
