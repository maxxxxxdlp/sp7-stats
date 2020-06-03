# Specify 7 Usage Statistics
This website provides some information on the usage of [Specify 7](https://github.com/specify/specify7).

## Requirements

1. PHP 7.4 (older versions may work)
1. Any Web server

## Installation

All settings parameters are located in `config.php`

1. Open the `config.php` file.
1. Set `LINK` to an address where the server would be located. This is needed to route css and js files properly.
1. Set `FILES_LOCATION` location to the place where all of your access.log files are located. Make sure the web server has read permissions to all the files in this folder.
1. Set `UNZIP_LOCATION` to any empty folder. This would be the destination for all uncompressed access.log. Make sure the web server has write permissions to this folder. **Warning!** All of the files present in `UNZIP_LOCATION` would be deleted.
1. Configure your web server to point to this directory.

### Optional settings
 
1. You can setup daily cron to the following location `http://<youraddress>/cron.php`. This will automatically unzip the files so that users can get up to date information.
1. You can change the duration of time before compiled data is considered out of date by changing `SHOW_DATA_OUT_OF_DATE_WARNING_AFTER`. The default value is 86400 = 1 day.
1. You can set which HTTP codes get ignored in the result by changing `HTTP_CODES_TO_EXCLUDE`
1. By default `SPLIT_DATA` is set to 1000, meaning compiled data would be split into files of 1000 lines

#### IP Filtering

- You may log visitor's IP by setting `LOG_IPS` to TRUE in `config.php`.
- If that is true, you can set `BLOCK_EXTERNAL_IPS` to TRUE to block all IPs that are not specified in the `WHITELIST_IP_LOCATION` file.
- `WHITELIST_IP_LOCATION` should point to the file that has one allowed IP per line.
- All IPs that were blocked, would be written in the `BLOCKED_IPS_LOG_LOCATION` file.
- All IPs that were allowed, would be logged in the `IPS_LOG_LOCATION` file.