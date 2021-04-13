# User Login
This API logins a user with `email` and `password`.

- Uri: `/api/v1/auth/login`
- Method: `POST`

### Parameters
- `email`: The user email (max 255)
- `password`: The user password (max 255)
- `remember` (optional): Remember the login or not (boolean)

### Response
Returns `401 Unauthorized` when the credentials are invalid.

Returns `200 Ok` when user is logged in successfully.

You can use Laravel session cookie to keep user logged in at frontend.
