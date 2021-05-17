# Permissions list
This application has a permission system to manage access level for users.
You can see list of valid permissions here.

To check a user has a permission or not:

```php
$user = User::find($x);
$user->hasPermission('name-of-permission'); // returns boolean

// or for adding a permission for a user:
$user->permissions()->create(['name' => 'name-of-permission']);
```

List of the permissions:

- `get-users-list`: Accessing to list of all of users
- `create-user`: Creating the new users
- `delete-user`: Deleting a user
- `create-genre`: Creating a new genre
- `delete-genre`: Deleting its own genres
- `delete-any-genre`: Deleting ANY genres
