# Specify 7 Usage Statistics

This website provides some information on the usage
of [Specify 7](https://github.com/specify/specify7).

## Screenshots

Usage stats in list view:

![Usage stats in list view](./docs/img/list.png)

Usage stats in table view:

![Usage stats in table view](./docs/img/table.png)

GitHub repository stats:

![GitHub repository stats](./docs/img/github.png)

## Installation

### Configuration

1. Clone this repository
2. Install Docker and Docker compose
3. Copy `./env.example` file to `./.env` and change the variables as applicable
4. Edit `docker-compose.yml` in all the places where you see `CHANGE THIS:`
5. Copy `./sp7-stats/config/auth.example.conf` to
   `./sp7-stats/config/auth.conf` and change the variables as applicable. That
   would require you to create a GitHub OAuth
   App. [See the instructions](https://github.com/specify/nginx-with-github-auth#installation)
6. Generate `fullchain.pem` and `privkey.pem` (certificate
   and the private key) using Let's Encrypt and put (or symlink) these files
   into the `./sp7-stats/config/` directory.

   While in development, you can generate self-signed certificates:

   ```sh
   openssl req \
      -x509 -sha256 -nodes -newkey rsa:2048 -days 365 \
      -keyout ./sp7-stats/config/privkey.pem \
      -out ./sp7-stats/config/fullchain.pem
   ```

### Start up

Start the containers: `docker compose up -d`

### Optional settings

You can go over the other settings in the `./sp7-stats/config/optional.php` file
and see if there is anything you would like to adjust.

For example:

1. You can set up daily cron to the following
   location `http://<yourdomain>/cron/refresh_data.php`. This will automatically
   unzip the files and compile the information so that users can get up to date
   information.
2. You can change the duration of time before compiled data is considered out of
   date by changing `SHOW_DATA_OUT_OF_DATE_WARNING_AFTER`. The default value is
   86400 = 1
   day[![analytics](http://www.google-analytics.com/collect?v=1&t=pageview&dl=https%3A%2F%2Fgithub.com%2Fspecify%2Fsp7-stats&uid=readme&tid=UA-169822764-2)]()
