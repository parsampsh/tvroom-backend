# Once user
This API returns information of once user by id or username of it.
It is accessible for any user (non-authenticated, non-admin, etc).

- Uri: `/api/v1/users/{id/username}`
- Method: `GET`

### Parameters
- `id/username`: Id OR username of the user (in url)

### Response
Returns `404 not found` when user is not exists.

Returns `200 Ok` with this json structure when user exists:

```json
{
  "id": 1,
  "username": "user-name",
  "email": "email@example.com",
  "is_manager": 0,
  "created_at": "yyyy-mm-dd 00:00:00",
  "updated_at": "yyyy-mm-dd 00:00:00",
}
```
