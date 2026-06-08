<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Lists</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h3>Registered Users</h3>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow border-0 p-3">
                <h5>🎓 Students</h5>
                <table class="table table-sm mt-2">
                    <thead><tr><th>Name</th><th>Email</th></tr></thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM users WHERE role='student'");
                        while($row = mysqli_fetch_assoc($res)) echo "<tr><td>".$row['fullname']."</td><td>".$row['email']."</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow border-0 p-3">
                <h5>👩‍🏫 Teachers</h5>
                <table class="table table-sm mt-2">
                    <thead><tr><th>Name</th><th>Email</th></tr></thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM users WHERE role='teacher'");
                        while($row = mysqli_fetch_assoc($res)) echo "<tr><td>".$row['fullname']."</td><td>".$row['email']."</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4"><a href="dashboard.php" class="btn btn-dark">Back to Dashboard</a></div>
</div>
</body>
</html>