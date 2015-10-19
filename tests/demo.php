<?php
require '../src/Phpenv/Env.php';
use Phpenv\Env;


/*
#*****Begin .env file content ******

#Master database
DB_HOST = '127.0.0.1' #Local database
DB_NAME="db_name"
DB_USER="root"
DB_PWD="root"
DB_PORT=3306

#Slave database 1
DB_SLAVE1_HOST="127.0.0.1"
DB_SLAVE1_NAME="db_name"
DB_SLAVE1_USER="root"
DB_SLAVE1_PWD="root"
DB_SLAVE1_PORT=3306

# URL config
ASSETS_URL="http://assets.test.com"

#*****End .env file content *****
 */
$envFile = realpath(".env");
Env::load($envFile);

echo "DB_HOST: ".$_ENV["DB_HOST"];
$_SERVER["DB_HOST"];
Env::getEnv("DB_HOST");
echo getenv("DB_HOST");

//Output all environment variables
print_r($_ENV);
print_r($_SERVER);

