# PHP Env
Easy to load system enivronment configuration from \$\_ENV,\$\_SERVER,getenv.

##Demo
###Step 1: Created .env file

\#Master database
DB_HOST = '127.0.0.1' \#Local database
DB_NAME="db_name"
DB_USER="root"
DB_PWD="root"
DB_PORT=3306

\#Slave database 1
DB_SLAVE1_HOST="127.0.0.1"
DB_SLAVE1_NAME="db_name"
DB_SLAVE1_USER="root"
DB_SLAVE1_PWD="root"
DB_SLAVE1_PORT=3306

###Step 2: Using
use Phpenv\Env;

$envFile = realpath(".env");
Env::load($envFile);

print_r(\$\_ENV);
print_r(\$\_SERVER);

## License
Released under the [MIT license](http://www.opensoure.org/licenses/MIT).


