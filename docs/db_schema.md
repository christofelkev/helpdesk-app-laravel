Database Schema - Helpdesk/Ticketing System
Table Structure
1. Users Table
sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'client') DEFAULT 'client',
    avatar VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    department VARCHAR(100) NULL,
    job_title VARCHAR(100) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
2. Tickets Table
sql
CREATE TABLE tickets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_number VARCHAR(50) UNIQUE NOT NULL, -- Format: TICKET-2023-001
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('open', 'in_progress', 'pending', 'resolved', 'closed', 'reopened') DEFAULT 'open',
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    category_id BIGINT UNSIGNED NULL,
    client_id BIGINT UNSIGNED NOT NULL,
    assigned_to BIGINT UNSIGNED NULL, -- Staff ID
    due_date DATE NULL,
    resolved_at TIMESTAMP NULL,
    closed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
3. Categories Table
sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    color VARCHAR(20) DEFAULT '#007bff', -- For UI color coding
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
4. Ticket Comments Table
sql
CREATE TABLE ticket_comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    message TEXT NOT NULL,
    is_internal BOOLEAN DEFAULT FALSE, -- Staff-only notes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
5. Attachments Table
sql
CREATE TABLE attachments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id BIGINT UNSIGNED NOT NULL,
    comment_id BIGINT UNSIGNED NULL, -- NULL if attached to ticket directly
    user_id BIGINT UNSIGNED NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    stored_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size BIGINT NOT NULL,
    mime_type VARCHAR(100) NULL,
    upload_type ENUM('ticket', 'comment') DEFAULT 'ticket',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (comment_id) REFERENCES ticket_comments(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
6. Priorities Table
sql
CREATE TABLE priorities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    level TINYINT NOT NULL, -- 1: Low, 2: Medium, 3: High, 4: Urgent
    color VARCHAR(20) NOT NULL, -- Hex color code
    response_time_hours INT NOT NULL, -- Expected response time
    resolution_time_hours INT NOT NULL, -- Expected resolution time
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
7. Ticket Activities/Logs Table
sql
CREATE TABLE ticket_activities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    activity_type VARCHAR(50) NOT NULL, -- 'status_changed', 'assigned', 'comment_added', etc.
    old_value TEXT NULL,
    new_value TEXT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
8. Notifications Table
sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(50) NOT NULL, -- 'ticket_assigned', 'new_comment', 'status_changed'
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    related_ticket_id BIGINT UNSIGNED NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    data JSON NULL, -- Additional data in JSON format
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (related_ticket_id) REFERENCES tickets(id) ON DELETE SET NULL
);
9. Settings Table
sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NULL,
    setting_type ENUM('string', 'integer', 'boolean', 'json', 'array') DEFAULT 'string',
    category VARCHAR(50) DEFAULT 'general',
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
10. SLA (Service Level Agreement) Logs
sql
CREATE TABLE sla_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id BIGINT UNSIGNED NOT NULL,
    priority_id BIGINT UNSIGNED NOT NULL,
    expected_response_time TIMESTAMP NOT NULL,
    expected_resolution_time TIMESTAMP NOT NULL,
    actual_response_time TIMESTAMP NULL,
    actual_resolution_time TIMESTAMP NULL,
    response_breached BOOLEAN DEFAULT FALSE,
    resolution_breached BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (priority_id) REFERENCES priorities(id) ON DELETE CASCADE
);
11. Knowledge Base Articles (Future Enhancement)
sql
CREATE TABLE knowledge_base_articles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NOT NULL,
    excerpt TEXT NULL,
    author_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    views INT DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
