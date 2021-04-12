# Users list
This API returns list of the users.
The response is **Paginated**.

Accessing this API requires a authenticated user via [`get-users-list` permission](../../permissions.md).

- Uri: `/api/v1/users`
- Method: `GET`

### Parameters
- `page`: The pagination page number

### Response
The response is something like this:

```json
{
  "current_page": 1,
  "data": [
    {user...},
    {user...},
    {user...}
  ],
  "first_page_url": "{host}/api/v1/users?page=1",
  "from": 1,
  "last_page": 5,
  "last_page_url": "{host}/api/v1/users?page=5",
  "links": [
    {"url": null, "label": "&laquo; Previous", "active": false},
    {"url": "{host}/api/v1/users?page=1", "label": "1","active": true},
    {"url": null, "label": "Next &raquo;", "active": false}
  ],
  "next_page_url": "{host}/api/v1/users?page=2",
  "path": "{host}/api/v1/users",
  "per_page": 30,
  "prev_page_url": null,
  "to": 1,
  "total": 1
}
```

(Structure of each `{user...}` is like [once](once.md) response)

Users list is in the `data` key and other keys are related to pagination.
