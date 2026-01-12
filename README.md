# 🚀 PHP & WordPress Engineering Journey

Welcome to my learning repository! I am a Computer Science student (Data Science background) pivoting to Backend Engineering with a focus on the **WordPress Ecosystem**.

This repository documents my code, experiments, and plugins as I master the rtCamp technology stack.

## 🎯 Learning Roadmap

### Phase 1: The Fundamentals
- [x] PHP 8.x Basics (Syntax, Arrays, Functions)
- [x] Object-Oriented PHP (Classes, Inheritance)
- [x] Security Best Practices (Sanitization, Validation)

### Phase 2: WordPress Core
- [x] Understanding `wp-config.php` and File Structure
- [x] Plugin Architecture & Hooks
- [x] Shortcode API

### Phase 3: Projects
- [x] **Project:** "Cricket Pace Calculator" Plugin
    - *Status:* **Completed** v1.1.0
    - *Tech:* PHP Backend + HTML Forms + Unit Conversions.

---

## 🏏 Project Spotlight: Cricket Pace Calculator

A custom WordPress plugin that calculates bowling speed based on pitch length and time.

### **Features**
* **Shortcode Based:** Use `[cricket_calculator]` on any page or post.
* **Security:** Inputs are sanitized using `floatval()` to prevent injection.
* **Physics Logic:** Converts standard Cricket Yardage (22yds) + Time (s) -> KPH & MPH.

### **How to Test**
1.  Download `cricket-pace-calculator.php`.
2.  Upload to your WordPress `wp-content/plugins/` folder.
3.  Activate via the Admin Dashboard.
4.  Add the shortcode `[cricket_calculator]` to a page.

---
*🌱 This repository is actively updated as I prepare for the Associate WordPress Engineer role.*