12. Ticket Tags (Many-to-Many Relationship)
sql
CREATE TABLE tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    color VARCHAR(20) DEFAULT '#6c757d',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ticket_tags (
    ticket_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (ticket_id, tag_id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
Indexes for Performance Optimization
sql
-- Users table indexes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_is_active ON users(is_active);

-- Tickets table indexes
CREATE INDEX idx_tickets_status ON tickets(status);
CREATE INDEX idx_tickets_priority ON tickets(priority);
CREATE INDEX idx_tickets_client_id ON tickets(client_id);
CREATE INDEX idx_tickets_assigned_to ON tickets(assigned_to);
CREATE INDEX idx_tickets_created_at ON tickets(created_at);
CREATE INDEX idx_tickets_ticket_number ON tickets(ticket_number);

-- Ticket comments indexes
CREATE INDEX idx_ticket_comments_ticket_id ON ticket_comments(ticket_id);
CREATE INDEX idx_ticket_comments_user_id ON ticket_comments(user_id);
CREATE INDEX idx_ticket_comments_created_at ON ticket_comments(created_at);

-- Attachments indexes
CREATE INDEX idx_attachments_ticket_id ON attachments(ticket_id);
CREATE INDEX idx_attachments_comment_id ON attachments(comment_id);

-- Notifications indexes
CREATE INDEX idx_notifications_user_id ON notifications(user_id);
CREATE INDEX idx_notifications_is_read ON notifications(is_read);
CREATE INDEX idx_notifications_created_at ON notifications(created_at);

-- Activities indexes
CREATE INDEX idx_ticket_activities_ticket_id ON ticket_activities(ticket_id);
CREATE INDEX idx_ticket_activities_user_id ON ticket_activities(user_id);
CREATE INDEX idx_ticket_activities_activity_type ON ticket_activities(activity_type);
Default Data (Seeders)
Priorities Default Data:
sql
INSERT INTO priorities (name, level, color, response_time_hours, resolution_time_hours, description) VALUES
('Low', 1, '#28a745', 48, 168, 'Non-urgent issues'),
('Medium', 2, '#ffc107', 24, 72, 'Standard issues'),
('High', 3, '#fd7e14', 8, 48, 'Important issues affecting work'),
('Urgent', 4, '#dc3545', 2, 24, 'Critical issues requiring immediate attention');
Categories Default Data:
sql
INSERT INTO categories (name, description, color) VALUES
('Hardware', 'Issues related to computer hardware', '#007bff'),
('Software', 'Software installation and problems', '#28a745'),
('Network', 'Network connectivity issues', '#6f42c1'),
('Email', 'Email client and server issues', '#fd7e14'),
('Account', 'User account and access problems', '#20c997'),
('Other', 'Other types of issues', '#6c757d');
Settings Default Data:
sql
INSERT INTO settings (setting_key, setting_value, setting_type, category, description) VALUES
('site_name', 'Helpdesk System', 'string', 'general', 'Website name'),
('ticket_prefix', 'TICKET', 'string', 'tickets', 'Prefix for ticket numbers'),
('auto_assign_tickets', '1', 'boolean', 'tickets', 'Automatically assign tickets to available staff'),
('default_priority', '2', 'integer', 'tickets', 'Default priority for new tickets'),
('max_file_size', '10', 'integer', 'uploads', 'Maximum file size in MB'),
('allowed_file_types', '["jpg","jpeg","png","gif","pdf","doc","docx","txt"]', 'json', 'uploads', 'Allowed file extensions');
Relationships Summary
text
USERS (1) → (n) TICKETS
- One user can create many tickets (as client)
- One user can be assigned many tickets (as staff)

TICKETS (1) → (n) TICKET_COMMENTS
- One ticket can have many comments

TICKETS (1) → (n) ATTACHMENTS
- One ticket can have many attachments

TICKETS (n) → (1) CATEGORIES
- Many tickets can belong to one category

TICKETS (n) → (1) PRIORITIES
- Many tickets can have the same priority

TICKETS (n) → (n) TAGS
- Many tickets can have many tags (through ticket_tags)

TICKETS (1) → (n) TICKET_ACTIVITIES
- One ticket can have many activity logs

TICKETS (1) → (n) NOTIFICATIONS
- One ticket can generate many notifications

TICKETS (1) → (1) SLA_LOGS
- One ticket has one SLA log (can be extended for history)
Sample Queries
Get All Open Tickets for a Staff Member:
sql
SELECT t.*, u.name as client_name, c.name as category_name, p.name as priority_name
FROM tickets t
JOIN users u ON t.client_id = u.id
LEFT JOIN categories c ON t.category_id = c.id
LEFT JOIN priorities p ON t.priority_id = p.id
WHERE t.assigned_to = ? AND t.status IN ('open', 'in_progress')
ORDER BY t.priority DESC, t.created_at ASC;
Get Ticket with Comments and Attachments:
sql
SELECT 
    t.*,
    u_client.name as client_name,
    u_staff.name as assigned_staff_name,
    c.name as category_name,
    p.name as priority_name,
    GROUP_CONCAT(DISTINCT tag.name) as tags
FROM tickets t
JOIN users u_client ON t.client_id = u_client.id
LEFT JOIN users u_staff ON t.assigned_to = u_staff.id
LEFT JOIN categories c ON t.category_id = c.id
LEFT JOIN priorities p ON t.priority_id = p.id
LEFT JOIN ticket_tags tt ON t.id = tt.ticket_id
LEFT JOIN tags tag ON tt.tag_id = tag.id
WHERE t.id = ?
GROUP BY t.id;
Dashboard Statistics Query:
sql
SELECT 
    COUNT(*) as total_tickets,
    SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open_tickets,
    SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress_tickets,
    SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved_tickets,
    AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_resolution_time
FROM tickets
WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY);