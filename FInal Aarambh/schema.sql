-- LifeLink Database Schema
-- Create and setup database for the LifeLink blood donation platform

-- Create database
CREATE DATABASE IF NOT EXISTS lifelink_db;
USE lifelink_db;

-- Table for individual users/donors
CREATE TABLE IF NOT EXISTS individuals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    blood_group VARCHAR(10) NOT NULL,
    address TEXT NOT NULL,
    willing_to_donate TINYINT(1) DEFAULT 0,
    last_donation_date DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for hospitals
CREATE TABLE IF NOT EXISTS hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_name VARCHAR(255) NOT NULL,
    hospital_id VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    contact_person VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for blood banks
CREATE TABLE IF NOT EXISTS bloodbanks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bloodbank_name VARCHAR(255) NOT NULL,
    license_no VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    capacity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Optional: Create indexes for better performance
CREATE INDEX idx_individual_email ON individuals(email);
CREATE INDEX idx_individual_blood_group ON individuals(blood_group);
CREATE INDEX idx_hospital_email ON hospitals(email);
CREATE INDEX idx_bloodbank_email ON bloodbanks(email);

-- Display success message
SELECT 'Database schema created successfully!' AS message;
