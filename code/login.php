<?php 
    $msg = ""; 
    if(isset($_POST['submitBtn']) && !empty($_POST['email']) && !empty($_POST['password'])){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "phonedb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user where email = '$email' and password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            header("Location: index.php");
        } else {
            $msg = "Wrong combination";
        }
        
        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cozastore Login</title>
</head>
<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="email" name="email" placeholder="Email" id="email" required="required">
        <input type="password" name="password" placeholder="Password" id="password" required="required">
        <input type="submit" name="submitBtn" value="Submit">
    </form>
    <p id="status"><?php echo $msg; ?></p>
</body>
</html>