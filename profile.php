<?php
include 'db.php';

// Redirect if not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// Handle Update
if(isset($_POST['update_profile'])){
    $new_name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $new_pass = $_POST['new_password'];

    // Update Name
    mysqli_query($conn, "UPDATE users SET fullname='$new_name' WHERE id='$user_id'");
    $_SESSION['name'] = $new_name; // Update session name immediately

    // Update Password if provided
    if(!empty($new_pass)){
        $uppercase = preg_match('@[A-Z]@', $new_pass);
        $number    = preg_match('@[0-9]@', $new_pass);

        if(!$uppercase || !$number || strlen($new_pass) < 8) {
            $msg = "<div class='alert alert-warning'>Name updated, but password failed rules (Min 8 chars, 1 Upper, 1 Number).</div>";
        } else {
            mysqli_query($conn, "UPDATE users SET password='$new_pass' WHERE id='$user_id'");
            $msg = "<div class='alert alert-success'>Profile and Password updated successfully!</div>";
        }
    } else {
        $msg = "<div class='alert alert-success'>Name updated successfully!</div>";
    }
}

// Fetch current data
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-4">
                    <h3 class="mb-4">⚙️ Account Settings</h3>
                    <?php echo $msg; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email Address (Cannot change)</label>
                            <input type="text" class="form-control" value="<?php echo $user_data['email']; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $user_data['fullname']; ?>" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">New Password (Leave blank to keep current)</label>
                            <input type="password" name="new_password" class="form-control" placeholder="••••••••">
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="javascript:history.back()" class="text-muted text-decoration-none">← Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>