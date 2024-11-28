<?php
$page_title = "CCS Ranking System - Add Account";

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
require_once '../classes/account.class.php'; // Include the User class
?>

<div class="wrapper">
    <?php include('includes/sidebar.php') ?>
    <div class="main p-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title pb-2 mb-2">Add New Account</h4>
                    <a href="dashboard.add.accounts.php" class="btn btn-secondary">
                        <span>
                                Back
                            </span>
                    </a>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>