# REST API Library Management System

API ini memungkinkan Anda untuk mengelola penulis dan buku. Berikut adalah dokumentasi untuk setiap endpoint yang tersedia.

Tabel Isi

-   [Base URL](#base-url)
-   [Authors API](#authors-api)
    -   [1. GET /authors](#1-get-authors)
    -   [2. GET /authors/{id}](#2-get-authorsid)
    -   [3. POST /authors](#3-post-authors)
    -   [4. PUT /authors/{id}](#4-put-authorsid)
    -   [5. DELETE /authors/{id}](#5-delete-authorsid)
-   [Books API](#books-api)
    -   [1. GET /books](#1-get-books)
    -   [2. GET /books/{id}](#2-get-booksid)
    -   [3. POST /books](#3-post-books)
    -   [4. PUT /books/{id}](#4-put-booksid)
    -   [5. DELETE /books/{id}](#5-delete-booksid)
-   [Unit Test](#unit-test)
    -   [1. Authors](#1-authors)
    -   [2. Books](#2-books)

## Base URL

http://127.0.0.1:8000/api

## Authors API

### 1. GET /authors

-   **Deskripsi**: Mengambil daftar semua penulis.
-   **Response**:

    ```json
    [
        {
            "id": 1,
            "name": "Mr. Jermain Shanahan",
            "bio": "Illo quasi cupiditate maxime magni sint. Velit quae corrupti quia aperiam. Consectetur qui omnis ut neque perferendis.",
            "birth_date": "2012-02-10T00:00:00.000000Z",
            "created_at": "2024-10-15T13:24:06.000000Z",
            "updated_at": "2024-10-15T13:24:06.000000Z",
            "books": [
                {
                    "id": 6,
                    "title": "Sit temporibus tempora quisquam omnis exercitationem ut et.",
                    "description": "Voluptates molestiae reprehenderit magni excepturi. Quam iste sit accusamus quia. Ducimus ut et ea sunt recusandae quia ut. Eligendi rerum illo inventore harum et consequatur quisquam.",
                    "publish_date": "2015-01-29T00:00:00.000000Z",
                    "author_id": 2,
                    "created_at": "2024-10-15T13:24:06.000000Z",
                    "updated_at": "2024-10-15T13:24:06.000000Z"
                },

            ]
        },
        {
            "id": 2,
            "name": "Prof. Jaylan Wisozk Sr.",
            .......
    ]
    ```

### 2. GET /authors/ {id}

-   **Deskripsi**: Mengambil detail dari penulis tertentu.
-   **Contoh Permintaan**:
    ```
    GET /authors/1
    ```
-   **Response**:
    ```json
        "id": 1,
        "name": "Mr. Jermain Shanahan",
        "bio": "Illo quasi cupiditate maxime magni sint. Velit quae corrupti quia aperiam. Consectetur qui omnis ut neque perferendis.",
        "birth_date": "2012-02-10T00:00:00.000000Z",
        "created_at": "2024-10-15T13:24:06.000000Z",
        "updated_at": "2024-10-15T13:24:06.000000Z",
        "books": [
            {
                "id": 6,
                "title": "Sit temporibus tempora quisquam omnis exercitationem ut et.",
                "description": "Voluptates molestiae reprehenderit magni excepturi. Quam iste sit accusamus quia. Ducimus ut et ea sunt recusandae quia ut. Eligendi rerum illo inventore harum et consequatur quisquam.",
                "publish_date": "2015-01-29T00:00:00.000000Z",
                "author_id": 2,
                "created_at": "2024-10-15T13:24:06.000000Z",
                "updated_at": "2024-10-15T13:24:06.000000Z"
            },
    ```
-   **Not Found**:
    ```json
    {
        "message": "Author not found"
    }
    ```

### 3. POST /authors

-   **Deskripsi**: Membuat penulis baru.
-   **Contoh Permintaan**:
    ```json
    {
        "name": "John Doe",
        "bio": "An author of various books."
    }
    ```
-   **Response**:
    ```json
    {
        "name": "John Doe",
        "bio": "An author of various books.",
        "updated_at": "2024-10-15T13:26:42.000000Z",
        "created_at": "2024-10-15T13:26:42.000000Z",
        "id": 11
    }
    ```

### 4. PUT /authors/ {id}

-   **Deskripsi**: Memperbarui penulis yang ada.
-   **Contoh Permintaan**:
    ```json
    {
        "id": 1,
        "name": "Dr. Christiana Ziemann Updated",
        "bio": "Updated biography."
    }
    ```
-   **Response**:
    ```json
    {
        "id": 1,
        "name": "Dr. Christiana Ziemann Updated",
        "bio": "Updated biography.",
        "birth_date": "2007-04-29T00:00:00.000000Z",
        "created_at": "2024-10-15T13:24:06.000000Z",
        "updated_at": "2024-10-15T13:27:03.000000Z"
    }
    ```
-   **Not Found**:
    ```json
    {
        "message": "Author not found"
    }
    ```

### 5. DELETE /authors/ {id}

-   **Deskripsi**: Menghapus penulis tertentu.
-   **Contoh Permintaan**:
    ```
    DELETE /authors/1
    ```
-   **Response**:
    ```json
    {
        "message": "Author deleted successfully"
    }
    ```
-   **Not Found**:
    ```json
    {
        "message": "Author not found"
    }
    ```

## Books API

### 1. GET /books

-   **Deskripsi**: Mengambil daftar semua buku.
-   **Response**:
    ```json
    [
        {
            "id": 6,
            "title": "Sit temporibus tempora quisquam omnis exercitationem ut et.",
            "description": "Voluptates molestiae reprehenderit magni excepturi. Quam iste sit accusamus quia. Ducimus ut et ea sunt recusandae quia ut. Eligendi rerum illo inventore harum et consequatur quisquam.",
            "publish_date": "2015-01-29T00:00:00.000000Z",
            "author_id": 2,
            "created_at": "2024-10-15T13:24:06.000000Z",
            "updated_at": "2024-10-15T13:24:06.000000Z",
            "author": {
                "id": 2,
                "name": "Mr. Jermain Shanahan",
                "bio": "Illo quasi cupiditate maxime magni sint. Velit quae corrupti quia aperiam. Consectetur qui omnis ut neque perferendis.",
                "birth_date": "2012-02-10T00:00:00.000000Z",
                "created_at": "2024-10-15T13:24:06.000000Z",
                "updated_at": "2024-10-15T13:24:06.000000Z"
            }
        },
        {
            "id": 7,
            "title": "Non omnis quia sed sed consequatur.",
            "description": "Consectetur tempora nesciunt illum rerum. Id non ex cupiditate ut. Omnis labore necessitatibus earum. Culpa distinctio necessitatibus qui veritatis animi ut nam.",
            "publish_date": "1986-05-11T00:00:00.000000Z",
            "author_id": 2,
            "created_at": "2024-10-15T13:24:07.000000Z",
            "updated_at": "2024-10-15T13:24:07.000000Z",
            "author": {
                "id": 2,
                "name": "Mr. Jermain Shanahan",
                "bio": "Illo quasi cupiditate maxime magni sint. Velit quae corrupti quia aperiam. Consectetur qui omnis ut neque perferendis.",
                "birth_date": "2012-02-10T00:00:00.000000Z",
                "created_at": "2024-10-15T13:24:06.000000Z",
                "updated_at": "2024-10-15T13:24:06.000000Z"
            }
        },
    ```

### 2. GET /books/ {id}

-   **Deskripsi**: Mengambil detail dari buku tertentu.
-   **Contoh Permintaan**:
    ```
    GET /books/1
    ```
-   **Response**:
    ```json
    {
        "id": 1,
        "title": "Sit temporibus tempora quisquam omnis exercitationem ut et.",
        "description": "Voluptates molestiae reprehenderit magni excepturi. Quam iste sit accusamus quia. Ducimus ut et ea sunt recusandae quia ut. Eligendi rerum illo inventore harum et consequatur quisquam.",
        "publish_date": "2015-01-29T00:00:00.000000Z",
        "author_id": 2,
        "created_at": "2024-10-15T13:24:06.000000Z",
        "updated_at": "2024-10-15T13:24:06.000000Z",
        "author": {
            "id": 2,
            "name": "Mr. Jermain Shanahan",
            "bio": "Illo quasi cupiditate maxime magni sint. Velit quae corrupti quia aperiam. Consectetur qui omnis ut neque perferendis.",
            "birth_date": "2012-02-10T00:00:00.000000Z",
            "created_at": "2024-10-15T13:24:06.000000Z",
            "updated_at": "2024-10-15T13:24:06.000000Z"
        }
    }
    ```
-   **Not Found**:
    ```json
    {
        "message": "Book not found"
    }
    ```

### 3. POST /books

-   **Deskripsi**: Membuat buku baru.
-   **Contoh Permintaan**:

    ```json
    {
        "title": "Laravel for Beginners",
        "description": "A beginner's guide to Laravel.",
        "publish_date": "2023-01-01",
        "author_id": 2
    }
    ```

-   **Response**:
    ```json
    {
        "title": "Laravel for Beginners",
        "description": "A beginner's guide to Laravel.",
        "publish_date": "2023-01-01T00:00:00.000000Z",
        "author_id": 2,
        "updated_at": "2024-10-15T13:55:02.000000Z",
        "created_at": "2024-10-15T13:55:02.000000Z",
        "id": 52
    }
    ```

### 4. PUT /books/ {id}

-   **Deskripsi**: Memperbarui buku yang ada.
-   **Contoh Permintaan**:
    ```json
    {
        "title": "Updated Book Title",
        "description": "An updated description.",
        "publish_date": "2023-01-15",
        "author_id": 1
    }
    ```
-   **Response**:
    ```json
    {
        "id": 1,
        "title": "Updated Book Title",
        "description": "An updated description.",
        "publish_date": "2023-01-15",
        "author_id": 1
    }
    ```
-   **Not Found**:
    ```json
    {
        "message": "Book not found"
    }
    ```

### 5. DELETE /books/ {id}

-   **Deskripsi**: Menghapus buku tertentu.
-   **Contoh Permintaan**:
    ```
    DELETE /books/1
    ```
-   **Response**:
    ```json
    {
        "message": "Book deleted successfully"
    }
    ```
-   **Not Found**:
    ```json
    {
        "message": "Book not found"
    }
    ```

## Unit Test

### 1. Authors

`php artisan test --filter=AuthorApiTest`

Output:

```json
 PASS  Tests\Feature\AuthorApiTest
  ✓ can list authors                                                                                                                                                               0.38s
  ✓ can create author                                                                                                                                                              0.02s
  ✓ can view author                                                                                                                                                                0.02s
  ✓ can update author                                                                                                                                                              0.02s
  ✓ can delete author                                                                                                                                                              0.02s
  ✓ validation on create author                                                                                                                                                    0.02s
  ✓ view non existent author                                                                                                                                                       0.01s

  Tests:    7 passed (24 assertions)
  Duration: 0.56s
```

### 2. Books

`php artisan test --filter=BookApiTest`

Output:

```json
 PASS  Tests\Feature\BookApiTest
  ✓ can list books                                                                                                                                                                 0.39s
  ✓ can create book                                                                                                                                                                0.03s
  ✓ can view book                                                                                                                                                                  0.02s
  ✓ can update book                                                                                                                                                                0.02s
  ✓ can delete book                                                                                                                                                                0.02s
  ✓ validation on create book                                                                                                                                                      0.02s
  ✓ view non existent book                                                                                                                                                         0.01s

  Tests:    7 passed (26 assertions)
  Duration: 0.58s
```
