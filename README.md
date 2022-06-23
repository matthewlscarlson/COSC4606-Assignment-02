# COSC4606-Assignment-02

Database front end that allows for CRUD operations and user management.

## Idea
The idea here is that the database holds the students and employees (instructors, registrars, etc.) of a fictional university. Users can perform SQL operations through role-specific forms. Also supported is the ability for users to generate reports.

## Security
This project was an exercise in security.

First, users have roles which basically dictate what SQL operations they can perform. Each user account has associated with it a username and password. The latter is hashed via bcrypt.

Second, all SQL statements are prepared, thereby making SQL injection a non-issue.

## Reports

As stated above, users can generate reports. This is accomplished under the hood with FPDF, a free PHP class which contains a number of functions for creating and manipulating PDFs.

## Usage

There are a few prerequisites for replicating the app:

- GNU/Linux (Windows should also work)
- MariaDB (download from [https://mariadb.org](https://mariadb.org))
- PHP with MySQLi extension (MySQLi can easily be enabled in php.ini and is compatible with MariaDB)

Before doing anything, the database needs to be imported into a server. Make sure a local MariaDB server is running on your machine and run the following commands (the default password for `root` is blank):

```
$ mysql -u root -p
mysql> CREATE DATABASE cosc4606_assignment_02;
CTRL+D
$ mysql -u root -p cosc4606_assignment_02 < cosc4606-assignment-02.sql
```
This application extensively uses PHP, so make sure that a local server is running. That can be done by navigating to the base directory of the app and typing `php -S localhost:8000` into the terminal. Open up a web browser and type `localhost:8000` into the URL bar to see the login page.

Once you are at the login page, you will be prompted for a username and password. You can use the admin account to log in. Use `admin` for both the username and the password.

Logging in will redirect you to the home page. From there you can either log out or choose an action by clicking on the 'Actions' button.

## Screenshots

![cosc4606-assignment-02-login](https://mcarlson.xyz/img/cosc4606-assignment-02-login.png)

![cosc4606-assignment-02-admin](https://mcarlson.xyz/img/cosc4606-assignment-02-admin.jpg)

![cosc4606-assignment-02-add-user](https://mcarlson.xyz/img/cosc4606-assignment-02-add-user.png)

![cosc4606-assignment-02-view-users](https://mcarlson.xyz/img/cosc4606-assignment-02-view-users.png)
