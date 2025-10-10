# AdminGuard

**Author:** Taha Karami  
**Version:** 1.0  
**License:** MIT (Open Source)  

---

## Overview

AdminGuard is a **self-healing WordPress script** that ensures a critical admin user always exists with the correct username, email, password, and role. If any of these properties are changed or deleted, AdminGuard automatically restores them silently without notifications or logs.

This script is designed for developers, site maintainers, or security-conscious administrators who want to guarantee that their main admin account is always present and correctly configured.

> **Note:** This script is specifically built for **WordPress** and uses core WordPress functions (`WP_User`, `wp_insert_user`, `wp_update_user`, `wp_set_password`).

---

## Features

- **Self-Healing Admin User**: Automatically restores username, email, password, and role if they are modified.  
- **Silent Operation**: No logs, notifications, or alerts; works completely in the background.  
- **Simple & Lightweight**: Single PHP function using WordPress core functions.  
- **Open Source**: Licensed under MIT, free to use, modify, or distribute.  
- **Safe for Production**: Compatible with all WordPress versions supporting `WP_User` functions.  

---

## Installation

There are **two simple ways** to use AdminGuard on your WordPress site:

### 1. Include as a separate PHP file
1. Copy the `AdminGuard.php` file into your WordPress theme or plugin directory.  
2. Include it in your theme’s `functions.php` or main plugin file:

```php
require_once get_template_directory() . '/AdminGuard.php';
// OR, if you placed it in a plugin folder:
// require_once WP_PLUGIN_DIR . '/your-plugin-folder/AdminGuard.php';
