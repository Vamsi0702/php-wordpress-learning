![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-Enterprise-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![Status](https://img.shields.io/badge/Maintenance-Active-success?style=for-the-badge)
![License](https://img.shields.io/badge/License-GPLv2-blue?style=for-the-badge)

# PHP & WordPress Engineering Portfolio

This repository documents my transition from Data Science to Backend Engineering, specifically focusing on the WordPress ecosystem. It serves as a centralized location for my code, experiments, and custom plugins built using the rtCamp technology stack.

## Learning Roadmap

### Phase 1: The Fundamentals
- [x] PHP 8.x Basics (Syntax, Arrays, Functions)
- [x] Object-Oriented PHP (Classes, Inheritance)
- [x] Security Best Practices (Sanitization, Validation)

### Phase 2: WordPress Core
- [x] Understanding `wp-config.php` and File Structure
- [x] Plugin Architecture & Hooks
- [x] Shortcode API
- [x] HTTP API & Transients (Caching)

### Phase 3: Enterprise Engineering (Active)
- [x] **Custom Database Tables (SQL)** for high-performance logging
- [x] **WP-CLI (Command Line Interface)** for automation
- [x] **Data Migration** (Handling bulk data ingestion)

---

## Project Documentation

### 1. Enterprise Audit Logger (New!)
**File:** `enterprise-audit-log.php` | **Type:** Security Plugin

A compliance tool that creates a custom SQL table (`dbDelta`) to track user activity, bypassing standard post storage for performance.

**Technical Highlights:**
* **Custom SQL Schema:** Uses `CREATE TABLE` and `dbDelta()` to manage high-volume log data outside of `wp_posts`.
* **Security Hooks:** Listeners for `wp_login` to create an immutable audit trail.
* **Dashboard Widget:** Custom UI implementation within the WP Admin for real-time monitoring.

### 2. Enterprise CLI Bulk Importer
**File:** `cli-bulk-importer.php` | **Type:** WP-CLI Command

A command-line tool designed to handle large-scale data migrations. It reads a CSV file and programmatically inserts posts into the WordPress database with a visual progress indicator.

**Technical Highlights:**
* **WP-CLI Integration:** Extends `WP_CLI_Command` to run scripts directly in the terminal, bypassing server timeout limits.
* **Stream Processing:** Uses `fopen()` to stream data line-by-line for memory efficiency.
* **UX for Engineers:** Implements `make_progress_bar()` for real-time feedback.

### 3. GitHub Portfolio Fetcher
**File:** `github-portfolio-fetcher.php` | **Type:** API Widget

A widget that connects to the GitHub REST API to display live repository data.

**Technical Highlights:**
* **Performance Caching:** Implements the WordPress Transients API to cache API responses for 1 hour.
* **Error Handling:** Gracefully manages API connection failures.
* **Note:** Ensure your input file matches the structure of `mock-data.csv` exactly. The importer validates headers before processing to maintain data integrity.

### 4. Cricket Pace Calculator
**File:** `cricket-pace-calculator.php` | **Type:** OOP Logic

A physics-based calculator for bowling speed, re-engineered using Object-Oriented Programming principles.

---

## Installation & Usage

1. **CLI Tool:** Run `wp vamsi_import run mock-data.csv` in terminal.
2. **Plugins:** Activate via Dashboard to see the "Enterprise Security Logs" widget.
3. **Shortcodes:** Use `[cricket_calculator]` or `[my_github_repos]`.

---
**Author:** Vamsi Bodapati
*Aspiring WordPress Engineer*
