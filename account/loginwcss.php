<?php
$page_title = "CodeLuck - Login";
include_once "../includes/_head.php";
require_once '../tools/functions.php';
require_once '../classes/account.class.php';

session_start();

$email_or_username = $password = '';
$accountObj = new Account();
$loginErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_username = clean_input(($_POST['email_or_username']));
    $password = clean_input($_POST['password']);

    if ($accountObj->login($email_or_username, $password)) {
        $data = $accountObj->fetch($email_or_username);
        $_SESSION['account'] = $data;
        header('location: ../admin/dashboard.php');
    } else {
        $loginErr = 'Invalid credentials';
    }
} else {
    if (isset($_SESSION['account'])) {
        if ($_SESSION['account']['is_staff']) {
            header('location: ../admin/dashboard.php');
        }
    }
}
?>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .logo-section,
    p {
        margin: 0;
    }

    p {
        width: 50%;
        margin: auto;
    }
</style>

<body class="d-flex align-items-center justify-content-center container" style="height: 100vh">

    <main class="form-signin border w-50 p-5 rounded">
        <form action="loginwcss.php" method="post">
            <div class="logo-section">
                <div class="d-flex justify-content-center align-items-center logo">
                    <img class="text-center" src="../img/ccs_logo.png" alt="" width="150" height="150">
                </div>
                <p class="text-center p-1">COLLEGE OF COMPUTING STUDIES
                    OFFICIAL RANKING SYSTEM</p>
            </div>


            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="email_or_username" name="email_or_username" placeholder="Email or Username">
                <label for="email_or_username">Email/Username</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <p class="w-full">Don't have an account?
                <a href="signup.php">Sign up here</a>
            </p>
            <p class="text-danger"><?= $loginErr ?></p>

            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
    </main>
    <?php
    require_once '../includes/_footer.php';
    ?>
</body>

</html>