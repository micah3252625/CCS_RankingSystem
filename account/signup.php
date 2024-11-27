<?php
$page_title = "CCS Ranking System";
include_once "../includes/_head.php";
require_once '../tools/functions.php';
require_once '../classes/user.class.php';
require_once '../classes/account.class.php';
require_once '../classes/role.class.php';

session_start();
$userObj = new User();
$accountObj = new Account();
$roleObj = new Role();
$roles = $roleObj->renderAllRoles(); // Fetch all roles for dropdown

// Initialize variables
$first_name = $last_name = $username = $password = $role = $email = $other = '';
$first_nameErr = $last_nameErr = $usernameErr = $passwordErr = $roleErr = $emailErr = $otherErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Clean and validate input
    $first_name = clean_input($_POST['firstname']);
    $last_name = clean_input($_POST['lastname']);
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $role = clean_input($_POST['role']);
    $email = clean_input($_POST['email']);
    $other = clean_input($_POST['other']);

    // Validate first name
    if (empty($first_name)) {
        $first_nameErr = "First name is required!";
    }

    // Validate last name
    if (empty($last_name)) {
        $last_nameErr = "Last name is required!";
    }

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format!";
    }

    // Validate username
    if (empty($username)) {
        $usernameErr = "Username is required!";
    } elseif ($accountObj->usernameExist($username)) {
        $usernameErr = "Username already taken!";
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required!";
    }

    // Validate role
    if (empty($role)) {
        $roleErr = "Role is required!";
    }

    // Validate course/department based on role
    if ($role === 'student' && empty($other)) {
        $otherErr = "Course is required for students!";
    } elseif ($role === 'staff' && empty($other)) {
        $otherErr = "Department is required for staff!";
    }

    // If no errors, create the account
    if (empty($first_nameErr) && empty($last_nameErr) && empty($usernameErr) && empty($passwordErr) && empty($roleErr) && empty($emailErr) && empty($otherErr)) {
        $userObj->first_name = $first_name;
        $userObj->last_name = $last_name;
        $userObj->username = $username;
        $userObj->password = $password;
        $userObj->role_id = $role;
        $userObj->email = $email;

        // Store account
        if ($userObj->store()) {
            header("Location: loginwcss.php");
            exit();
        } else {
            $usernameErr = "Failed to create account. Please try again!";
        }
    }
}
?>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <form action="signup.php" method="post">
            <img class="mb-4" src="../img/box.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Sign Up</h1>

            <!-- First Name -->
            <div class="form-floating">
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" value="<?= htmlspecialchars($first_name) ?>" required>
                <label for="firstname">First Name</label>
                <p class="text-danger"><?= $first_nameErr ?></p>
            </div>

            <!-- Last Name -->
            <div class="form-floating">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="<?= htmlspecialchars($last_name) ?>" required>
                <label for="lastname">Last Name</label>
                <p class="text-danger"><?= $last_nameErr ?></p>
            </div>

            <!-- Course/Department -->
            <div class="form-floating">
                <input type="text" class="form-control" id="other" name="other" placeholder="Course or Department" value="<?= htmlspecialchars($other) ?>" required>
                <label for="other">Course/Department</label>
                <p class="text-danger"><?= $otherErr ?></p>
            </div>

            <!-- Email -->
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
                <label for="email">Email</label>
                <p class="text-danger"><?= $emailErr ?></p>
            </div>

            <!-- Role -->
            <div class="form-floating">
                <select class="form-control" id="role" name="role" required>
                    <option value="" disabled selected>Select a role</option>
                    <?php
                    foreach ($roles as $r) {
                        $isSelected = ($role == $r['name']) ? 'selected' : '';
                        echo "<option value=\"{$r['name']}\" $isSelected>{$r['name']}</option>";
                    }
                    ?>
                </select>
                <label for="role">Role</label>
                <p class="text-danger"><?= $roleErr ?></p>
            </div>

            <!-- Username -->
            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($username) ?>" required>
                <label for="username">Username</label>
                <p class="text-danger"><?= $usernameErr ?></p>
            </div>

            <!-- Password -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
                <p class="text-danger"><?= $passwordErr ?></p>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Sign Up</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2024–2025</p>
        </form>
    </main>
    <?php include_once '../includes/_footer.php'; ?>
</body>

</html>