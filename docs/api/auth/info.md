# Get logged in user info
This API will return the current logged in user info.

- Uri: `/api/v1/auth/info`
- Method: `GET`

### Response
Returns `401 Unauthorized` when the user is not logged in.

Returns `200 OK` when user is logged in and returns user information at the json response.

User json response fields:

```json
{
  "id": 4,
  "username": "user-name",
  "email": "email@example.net",
  "email_verified_at": "2021-01-01T01:10:10.000000Z",
  "updated_at": "2021-01-01T01:10:10.000000Z",
  "created_at": "2021-01-01T01:10:10.000000Z",
}
```
