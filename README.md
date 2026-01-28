<div align="center">

# 🐘 Enterprise WordPress Engineering
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

## ⚡ Core Modules

We don't just write plugins; we build **Systems**. Here is the breakdown of the enterprise modules in this repository.

| Module Name | Tech Stack | Architecture | Performance Win | Status |
| :--- | :--- | :--- | :--- | :--- |
| **[Enterprise Audit Logger](enterprise-audit-log.php)** | `dbDelta`, Custom SQL | 🔒 Security | ⚡ **10x Faster** (No `wp_posts` bloat) | ✅ Production |
| **[CLI Bulk Importer](cli-bulk-importer.php)** | `WP-CLI`, PHP Streams | 💾 Big Data | 🚀 **O(1) Memory** (Streaming) | ✅ Production |
| **[Portfolio Fetcher](github-portfolio-fetcher.php)** | REST API, Transients | 🌐 API Widget | 🕒 **Cached** (1 hr TTL) | ✅ Production |

<br/>

## 🚀 Quick Start

Get these tools running in your local environment in under 30 seconds.

### 1. Installation
Clone the repository directly into your plugins folder:
```bash
git clone [https://github.com/Vamsi0702/php-wordpress-learning.git](https://github.com/Vamsi0702/php-wordpress-learning.git)
cd php-wordpress-learning
