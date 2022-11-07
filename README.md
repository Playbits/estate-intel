# Estate Intel App

## Instalation

---

Follow this few steps below to install the applications and get started. The application will be served on `localhost:80`

-   Clone repository `git@github.com:Playbits/estate-intel.git`
    ```
    # git clone git@github.com:Playbits/estate-intel.git .
    ```
-   Enter app folder
    ```
    # cd estate-intel
    ```
-   Build application with sail
    ```
    # ./vendor/bin/sail build
    ```
-   Start application with sail.
    ```
    # ./vendor/bin/sail up
    ```
-   Run application migrations
    ```
    #  ./vendor/bin/sail artisan migrate:install
    #  ./vendor/bin/sail artisan migrate:fresh
    ```

## Test

---

I also took some quality to get the application API tested. Below is the command and expected output

```
# ./vendor/bin/sail artisan test
```

Output

```

   PASS  Tests\Unit\BookTest
  ✓ example

   PASS  Tests\Feature\BookTest
  ✓ external book
  ✓ book create
  ✓ get all books
  ✓ show a book
  ✓ delete a book

  Tests:  6 passed
  Time:   4.48s
```

## Endpoints

---

The application running on `localhost` has shipped the below listed endpoints

-   External Books `http://localhost/api/external-books?name=A game of thrones` [GET]
-   Add a new book `localhost/api/v1/books` [POST]
-   Get all books `localhost/api/v1/books` [GET]
-   Get a book by book id `localhost/api/v1/books/1` [GET]
-   Update a book by book id `localhost/api/v1/books/1` [PATCH]
-   Delete a book `localhost/api/v1/books/1` [DELETE] or `localhost/api/v1/books/1/delete`[POST]
-   We can also filter a book search by `name`, `country`, `publisher` or `release_date` `localhost/api/v1/books?{filter}=` [GET]
