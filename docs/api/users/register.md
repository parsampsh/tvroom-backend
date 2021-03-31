# User Registration
You can register the users via this API.

- Uri: `/api/v1/user/register`
- Method: `POST`

### Parameters
- `username`: Username of the user
- `email`: Email of the user
- `password`: Password of the user

### Response
Returns `409 Conflict` status code when the username or email is already registered.
Also, the error message is in `error` json field.

Returns `201 Created` when the user is registered successfully.
Also, the message is in `message` json field.
