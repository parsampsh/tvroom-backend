# Tvroom-Backend Database structure
You can see the Database Models (Tables) structure and fields below.

(Note: Soft deletes is enabled for all tables)

## Table of contents
- [User](#user)
- [UserPermission](#userpermission)
- [Movie](#movie)

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

## Movie
The movies/serials.

Columns:
- `title`: Title of the movie
- `user_id`: Which user added This
- `description`: The description of the movie
- `img`: Image filename
- `type`: `0` is movie and `1` is serial
- `is_free`: Can be watched without subscription

## Crew
The crews are directors, artists... of the movies.

Columns:
- `title`: Name of the crew
- `en_title`: English Name of the crew
- `img`: Image filename
- `description`: A description for crew
- `user_id`: Which user added this

## MovieCrew
The relation between movies and crews is a N2N relation.
This table makes the N2N relation for them.

Columns:
- `movie_id`: Id of the movie
- `crew_id`: Id of the crew
- `role`: Role of the crew in the movie (for example `director`)
