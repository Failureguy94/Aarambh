# LifeLink - Blood Donation Platform

A web-based platform connecting blood donors with those in need, including individuals, hospitals, and blood banks.

## Features

- User registration and authentication for three user types:
  - Individual donors
  - Hospitals
  - Blood banks
- Secure login system with password hashing
- Dashboard for each user type
- Responsive design

## Project Structure

```
FInal Aarambh/
├── index.html           # Homepage/landing page
├── loginpage.html       # Combined login and registration page
├── signup-page.html     # Alternative login page
├── login.php            # Login processing script
├── register.php         # Registration processing script
├── dashboard.php        # User dashboard after login
├── logout.php           # Logout handler
├── db.php              # Database connection configuration
├── schema.sql          # Database schema
└── README.md           # This file
```

## Setup Instructions

### Prerequisites

- PHP 7.4 or higher
- MySQL/MariaDB database server
- Apache/Nginx web server (or XAMPP/WAMP/MAMP)

### Installation Steps

1. **Install XAMPP/WAMP/MAMP** (if you don't have a local server)
   - Download from: https://www.apachefriends.org/
   - Install and start Apache and MySQL services

2. **Create Database**
   - Open phpMyAdmin (usually at http://localhost/phpmyadmin)
   - Import the `schema.sql` file to create the database and tables
   - OR manually run the SQL commands in `schema.sql`

3. **Configure Database Connection**
   - Open `db.php`
   - Update the following variables if needed:
     ```php
     $host = 'localhost';      // Usually localhost
     $dbname = 'lifelink_db';  // Database name
     $username = 'root';        // MySQL username (default: root)
     $password = '';            // MySQL password (default: empty for XAMPP)
     ```

4. **Move Project to Web Server**
   - Copy the `FInal Aarambh` folder to your web server's document root:
     - XAMPP: `C:\xampp\htdocs\`
     - WAMP: `C:\wamp\www\`
     - MAMP: `/Applications/MAMP/htdocs/`

5. **Access the Application**
   - Open your browser and navigate to:
     - http://localhost/FInal%20Aarambh/index.html
   - Or for cleaner URL, rename folder to `lifelink` and access:
     - http://localhost/lifelink/index.html

## Usage

### Registration

1. Click "Login or Register" button on the homepage
2. Select the "Register" tab
3. Choose your user type (Individual, Hospital, or Blood Bank)
4. Fill in the required information
5. Click "Create Account"

### Login

1. Go to the login page
2. Enter your email and password
3. Click "Login"
4. You'll be redirected to your dashboard

### User Types

- **Individual**: Blood donors and recipients
- **Hospital**: Medical facilities requiring blood
- **Blood Bank**: Blood storage and distribution centers

## Database Tables

- `individuals` - Individual user accounts
- `hospitals` - Hospital accounts
- `bloodbanks` - Blood bank accounts

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection protection using `mysqli_real_escape_string()`
- Session management for authenticated users
- Form validation on client and server side

## Common Issues

### Database Connection Failed
- Check if MySQL is running
- Verify database credentials in `db.php`
- Ensure database `lifelink_db` exists

### Page Not Found
- Check if files are in the correct web server directory
- Verify Apache/web server is running
- Check file permissions

### Login Not Working
- Ensure database tables are created
- Check if registration was successful
- Verify password is correct

## Future Enhancements

- Blood donation request system
- Real-time blood availability tracking
- Email notifications
- Admin panel
- Search and filter functionality
- Mobile app integration

## Credits

Developed by **Team Aarambh**

## License

© 2025 LifeLink by Team Aarambh. All rights reserved.
