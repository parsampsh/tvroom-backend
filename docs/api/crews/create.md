# Create a Crew
This API creates a new crew.
The user should have `create-crew` [permission](../../permissions.md) to create a new crew.

- Uri: `/api/v1/crews/create`
- Method: `POST`

### Parameters
- `title`: Title of the crew (required, max 255)
- `en_title`: English Title of the crew (required, max 255)
- `description`: A Description for the crew (optional, unlimited)
- `image`: A file as image of the crew (optional)

### Response
Returns `403 Forbidden` when user has not permission.

Returns `201 Created` when the crew is created:

```json
{
  "message": "...",
  "crew": {crew...}
}
```

The `{crew...}` is the created crew data. this is even with [crews list response](list.md).
