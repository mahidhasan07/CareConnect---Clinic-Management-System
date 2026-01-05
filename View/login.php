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
    <div class="form-box">
        <h2>Login</h2>
        <form action="../Controller/loginCheck.php" method="POST">
            <label>Email</label>
            <input type="email" name="email" value="" required> <label>Password</label>
            <input type="password" name="password" value="" required> <input type="submit" name="submit" value="Login" class="btn">
        </form>
        <br>
        <p>New user? <a href="register.php" style="color:#007bff; margin:0;">Register Here</a></p>
    </div>
</body>
</html>