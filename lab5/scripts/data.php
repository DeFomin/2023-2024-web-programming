<?php
$db = new SQLite3('data.db');

$db->exec("CREATE TABLE IF NOT EXISTS orders (
    id INTEGER PRIMARY KEY,
    first_name TEXT,
    last_name TEXT,
    middle_name TEXT,
    address TEXT,
    phone TEXT,
    email TEXT,
    product TEXT,
    comments TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first-name"];
    $last_name = $_POST["last-name"];
    $middle_name = $_POST["middle-name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $product = $_POST["products"];
    $comments = $_POST["comments"];
} else {
    echo "Данные не были отправлены через форму.<br>";
}


$query = "INSERT INTO orders (first_name, last_name, middle_name, address, phone, email, product, comments) VALUES ('$first_name', '$last_name', '$middle_name', '$address', '$phone', '$email', '$product', '$comments')";
$result = $db->exec($query);

$results = $db->query("SELECT * FROM orders");
while ($row = $results->fetchArray()) 
{
    var_dump($row);
}

$db->close();
?>

<br>
<button style="
    display: block;
    width: 35%;
    padding: 10px;
    color: white;
    background-color: rgb(116, 20, 171);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 5px;"
    onclick="history.go(-1);"
>
OK
</button>
