# Create a Genre
This API creates a new genre.
The user should have `create-genre` [permission](../../permissions.md) to create a new genre.

- Uri: `/api/v1/genres/create`
- Method: `POST`

### Parameters
- `title`: Title of the genre (required, max 255)
- `en_title`: English Title of the genre (required, max 255)
- `description`: A Description for the genre (optional, unlimited)
- `image`: A file as image of the genre (optional)

### Response
Returns `403 Forbidden` when user has not permission.

Returns `201 Created` when the user is created:

```json
{
  "message": "...",
  "genre": {genre...}
}
```

The `{genre...}` is the created genre data. this is even with [genre list response](list.md).
