-- Enhanced SUC Forum Database Schema
CREATE DATABASE IF NOT EXISTS suc_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE suc_db;

-- Users table with enhanced fields
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    university VARCHAR(100) NOT NULL,
    course VARCHAR(100),
    year_level ENUM('1st', '2nd', '3rd', '4th', 'graduate', 'faculty') DEFAULT '1st',
    role ENUM('admin', 'moderator', 'faculty', 'college student', 'other') DEFAULT 'other',
    avatar VARCHAR(255) DEFAULT 'default.png',
    bio TEXT,
    reputation INT DEFAULT 0,
    status ENUM('active', 'banned', 'pending') DEFAULT 'active',
    email_verified BOOLEAN DEFAULT FALSE,
    email_verification_token VARCHAR(255),
    password_reset_token VARCHAR(255),
    password_reset_expires TIMESTAMP NULL,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_university (university),
    INDEX idx_role (role),
    INDEX idx_status (status)
);

-- Login Attempts
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_username (username),
    KEY idx_ip_address (ip_address),
    KEY idx_attempted_at (attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Enhanced categories with permissions
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50) DEFAULT 'fas fa-folder',
    color VARCHAR(7) DEFAULT '#007bff',
    position INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    permissions JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_position (position),
    INDEX idx_active (is_active)
);

-- Enhanced forums table
CREATE TABLE forums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    position INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    topics_count INT DEFAULT 0,
    posts_count INT DEFAULT 0,
    last_post_id INT,
    last_post_at TIMESTAMP NULL,
    permissions JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_position (position),
    INDEX idx_active (is_active),
    INDEX idx_last_post (last_post_at)
);

-- Enhanced topics table
CREATE TABLE topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    forum_id INT,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    is_solved BOOLEAN DEFAULT FALSE,
    views INT DEFAULT 0,
    replies_count INT DEFAULT 0,
    votes_up INT DEFAULT 0,
    votes_down INT DEFAULT 0,
    tags JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (forum_id) REFERENCES forums(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_forum (forum_id),
    INDEX idx_user (user_id),
    INDEX idx_pinned (is_pinned),
    INDEX idx_created (created_at),
    INDEX idx_updated (updated_at),
    FULLTEXT idx_search (title, content)
);

-- Enhanced posts table
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic_id INT,
    user_id INT,
    parent_id INT NULL,
    content TEXT NOT NULL,
    votes_up INT DEFAULT 0,
    votes_down INT DEFAULT 0,
    is_solution BOOLEAN DEFAULT FALSE,
    is_edited BOOLEAN DEFAULT FALSE,
    edited_at TIMESTAMP NULL,
    edited_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (edited_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_topic (topic_id),
    INDEX idx_user (user_id),
    INDEX idx_parent (parent_id),
    INDEX idx_created (created_at),
    FULLTEXT idx_content (content)
);

-- System settings table
CREATE TABLE system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key),
    INDEX idx_public (is_public)
);

-- Activity logs table
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    target_type VARCHAR(50),
    target_id INT,
    details JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_target (target_type, target_id),
    INDEX idx_created (created_at)
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_event_date (event_date)
);

CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(500) NOT NULL,
    file_size INT DEFAULT 0,
    FILE_TYPE VARCHAR(50),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    downloads INT DEFAULT 0,
    uploaded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
);

CREATE TABLE research_collaborations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    research_area VARCHAR(100),
    requirements TEXT,
    status ENUM('open', 'in_progress', 'completed', 'closed') DEFAULT 'open',
    created_by INT,
    participants_needed INT DEFAULT 1,
    current_paticipants INT DEFAULT 0,
    dealine DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_research_area (research_area),
    INDEX idx_created (created_at)
);

CREATE TABLE job_board (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    description TEXT,
    requirements TEXT,
    location VARCHAR(255),
    job_type ENUM('full-time', 'part-time', 'internship', 'contract') DEFAULT 'full-time',
    salary_range VARCHAR(100),
    status ENUM('active', 'closed', 'draft') DEFAULT 'active',
    posted_by INT,
    application_deadline DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_job_type (job_type),
    INDEX idx_created (created_at)
);

