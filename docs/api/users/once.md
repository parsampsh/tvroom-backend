# Once user
This API returns information of once user by id of it.
It is accessible for any user (non-authenticated, non-admin, etc).

- Uri: `/api/v1/users/{id}`
- Method: `GET`

### Parameters
- `id`: Id of the user (in url)

### Response
Returns `404 not found` when user is not exists.

Returns `200 Ok` with this json structure when user exists:

```json
{
  "id": 1,
  "username": "user-name",
  "email": "email@example.com",
  "is_manager": 0
}
```
