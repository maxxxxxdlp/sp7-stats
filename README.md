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
1. You can go over the other settings in the `config.php` files and see if there is anything you would like to adjust.

### Optional settings
1. You can set up daily cron to the following location `http://<yourdomain>/cron.php`. This will automatically unzip the files and compile the information so that users can get up to date information.
1. You can change the duration of time before compiled data is considered out of date by changing `SHOW_DATA_OUT_OF_DATE_WARNING_AFTER`. The default value is 86400 = 1 day.
1. By default `SPLIT_DATA` is set to 2000, meaning compiled data would be split into files of 2000 lines. Increasing this value negatively affects page load performance. Adjust this value based on how much traffic you are getting.

## Credit for used resources
There were snippets of code/files from the following resources used:
- [Bootstrap 4.5.0](https://github.com/twbs/bootstrap)
- [jQuery 3.5.1](https://github.com/jquery/jquery)
- [Chart.js](https://github.com/chartjs/Chart.js)
- [user_agent_strings.php](https://gist.github.com/maxxxxxdlp/f5977416b66000746f4abdf861caf1e3)
- [Specify 7 icon](https://sp7demofish.specifycloud.org/static/img/fav_icon.png)