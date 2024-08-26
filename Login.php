<?php
$host="localhost";
$user="root";
$password="";
$db="user";

session_start();

$data = mysqli_connect($host, $user, $password, $db);
if($data === false) {
    die("Connection error");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST["username"];   
    $password = $_POST["password"];

    $stmt = $data->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    
    if ($row) {
        if ($row["usertype"] == "user") {
            $_SESSION["username"] = $username;
            header("location:userhome.php");
            exit();
        } elseif ($row["usertype"] == "admin") {
            $_SESSION["username"] = $username;
            header("location:admin.php");
            exit();
        }
    } else {
        echo "Username or password incorrect";
    }

 
    $stmt->close();
}


mysqli_close($data);
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <header>
<img src="lokalhood.png" alt="komang">
    </header>
    <form action="#" method="post">
    <h1>Login</h1>
    <fieldset>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <input id="pass" type="submit" value="Login">   
    </fieldset>
    </form>
</body>
</html>
