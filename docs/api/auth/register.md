# User Registration
You can register the users via this API.

- Uri: `/api/v1/auth/register`
- Method: `POST`

### Parameters
- `username`: Username of the user
- `email`: Email of the user
- `password`: Password of the user

### Response
Returns `409 Conflict` status code when the username or email is already registered.

Returns `201 Created` when the user is registered successfully.
