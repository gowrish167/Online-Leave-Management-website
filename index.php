<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeaveFlow | Digital Leave Management</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #00d2ff;
            --secondary: #3a7bd5;
            --student-color: #3b82f6;
            --teacher-color: #10b981;
            --admin-color: #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            color: white;
            margin: 0;
            scroll-behavior: smooth;
        }

        /* HERO SECTION */
        .hero {
            height: 70vh;
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.85)), 
                        url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* INFO SECTIONS */
        .section-title { font-weight: 800; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 2px; }
        .info-box { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 30px; transition: 0.3s; height: 100%; }
        .info-box:hover { background: rgba(255, 255, 255, 0.06); border-color: var(--primary); }

        /* STEP INDICATORS */
        .step-num { width: 50px; height: 50px; background: var(--primary); color: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 20px; font-size: 1.2rem; box-shadow: 0 0 20px rgba(0, 210, 255, 0.4); }

        /* ROLE CARDS */
        .portal-card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 24px; padding: 40px 30px; transition: all 0.4s ease; height: 100%; }
        .portal-card:hover { transform: translateY(-10px); background: rgba(255, 255, 255, 0.07); }
        .btn-portal { border-radius: 12px; padding: 10px 20px; font-weight: 700; width: 100%; margin-bottom: 10px; }

        h1 { font-size: clamp(2rem, 5vw, 4rem); font-weight: 800; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(10px);">
    <div class="container">
        <a class="navbar-brand fw-bold text-white fs-3" href="index.php">LEAVE<span style="color:var(--primary)">FLOW</span></a>
        <a href="#portals" class="btn btn-primary rounded-pill px-4">Get Started</a>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <h1 class="mb-3">TRANSFORMING CAMPUS LOGISTICS</h1>
        <p class="lead opacity-75 mb-5">The most efficient way to manage academic and professional leaves.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#how-it-works" class="btn btn-outline-light btn-lg rounded-pill px-4">Learn More</a>
            <a href="#portals" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow">Login Now</a>
        </div>
    </div>
</section>

<section id="how-it-works" class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Why LeaveFlow?</h2>
        <p class="text-muted mx-auto" style="max-width: 700px;">Our system eliminates paper forms, long wait times, and manual tracking. We provide a 100% digital experience for modern institutions.</p>
    </div>
    
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="info-box">
                <div class="step-num mx-auto">01</div>
                <h4>Paperless Process</h4>
                <p class="small text-muted">Environmentally friendly and organized. All records are stored securely in our cloud database.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <div class="step-num mx-auto">02</div>
                <h4>Real-Time Tracking</h4>
                <p class="small text-muted">No more wondering about your application. Get instant updates when your HOD takes action.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <div class="step-num mx-auto">03</div>
                <h4>Digital Slips</h4>
                <p class="small text-muted">Once approved, generate a professional, printable leave slip with unique ID verification.</p>
            </div>
        </div>
    </div>
</section>



<section class="py-5" style="background: rgba(255,255,255,0.02);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold mb-4">How It Works <br><span class="text-primary">Step-By-Step</span></h2>
                <p class="text-muted">We have simplified the complex approval chain into four simple digital actions.</p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3 text-primary">✔️</div>
                    <div>
                        <h5>Create Your Account</h5>
                        <p class="small text-muted">Signup as a Student or Teacher using your institutional ID and email.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3 text-primary">✔️</div>
                    <div>
                        <h5>Submit Leave Form</h5>
                        <p class="small text-muted">Enter your leave dates, type (Sick, Casual, Academic), and provide a valid reason.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3 text-primary">✔️</div>
                    <div>
                        <h5>Admin Review</h5>
                        <p class="small text-muted">The HOD/Admin reviews the request on their master dashboard instantly.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-3 fs-3 text-primary">✔️</div>
                    <div>
                        <h5>Final Notification</h5>
                        <p class="small text-muted">You receive an 'Approved' or 'Rejected' status with optional admin feedback.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="portals" class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Institutional Portals</h2>
        <p class="text-muted">Choose your specific role to enter your dedicated dashboard.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="portal-card text-center border-bottom border-primary border-4 shadow-lg">
                <div class="icon-circle mb-3 fs-1">🎓</div>
                <h3>Students</h3>
                <p class="text-muted mb-4 small">Submit leaves, track approval status, and view your semester history.</p>
                <div class="d-grid gap-2">
                    <a href="auth/student_login.php" class="btn btn-primary btn-portal">STUDENT LOGIN</a>
                    <a href="auth/student_signup.php" class="btn btn-outline-light btn-portal">STUDENT SIGNUP</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="portal-card text-center border-bottom border-success border-4 shadow-lg">
                <div class="icon-circle mb-3 fs-1">👩‍🏫</div>
                <h3>Teachers</h3>
                <p class="text-muted mb-4 small">Request duty or personal leaves and manage your professional profile.</p>
                <div class="d-grid gap-2">
                    <a href="auth/teacher_login.php" class="btn btn-success btn-portal text-white">TEACHER LOGIN</a>
                    <a href="auth/teacher_signup.php" class="btn btn-outline-light btn-portal">TEACHER SIGNUP</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="portal-card text-center border-bottom border-warning border-4 shadow-lg">
                <div class="icon-circle mb-3 fs-1">🛡️</div>
                <h3>HOD / Admin</h3>
                <p class="text-muted mb-4 small">Executive dashboard to monitor all requests and generate reports.</p>
                <div class="d-grid gap-2">
                    <a href="auth/admin_login.php" class="btn btn-warning btn-portal text-dark" style="margin-top: 50px;">ADMIN LOGIN</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="py-5 text-center opacity-50 border-top border-secondary mt-5">
    <div class="container">
        <h4 class="text-white mb-3">LeaveFlow</h4>
        <p>&copy; 2026 Online Leave Management System | All Rights Reserved.</p>
        <p class="small">Designed to modernize campus communications and administrative efficiency.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>