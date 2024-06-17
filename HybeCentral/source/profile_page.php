<?php
session_start();

// Check if user is logged in, redirect if not
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}

// Database connection settings
$host = '127.0.0.1';
$db = 'hybe_central';
$user = 'root';
$pass = '';

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user data based on session username
$username = $_SESSION['username'];
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch user details
if ($user = mysqli_fetch_assoc($result)) {
    $displayName = $user['username'];
    // Other fields as needed (email, bio, top1, top2, top3)
} else {
    echo "Error: User not found.";
    exit;
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="user_profile.css">
    <link rel="icon" href="assets/newhycenfav.ico">
    <title>HYCEN Profile</title>
</head>
<body>
    <section class="user_">
        <div class="user_dashboard_nav">
            <div class="user_handle">
                <div class="profilepic_holder"></div>
                <div class="User_account">
                    <div class="username">
                        <h1><?php echo htmlspecialchars($displayName); ?></h1>
                    </div>
                    <div class="user_email">
                        <h4><?php echo htmlspecialchars($user['email']); ?></h4>
                    </div>
                </div>
                <div class="nav_buttons">
                    <button id="home"><p>HOME</p></button>
                    <button id="gallery"><p>GALLERY</p></button>
                    <button id="about"><p>ABOUT</p></button>
                </div>

                <script>

                    let homebtn = document.getElementById('home');
                    let gal = document.getElementById('gallery');
                    let bout = document.getElementById('about');

                    homebtn.onclick = function() {
                        window.location.href = 'user_dashboard.html';
                    }

                    gal.onclick = function() {
                        window.location.href = 'gallery.html';
                    }

                    bout.onclick = function() {
                        window.location.href = 'about_page.html'
                    }


                </script>
            </div>
        </div>
        <div class="user_dashboard_body">
            <div class="left">
                <div class="about_me_field">
                    <h1>ABOUT ME</h1>
                    <form id="abtme" action="save_profile.php" method="POST">
                        <label for="DspName">Display Name :</label><br>
                        <input type="text" id="DspName" name="displayName" value="<?php echo htmlspecialchars($displayName); ?>" readonly><br>
                        <label for="Bdate">BirthDate :</label><br>
                        <input type="date" id="Bdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>" readonly><br>
                        <div class="biofield">
                            <label for="Bio">Bio :</label><br>
                            <textarea id="Bio" name="bio" maxlength="500" readonly><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea><br>
                        </div>
                        <button type="button" id="togglebutton">Edit</button>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="top_picks">
                    <div class="tp_title">
                        <h1>TOP IDOLS</h1>
                    </div>
                    <form id="toppicks" action="save_profile.php" method="POST">
                        <label for="TOP1">Top 1: </label><br>
                        <input type="text" id="TOP1" name="top1" value="<?php echo htmlspecialchars($user['top1'] ?? ''); ?>" readonly><br>
                        <label for="TOP2">Top 2: </label><br>
                        <input type="text" id="TOP2" name="top2" value="<?php echo htmlspecialchars($user['top2'] ?? ''); ?>" readonly><br>
                        <label for="TOP3">Top 3: </label><br>
                        <input type="text" id="TOP3" name="top3" value="<?php echo htmlspecialchars($user['top3'] ?? ''); ?>" readonly><br>
                        <button type="button" id="toggleTopPicks">Edit Top Picks</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script src="user_profile.js"></script>
</body>
</html>
