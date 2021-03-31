# User Login
This API logins a user with `email` and `password`.

- Uri: `/api/v1/user/login`
- Method: `POST`

### Parameters
- `email`: The user email
- `password`: The user password
- `remember` (optional): Remeber the login or not

### Response
Returns `401 Unauthorized` when the credentials are invalid.

Returns `200 Ok` when user is logged in successfully.

You can use Laravel session cookie to keep user logged in at frontend.
