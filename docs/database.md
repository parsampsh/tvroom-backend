# Tvroom-Backend Database structure
You can see the Database Models (Tables) structure and fields below.

(Note: Soft deletes is enabled for all tables)

## Table of contents
- [User](#user)
- [UserPermission](#userpermission)

## User
This table keeps the users and admins.

Columns:
- `username`: A unique username for the user
- `email`: A unique email for user
- `password`: Hash of the user password
- `is_manager`: A boolean that determines is this user **Super user** (manager)

## UserPermission
Each user has one or more permissions in this application.
You can see list of valid permissions [here](permissions.md).

Columns:
- `user_id`: Foreign key for [User](#user).
- `name`: Name of the permission ([See permissions list](permissions.md))

(Note: there are some methods in [User](#user) model for working with permissions)
