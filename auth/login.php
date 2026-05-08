<?php
session_start();
include("../config/db.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

/* =========================
   GET USER DATA
========================= */
$stmt = $conn->prepare("
    SELECT 
        id,
        email,
        password,
        role_id,
        division_id,
        username,
        is_active,
        first_name,
        last_name
    FROM users
    WHERE email = ?
    LIMIT 1
");

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* =========================
   VALIDATIONS
========================= */

// user not found
if (!$user) {
    header("Location: ../index.php?error=user_not_found");
    exit();
}

// inactive account
if ($user['is_active'] != 1) {
    header("Location: ../index.php?error=account_disabled");
    exit();
}

// wrong password
if (!password_verify($password, $user['password'])) {
    header("Location: ../index.php?error=wrong_password");
    exit();
}

/* =========================
   SESSION
========================= */
session_regenerate_id(true);

$_SESSION['user'] = [
    'id' => $user['id'],
    'email' => $user['email'],
    'role_id' => $user['role_id'],
    'division_id' => $user['division_id'],
    'username' => $user['username'],
    'name' => $user['first_name'] . ' ' . $user['last_name']
];

/* =========================
   REDIRECT
========================= */
switch ($user['role_id']) {

    case 1:
        header("Location: ../superadmin/superadmin_dashboard.php");
        break;

    case 2:
        header("Location: ../admin/admin_dashboard.php");
        break;

    case 3:
        header("Location: ../encoder/encoder_dashboard.php");
        break;

    default:
        header("Location: ../index.php?error=invalid_role");
        break;
}

exit();
?>