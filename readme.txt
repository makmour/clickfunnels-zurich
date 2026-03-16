=== Zurich for ClickFunnels (SudoWP Edition) ===

Contributors: SudoWP, WP Republic
Tags: clickfunnels, security-patch, legacy, landing pages, xss-fix
Requires at least: 4.3
Tested up to: 6.7
Stable tag: 0.1.3
License: GPLv2 or later

An unofficial, security-patched fork of the legacy ClickFunnels plugin.

== Description ==
This is "Zurich", a community-maintained fork of the abandoned ClickFunnels Classic plugin (v3.1.1).
It patches a critical Stored XSS vulnerability (CVE-2022-4782) and ensures compatibility with modern WordPress versions.

**DISCLAIMER:** This plugin is NOT affiliated with or endorsed by ClickFunnels / Etison, LLC.

== Changelog ==

= Version 0.1.3 =
* Security Fix: Reflected XSS fix on REQUEST_URI (proper escaping).
* Security Fix: Remote HTML sanitization using wp_kses_post.
* Hardening: Added ABSPATH guards to all PHP files.
* Cleanup: Added uninstall.php with WP_UNINSTALL_PLUGIN check for proper data removal.

= Version 0.1.2 =
* Security Fix: Patched Stored XSS (CVE-2022-4782).
* Hardening: Strict sanitization and output escaping.

= Version 0.1.1 =
* Security Fix: Patched Stored Cross-Site Scripting (XSS) vulnerability (CVE-2022-4782).
* Hardening: Implemented strict sanitization and output escaping.