# PHP & WordPress Engineering Portfolio

This repository documents my transition from Data Science to Backend Engineering, specifically focusing on the WordPress ecosystem. It contains two custom plugins built from scratch to demonstrate core WordPress development competencies.

## Project 1: Cricket Pace Calculator (OOP Architecture)
**File:** `cricket-pace-calculator.php`

A physics-based calculator for bowling speed, re-engineered using Object-Oriented Programming principles.

**Engineering Highlights:**
* **Object-Oriented Architecture:** Implements a class-based structure with distinct methods for rendering and logic processing.
* **Security:** Utilizes `floatval()` for input sanitization and validates data before processing.
* **Shortcode API:** Registered via `[cricket_calculator]` for easy embedding.
* **Separation of Concerns:** Decouples the UI rendering from the mathematical logic.

## Project 2: GitHub Portfolio Fetcher (API Integration)
**File:** `github-portfolio-fetcher.php`

A widget that connects to the GitHub REST API to display live repository data.

**Engineering Highlights:**
* **HTTP API:** Uses `wp_remote_get()` to consume external JSON APIs securely.
* **Performance Caching:** Implements the WordPress Transients API to cache API responses for 1 hour, reducing server load and latency.
* **Error Handling:** Gracefully manages API connection failures or timeouts.
* **Data Parsing:** Decodes JSON responses and dynamically generates HTML output.

---
**Author:** Vamsi Bodapati
*Aspiring WordPress Engineer*
