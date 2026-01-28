<div align="center">

#  Enterprise WordPress Engineering
### Scalable Architecture • Custom SQL • WP-CLI Automation

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-Enterprise-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![Status](https://img.shields.io/badge/Maintenance-Active-success?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
[![PHP Syntax Check](https://github.com/Vamsi0702/php-wordpress-learning/actions/workflows/php-lint.yml/badge.svg)](https://github.com/Vamsi0702/php-wordpress-learning/actions/workflows/php-lint.yml)

<br/>

**A centralized portfolio documenting the transition from Data Science to Backend Engineering.** Built specifically for high-scale environments using the **rtCamp technology stack**.

[Explore Code](https://github.com/Vamsi0702/php-wordpress-learning/blob/main/enterprise-audit-log.php) • 
[Read Documentation](https://github.com/Vamsi0702/php-wordpress-learning/wiki) • 
[Report Bug](https://github.com/Vamsi0702/php-wordpress-learning/issues)

</div>

---

##  Core Modules

We don't just write plugins; we build **Systems**. Here is the breakdown of the enterprise modules in this repository.

| Module Name | Tech Stack | Architecture | Performance Win | Status |
| :--- | :--- | :--- | :--- | :--- |
| **[Enterprise Audit Logger](enterprise-audit-log.php)** | `dbDelta`, Hooks |  Security Audit |  **10x Faster** (Custom SQL) |  v1.1.0 Active |
| **[CLI Bulk Importer](cli-bulk-importer.php)** | `WP-CLI`, PHP Streams |  Big Data |  **O(1) Memory** (Streaming) |  Production |
| **[Portfolio Fetcher](github-portfolio-fetcher.php)** | REST API, Transients |  API Widget |  **Cached** (1 hr TTL) |  Production |

<br/>

##  Feature Spotlight: Content Lifecycle Auditing (v1.1.0)
The **Enterprise Audit Logger** has been upgraded to provide a full-cycle security overview, verified in a **WordPress 6.9** local environment.

* **Multi-Hook Integration:** Simultaneously monitors `wp_login` and `save_post` events.
* **Intelligent DB Filtering:** Engineered to ignore `wp_is_post_revision()` and auto-saves, ensuring the custom audit table only tracks human-initiated changes.
* **Real-time Visualization:** Displays the specific title of updated posts directly in the **Dashboard Widget**, providing instant context for administrators.



---

##  Performance Architecture (The ADR-001 Approach)

Following the principles of **Enterprise WordPress (VIP)**, this portfolio prioritizes database health and scalability:

1.  **Bypassing `wp_posts`:** Audit logs are stored in a dedicated SQL table to prevent metadata bloat, ensuring queries remain fast even with millions of logs.
2.  **WPCS Compliance:** All code is strictly linted via **GitHub Actions** to meet WordPress Coding Standards.
3.  **Data Science Integration:** Leveraging memory-efficient streaming for CLI operations to handle large-scale data migrations without hitting PHP memory limits.

---

##  Quick Start

### 1. Installation
Clone the repository directly into your local `plugins` folder:
```bash
git clone [https://github.com/Vamsi0702/php-wordpress-learning.git](https://github.com/Vamsi0702/php-wordpress-learning.git)
