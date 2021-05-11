# Genres list
This API returns list of the genres.

- Uri: `/api/v1/genres`
- Method: `GET`

### Response
The response is an array that contains list of the genres.

This is structure of the response:

```json
[
  {
    "id": 1,
    "title": "A title",
    "en_title": "An English title",
    "img": "name-of-image-file.ext",
    "description": "Some description",
    "user": {user...}
  },
  {...}
]
```

Note: the `{user...}` structure is even with [user once](../users/once.md).
Also, the `img` key is the name of image file that is accessible at
`{api-host}/uploads/img/{filename}`.
