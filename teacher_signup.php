<?php 
include '../includes/db.php'; 

if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    $uppercase = preg_match('@[A-Z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);

    if(!$uppercase || !$number || strlen($pass) < 8) {
        $error = "Password must be at least 8 characters, include 1 uppercase letter and 1 number.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "This faculty email is already registered!";
        } else {
            $query = "INSERT INTO users (fullname, email, password, role) VALUES ('$name', '$email', '$pass', 'teacher')";
            if(mysqli_query($conn, $query)){
                echo "<script>alert('Teacher Signup Successful!'); window.location='teacher_login.php';</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Registration | LeaveFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), 
                        url('https://images.unsplash.com/photo-1544640808-32ca72ac7f37?auto=format&fit=crop&q=80&w=1500');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .signup-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white !important;
            border-radius: 10px;
            padding: 12px;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.5); }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #10b981;
            box-shadow: none;
        }
        .btn-signup {
            background: #10b981;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            color: white;
            transition: 0.3s;
        }
        .btn-signup:hover { background: #059669; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="signup-card shadow-lg">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold" style="color: #10b981;">👩‍🏫 Teacher Signup</h2>
                        <p class="text-muted small">Faculty registration for leave management</p>
                    </div>

                    <?php if(isset($error)) echo "<div class='alert alert-danger bg-danger bg-opacity-25 border-danger text-white small'>$error</div>"; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Prof. Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Official Email</label>
                            <input type="email" name="email" class="form-control" placeholder="faculty@college.edu" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Min. 8 chars, 1 uppercase, 1 number.</small>
                        </div>
                        <button type="submit" name="signup" class="btn btn-signup w-100 mb-3">REGISTER FACULTY</button>
                        <div class="text-center">
                            <span class="small text-muted">Already have an account? <a href="teacher_login.php" class="text-success text-decoration-none fw-bold">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>