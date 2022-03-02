# Hiring Test :)
Assume that a company is a book marketplace and has millions of books from publishers worldwide. Please develop an application with Laravel that provides search API for end-users. It is essential for the business so their customers can find their books in less than two or three seconds.



1- The system should have a single api endpoint like :
``http://someflousrishingcompany.com/search/book?q={keyword}``



2- The `keyword` can be a `title,` `summary,` `publisher,` or `authors.`



3- The response should be JSON for both success and fail requests.



4- Data should be cached in Redis for configurable minutes.



6- The final JSON data model for a response should contain these values:


```
{
    "id": 1234,
    "publisher": "Packt",
    "title": "Mastering Something",
    "summary": "some long summary",
    "authors": [
        "Author One",
        "Author Two"
    ]
}
```
7- The project should have units and integrations tests.


8- Dockerize this project and make sure that it will work out of the box.


9- You should find your way around. That's all we know.


## Usage

Navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose up -d --build site`.

After that completes, cd to [src/](src/) and install Laravel by running 

` docker-compose run --rm composer install`



Three additional containers are included that handle Composer, and Artisan commands *without* having to have these platforms installed on your local computer. Use the following command examples from your project root, modifying them to fit your particular use case.

- `docker-compose run --rm composer update`
- `docker-compose run --rm artisan migrate`

You need to migrate and run seed, so after install Laravel run these commands.

```
 docker-compose run --rm artisan migrate
 docker-compose run --rm artisan db:seed
```

Bringing up the Docker Compose network with `site` instead of just using `up`, ensures that only our site's containers are brought up at the start, instead of all of the command containers as well. The following are built for our web server, with their exposed ports detailed:

- **nginx** - `:8090`
- **mysql** - `:3306`
- **php** - `:9000`
- **redis** - `:6379`

