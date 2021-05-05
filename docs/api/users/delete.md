# User delete
This API allows you to delete a user.
Deleting a user requires [`user-delete` permission](../../permissions.md).
Also, the manager user cannot be deleted.

- Uri: `/api/v1/users/delete/{user-id}`
- Method: `DELETE`

### Parameters
The only parameter is `user-id`. This is Id of the user that you want to delete it.
Id of the user is accessible in the [response of the user data api](once.md).

### Response
Returns `403 Forbidden` when user has not permission.
Returns `200 Ok` when the user has been deleted.
