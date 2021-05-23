# Crews list
This API returns list of the crews.

- Uri: `/api/v1/crews`
- Method: `GET`

### Parameters
- `page`: The pagination page number

### Response
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "title": "The title",
      "en_title": "The en title",
      "img": "test.png",
      "description": "hello world",
      "user": {user...},
    },
    {...},
    {...}
  ],
  "first_page_url": "{host}/api/v1/crews?page=1",
  "from": 1,
  "last_page": 5,
  "last_page_url": "{host}/api/v1/crews?page=5",
  "links": [
    {"url": null, "label": "&laquo; Previous", "active": false},
    {"url": "{host}/api/v1/crews?page=1", "label": "1","active": true},
    {"url": null, "label": "Next &raquo;", "active": false}
  ],
  "next_page_url": "{host}/api/v1/crews?page=2",
  "path": "{host}/api/v1/crews",
  "per_page": 30,
  "prev_page_url": null,
  "to": 1,
  "total": 1
}
```

(The `{user...}` is like [user once](../users/once.md))
