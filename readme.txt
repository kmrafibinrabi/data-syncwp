=== Data syncWP ===
Contributors: kmrafibinrabi
Tags:data,integration,management,api-endpoint,synchronization
Requires at least:5.2
Tested up to:  6.4.2
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or  later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Data SyncWP is a powerful plugin that simplifies the management and synchronization of data within WordPress websites. By providing a simple interface for data input, storage, retrieval, and integration via REST API, the plugin aims to enhance data management capabilities for WordPress users, making it easier to maintain and utilize data effectively within their websites.

= Key Features =

- **Data Management:** Allows users to easily save and maintain various types of data, including headings, keywords, posts, dates, and times, via a user-    friendly form in the WordPress admin area.
- **CSV Upload:** Provides the ability to upload CSV files containing keywords, enabling bulk data import and synchronization.
- **Responsive:** Pricing tables are fully responsive and look great on all devices.
- **Data Display** Enables users to view and manage saved data conveniently through dedicated admin pages, offering options for data deletion and       manipulation.
- **REST API Integration:** ntegrates with the WordPress REST API to expose a custom endpoint (/data-syncwp/v1/data/) for accessing saved data programmatically, facilitating seamless integration with external applications or services.
- **Modifying API:** You can find api endpoint in your root plugin file,named "data_syncwp_register_api_endpoint")

== Manual Installation ==

1. Upload the entire `data-syncwp` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the Data SyncWP menu in the admin area to create new data.

= Automatic installation =

Automatic installation is the easiest option. Log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New.”
 

== Screenshots ==

1.  ![Screenshot 4](screenshot-4.jpg)
   - This is a screenshot of the data-syncwp on Admin dashboard.
    ![Screenshot 2](screenshot-2.jpg)
    ![Screenshot 3](screenshot-3.jpg)
  
  
  
  
== Frequently Asked Questions ==

= Can I import data from CSV files? =

Yes, you can import data from CSV files using the provided functionality.

= Is the plugin compatible with other WordPress plugins? =

Data SyncWP is designed to be compatible with most WordPress plugins. However, compatibility may vary depending on individual plugin configurations.

= How can I access the API endpoint? =

To access the API endpoint provided by Data SyncWP, you can use the following URL structure: `https://yourwebsite.com/wp-json/data-syncwp/v1/data/`.



== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
Initial release of Data SyncWP. Manage and synchronize your data with ease!

== Support ==

For support and inquiries, please contact us at kmrafibinrabi97@gmail.com.

== Credits ==

* K M RAFI BIN RABI - Lead Developer

== License ==

Data SyncWP is licensed under the GPLv2 or later. See http://www.gnu.org/licenses/gpl-2.0.html for more details.
  