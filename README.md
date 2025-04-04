
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

## Screenshots

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
