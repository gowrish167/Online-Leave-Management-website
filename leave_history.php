<?php include 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Leave History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">My Leave History</h3>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        
        <div class="card shadow border-0 overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Type</th>
                        <th>From - To</th>
                        <th>Reason</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Print</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM leave_requests WHERE user_id='$user_id' ORDER BY applied_on DESC");
                    
                    if(mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)){
                            $status = $row['status'];
                            $badge = ($status == 'approved') ? 'bg-success' : (($status == 'rejected') ? 'bg-danger' : 'bg-warning text-dark');
                            
                            echo "<tr>";
                            echo "<td><strong>" . $row['leave_type'] . "</strong></td>";
                            echo "<td>" . $row['from_date'] . " to " . $row['to_date'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
                            echo "<td>" . date('d M Y', strtotime($row['applied_on'])) . "</td>";
                            echo "<td><span class='badge $badge'>" . ucfirst($status) . "</span></td>";
                            echo "<td>";
                            if($status == 'approved'){
                                echo "<a href='../includes/print_slip.php?id=" . $row['id'] . "' target='_blank' class='btn btn-sm btn-outline-dark'>🖨️ Slip</a>";
                            } else {
                                echo "<small class='text-muted'>Unavailable</small>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-4'>No leave applications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>