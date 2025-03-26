<?php
session_start();
require '../php/config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = md5($_POST['password']); // MD5 encryption (although using password_hash() is more secure)

    // Fix: Use prepared statements to avoid SQL injection and prevent syntax errors
    $stmt = $conn->prepare("SELECT * FROM users WHERE gmail = ? AND password = ?");
    $stmt->execute([$email, $password]); // Secure query execution using prepared statements

    $user = $stmt->fetch(); // Fetch the result

    if ($user) {
        $_SESSION['user_id'] = $user['sno'];
        $_SESSION['username'] = $user['usernameid'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        echo "<script>alert('Login successful!'); window.location='../dot';</script>";
    } else {
        $error = "<div class='alert alert-danger'>Invalid email or password.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container {
            max-width: 400px; margin: 80px auto; padding: 30px;
            background: white; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="login-container">
            <h3 class="text-center">Login</h3>
            <?php echo $error ?? ''; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <br>
                <a href="forgot-password.php">Forgot Password?</a>
            </form>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
