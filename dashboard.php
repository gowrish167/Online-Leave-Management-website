<?php 
// session_check.php contains session_start() and role validation
include 'session_check.php'; 

// Database connection is assumed to be in session_check.php or included here
// include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Admin | Management Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f1f3f9;
            --sidebar-dark: #33394b;
            --accent-purple: #8b5cf6;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body { 
            background: var(--bg-color); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #2d3748;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar { 
            min-height: 100vh; 
            background: var(--sidebar-dark); 
            border-radius: 0 30px 30px 0;
            padding: 30px 15px;
            color: white;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 10px 20px;
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .sidebar-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8c93a7;
            padding: 0 20px;
            margin: 20px 0 10px;
        }

        .sidebar a { 
            color: #a0aec0; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            padding: 12px 20px; 
            border-radius: 12px;
            transition: 0.3s; 
            margin-bottom: 5px;
        }

        .sidebar a i { width: 25px; }

        .sidebar a:hover, .sidebar a.active { 
            background: rgba(255, 255, 255, 0.1); 
            color: white; 
        }

        .badge-notif { 
            background: #f59e0b; 
            color: white; 
            padding: 2px 8px; 
            border-radius: 20px; 
            font-size: 0.7rem;
            margin-left: auto;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
        }

        /* Top Navbar */
        .top-nav {
            background: var(--sidebar-dark);
            border-radius: 20px;
            padding: 15px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: var(--card-shadow);
        }

        .nav-links a {
            color: #cbd5e0;
            text-decoration: none;
            margin-left: 25px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Dashboard Cards */
        .dash-card {
            background: white;
            border: none;
            border-radius: 25px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .dash-card:hover { transform: translateY(-5px); }

        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .bg-soft-blue { background: #ebf4ff; color: #3182ce; }
        .bg-soft-green { background: #f0fff4; color: #38a169; }
        .bg-soft-purple { background: #faf5ff; color: #805ad5; }

        .stat-val { font-size: 2rem; font-weight: 800; margin: 0; }
        .stat-label { color: #718096; font-size: 0.85rem; font-weight: 600; }

        /* Recent Activity Table */
        .activity-card { 
            background: white; 
            border-radius: 25px; 
            padding: 30px; 
            box-shadow: var(--card-shadow); 
            margin-top: 30px; 
        }

        .table thead th { 
            background: transparent; 
            border-bottom: 1px solid #edf2f7; 
            color: #a0aec0; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            font-weight: 700;
        }

        .user-avatar { 
            width: 38px; 
            height: 38px; 
            border-radius: 10px; 
            background: #edf2f7; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: bold; 
            color: #4a5568; 
        }

        .status-pill { 
            padding: 5px 14px; 
            border-radius: 20px; 
            font-size: 0.75rem; 
            font-weight: 700; 
        }

        .export-section {
            background: white;
            border-radius: 25px;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--card-shadow);
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="sidebar d-none d-md-block">
        <div class="sidebar-brand">
            <div style="background: var(--accent-purple); padding: 8px; border-radius: 10px;">
                <i class="fa-solid fa-graduation-cap text-white"></i>
            </div>
            LMS Admin
        </div>

        <?php
        // Fetch Counts for Badges
        $s_pend = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM leave_requests JOIN users ON leave_requests.user_id = users.id WHERE users.role='student' AND status='pending'"))['c'];
        $t_pend = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM leave_requests JOIN users ON leave_requests.user_id = users.id WHERE users.role='teacher' AND status='pending'"))['c'];
        $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM users WHERE role!='admin'"))['c'];
        ?>

        <div class="sidebar-label">Analytics</div>
        <a href="dashboard.php" class="active"><i class="fa-solid fa-chart-line"></i> Overview</a>
        <a href="#"><i class="fa-solid fa-bell"></i> Notifications <?php if(($s_pend + $t_pend) > 0) echo "<span class='badge-notif'>".($s_pend + $t_pend)."</span>"; ?></a>

        <div class="sidebar-label">Management</div>
        <a href="manage_students.php"><i class="fa-solid fa-user-graduate"></i> Students</a>
        <a href="manage_teachers.php"><i class="fa-solid fa-chalkboard-user"></i> Teachers</a>
        <a href="user_lists.php"><i class="fa-solid fa-users"></i> All Users</a>

        <div style="margin-top: 50px;">
            <a href="../auth/logout.php" class="text-danger"><i class="fa-solid fa-power-off"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-nav">
            <h5 class="m-0 fw-bold">Dashboard</h5>
            <div class="nav-links">
                <a href="dashboard.php">Overview</a>
                <a href="manage_students.php">Students</a>
                <a href="manage_teachers.php">Teachers</a>
                <a href="../auth/logout.php" style="background: rgba(255,255,255,0.1); padding: 8px 20px; border-radius: 12px;">
                    <i class="fa-solid fa-link me-2"></i>Logout
                </a>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="fw-bold">Overview</h3>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="dash-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="icon-circle bg-soft-blue">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <p class="stat-label mb-1">PENDING STUDENTS</p>
                            <h1 class="stat-val"><?php echo $s_pend; ?></h1>
                        </div>
                        <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dash-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="icon-circle bg-soft-green">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                            <p class="stat-label mb-1">PENDING TEACHERS</p>
                            <h1 class="stat-val"><?php echo $t_pend; ?></h1>
                        </div>
                        <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dash-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="icon-circle bg-soft-purple">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <p class="stat-label mb-1">TOTAL USERS</p>
                            <h1 class="stat-val"><?php echo $total; ?></h1>
                        </div>
                        <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="activity-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0">Recent Applications & Messages</h5>
                <a href="manage_students.php" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Leave Type</th>
                            <th>Reason / Message</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // FIX: Changed u.name to u.fullname based on your phpMyAdmin screenshot
                        $recent_leaves = mysqli_query($conn, "SELECT lr.*, u.fullname, u.role 
                            FROM leave_requests lr 
                            JOIN users u ON lr.user_id = u.id 
                            ORDER BY lr.applied_on DESC LIMIT 5");

                        if (!$recent_leaves) {
                            echo "<tr><td colspan='5' class='text-center text-danger'>Query Error: " . mysqli_error($conn) . "</td></tr>";
                        } else {
                            while($row = mysqli_fetch_assoc($recent_leaves)) {
                                $role_badge = ($row['role'] == 'teacher') ? 'bg-success' : 'bg-primary';
                                $status_class = ($row['status'] == 'pending') ? 'bg-warning text-dark' : (($row['status'] == 'approved') ? 'bg-success text-white' : 'bg-danger text-white');
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3"><?php echo strtoupper(substr($row['fullname'], 0, 1)); ?></div>
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem;"><?php echo htmlspecialchars($row['fullname']); ?></div>
                                        <span class="badge <?php echo $role_badge; ?>" style="font-size: 0.6rem;"><?php echo strtoupper($row['role']); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-medium" style="font-size: 0.9rem;"><?php echo htmlspecialchars($row['leave_type']); ?></td>
                            <td class="text-muted" style="max-width: 300px; font-size: 0.85rem;">
                                <?php echo htmlspecialchars($row['reason'] ?? 'No reason specified.'); ?>
                            </td>
                            <td class="small text-muted"><?php echo date('M d, Y', strtotime($row['applied_on'])); ?></td>
                            <td>
                                <span class="status-pill <?php echo $status_class; ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="export-section">
            <div>
                <h5 class="fw-bold mb-1">Quick Export</h5>
                <p class="text-muted small m-0">Download institutional leave records for documentation.</p>
            </div>
            <a href="export_leaves.php" class="btn btn-dark rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-file-csv me-2"></i> Generate CSV Report
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>