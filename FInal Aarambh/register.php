<?php
    include 'db.php'; // make sure db.php connects properly to your database

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user type from form submission
        $user_type = isset($_POST['user_type']) ? mysqli_real_escape_string($conn, $_POST['user_type']) : 'individual';
  
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($user_type == 'individual') {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $willing_to_donate = isset($_POST['willing_to_donate']) ? 1 : 0;
        $last_donation_date = !empty($_POST['last_donation_date']) ? mysqli_real_escape_string($conn, $_POST['last_donation_date']) : NULL;

        $sql = "INSERT INTO `individuals` (`first_name`, `last_name`, `email`, `phone`,`password`, `date_of_birth`, `blood_group`, `address`, `willing_to_donate`, `last_donation_date`) VALUES ('$first_name', '$last_name', '$email', '$phone', '$password', '$dob', '$blood_group', '$address', '$willing_to_donate', '$last_donation_date')";
    }

    elseif ($user_type == 'hospital') {
        $hospital_name = mysqli_real_escape_string($conn, $_POST['hospital_name']);
        $hospital_id = mysqli_real_escape_string($conn, $_POST['hospital_id']);
        $hospital_address = mysqli_real_escape_string($conn, $_POST['hospital_address']);
        $hospital_city = mysqli_real_escape_string($conn, $_POST['hospital_city']);
        $hospital_contact_person = mysqli_real_escape_string($conn, $_POST['hospital_contact_person']);

        $sql = "INSERT INTO hospitals (hospital_name, hospital_id, email, phone, password, address, city, contact_person)
                VALUES ('$hospital_name', '$hospital_id', '$email', '$phone', '$password', '$hospital_address', '$hospital_city', '$hospital_contact_person')";
    }

    elseif ($user_type == 'bloodbank') {
        $bloodbank_name = mysqli_real_escape_string($conn, $_POST['bloodbank_name']);
        $license_no = mysqli_real_escape_string($conn, $_POST['license_no']);
        $bloodbank_address = mysqli_real_escape_string($conn, $_POST['bloodbank_address']);
        $bloodbank_city = mysqli_real_escape_string($conn, $_POST['bloodbank_city']);
        $bloodbank_capacity = mysqli_real_escape_string($conn, $_POST['bloodbank_capacity']);

        $sql = "INSERT INTO bloodbanks (bloodbank_name, license_no, email, phone, password, address, city, capacity)
                VALUES ('$bloodbank_name', '$license_no', '$email', '$phone', '$password', '$bloodbank_address', '$bloodbank_city', '$bloodbank_capacity')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful! <a href='loginpage.html'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeLink - Login & Registration</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: var(--primary);
            color: var(--text-light);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            text-decoration: none;
            color: var(--text-light);
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            list-style: none;
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

        main {
            flex: 1;
            padding: 50px 0;
        }

        .auth-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-tabs {
            display: flex;
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            background-color: #f1f1f1;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .auth-tab.active {
            background-color: white;
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
        }

        .auth-content {
            padding: 40px;
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary);
            font-size: 2rem;
        }

        .user-type-selection {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .user-type {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
            width: 150px;
            cursor: pointer;
            transition: 0.3s;
        }

        .user-type.selected {
            border-color: var(--primary);
            background-color: rgba(229, 57, 53, 0.05);
        }

        .user-type-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(229, 57, 53, 0.2);
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 250px;
        }

        .form-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        .form-submit:hover {
            background-color: var(--primary-dark);
        }

        .form-note {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
        }

        .form-note a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .or-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .or-divider::before,
        .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: #ddd;
        }

        .or-divider span {
            padding: 0 15px;
            color: #666;
            font-size: 0.9rem;
        }

        .social-auth {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: transparent;
            cursor: pointer;
            transition: 0.3s;
        }

        .social-btn:hover {
            background-color: #f5f5f5;
        }

        .social-icon {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .additional-fields {
            display: none;
        }

        .additional-fields.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-check-input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }

        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(229, 57, 53, 0.2);
        }

        .success-message {
            text-align: center;
            padding: 20px;
            background-color: rgba(76, 175, 80, 0.1);
            border: 1px solid var(--secondary);
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .error-message {
            color: var(--primary-dark);
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .auth-content {
                padding: 20px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .form-group {
                min-width: 100%;
            }

            .user-type-selection {
                flex-direction: column;
                align-items: center;
            }

            .user-type {
                width: 80%;
                max-width: 200px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="index.html" class="logo">
                    <img src="C:\Users\sarth\OneDrive\Desktop\FInal Aarambh\WhatsApp Image 2025-04-06 at 20.13.42_46a234b7.jpg"
                        alt="LifeLink Logo">
                    LifeLink
                </a>
                <ul class="nav-links">
                    <li><a href="index.html#features">Features</a></li>
                    <li><a href="index.html#how-it-works">How It Works</a></li>
                    <li><a href="index.html#testimonials">Success Stories</a></li>
                    <li><a href="index.html#faq">FAQ</a></li>
                    <li><a href="index.html#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="auth-container">
                <div class="auth-tabs">
                    <div class="auth-tab active" id="login-tab">Login</div>
                    <div class="auth-tab" id="register-tab">Register</div>
                </div>

                <div class="auth-content">
                    <div class="success-message" id="success-message">
                        Account created successfully! You can now login with your credentials.
                    </div>

                    <!-- Login Form -->
                    <form class="auth-form active" id="login-form" action="login.php" method="POST">
                        <h2 class="form-title">Welcome Back</h2>

                        <div class="form-group">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="email" id="login-email" class="form-input"
                                placeholder="Enter your email address" name="email" required>
                            <div class="error-message" id="login-email-error">Please enter a valid email address</div>
                        </div>

                        <div class="form-group">
                            <label for="login-password" class="form-label">Password</label>
                            <input type="password" id="login-password" class="form-input"
                                placeholder="Enter your password" name="password" required>
                            <div class="error-message" id="login-password-error">Password must be at least 6 characters
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="remember-me" class="form-check-input">
                            <label for="remember-me">Remember me</label>
                        </div>

                        <button type="submit" class="form-submit">Login</button>

                        <p class="form-note">
                            <a href="#">Forgot your password?</a>
                        </p>

                        <div class="or-divider">
                            <span>OR</span>
                        </div>

                        <div class="social-auth">
                            <button type="button" class="social-btn">
                                <span class="social-icon">G</span>
                                Google
                            </button>
                            <button type="button" class="social-btn">
                                <span class="social-icon">f</span>
                                Facebook
                            </button>
                        </div>
                    </form>

                    <!-- Register Form -->
                    <form class="auth-form" id="register-form" action="register.php" method="POST">
                        <h2 class="form-title">Create an Account</h2>
                        <!-- <input type="hidden" name="user_type" id="user_type"> -->
                        <div class="user-type-selection">
                            <div class="user-type" name="user_type" data-type="individual">
                                <span class="user-type-icon">👤</span>
                                <span>Individual</span>
                             </div>
                            <div class="user-type" name="user_type" data-type="hospital">
                                <span class="user-type-icon">🏥</span>
                                <span>Hospital</span>
                             </div>
                            <div class="user-type" name="user_type" data-type="bloodbank">
                                <span class="user-type-icon">🩸</span>
                                <span>Blood Bank</span>
                             </div>
                        </div>

                        <!-- Common Fields for All User Types -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="register-email" class="form-label">Email</label>
                                <input type="email" id="register-email" class="form-input"
                                    placeholder="Enter your email address" name="email" required>
                                <div class="error-message" id="register-email-error">Please enter a valid email address
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="register-phone" class="form-label">Phone Number</label>
                                <input type="tel" id="register-phone" class="form-input"
                                    placeholder="Enter your phone number" name="phone" required>
                                <div class="error-message" id="register-phone-error">Please enter a valid phone number
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="register-password" class="form-label">Password</label>
                                <input type="password" id="register-password" class="form-input"
                                    placeholder="Create a password" name="password" required>
                                <div class="error-message" id="register-password-error">Password must be at least 8
                                    characters with letters and numbers</div>
                            </div>
                            <div class="form-group">
                                <label for="register-confirm-password" class="form-label">Confirm Password</label>
                                <input type="password" id="register-confirm-password" name="confirm_password"
                                    class="form-input" placeholder="Confirm your password" required>
                                <div class="error-message" id="register-confirm-password-error">Passwords do not match
                                </div>
                            </div>
                        </div>

                        <!-- Individual User Fields -->
                        <div class="additional-fields active" id="individual-fields">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="register-firstname" class="form-label">First Name</label>
                                    <input type="text" id="register-firstname" class="form-input"
                                        placeholder="Enter your first name" name="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="register-lastname" class="form-label">Last Name</label>
                                    <input type="text" id="register-lastname" class="form-input" name="last_name"
                                        placeholder="Enter your last name" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="register-dob" class="form-label">Date of Birth</label>
                                    <input type="date" id="register-dob" class="form-input" name="dob" required>
                                </div>
                                <div class="form-group">
                                    <label for="register-blood-type" class="form-label">Blood Type</label>
                                    <select id="register-blood-type" class="form-select" name="blood_group" required>
                                        <option value="" disabled selected>Select your blood type</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="unknown">I don't know</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="register-address" class="form-label">Address</label>
                                <input type="text" id="register-address" class="form-input"
                                    placeholder="Enter your address" name="address" required>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" id="register-donor" class="form-check-input"
                                    name="willing_to_donate">
                                <label for="register-donor">I am willing to be a blood donor</label>
                            </div>

                            <div id="donor-info" style="display: none;">
                                <div class="form-group">
                                    <label for="register-last-donation" class="form-label">Last Donation Date (if
                                        applicable)</label>
                                    <input type="date" id="register-last-donation" name="last_donation_date"
                                        class="form-input">
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" id="register-medical-conditions" class="form-check-input">
                                    <label for="register-medical-conditions">I have no medical conditions that prevent
                                        blood donation</label>
                                </div>
                            </div>
                        </div>

                        <!-- Hospital User Fields -->
                        <div class="additional-fields" id="hospital-fields">
                            <div class="form-group">
                                <label for="register-hospital-name" class="form-label">Hospital Name</label>
                                <input type="text" id="register-hospital-name" name="hospital_name" class="form-input"
                                    placeholder="Enter hospital name">
                            </div>

                            <div class="form-group">
                                <label for="register-hospital-id" class="form-label">Hospital Registration ID</label>
                                <input type="text" name="hospital_id" id="register-hospital-id" class="form-input"
                                    placeholder="Enter hospital registration ID">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="register-hospital-address" class="form-label">Hospital Address</label>
                                    <input type="text" name="hospital_address" id="register-hospital-address"
                                        class="form-input" placeholder="Enter hospital address">
                                </div>
                                <div class="form-group">
                                    <label for="register-hospital-city" class="form-label">City</label>
                                    <input type="text" name="hospital_city" id="register-hospital-city"
                                        class="form-input" placeholder="Enter city">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="register-hospital-contact-person" class="form-label">Contact Person</label>
                                <input type="text" name="hospital_contact_person" id="register-hospital-contact-person"
                                    class="form-input" placeholder="Enter name of contact person">
                            </div>

                            <div class="form-check">
                                <input type="checkbox" id="register-hospital-verification" class="form-check-input">
                                <label for="register-hospital-verification">I agree to provide necessary documentation
                                    for verification</label>
                            </div>
                        </div>

                        <!-- Blood Bank User Fields -->
                        <div class="additional-fields" id="bloodbank-fields">
                            <div class="form-group">
                                <label for="register-bloodbank-name" class="form-label">Blood Bank Name</label>
                                <input type="text" name="bloodbank_name" id="register-bloodbank-name" class="form-input"
                                    placeholder="Enter blood bank name">
                            </div>

                            <div class="form-group">
                                <label for="register-bloodbank-id" class="form-label">Blood Bank License Number</label>
                                <input type="text" name="license_no" id="register-bloodbank-id" class="form-input"
                                    placeholder="Enter license number">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="register-bloodbank-address" class="form-label">Blood Bank
                                        Address</label>
                                    <input type="text" name="bloodbank_address" id="register-bloodbank-address"
                                        class="form-input" placeholder="Enter blood bank address">
                                </div>
                                <div class="form-group">
                                    <label for="register-bloodbank-city" class="form-label">City</label>
                                    <input type="text" name="bloodbank_city" id="register-bloodbank-city"
                                        class="form-input" placeholder="Enter city">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="register-bloodbank-capacity" class="form-label">Storage Capacity
                                    (units)</label>
                                <input type="number" id="register-bloodbank-capacity" class="form-input"
                                    placeholder="Enter storage capacity">
                            </div>

                            <div class="form-check">
                                <input type="checkbox" name="bloodbank_capacity" id="register-bloodbank-verification"
                                    class="form-check-input">
                                <label for="register-bloodbank-verification">I agree to provide necessary documentation
                                    for verification</label>
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="register-terms" class="form-check-input" required>
                            <label for="register-terms">I agree to the <a
                                    href="https://www.termsfeed.com/live/047536a6-24fa-4603-a10a-403fc2715e08">Terms of
                                    Service and Privacy Policy</a> </label>
                            <div class="error-message" id="register-terms-error">You must agree to the terms to continue
                            </div>
                        </div>

                        <button type="submit" class="form-submit">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 LifeLink by Team Aarambh. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Tab switching
        document.getElementById('login-tab').addEventListener('click', function () {
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('register-tab').classList.remove('active');
            document.getElementById('login-form').classList.add('active');
            document.getElementById('register-form').classList.remove('active');
        });

        document.getElementById('register-tab').addEventListener('click', function () {
            document.getElementById('register-tab').classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
            document.getElementById('register-form').classList.add('active');
            document.getElementById('login-form').classList.remove('active');
        });

        // User type selection
        const userTypes = document.querySelectorAll('.user-type');
        userTypes.forEach(type => {
            type.addEventListener('click', function () {
                userTypes.forEach(t => t.classList.remove('selected'));
                this.classList.add('selected');
                const userType = this.getAttribute('data-type');
                document.querySelectorAll('.additional-fields').forEach(field => {
                    field.classList.remove('active');
                });

                document.getElementById(userType + '-fields').classList.add('active');
            });
        });

        // Toggle donor info visibility
        document.getElementById('register-donor').addEventListener('change', function () {
            document.getElementById('donor-info').style.display = this.checked ? 'block' : 'none';
        });

        // Form validation
        document.getElementById('login-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Simple validation for login form
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            let isValid = true;

            // Email validation
            if (!validateEmail(email)) {
                document.getElementById('login-email-error').classList.add('show');
                isValid = false;
            } else {
                document.getElementById('login-email-error').classList.remove('show');
            }

            // Password validation
            if (password.length < 6) {
                document.getElementById('login-password-error').classList.add('show');
                isValid = false;
            } else {
                document.getElementById('login-password-error').classList.remove('show');
            }

            if (isValid) {
                // Here you would typically send data to your backend
                alert('Login successful! Redirecting to dashboard...');
                // Redirect to dashboard or homepage
                // window.location.href = 'dashboard.html';
                header("Location: dashboard.php");
                exit();
            }
        });

        document.getElementById('register-form').addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            // Email validation
            const email = document.getElementById('register-email').value;
            if (!validateEmail(email)) {
                document.getElementById('register-email-error').classList.add('show');
                isValid = false;
            } else {
                document.getElementById('register-email-error').classList.remove('show');
            }

            // Phone validation
            const phone = document.getElementById('register-phone').value;
            if (!validatePhone(phone)) {
                document.getElementById('register-phone-error').classList.add('show');
                isValid = false;
            } else {
                document.getElementById('register-phone-error').classList.remove('show');
            }

            // Password validation
          

            // Terms checkbox validation
            if (!document.getElementById('register-terms').checked) {
                document.getElementById('register-terms-error').classList.add('show');
                isValid = false;
            } else {
                document.getElementById('register-terms-error').classList.remove('show');
            }

            if (isValid) {
                // Here you would typically send data to your backend
                document.getElementById('success-message').classList.add('show');
                document.getElementById('register-form').reset();
                showToast("Registered Successfully!");
                // Switch to login tab after successful registration
                setTimeout(() => {
                    document.getElementById('login-tab').click();
                    document.getElementById('success-message').classList.remove('show');
                }, 3000);
                header("Location: dashboard.php");
                exit();
            }
        }
        );

        // Helper validation functions
        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        function validatePhone(phone) {
            // Basic phone validation - adjust based on your needs
            const re = /^\d{10}$/;
            return re.test(String(phone).replace(/[^0-9]/g, ''));
        }

       
        function showToast(message) {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.padding = '15px';
            toast.style.backgroundColor = '#4CAF50';
            toast.style.color = 'white';
            toast.style.borderRadius = '5px';
            toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.3)';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        userTypes.forEach(type => {
            type.addEventListener('click', function () {
                document.getElementById('user_type').value = this.getAttribute('data-type');
            });
        });
    </script>
</body>

</html>