# Update genre
This API updates a genre.
Updating a genre requires [`update-genre`/`update-any-genre` permissions](../../permissions.md).

- Uri: `/api/v1/genres/update/{genre-id}`
- Method: `PUT`

### Parameters
- `title`: Title of the genre (required, max 255)
- `en_title`: English Title of the genre (required, max 255)
- `description`: A Description for the genre (optional, unlimited)
- `image`: A file as image of the genre (optional)

### Response
Returns `403 Forbidden` when user has not permission.
Returns `200 Ok` when the genre is updated.