CREATE TABLE user_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('academic', 'social', 'professional', 'other') DEFAULT 'other',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by INT,
    member_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX ikdx_status (status),
    INDEX idx_type (type)
);

-- Sample User / password: yourpasswordhere
INSERT INTO users (username, email, password, full_name, university, role) VALUES
('developer', 'it@3ehitech.com', '$2y$10$q1AKe5CMiOLte31M.JspAuO4AAdc5vfG9lxqWoJdwqxhk/dJJ7BOG', 'Angelo Dev IT', 'Infotech Development Systems Colleges', 'admin');

-- Insert default system settings
INSERT INTO system_settings (setting_key, setting_value, setting_type, description, is_public) VALUES
('site_name', 'SUC Forum', 'string', 'Website name', TRUE),
('site_description', 'Philippine State Universities and Colleges Forum', 'string', 'Website description', TRUE),
('maintenance_mode', 'false', 'boolean', 'Enable maintenance mode', FALSE),
('registration_enabled', 'true', 'boolean', 'Allow new user registration', TRUE),
('email_verification_required', 'false', 'boolean', 'Require email verification for new users', FALSE),
('max_file_upload_size', '10485760', 'integer', 'Maximum file upload size in bytes (10MB)', FALSE),
('allowed_file_types', '["jpg","jpeg","png","gif","pdf","doc","docx"]', 'json', 'Allowed file upload types', FALSE);

-- Insert default categories
INSERT INTO categories (name, description, icon, color, position) VALUES
('General Discussion', 'General topics for all SUC members', 'fas fa-comments', '#007bff', 1),
('Academic', 'Academic discussions and resources', 'fas fa-graduation-cap', '#28a745', 2),
('Research', 'Research collaboration and sharing', 'fas fa-microscope', '#dc3545', 3),
('Events & Announcements', 'University events and official announcements', 'fas fa-calendar', '#ffc107', 4),
('Student Life', 'Campus life, activities, and student concerns', 'fas fa-users', '#17a2b8', 5);

-- Insert default forums
INSERT INTO forums (category_id, name, description, position) VALUES
(1, 'Welcome & Introductions', 'Introduce yourself to the SUC community', 1),
(1, 'General Chat', 'General discussions about anything', 2),
(1, 'Help & Support', 'Get help with forum usage and technical issues', 3),
(2, 'Course Discussions', 'Discuss courses, curriculum, and academic topics', 1),
(2, 'Study Groups', 'Form and join study groups', 2),
(2, 'Academic Resources', 'Share textbooks, notes, and study materials', 3),
(3, 'Research Projects', 'Share and collaborate on research projects', 1),
(3, 'Publications & Papers', 'Share published papers and research articles', 2),
(3, 'Research Opportunities', 'Post and find research opportunities', 3),
(4, 'University Events', 'Upcoming events and activities', 1),
(4, 'Official Announcements', 'Important announcements from administration', 2),
(4, 'News & Updates', 'Latest news and updates from SUC institutions', 3),
(5, 'Campus Life', 'Discuss campus life and experiences', 1),
(5, 'Organizations & Clubs', 'Student organizations and club activities', 2),
(5, 'Career & Opportunities', 'Job opportunities, internships, and career advice', 3);

-- Insert sample Events
INSERT INTO events (title, description, event_date, location) VALUES
('SUC-Industry Collaboration Forum', 'Collaboration forum site', '2026-01-26 11:00:00', 'H.V. Dela Costa Makati City, The World Center Building, 25th Floor');

-- Insert sample data
INSERT INTO research_collaborations (title, description, research_area, requirements, created_by, participants_needed, deadline) VALUES
('Sample Data', 'Sample Data', 'Sample Data', 'Sample Data', 1, 3, '2024-06-30');