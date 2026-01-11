<!DOCTYPE html>
<html>
<head>
    <title>CMS - Login</title>
    <link rel="stylesheet" href="../Asset/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Clinic Management System</h1>
        </div>
    </header>

    <div class="login-form">
        <h2>Login</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p style="color: red; font-size: 14px; margin-bottom: 10px;">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </p>
        <?php } ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success') { ?>
            <p style="color: green; font-size: 14px; margin-bottom: 10px;">
                Registration successful! Please login.
            </p>
        <?php } ?>

        <form action="../Controller/loginCheck.php" method="POST">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required><br>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required><br>
            
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p><a href="home.php" style="font-size: 12px; color: #555;">&larr; Back to Home</a></p>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('msg') === 'timeout') {
            alert("Session Expired! You were inactive for 45 seconds. Please login again.");
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
</body>
</html>