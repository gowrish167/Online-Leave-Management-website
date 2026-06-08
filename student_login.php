<?php 
include '../includes/db.php'; 

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Explicitly check for 'student' role
    $query = "SELECT * FROM users WHERE email='$email' AND password='$pass' AND role='student'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = 'student';
        $_SESSION['name'] = $user['fullname'];
        header("Location: ../student/dashboard.php");
        exit();
    } else {
        $error = "Invalid Student Credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | LeaveFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Same professional background as signup for consistency */
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), 
                        url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 45px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9) !important;
            border: none;
            color: #1e293b !important;
            border-radius: 10px;
            padding: 14px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.9);
        }

        .btn-student {
            background: #3b82f6;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-student:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(37, 99, 235, 0.3);
        }

        .forgot-link {
            color: #fca5a5;
            text-decoration: none;
            font-size: 0.8rem;
            transition: 0.3s;
        }

        .forgot-link:hover { color: #ef4444; }

        .signup-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #fca5a5;
            border-radius: 10px;
            padding: 12px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <div class="text-center mb-4">
                    <span style="font-size: 3rem;">🎓</span>
                    <h2 class="fw-bold mt-2">Student Login</h2>
                    <p class="text-muted small">Access your leave portal</p>
                </div>

                <?php if(isset($error)) echo "<div class='alert-error mb-4 text-center'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Password</label>
                            <a href="forgot_password.php" class="forgot-link">Forgot?</a>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="login" class="btn btn-student w-100 mt-2">Sign In</button>
                    
                    <div class="text-center mt-4">
                        <p class="small opacity-75 mb-1">New here?</p>
                        <a href="student_signup.php" class="signup-link small">Create Student Account</a>
                        <div class="mt-3">
                            <a href="../index.php" class="text-white opacity-50 text-decoration-none small">← Back to Home</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>