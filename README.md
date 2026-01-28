# Pet project with raw php + mysql

## How to run it:

### Up in docker mysql container ( example below )
```Bash
( docker run --name mysql-container -e MYSQL_ROOT_PASSWORD=secret -p 3306:3306 -d mysql:8.0 ) 
```
### Set up .env file with your credentials

### Run this commands:

```Bash
Composer install
```

```Bash
php -s "yourhost:anyport"
```
