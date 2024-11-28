<?php
$page_title = "CCS Ranking System - Dashboard";
session_start();

// Check if session is set
if (isset($_SESSION['account'])) {
    // Verify role_id existence and value
    if (empty($_SESSION['account']['role_id'])) {
        // Log error message for debugging
        error_log("Access attempt with missing or invalid role_id.");
        // Redirect to login page with an error message
        header('location: ../account/loginwcss.php?error=missing_role');
        exit;
    }
} else {
    // Log error message for debugging
    error_log("Unauthorized access attempt. Session not set.");
    // Redirect to login page with an error message
    header('location: ../account/loginwcss.php?error=unauthorized');
    exit;
}
$account = $_SESSION['account'];

// Include header file with error handling
$header_file = 'includes/header.php';
if (file_exists($header_file)) {
    require_once($header_file);
} else {
    // Log error message for debugging
    error_log("Header file ($header_file) not found.");
    // Display user-friendly error message
    die("An error occurred while loading the dashboard. Please try again later.");
}

?>

    <div class="wrapper">
        <?php include('includes/sidebar.php') ?>
        <div class="main p-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Applications</h4>
                    <div class="table-wrapper table-responsive">
                        <table class="table table-bordered" style="width: 100%">
                            <thead>
                            <th>Student Name</th>
                            <th>Studen ID</th>
                            <th>Course & Year</th>
                            <th>Submission Date</th>
                            <th>Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('includes/footer.php') ?>