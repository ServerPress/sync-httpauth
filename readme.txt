=== WPSiteSync for HTTP Authentication ===
Contributors: serverpress, spectromtech, davejesch, Steveorevo
Donate link: http://serverpress.com
Tags: wpsitesync, content, synchronization, content sync, data migration, desktopserver, http authentication
Requires at least: 3.5
Tested up to: 4.7.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds support for sites protected with HTTP Authentication via .htaccess rules.

== Description ==

This plugin provides the ability to configure WPSiteSync with an HTTP Authentication username and password to be used when communicating with a Target server that is set up with Authentication.

<strong>Usage Scenarios:</strong>

If you're using WPSiteSync with a staging server but want to limit access to the staging server via HTTP Authentication, this is the plugin for you.

This add-on plugin for WPSiteSync allows you to configure an HTTP Authentication username and password that will be used in communicating with the Target server; allowing you to PUSH and PULL changes from your local site to your password protected staging site.

This plugin works the same whether your Source Site is a local install via DesktopServer or other local development environment, or a publicly hosted site. For more information on DesktopServer and local development tools, please visit our web site at: <a href="https://serverpress.com/get-desktopserver/">https://serverpress.com/get-desktopserver/</a>

<strong>How it Works:</strong>

The WPSiteSync for HTTP Authentication add-on plugin sends the username and password with each API request made to the Target site. This allows you to configure your Target site with .htaccess rules that will limit access to user that have the password.

<strong>Support:</strong>

><strong>Support Details:</strong> We are happy to provide support and help troubleshoot issues. Visit our Contact page at <a href="http://serverpress.com/contact/">http://serverpress.com/contact/</a>. Users should know however, that we check the WordPress.org support forums once a week on Wednesdays from 6pm to 8pm PST (UTC -8).

ServerPress, LLC is not responsible for any loss of data that may occur as a result of using this tool. We strongly recommend performing a site and database backup before testing and using this tool. However, should you experience such an issue, we want to know about it right away.

We welcome feedback and Pull Requests for this plugin via our public GitHub repository located at: <a href="https://github.com/ServerPress/wpsitesync-httpauth">https://github.com/ServerPress/wpsitesync-httpauth</a>

== Installation ==

Installation instructions: To install, do the following:

1. From the dashboard of your site, navigate to Plugins --&gt; Add New.
2. Select the "Upload Plugin" button.
3. Click on the "Choose File" button to upload your file.
3. When the Open dialog appears select the wpsitesync-httpauth.zip file from your desktop.
4. Follow the on-screen instructions and wait until the upload is complete.
5. When finished, activate the plugin via the prompt. A confirmation message will be displayed.

or, you can upload the files directly to your server.

1. Upload all of the files in `wpsitesync-httpauth.zip` to your  `/wp-content/plugins/wpsitesync-httpauth` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1. Plugin page.

== Changelog ==
= 1.0.0 - May 4, 2017 =
Initial release to WordPress repository.

= 1.0.0 - Mar 31, 2017 =
* Initial Release

== Upgrade Notice ==

= 1.0.0 =
First release.
