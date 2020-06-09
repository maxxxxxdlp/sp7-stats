# Specify 7 Usage Statistics
This website provides some information on the usage of [Specify 7](https://github.com/specify/specify7).

## Requirements

1. PHP 7.4 (older versions may work)
1. Any Webserver

## Installation

All settings parameters are located in `config.php`

1. Open the `config.php` file.
1. Set `LINK` to an address the website would be served on.
1. Set `FILES_LOCATION` location to the place where all of your access.log files are located. Make sure the webserver has read permissions to all the files in this folder.
1. Set `WORKING_LOCATION` to an empty folder. This would be the destination for all uncompressed access.log files and other files created in the process. Make sure the webserver has to write permissions to this folder. **Warning!** All of the files present in this directory would be deleted.
1. Configure your webserver to point to this directory.

### Optional settings
 
1. You can set up daily cron to the following location `http://<yourdomain>/cron.php`. This will automatically unzip the files and compile the information so that users can get up to date information.
1. You can change the duration of time before compiled data is considered out of date by changing `SHOW_DATA_OUT_OF_DATE_WARNING_AFTER`. The default value is 86400 = 1 day.
1. By default `SPLIT_DATA` is set to 1000, meaning compiled data would be split into files of 1000 lines. Increasing this value negatively affects page load performance. Adjust this value based on how much traffic you are getting.

#### IP Filtering

- You may log visitor's IP by setting `LOG_IPS` to TRUE in `config.php`.
- If that is true, you can set `BLOCK_EXTERNAL_IPS` to TRUE to block all IPs that are not specified in the `WHITELIST_IP_LOCATION` file.
- `WHITELIST_IP_LOCATION` should point to the file that has one allowed IP per line.
- All IPs that were blocked, would be written in the `BLOCKED_IPS_LOG_LOCATION` file.
- All IPs that were allowed, would be logged in the `IPS_LOG_LOCATION` file.

## Credit for used resources
There were snippets of code/files from the following resources used:
- [Bootstrap 4.5.0](https://github.com/twbs/bootstrap)
- [jQuery 3.5.1](https://github.com/jquery/jquery)
- [Chart.js](https://github.com/chartjs/Chart.js)
- [user_agent_strings.php](https://gist.github.com/maxxxxxdlp/f5977416b66000746f4abdf861caf1e3)
- [Specify 7 icon](https://sp7demofish.specifycloud.org/static/img/fav_icon.png)