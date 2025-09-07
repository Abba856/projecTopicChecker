CREATE DATABASE IF NOT EXISTS project_checker;
USE project_checker;

-- Create topics table (fixing the table name issue)
CREATE TABLE IF NOT EXISTS topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_title VARCHAR(255) NOT NULL,
    topic_text TEXT,
    project_abstract TEXT,
    status ENUM('available', 'taken', 'completed') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create register table for user registration
CREATE TABLE IF NOT EXISTS register (
    r_id INT AUTO_INCREMENT PRIMARY KEY,
    r_fnm VARCHAR(100) NOT NULL,
    r_unm VARCHAR(50) NOT NULL UNIQUE,
    r_pwd VARCHAR(255) NOT NULL,
    r_cno VARCHAR(15),
    r_email VARCHAR(100),
    r_question VARCHAR(255),
    r_answer VARCHAR(255),
    r_time INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create contact table
CREATE TABLE IF NOT EXISTS contact (
    c_id INT AUTO_INCREMENT PRIMARY KEY,
    c_nm VARCHAR(100) NOT NULL,
    c_email VARCHAR(100) NOT NULL,
    c_msg TEXT NOT NULL,
    c_time INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial data into topics table
INSERT INTO topics (topic_title, topic_text, project_abstract, status) VALUES
('Online Examination System', 'Online Examination System', 'An online platform for conducting examinations remotely.', 'available'),
('School Management System', 'School Management System', 'A comprehensive system for managing school operations.', 'available'),
('Attendance Management System', 'Attendance Management System', 'A system for tracking student attendance.', 'available'),
('Online Admission System', 'Online Admission System', 'A platform for online student admissions.', 'available'),
('Tours and Travels Management System', 'Tours and Travels Management System', 'A system for managing tour and travel bookings.', 'available'),
('Student Result Management System', 'Student Result Management System', 'A system for managing and displaying student results.', 'available'),
('Online Jewellery Shopping System', 'Online Jewellery Shopping System', 'An e-commerce platform for jewellery.', 'available'),
('Online Shopping System', 'Online Shopping System', 'A general e-commerce platform.', 'available'),
('Online Art Gallery', 'Online Art Gallery', 'A platform for showcasing and selling art.', 'available'),
('Online Matrimonial Website', 'Online Matrimonial Website', 'A platform for finding life partners.', 'available'),
('Online Bookstore', 'Online Bookstore', 'An e-commerce platform for books.', 'available'),
('Blood Bank Management System', 'Blood Bank Management System', 'A system for managing blood bank operations.', 'available'),
('Car Rental System', 'Car Rental System', 'A platform for renting cars online.', 'available'),
('Online Food Ordering System', 'Online Food Ordering System', 'A platform for ordering food online.', 'available'),
('Hostel Management System', 'Hostel Management System', 'A system for managing hostel operations.', 'available'),
('Online Voting System', 'Online Voting System', 'A secure platform for conducting online elections.', 'available'),
('Gym Management System', 'Gym Management System', 'A system for managing gym memberships and operations.', 'available'),
('Leave Management System', 'Leave Management System', 'A system for managing employee leave applications.', 'available'),
('Image Crop Tool', 'Image Crop Tool', 'A tool for cropping images online.', 'available'),
('Image Editor', 'Image Editor', 'An online image editing platform.', 'available'),
('Online Hotel Booking System', 'Online Hotel Booking System', 'A platform for booking hotels online.', 'available'),
('College Management System', 'College Management System', 'A comprehensive system for managing college operations.', 'available'),
('PHP Image Gallery', 'PHP Image Gallery', 'A web-based image gallery built with PHP.', 'available'),
('Online Notes Sharing Platform', 'Online Notes Sharing Platform', 'A platform for sharing educational notes.', 'available'),
('Travel Management System', 'Travel Management System', 'A system for managing travel arrangements.', 'available'),
('Property Listing & House Rental Platform', 'Property Listing & House Rental Platform', 'A platform for listing properties and house rentals.', 'available'),
('Electricity Bill Payment System', 'Electricity Bill Payment System', 'A system for paying electricity bills online.', 'available'),
('Expense Management System', 'Expense Management System', 'A system for tracking and managing expenses.', 'available'),
('Time Management System', 'Time Management System', 'A system for managing time and schedules.', 'available'),
('Online File Storage in PHP', 'Online File Storage in PHP', 'A cloud storage solution built with PHP.', 'available'),
('Event Booking System', 'Event Booking System', 'A platform for booking events online.', 'available'),
('Doctor Appointment Booking System', 'Doctor Appointment Booking System', 'A system for booking doctor appointments online.', 'available'),
('Visitor Management System', 'Visitor Management System', 'A system for managing visitor entries.', 'available'),
('Online Chat Application', 'Online Chat Application', 'A real-time chat application.', 'available'),
('PHP Casino (Blackjack & Slots)', 'PHP Casino (Blackjack & Slots)', 'An online casino game built with PHP.', 'available'),
('Life Insurance Management System', 'Life Insurance Management System', 'A system for managing life insurance policies.', 'available'),
('Beauty Parlour Management System', 'Beauty Parlour Management System', 'A system for managing beauty parlour operations.', 'available'),
('Vehicle Breakdown Assistance System', 'Vehicle Breakdown Assistance System', 'A platform for requesting vehicle breakdown assistance.', 'available'),
('Online Time Table Generator', 'Online Time Table Generator', 'A system for generating academic timetables.', 'available'),
('Online Lawyer Management System', 'Online Lawyer Management System', 'A platform for managing lawyer appointments.', 'available'),
('Student Project Allocation System', 'Student Project Allocation System', 'A system for allocating projects to students.', 'available'),
('Online Fee Payment System', 'Online Fee Payment System', 'A platform for paying academic fees online.', 'available'),
('Online Learning Management System', 'Online Learning Management System', 'A comprehensive learning management system.', 'available'),
('E-Commerce Website for Electronics', 'E-Commerce Website for Electronics', 'An e-commerce platform for electronic products.', 'available'),
('Digital Library Management System', 'Digital Library Management System', 'A system for managing digital library resources.', 'available'),
('Course Registration and Result System', 'Course Registration and Result System', 'A system for course registration and result management.', 'available'),
('Restaurant Table Booking System', 'Restaurant Table Booking System', 'A platform for booking restaurant tables online.', 'available'),
('Vehicle Parking Management System', 'Vehicle Parking Management System', 'A system for managing vehicle parking.', 'available'),
('University Certificate Verification System', 'University Certificate Verification System', 'A system for verifying university certificates.', 'available'),
('Online Complaint Management System', 'Online Complaint Management System', 'A platform for managing complaints online.', 'available');