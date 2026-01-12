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

### Phase 3: Projects
- [x] **Project 1:** Cricket Pace Calculator (Completed v1.2.0)
- [x] **Project 2:** GitHub Portfolio Fetcher (Completed v1.0.0)

---

## Project Documentation

### 1. Cricket Pace Calculator
**File:** `cricket-pace-calculator.php`

A physics-based calculator for bowling speed, re-engineered using Object-Oriented Programming principles.

**Technical Highlights:**
* **Object-Oriented Architecture:** Implements a class-based structure with distinct methods for rendering and logic processing.
* **Security:** Utilizes `floatval()` for strict input sanitization to prevent injection attacks.
* **Shortcode API:** Registered via `[cricket_calculator]` for modular embedding.
* **Separation of Concerns:** Decouples the UI rendering from the mathematical logic.

### 2. GitHub Portfolio Fetcher
**File:** `github-portfolio-fetcher.php`

A widget that connects to the GitHub REST API to display live repository data, demonstrating third-party integration skills.

**Technical Highlights:**
* **HTTP API:** Uses `wp_remote_get()` to consume external JSON APIs securely.
* **Performance Caching:** Implements the WordPress Transients API to cache API responses for 1 hour, reducing server load.
* **Error Handling:** Gracefully manages API connection failures or timeouts.
* **Data Parsing:** Decodes JSON responses and dynamically generates HTML output.

---

## Installation Instructions

1. Download the `.php` file for the desired plugin.
2. Upload the file to your WordPress `wp-content/plugins/` directory.
3. Activate the plugin via the WordPress Admin Dashboard.
4. Add the corresponding shortcode (`[cricket_calculator]` or `[my_github_repos]`) to any page or post.

---
**Author:** Vamsi Bodapati
*Aspiring WordPress Engineer*
