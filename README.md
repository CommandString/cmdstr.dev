# cmdMicro

A PHP microframework for building websites

# Table of Contents
- [Requirements](#requirements)
- [Getting started](#getting-started)
- [Environment Configuration](#environment-configuration)
- [Creating Routes](#creating-routes)
- [Cookie Manipulation](#cookie-manipulation)
- [Database Interaction](#database-interaction)
- [File Structure](#file-structure)
- [Developing](#developing)
- [Final Notes](#final-notes)

# Requirements
* PHP 8.1<=
* Composer
* nodemon (recommended for development)
* Basic understanding of MVC

# Getting started

1. [Create a repository from the template](https://github.com/CommandString/cmdmicro/generate) or [download the latest release](https://github.com/CommandString/cmdmicro/releases)
2. `composer install && php index.php`
3. Goto http://localhost:8000 and viola the website is alive

# Environment Configuration

You can change or add your own configuration options to `/env.json`. Below is an explanation for each configurable option.

```js
{
    "server": {
        "ip": "127.0.0.1", // the IP address the server should be binded to
        "port": 8000, // The port the server will be binded to
        "dev": true // Whether exceptions should be shown as a webpage, disable in production
    },
    "twigConfig": { 
        "cache": "./cache", // Where cache files are stored
        "views": "./views", // Where views are stored
        "cache_templates": false // Whether to cache templates, enable in production
    },
    "cookies": {
        "enabled": false, // Create commandstring/cookies instance
        "encryption_passphrase": "", // 32+ character alphanumeric key to encrypt cookies with
        "encryption_algo": "" // an openssl algo to encrypt cookies with
    },
    "database": {
        "enabled": false, // Create commandstring/pdo instance 
        "username": "", // username used for connecting to db
        "password": "", // password used for connect to db
        "name": "", // the name of the database to connect to
        "host": "", // the host of the db (e.g. 127.0.0.1)
        "port": "" // port of the db (e.g. 3306)
    }
}
```

*Note: When `env.json` does not exist `/env.example.json` will be copied to `/env.json` automatically*

You can read more on how to utilize this by checking out the README for [CommandString/Env](https://github.com/commandstring/env)

# Creating Routes

Route Controllers should be stored inside `/routes`. For actually creating routes read through [CommandString/Router](https://github.com/commandstring/router#routing) for a more in-depth explanation on how to create routes.

For creating views I would recommend checking out the documentation for [BladeOne](https://github.com/EFTEC/BladeOne) as well as [Blade](https://laravel.com/docs/9.x/blade) by default all views are stored in `/views` and all public assets (e.g. css, js, and images) are stored inside `/public`

# Cookie Manipulation

Checkout the README for [CommandString/ReactPHP-Cookies](https://github.com/commandstring/reactphp-cookies) for on how to manipulate cookies.

# Database Interaction

If you know PDO then you know how to use 99% of my PDO driver you can read more on that here [CommandString/PDO](https://github.com/commandstring/pdo#executing-a-query)

# File Structure
| Folder Path | Description |
|:-| :-|
| /public               | Files that can be accessed directly by the client
| /public/assets        | Public assets
| /public/assets/img 	| Images
| /public/assets/css 	| Cascading Style Sheets
| /public/assets/js  	| Javascript
| /routes 		        | Route controller storage
| /views  		        | Blade template storage
| /compiled		        | Compiled view storage
| /common               | Common class storage

# Developing

I highly recommend installing nodemon from npm when developing. This is because by default you have to restart the script everytime you make modifications, which can be a huge waste of time. So you'll need nodejs and npm to install nodemon, after verifying you have those two installed on your system you can do...`npm install -g nodemon` and then instead of starting the server with `php index.php` instead do `nodemon index.php`. Change a file and you will see it says the server has restarted. You can also invoke a restart by entering `r` into the console.

# Final Notes

If you have any questions on how to use this microframework or have any issues setting it up feel free to join my [discord server](https://discord.gg/TgrcSkuDtQ) and ask there.
