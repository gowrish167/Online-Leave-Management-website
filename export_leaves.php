<?php
include 'session_check.php';

// Set headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Leave_Report_'.date('Y-m-d').'.csv');

// Open the output stream
$output = fopen('php://output', 'w');

// Set the column headings
fputcsv($output, array('ID', 'Name', 'Role', 'Leave Type', 'From Date', 'To Date', 'Reason', 'Status', 'Applied On'));

// Fetch the data
$query = "SELECT leave_requests.id, users.fullname, users.role, leave_requests.leave_type, 
          leave_requests.from_date, leave_requests.to_date, leave_requests.reason, 
          leave_requests.status, leave_requests.applied_on 
          FROM leave_requests 
          JOIN users ON leave_requests.user_id = users.id 
          ORDER BY leave_requests.applied_on DESC";

$rows = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($rows)) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>