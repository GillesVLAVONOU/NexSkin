-- NexSkin Database Schema
-- MySQL 8.0+

CREATE DATABASE IF NOT EXISTS nexskin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nexskin;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB;

-- Projects table
CREATE TABLE IF NOT EXISTS projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    short_description VARCHAR(500) NULL,
    description TEXT NULL,
    cover_image VARCHAR(500) NULL,
    before_image VARCHAR(500) NULL,
    after_image VARCHAR(500) NULL,
    project_date DATE NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    featured TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_sort_order (sort_order),
    CONSTRAINT fk_project_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Project images (gallery)
CREATE TABLE IF NOT EXISTS project_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(500) NOT NULL,
    alt_text VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_project (project_id),
    INDEX idx_sort_order (sort_order),
    CONSTRAINT fk_image_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Contact messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NULL,
    project_type VARCHAR(255) NULL,
    device_model VARCHAR(255) NULL,
    budget VARCHAR(100) NULL,
    reference_image VARCHAR(500) NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'in_progress', 'processed', 'archived') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- Settings
CREATE TABLE IF NOT EXISTS settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
) ENGINE=InnoDB;

-- The first admin account is created by install.php with a strong password.

-- Insert default categories
INSERT IGNORE INTO categories (name, slug, description, sort_order) VALUES
('Minimaliste', 'minimaliste', 'Designs épurés et simples', 1),
('Artistique', 'artistique', 'Créations artistiques uniques', 2),
('Vintage', 'vintage', 'Styles rétro et classiques', 3),
('Voyage', 'voyage', 'Inspirations du monde entier', 4),
('Anime & Pop Culture', 'anime-pop-culture', 'Personnages et univers pop culture', 5),
('Personnalise', 'personnalise', 'Créations sur mesure', 6);

-- Insert default settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('company_name', 'NexSkin'),
('slogan', 'Votre ordinateur. Votre style.'),
('email', 'contact@nexskin.com'),
('phone', ''),
('whatsapp', ''),
('instagram', ''),
('facebook', ''),
('tiktok', ''),
('address', ''),
('description', 'NexSkin transforme votre ordinateur en une pièce unique grâce à des designs et habillages personnalisés.'),
('meta_description', 'NexSkin - Personnalisation et habillage d ordinateurs portables. Designs uniques, skins sur mesure.'),
('hero_title', 'Votre ordinateur. Votre style.'),
('hero_subtitle', 'NexSkin transforme votre ordinateur en une pièce unique grâce à des designs et habillages personnalisés.'),
('contact_notification_email', 'contact@nexskin.com'),
('smtp_host', ''),
('smtp_port', ''),
('smtp_username', ''),
('smtp_from_email', ''),
('smtp_from_name', 'NexSkin');


