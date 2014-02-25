djjob-test
==========

## About DJJob

DJJob is, as the developer says, is a PHP port of delayed_job, one of the many Background Jobs Runner used by the Ruby community. This basically gives you a way of enqueueing some function execution in the database. It provides a worker proccess that takes that job from the database and tries to execute it, counting the attempts. It starts to attempt faster first, and slower when failed attempts are showing up. Eg.: 5 first attempts in a few seconds, the next ones in minutes, then hours, then days. 

## Setup

### 1 DJJob

Create the `jobs` table in your database.

```sql
CREATE TABLE `jobs` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`handler` TEXT NOT NULL,
`queue` VARCHAR(255) NOT NULL DEFAULT 'default',
`attempts` INT UNSIGNED NOT NULL DEFAULT 0,
`run_at` DATETIME NULL,
`locked_at` DATETIME NULL,
`locked_by` VARCHAR(255) NULL,
`failed_at` DATETIME NULL,
`error` TEXT NULL,
`created_at` DATETIME NOT NULL
) ENGINE = INNODB;
```

### 2 Facebook

To be able to create events, you have to [create an facebook application](https://developers.facebook.com/), that resembles your own application name.

The important fields after the creation are the `App Id` and the `App Secret`

After that, you have to go: `Settings > Basic > Add Platform > Site`, and add your application url.

Then you have do go: `Settings > Basic > Domains`, and add alternative domains, if they exists.

Now you have to add a button in somewhere in your own site redirecting to the `permission.php` file, that will asks the user for permissions, so your application can create events in their names.

### 3 The Calendar Class

In your application, you will instantiate a new Calendar() class, anywhere in your system, with the event information (See `worker.php`)

After you will call $calendar->sendLater(), so this job will be enqueued.

### 4 Running the worker

For example purpose, there is a new Calendar() instantiation inside the worker.php. This will not happen in production. The places you have to change is:
```php
$options = ['driver'=> 'mysql','host'=> '127.0.0.1','dbname'=> 'djjob','user'=> 'root','password'=> ''];
DJJob::configure($options);
```
And
```php
$worker = new DJWorker($options);
$worker->start();
```

This worker.php file can start to run simply by a crontab task, executing the command `php worker.php`. If you need any help setting up all of this, just let me know.

