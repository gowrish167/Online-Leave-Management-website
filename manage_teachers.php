<?php 
include 'session_check.php'; 

// HANDLE APPROVAL / REJECTION
if(isset($_GET['id']) && isset($_GET['status'])){
    $id = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    mysqli_query($conn, "UPDATE leave_requests SET status='$status' WHERE id='$id'");
    header("Location: manage_teachers.php");
    exit();
}

// Handle Search Query
$search = "";
if(isset($_POST['search_btn'])){
    $search = mysqli_real_escape_string($conn, $_POST['search_txt']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Teacher Leaves | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; }
        .table-teacher { border-radius: 10px; overflow: hidden; }
        .table-teacher thead { background: #16a34a; color: white; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <h3 class="fw-bold text-success">👩‍🏫 Faculty Leave Management</h3>
        
        <form method="POST" class="d-flex gap-2 w-50">
            <input type="text" name="search_txt" class="form-control" placeholder="Search teacher by name..." value="<?php echo $search; ?>">
            <button type="submit" name="search_btn" class="btn btn-success px-4">Search</button>
            <?php if($search != ""): ?>
                <a href="manage_teachers.php" class="btn btn-outline-secondary">Reset</a>
            <?php endif; ?>
        </form>
        
        <a href="dashboard.php" class="btn btn-dark">Dashboard</a>
    </div>

    

    <div class="card shadow border-0 table-teacher">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Faculty Name</th>
                    <th>Leave Type</th>
                    <th>Duration</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Decision</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query joining users and leave_requests for 'teacher' role
                $sql = "SELECT leave_requests.*, users.fullname FROM leave_requests 
                        JOIN users ON leave_requests.user_id = users.id 
                        WHERE users.role='teacher'";
                
                if($search != ""){
                    $sql .= " AND users.fullname LIKE '%$search%'";
                }
                
                $sql .= " ORDER BY applied_on DESC";
                $res = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $status = $row['status'];
                        $badge = ($status == 'pending') ? 'bg-warning text-dark' : (($status == 'approved') ? 'bg-success' : 'bg-danger');
                        
                        echo "<tr>
                            <td><strong>".$row['fullname']."</strong></td>
                            <td>".$row['leave_type']."</td>
                            <td>".$row['from_date']." <small class='text-muted'>to</small> ".$row['to_date']."</td>
                            <td><small>".(strlen($row['reason']) > 30 ? substr($row['reason'],0,30)."..." : $row['reason'])."</small></td>
                            <td><span class='badge $badge'>".ucfirst($status)."</span></td>
                            <td>";
                            if($status == 'pending'){
                                echo "<a href='?id=".$row['id']."&status=approved' class='btn btn-sm btn-success me-1'>Approve</a>";
                                echo "<a href='?id=".$row['id']."&status=rejected' class='btn btn-sm btn-danger'>Reject</a>";
                            } else {
                                echo "<span class='text-muted small'>Complete</span>";
                            }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No faculty records found matching '$search'</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>