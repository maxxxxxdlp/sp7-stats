# Specify 7 Usage Statistics
This website provides some information on the usage of [Specify 7](https://github.com/specify/specify7).

## Installation

### Preliminary steps

1. Clone this repository
2. Install Docker and Docker compose
3. Edit `docker-compose.yml` in all the places where you see `CHANGE THIS:`
4. To run the containers, generate `fullchain.pem` and `privkey.pem` (certificate
   and the private key) using Let's Encrypt and put (or symlink) these files into
   the `./` directory.

   While in development, you can generate self-signed certificates:
  
   ```sh
   openssl req \
   -x509 -sha256 -nodes -newkey rsa:2048 -days 365 \
   -keyout ./lmtrex/config/privkey.pem \
   -out ./lmtrex/config/fullchain.pem
   ```
   
### Create a GitHub OAuth App

In order to enable authentication though GitHub and usage of GitHub APIs, a GitHub OAuth application needs to be created.

This can be done for a GitHub organization or user profile:

1. Open organization / user settings on GitHub
2. On the sidebar, select "Developer Settings"
3. Select "OAuth Apps"
4. Press "New OAuth App"
5. Fill out the required information
6. Set authentication callback URL to this URL:

   ```
   https://localhost/sign-in
   ```

   When in production, replace `localhost` with the actual hostname

7. Press "Generate a new client secret"
8. Client ID and Client Secret is displayed on the OAUth app configuration page.
9. Write them down somewhere temporary as they would be needed later

### Start up

Start the containers: `docker compose up -d`


### Optional settings

You can go over the other settings in the `./sp7-stats/config/optional.php` file and see if there is anything you would like to adjust.

For example:
1. You can set up daily cron to the following location `http://<yourdomain>/cron/refresh_data.php`. This will automatically unzip the files and compile the information so that users can get up to date information.
1. You can change the duration of time before compiled data is considered out of date by changing `SHOW_DATA_OUT_OF_DATE_WARNING_AFTER`. The default value is 86400 = 1 day[![analytics](http://www.google-analytics.com/collect?v=1&t=pageview&dl=https%3A%2F%2Fgithub.com%2Fspecify%2Fsp7-stats&uid=readme&tid=UA-169822764-2)]()
