<?php


# Set a list of IPs that should be excluded from the reports
const IPS_TO_EXCLUDE = [
	'129.237.229.',
	'129.237.201.',
	'24.143.45.91',
	'195.26.95.208',
	'24.124.121.150',
	'24.143.33.129',
	'24.143.39.179',
	'24.143.45.91',
	'24.143.60.228',
	'99.184.64.68',
	'129.237.92.172',
	'129.237.183.',
	'172.58.139.',
	'172.58.142.',
];

# Set a list of Institution Names to exclude
const INSTITUTIONS_TO_EXCLUDE = [
	//'University of Kansas Biodiversity Institute',
	//'KU Biodiversity Institute',
	'1',
];



# If data was not refreshed for this much time, the user would get a reminder to refresh data
# Also, if no new records were coming after this much time, an error message would be shown
define('SHOW_DATA_OUT_OF_DATE_WARNING_AFTER',86400);//one day



# Specifies the value to be used if failed to extract the browser from the User-Agent String
define('DEFAULT_BROWSER','');

# Specifies the value to be used if failed to extract the os from the User-Agent String
define('DEFAULT_OS','');



# Formatting for years, months and days when showing the usage statistics for a particular institution
# See more at https://www.php.net/manual/en/function.date.php
define('YEAR_FORMATTER','Y');
define('MONTH_FORMATTER','F');
define('DAY_FORMATTER','j D');



# Specifies how to display the results on the main page
# These values can be overwritten by supplying $_GET['view'] (e.x. ?view=00)
# 0  - Shows list view by default. Table view is also available
# 1  - Shows table view by default. List view is also available
# 00 - Shows list only. Table view is not available
# 11 - Shows table view only. List view is not available
define('MAIN_PAGE_OUTPUT_FORMAT','0');



# Specifies background and border colors for charts
# Both arrays should have the same number of elements since background and border colors go in pairs
const CHART_BACKGROUND_COLORS = ["rgba(86,206,255,0.2)", "rgba(162,235,54,0.2)", "rgba(86,255,206,0.2)", "rgba(235,54,162,0.2)", "rgba(54,162,235,0.2)", "rgba(192,192,75,0.2)", "rgba(162,54,235,0.2)", "rgba(255,206,86,0.2)", "rgba(75,192,192,0.2)", "rgba(99,255,132,0.2)", "rgba(206,255,86,0.2)", "rgba(255,99,132,0.2)", "rgba(153,255,102,0.2)", "rgba(64,159,255,0.2)", "rgba(235,162,54,0.2)", "rgba(64,255,159,0.2)", "rgba(99,132,255,0.2)", "rgba(153,102,255,0.2)", "rgba(192,192,75,0.2)", "rgba(192,75,192,0.2)", "rgba(255,132,99,0.2)", "rgba(255,86,206,0.2)", "rgba(255,102,153,0.2)", "rgba(132,99,255,0.2)", "rgba(159,64,255,0.2)", "rgba(255,64,159,0.2)", "rgba(102,255,153,0.2)", "rgba(54,235,162,0.2)", "rgba(255,153,102,0.2)", "rgba(75,192,192,0.2)", "rgba(255,159,64,0.2)", "rgba(159,255,64,0.2)", "rgba(192,75,192,0.2)", "rgba(132,255,99,0.2)", "rgba(102,153,255,0.2)", "rgba(206,86,255,0.2)"];
const CHART_BORDER_COLORS = ["rgba(86,206,255,1)", "rgba(162,235,54,1)", "rgba(86,255,206,1)", "rgba(235,54,162,1)", "rgba(54,162,235,1)", "rgba(192,192,75,1)", "rgba(162,54,235,1)", "rgba(255,206,86,1)", "rgba(75,192,192,1)", "rgba(99,255,132,1)", "rgba(206,255,86,1)", "rgba(255,99,132,1)", "rgba(153,255,102,1)", "rgba(64,159,255,1)", "rgba(235,162,54,1)", "rgba(64,255,159,1)", "rgba(99,132,255,1)", "rgba(153,102,255,1)", "rgba(192,192,75,1)", "rgba(192,75,192,1)", "rgba(255,132,99,1)", "rgba(255,86,206,1)", "rgba(255,102,153,1)", "rgba(132,99,255,1)", "rgba(159,64,255,1)", "rgba(255,64,159,1)", "rgba(102,255,153,1)", "rgba(54,235,162,1)", "rgba(255,153,102,1)", "rgba(75,192,192,1)", "rgba(255,159,64,1)", "rgba(159,255,64,1)", "rgba(192,75,192,1)", "rgba(132,255,99,1)", "rgba(102,153,255,1)", "rgba(206,86,255,1)"];



# Specifies the list of repositories that are available to chose from in the `github/` page
const ALLOWED_REPOSITORIES = ['specify7','specify6','webportal-installer','specify7-docker'];



### FOR DEBUG ONLY ###

# This will show success actions for most actions performed while the data refresh is running
define('VERBOSE',FALSE);

# Whether to output all PHP errors while DEVELOPMENT is set to FALSE
define('SHOW_ERRORS_IN_PRODUCTION',TRUE);