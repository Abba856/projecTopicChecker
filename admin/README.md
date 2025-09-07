# Admin Panel - Project Topic Checker

## Overview
This is the administrative panel for the Project Topic Checker system. It provides administrators with tools to manage project topics, users, and contact messages.

## Features
- **Dashboard**: Overview of system statistics
- **Topic Management**: Accept, reject, or reset project topics
- **User Management**: View and manage registered users
- **Message Management**: Review and respond to contact form submissions
- **Settings**: Change password and update profile

## Default Login Credentials
- **Username**: admin
- **Password**: admin123

**Important**: Please change the default password immediately after your first login for security reasons.

## Accessing the Admin Panel
Navigate to: `http://your-domain/admin/`

## Functionality Details

### Dashboard
- Shows statistics for topics, users, and messages
- Displays recent activity and quick actions

### Manage Topics
- View all project topics with filtering options
- Accept topics (changes status to "taken")
- Reject topics (changes status to "completed")
- Reset topics (changes status back to "available")
- Search topics by title or abstract

### Manage Users
- View all registered users
- Delete user accounts
- Search users by name, username, or email

### Messages
- View all contact form submissions
- Delete individual messages or all messages
- Search messages by content

### Settings
- Change admin password
- Update admin username
- View system statistics

## Security Features
- Passwords are securely hashed using PHP's `password_hash()` function
- Session-based authentication
- SQL injection protection using prepared statements
- Input validation and sanitization

## Technical Implementation
- Built with PHP and MySQL
- Modern responsive design using HTML5, CSS3, and JavaScript
- Uses prepared statements for database queries to prevent SQL injection
- Implements proper password hashing for security

## Requirements
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web server (Apache, Nginx, etc.)

## Setup Instructions
1. Ensure the database is set up (run `setup_database.php` in the project root)
2. Access the admin panel at `/admin/`
3. Log in with the default credentials
4. Change your password immediately for security

## Support
For technical support, please contact the system administrator.