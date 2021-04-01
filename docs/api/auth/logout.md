# Logout
This API logouts the logged in user.

Uri: `/api/v1/auth/logout`
Method: `GET`

### Response
Returns `401 Unauthorized` when the user is not logged in.

Returns `200 OK` when user is logged out successfully.
