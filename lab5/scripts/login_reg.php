<?php

$db = new SQLite3('data_login.db');

$db->exec("CREATE TABLE IF NOT EXISTS login_base (
    id INTEGER PRIMARY KEY,
    login TEXT,
    hashed_password BLOB,
    plain_password TEXT,
    inverse_password BLOB
)");

// функция; меняем 1 и 0 местами
function bitnot($bin) {
    $not = "";
    for ($i = 0; $i < strlen($bin); $i++)
    {
        if($bin[$i] == 0) { $not .= '1'; }
        if($bin[$i] == 1) { $not .= '0'; }
    }
    return $not;
}

function invert_password($pass) {
    // получаем биты
    $bytes = unpack('C*', $pass);
    $binary = '';
    foreach ($bytes as $byte) {
        $binary .= str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);
    }
    $inverted_binary = bitnot($binary);

    // декод
    $length = strlen($inverted_binary);
    $inverted_password = '';

    for ($i = 0; $i < $length; $i += 8) {
        $byte = bindec(substr($inverted_binary, $i, 8));
        $inverted_password .= chr($byte);
    }

    return $inverted_password;
}

function check_user($login, $password, $db) {
    $result = $db->query("SELECT * FROM login_base WHERE login = '$login'");
    if (!$result) return false;

    if ($row = $result->fetchArray()) {
        $hashed_password = $row["hashed_password"];
        $correct = password_verify($password, $hashed_password);
        if ($correct) {
            return true;
        }
        return false;
    } 
    return false;
}


function redirect_next($message, $next_page) {
    echo "<script type='text/javascript'>alert('$message'); window.location.href='$next_page';</script>";
}

$success_message = "Error!";
$login = $_POST['username'];
$password = $_POST['password'];

$user_exists = check_user($login, $password, $db);
echo $user_exists;
if ($user_exists) {
    redirect_next("Login success! everything works good", "../index.php");
} else {
    $inverse_password = invert_password($password);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO login_base (
        login, plain_password, hashed_password
    ) VALUES (
        '$login', '$password', '$hashed_password'
    )";

    $result = $db->query($query);
    
    redirect_next("Register success!", "../index.php");
}
$db->close();

?>
