<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
?>

<!-- HEADER -->
<header class="header">

    <div class="navbar">

        <div class="nav-left">

            <img src="../../assets/img/ITMSLOGO.jpg" class="logo">

            <span class="title">
                ITMS INVENTECH
            </span>

        </div>

        <!-- PROFILE -->
        <div class="admin-profile" id="adminProfile">

            <span>
                <?= htmlspecialchars($user['username']) ?>
            </span>

            <div class="profile-avatar">
                <?= strtoupper(substr($user['username'], 0, 1)) ?>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a href="../../auth/logout.php">
                    Logout
                </a>

            </div>

        </div>

    </div>

</header>

<!-- DROPDOWN SCRIPT -->
<script>
    const adminProfile = document.getElementById("adminProfile");
    const dropdownMenu = document.getElementById("dropdownMenu");

    adminProfile.addEventListener("click", () => {
        dropdownMenu.style.display =
            dropdownMenu.style.display === "block"
                ? "none"
                : "block";
    });

    // CLOSE WHEN CLICK OUTSIDE
    window.addEventListener("click", function (e) {

        if (!adminProfile.contains(e.target)) {
            dropdownMenu.style.display = "none";
        }

    });
</script>