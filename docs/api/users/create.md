# User create
This API creates a new user.
This is possible by only the admins that have permission [`create-user`](../../permissions.md).

- Uri: `/api/v1/users/create`
- Method: `POST`

### Parameters
- `username`
- `email`
- `password`

### Response
Returns `201 Created` when user is created via this json data:

```json
{
  "message": "...",
  "user": {user...}
}
```

(Structure of `{user...}` is like [once](once.md) response)

Returns `409 Conflict` error when the username or email is already exists.
