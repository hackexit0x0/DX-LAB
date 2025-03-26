<?php

include "../php/config.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password = md5($password); // Hashing password

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE gmail = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->rowCount() > 0) {
        $error = "<div class='alert alert-danger'>Email already exists. Try another.</div>";
    } else {
        // Generate username
        $stmt = $conn->query("SELECT COUNT(*) AS user_count FROM users");
        $row = $stmt->fetch();
        $userCount = $row['user_count'] + 1;
        $username = "user" . str_pad($userCount, 2, "0", STR_PAD_LEFT);

        // Insert into database
        $insert = $conn->prepare("INSERT INTO users (name, gmail, usernameid, password) VALUES (?, ?, ?, ?)");
        if ($insert->execute([$name, $email, $username, $password])) {
            $error = "<div class='alert alert-success'>Registration successful. You can now <a href='login.php'>login</a>.</div>";
        } else {
            $error = "<div class='alert alert-danger'>Registration failed. Please try again.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .register-container {
            max-width: 400px; margin: 80px auto; padding: 30px;
            background: white; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-dark">
    <br><br><br><br>
    <div class="container">
        <div class="register-container">
            <h3 class="text-center">Register</h3>
            <?php if (isset($error)) echo $error; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <br>
                <a href="login.php">Already have an account?</a>
            </form>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
