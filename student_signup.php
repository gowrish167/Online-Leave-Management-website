<?php 
include '../includes/db.php'; 

if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    // PASSWORD RULES VALIDATION
    $uppercase = preg_match('@[A-Z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);

    if(!$uppercase || !$number || strlen($pass) < 8) {
        $error = "Password must be at least 8 characters, include 1 uppercase letter and 1 number.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $error = "Email already exists!";
        } else {
            $query = "INSERT INTO users (fullname, email, password, role) VALUES ('$name', '$email', '$pass', 'student')";
            if(mysqli_query($conn, $query)){
                echo "<script>alert('Student Signup Successful!'); window.location='student_login.php';</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup | LeaveFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Using a high-quality dark library image to match your reference */
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

        .signup-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9) !important; /* Lighter inputs for better readability like your image */
            border: none;
            color: #1e293b !important;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 5px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: block;
        }

        .btn-signup {
            background: #3b82f6; /* Matching the blue button in your image */
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 15px;
        }

        .btn-signup:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(37, 99, 235, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #fca5a5;
            border-radius: 10px;
            padding: 10px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="signup-card">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-1">🎓 Student Signup</h2>
                    <p class="text-muted small">Enter your details to create a student account</p>
                </div>

                <?php if(isset($error)) echo "<div class='alert-error mb-3 text-center'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="password" required>
                        <small class="opacity-75" style="font-size: 0.7rem;">Min. 8 chars, 1 uppercase, 1 number.</small>
                    </div>

                    <button type="submit" name="signup" class="btn btn-signup w-100">REGISTER ACCOUNT</button>
                    
                    <div class="text-center mt-4">
                        <span class="small opacity-75">Already have an account? </span>
                        <a href="student_login.php" class="text-info text-decoration-none small fw-bold">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>