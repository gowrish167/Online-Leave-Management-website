<?php 
include 'session_check.php'; 

// HANDLE APPROVAL / REJECTION
if(isset($_GET['id']) && isset($_GET['status'])){
    $id = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    mysqli_query($conn, "UPDATE leave_requests SET status='$status' WHERE id='$id'");
    header("Location: manage_students.php");
    exit();
}

// Handle Search Query
$search = "";
if(isset($_POST['search_btn'])){
    $search = mysqli_real_escape_string($conn, $_POST['search_txt']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Student Leaves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between mb-4 align-items-center">
        <h3>🎓 Student Leave Requests</h3>
        
        <form method="POST" class="d-flex gap-2">
            <input type="text" name="search_txt" class="form-control" placeholder="Search by name..." value="<?php echo $search; ?>">
            <button type="submit" name="search_btn" class="btn btn-primary">Search</button>
            <?php if($search != ""): ?>
                <a href="manage_students.php" class="btn btn-outline-secondary">Reset</a>
            <?php endif; ?>
        </form>
        
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow border-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th>Student Name</th>
                    <th>Type</th>
                    <th>Dates</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Modify query based on search
                $sql = "SELECT leave_requests.*, users.fullname FROM leave_requests 
                        JOIN users ON leave_requests.user_id = users.id 
                        WHERE users.role='student'";
                
                if($search != ""){
                    $sql .= " AND users.fullname LIKE '%$search%'";
                }
                
                $sql .= " ORDER BY applied_on DESC";
                
                $res = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $badge = ($row['status'] == 'pending') ? 'bg-warning' : (($row['status'] == 'approved') ? 'bg-success' : 'bg-danger');
                        echo "<tr>
                            <td><b>".$row['fullname']."</b></td>
                            <td>".$row['leave_type']."</td>
                            <td>".$row['from_date']." to ".$row['to_date']."</td>
                            <td>".$row['reason']."</td>
                            <td><span class='badge $badge'>".ucfirst($row['status'])."</span></td>
                            <td>";
                            if($row['status'] == 'pending'){
                                echo "<a href='?id=".$row['id']."&status=approved' class='btn btn-sm btn-success me-1'>Approve</a>";
                                echo "<a href='?id=".$row['id']."&status=rejected' class='btn btn-sm btn-danger'>Reject</a>";
                            } else {
                                echo "<small class='text-muted'>Processed</small>";
                            }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center py-4'>No records found matching '$search'</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>