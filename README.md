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

### Phase 3: Enterprise Engineering
- [x] **WP-CLI (Command Line Interface)** for automation
- [x] **Data Migration** (Handling bulk data ingestion)
- [x] Programmatic Content Creation

---

## Project Documentation

### 1. Enterprise CLI Bulk Importer (New!)
**File:** `cli-bulk-importer.php` | **Type:** WP-CLI Command

A command-line tool designed to handle large-scale data migrations. It reads a CSV file and programmatically inserts posts into the WordPress database with a visual progress indicator.

**Technical Highlights:**
* **WP-CLI Integration:** Extends `WP_CLI_Command` to run scripts directly in the terminal, bypassing server timeout limits inherent to browser-based uploads.
* **Stream Processing:** Uses `fopen()` and `fgetcsv()` to stream data line-by-line, ensuring memory efficiency even with large datasets.
* **UX for Engineers:** Implements `WP_CLI\Utils\make_progress_bar()` to provide real-time feedback during long-running operations.
* **Data Integrity:** Validates file existence and sanitizes data using `wp_strip_all_tags()` before insertion.

### 2. GitHub Portfolio Fetcher
**File:** `github-portfolio-fetcher.php` | **Type:** Widget Plugin

A widget that connects to the GitHub REST API to display live repository data, demonstrating third-party integration skills.

**Technical Highlights:**
* **HTTP API:** Uses `wp_remote_get()` to consume external JSON APIs securely.
* **Performance Caching:** Implements the WordPress Transients API to cache API responses for 1 hour, reducing server load.
* **Error Handling:** Gracefully manages API connection failures.

### 3. Cricket Pace Calculator
**File:** `cricket-pace-calculator.php` | **Type:** Logic Plugin

A physics-based calculator for bowling speed, re-engineered using Object-Oriented Programming principles.

**Technical Highlights:**
* **Object-Oriented Architecture:** Implements a class-based structure with distinct methods for rendering and logic processing.
* **Security:** Utilizes `floatval()` for strict input sanitization.
* **Separation of Concerns:** Decouples the UI rendering from the mathematical logic.

---

## Installation & Usage Instructions

### For Plugins (Projects 2 & 3)
1. Upload the file to `wp-content/plugins/`.
2. Activate via the WordPress Admin Dashboard.
3. Use the shortcodes: `[cricket_calculator]` or `[my_github_repos]`.

### For CLI Tools (Project 1)
1. Place `cli-bulk-importer.php` in your plugin directory or mu-plugins.
2. Open your terminal and navigate to the WordPress root.
3. Run the import command:
   ```bash
   wp vamsi_import run mock-data.csv
