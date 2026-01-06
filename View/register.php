<!DOCTYPE html>
<html>
<head>
    <title>CMS - Register</title>
    <link rel="stylesheet" href="../Asset/style.css">
</head>
<body>
    <div class="form-box">
        <h2>Patient Registration</h2>
        
        <?php if (isset($_GET['error'])) { ?>
            <p style="color: red; font-size: 14px; text-align: center;">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </p>
        <?php } ?>

        <form action="../Controller/registerCheck.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required 
                   value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
            
            <input type="email" name="email" placeholder="Email" required
                   value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            
            <input type="password" name="password" placeholder="Password" required>
            
            <input type="text" name="phone" placeholder="Phone Number" required
                   value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>">

            <input type="number" name="age" placeholder="Age" required
                   value="<?php echo isset($_GET['age']) ? htmlspecialchars($_GET['age']) : ''; ?>">
            
            <?php $g = isset($_GET['gender']) ? $_GET['gender'] : ''; ?>
            <select name="gender" required>
                <option value="" disabled <?php if($g == '') echo 'selected'; ?>>Select Gender</option>
                <option value="Male" <?php if($g == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($g == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($g == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <input type="text" name="address" placeholder="Address" required
                   value="<?php echo isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; ?>">
            
            <input type="hidden" name="role" value="patient">

            <input type="submit" name="submit" value="Register Now" class="btn">
        </form>
        <br>
        <p>Already registered? <a href="login.php" style="color:#007bff; margin:0;">Login</a></p>
    </div>
</body>
</html>