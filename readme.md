# Glints Scraping Project

### Server Requirements
- PHP 7.0.0
- Composer 1.0
- MySQL 5.5.9

### Local Server Setup
- Run `composer install`
- Copy `.env.example` to `.env`
- Edit `.env` to fit your configuration (Create the db, set the db info inside `.env`)
- if you need, create a new user & database in mysql:
  * Run `mysql` or `mysql -u root -p`
  * Enter password for root, if any
  * `CREATE DATABASE homestead;`
  * `CREATE USER 'homestead'@'localhost' IDENTIFIED BY 'secret';`
  * `GRANT ALL PRIVILEGES ON * . * TO 'homestead'@'localhost';`
  * `FLUSH PRIVILEGES;`
  * `exit` to exit mysql command line control.
- Run `php artisan key:generate` to generate key for application
- Run `php artisan migrate` to migrate the database

### Start Server
- Run `php artisan serve --port 3000`

###Web Interface
* `/` and `/book` - shows all books
* `/book?skill=exampleSkill` - shows all books related to `exampleSkill`
* `/skills` - shows all scraped skills
* `/scrape` - interface for scraping skill from Amazon
* `/scrape?skill=exampleSkill` - scrapes first page of book results from Amazon related to `exampleSkill`

###API Interface
* `GET /api/book` - returns all books in JSON format
* `GET /api/book?skill=exampleSkill` - returns all books related to `examepleSkill` in JSON format
* `GET /api/book/id` - returns book with id = `id` in JSON format
* `POST /api/book` - inserts a new book into the database. Parameters for the book are as below. It is advised to supply all parameters but only `skill` is compulsory.
  *  `title`: title of book
  *  `skill`: skill related to book **(COMPULSORY)**
  *  `author`: author of book
  *  `author_bio`: author's bio
  *  `description`: description of book
  *  `price`: price of book. value in numbers. omit `$` sign
  *  `rating`: rating of book. maximum rating of 5
  *  `img_url`: url to img of book's cover
  *  `book_url`: url to book on Amazon
* `PUT/PATCH /api/book/id` - updates book with id = `id` with the relevant attributes as above
* `DELETE /api/book/id` - updates book with id = `id`
