# Get logged in user info
This API will return the current logged in user info.

- Uri: `/api/v1/auth/info`
- Method: `GET`

### Response
Returns `401 Unauthorized` when the user is not logged in.

Returns `200 OK` when user is logged in and returns user information at the json response.

User json response fields: even with [user once](../users/once.md).
