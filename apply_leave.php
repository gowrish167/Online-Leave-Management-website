<?php 
include 'session_check.php'; 

if(isset($_POST['apply'])){
    $type = $_POST['leave_type'];
    $from = $_POST['from_date'];
    $to = $_POST['to_date'];
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    // Insert request with 'pending' status
    $query = "INSERT INTO leave_requests (user_id, leave_type, from_date, to_date, reason, status) 
              VALUES ('$user_id', '$type', '$from', '$to', '$reason', 'pending')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Leave Applied Successfully!'); window.location='leave_history.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply Leave | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 card p-4 shadow-sm border-0">
                <h3 class="mb-4">Request New Leave</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <select name="leave_type" class="form-select" required>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Leave</label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="Explain your reason here..." required></textarea>
                    </div>
                    <button type="submit" name="apply" class="btn btn-primary w-100">Submit Application</button>
                    <a href="dashboard.php" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">Back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>