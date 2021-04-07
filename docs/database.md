# Tvroom-Backend Database structure
You can see the Database Models (Tables) structure and fields below.

(Note: Soft deletes is enabled for all tables)

## Table of contents
- [User](#user)
- [UserPermission](#userpermission)
- [Movie](#movie)
- [Crew](#crew)
- [MovieCrew](#moviecrew)
- [Genre](#genre)
- [MovieGenre](#moviegenre)
- [MovieImage](#movieimage)
- [Comment](#comment)
- [Subscription](#subscription)

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
- `en_title`: English Title of the movie (nullable)
- `user_id`: Which [user](#user) added This
- `description`: The description of the movie (nullable)
- `img`: Image filename (nullable)
- `type`: `0` is movie and `1` is serial
- `is_free`: Can be watched without subscription
- `is_show`: Is enable for showing

## Crew
The crews are directors, artists... of the [movies](#movie).

Columns:
- `title`: Name of the crew
- `en_title`: English Name of the crew (nullable)
- `img`: Image filename (nullable)
- `description`: A description for crew (nullable)
- `user_id`: Which [user](#user) added this

## MovieCrew
The relation between [movies](#movie) and [crews](#crew) is a N2N relation.
This table makes the N2N relation for them.

Columns:
- `movie_id`: Id of the [movie](#movie)
- `crew_id`: Id of the [crew](#crew)
- `role`: Role of the crew in the movie (for example `director`)

## Genre
The genres table.

Columns:
- `title`: Title of the genre
- `en_title`: English Title of the genre (nullable)
- `img`: Image filename (nullable)
- `description`: Description (nullable)
- `user_id`: Which [user](#user) added this genre

## MovieGenre
The [movies](#movie) and the [genres](#genre) have N2N relation.
This table makes the N2N relation for them.

Columns:
- `movie_id`: Id of the [movie](#movie)
- `genre_id`: Id of the [genre](#genre)

## MovieImage
Each [movie](#movie) has some videos and images as preview.

- `title`: A title for image/video
- `src`: Filename
- `movie_id`: Id of the [movie](#movie)
- `is_video`: Is video or not

## Comment
The comments are here.

Columns:
- `user_id`: Which user commented this
- `body`: Content of the comment (max 1000)
- `is_show`: Is enable for showing
- `is_spoil`: Does spoil the movie
- `comment_id`: Id of the comment that this comment is reply to (nullable)

## Subscription
The subscription plans are stored dynamically here.

Columns:
- `title`: Title of the plan
- `days`: Plan Days count
- `price`: Price of the plan
- `caption`: A caption for the plan
- `off`: The off (%)
- `user_id`: Who added this
