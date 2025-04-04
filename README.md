
# KPS Interview - WordPress Plugin

## Description

**KPS Interview** is a robust WordPress plugin designed to provide an extensible and developer-friendly solution for managing candidates using custom post types, custom fields, and custom admin columns. This plugin also supports bulk import functionality via CSV, ensuring seamless data entry and management. Built with adherence to WordPress coding standards, the plugin can be easily installed, activated, and integrated into other WordPress projects.

## Features

- **Custom Post Type:** Create and manage candidates with structured metadata.
- **Custom Fields:** Store detailed candidate information, including first name, last name, email, hobbies, gender, and profile picture.
- **Admin Columns:** Enhance the WordPress admin interface with sortable and filterable columns.
- **Bulk Import:** Efficiently import multiple candidates via CSV with validation and reporting.
- **User Management:** Add, edit, delete, and paginate user records.
- **Seamless Integration:** Compatible with standard WordPress functionalities and other plugins.
- **WordPress Coding Standards:** Ensures security, performance, and maintainability.
- **Auto Database Setup:** Executes SQL scripts automatically upon plugin activation.

## Installation

### Install via WordPress Admin

1. Navigate to **Plugins > Add New**.
2. Search for **KPS Interview**.
3. Click **Install Now**, then activate the plugin.

### Manual Installation

1. Download and unzip the plugin package.
2. Upload the `kps-interview` directory to `/wp-content/plugins/`.
3. Activate the plugin through the **Plugins** menu in WordPress.

## Usage Guide

### Admin Panel Sections

- **Create User:** Add new candidates with required fields and profile pictures.
- **Import Users:** Upload candidate data from a CSV file. A report is generated to show successful and failed imports.
- **List Users:** View, edit, and delete user records with pagination support.

### Bulk Import Process

1. Upload a CSV file containing candidate details.
2. Validate data and display import status.
3. Review results and manage imported records.

## Changelog

### Version 1.0
- Initial release with candidate management, custom fields, bulk import, and admin UI enhancements.

## Compatibility

- **Requires at least:** WordPress
- **Tested up to:** WordPress
- **Requires PHP:** 7.4 or later


## Support & Contributions

For feature requests, issues, or contributions, please visit our [GitHub repository](https://github.com/deven-sitapara) or consider donating to support the project: [PayPal Donation](https://www.paypal.com/paypalme/DevenSitapara).

## License

This plugin is licensed under the **GPLv2 or later**.

-----------------------

=== KPS Interview - WordPress Plugin with Custom Post Type and Custom Fields and Custom Admin Columns and Bulk Import ===

Contributors: shriramsoft

Donate link: https://www.paypal.com/paypalme/DevenSitapara

Tags: kps-interview, custom fields, custom post types, admin columns, bulk import

Requires at least: 4.3

Requires PHP: 5.3

Tested up to: 5.4.2

Stable tag: 5.3.3

License: GPLv2 or later

KPS Interview plugin is a powerful, professional developer sample example
to create plugin with custom types, fields and columns with bulk import for WordPress.

== Description ==

I was given following task, which is mentioned bellow.

WordPress Task for GKB Labs Interview

Create a plugin with the following features

Admin section
a) Add an option in settings menu called demo-plugin with submenu options

1.  create user 2) import users 3) list users

Create-users page:

First Name (Text Box)

Last Name (Text Box)

Email (Text Box)

Hobbies (checkbox) with option TV, Reading, coding, skiing

Gender (Radio) with options Male, Female

Upload picture (add WordPress media upload option )

Submit and Cancel buttons

Upon Submit save data into Database

3. Import users:

Provide an option to import users data from a CSV (CSV will contain above fields, first name or last name and email are mandatory )

Upon import CSV, report (display on the screen) how many were successfully imported and how many were failed

4. List Users:
   List all users with pagination
   Provider options to edit, delete

5)  Upload code into GitHub and share the link ( you may create an account if you don’t have one )

6. Find out a free hosting and upload your code as a demo (very helpful for evaluating the task )

Most importantly, plugin should follow all WordPress coding standards, and it should be export as zip and import as a plugin in other WordPress sites. The plugin should contain the SQL file required to store the user’s data and auto-execute SQL when plugin activated.

#### It's developer-friendly

As a developer, you have enough on your plate. You shouldn't have to create an entirely new system for each project. Use KPS Interview to your full advantage.

You can use KPS Interview and its custom fields in WordPress on as many websites as you want so you can use it on client projects as well.

== Installation ==

From within WordPress

1. Visit **Plugins > Add New**
1. Search for **KPS Interview**
1. Click the **Install Now** button to install the plugin
1. Click the **Activate** button to activate the plugin

Manually

1. Unzip the download package
1. Upload `kps-interview` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

To getting started with the plugin, please read the [Quick Start Guide](https://docs.metabox.io/quick-start/).

== Frequently Asked Questions ==

1. How to install ?
   Please check bellow screenshots.

== Screenshots ==

1. Plugin page

![Alt text](screenshots/plugin-page.png)

2. List Candidates

![Alt text](screenshots/list-candidates.png)

3. Add Candidate

![Alt text](screenshots/add-candidate.png)

4. CSV Sample

![Alt text](screenshots/csv-sample.png)

5. Import Step1

![Alt text](screenshots/import-step1.png)

6. Import Step2

![Alt text](screenshots/import-step2.png)

7. Import Step3

![Alt text](screenshots/import-step3.png)

== Changelog ==

= 1.0 =

- KPS Plugin can Add Candidate First Name, Last Name, Email, Gender , Hobbies

- Can Bulk Import.

== Upgrade Notice ==

Since version 5.0.0, the plugin requires PHP >= 5.3. If you use an older PHP version, please ask your host to upgrade or use an older version of KPS Interview.
