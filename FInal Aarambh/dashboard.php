<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.html");
    exit();
}

$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LifeLink</title>
    <style>
        :root {
            --primary: #e53935;
            --primary-light: #ff6f60;
            --primary-dark: #ab000d;
            --secondary: #4caf50;
            --secondary-light: #80e27e;
            --secondary-dark: #087f23;
            --text-light: #ffffff;
            --text-dark: #212121;
            --background: #f5f5f5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--background);
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        header {
            background-color: var(--primary);
            color: var(--text-light);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .container {
            width: 85%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-light);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
        }
        
        .nav-links li {
            margin: 0 15px;
        }
        
        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--secondary-light);
        }
        
        .btn {
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s;
            background-color: var(--secondary);
            color: var(--text-light);
        }
        
        .btn:hover {
            background-color: var(--secondary-dark);
        }
        
        main {
            padding: 50px 0;
        }
        
        .dashboard-welcome {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .dashboard-welcome h1 {
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .user-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .user-info h2 {
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .user-info p {
            margin: 10px 0;
        }
        
        .dashboard-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-box {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: 0.3s;
        }
        
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-box h3 {
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .feature-box p {
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="index.html" class="logo">
                    LifeLink
                </a>
                <ul class="nav-links">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="logout.php" class="btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="dashboard-welcome">
                <h1>Welcome to Your Dashboard!</h1>
                <p>Successfully logged in to LifeLink</p>
                
                <div class="user-info">
                    <h2>Your Account Information</h2>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>
                    <p><strong>Account Type:</strong> <?php echo ucfirst(htmlspecialchars($user_type)); ?></p>
                    <p><strong>Status:</strong> <span style="color: var(--secondary);">Active</span></p>
                </div>
            </div>
            
            <div class="dashboard-features">
                <?php if ($user_type == 'individual'): ?>
                    <div class="feature-box">
                        <h3>🩸 Find Blood</h3>
                        <p>Search for available blood donations in your area</p>
                    </div>
                    <div class="feature-box">
                        <h3>💝 Donate Blood</h3>
                        <p>Register as a blood donor and save lives</p>
                    </div>
                    <div class="feature-box">
                        <h3>📅 My Donations</h3>
                        <p>View your donation history and schedule</p>
                    </div>
                <?php elseif ($user_type == 'hospital'): ?>
                    <div class="feature-box">
                        <h3>🏥 Blood Requests</h3>
                        <p>Create and manage blood requests</p>
                    </div>
                    <div class="feature-box">
                        <h3>📊 Inventory</h3>
                        <p>Track blood inventory and supplies</p>
                    </div>
                    <div class="feature-box">
                        <h3>👥 Donors</h3>
                        <p>Connect with available blood donors</p>
                    </div>
                <?php elseif ($user_type == 'bloodbank'): ?>
                    <div class="feature-box">
                        <h3>🩸 Blood Stock</h3>
                        <p>Manage blood bank inventory</p>
                    </div>
                    <div class="feature-box">
                        <h3>📦 Distribution</h3>
                        <p>Track blood distribution to hospitals</p>
                    </div>
                    <div class="feature-box">
                        <h3>📈 Analytics</h3>
                        <p>View donation and usage statistics</p>
                    </div>
                <?php endif; ?>
                
                <div class="feature-box">
                    <h3>📞 Support</h3>
                    <p>Get help and contact support</p>
                </div>
            </div>
        </div>
    </main>

    <footer style="background-color: #333; color: white; padding: 20px 0; text-align: center; margin-top: 50px;">
        <div class="container">
            <p>&copy; 2025 LifeLink by Team Aarambh. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
