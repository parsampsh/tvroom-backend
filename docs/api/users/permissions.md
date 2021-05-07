# User update Permissions
This API updates list of the user permissions.
ONLY THE MANAGER has permission for doing this.

- Uri: `/api/v1/users/update_permissions/{user}`
- Method: `PUT`

### Parameters
There is one parameter in uri named `user` that is the Id of the user that you want to update
permissions list.

The second arguments, is an array named `permissions` that should be sent in the request body.
You should put list of user's new permissions list
(the old permissions will be deleted and new list will be overwritten on this).

### Response
Returns `200 Ok` when permissions updated.
Returns `400 Bad request` when the `permissions` field is not valid.
Returns `403 Forbidden` when user has not permission to update permissions list.
