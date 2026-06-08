<?php 
include '../includes/db.php'; 

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Explicitly check for 'admin' role
    $query = "SELECT * FROM users WHERE email='$email' AND password='$pass' AND role='admin'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = 'admin';
        $_SESSION['name'] = $user['fullname'];
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        $error = "Access Denied: Admin Credentials Only!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; font-family: 'Inter', sans-serif; }
        .login-card { border: none; border-radius: 20px; background: #ffffff; }
        .btn-admin { background: #0f172a; color: white; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-4">
                <div class="card login-card p-4 shadow-lg">
                    <div class="text-center mb-4">
                        <span style="font-size: 3rem;">🛡️</span>
                        <h2 class="fw-bold text-dark">Admin Login</h2>
                        <p class="text-muted">HOD / Management Portal</p>
                    </div>
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Admin Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-admin w-100 py-2">Authorize Login</button>
                    </form>
                    <div class="text-center mt-4">
                         <a href="../index.php" class="text-muted small">← Back to Main System</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>