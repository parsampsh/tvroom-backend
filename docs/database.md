# Tvroom-Backend Database structure
You can see the Database Models (Tables) structure and fields below.

(Note: Soft delete is enabled for all tables)

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
- [Score](#score)
- [Season](#season)
- [Episode](#episode)
- [Media](#media)

## User
This table keeps the users and admins.

Columns:
- `username`: A unique username for the user (max 255)
- `email`: A unique email for user (max 255)
- `password`: Hash of the user password
- `is_manager`: A boolean that determines is this user **Super user** (manager). default 0

## UserPermission
Each user has one or more permissions in this application.
You can see list of valid permissions [here](permissions.md).

Columns:
- `user_id`: Foreign key for [User](#user).
- `name`: Name of the permission ([See permissions list](permissions.md))  (max 255)

## Movie
The movies/serials.

Columns:
- `title`: Title of the movie (max 255)
- `en_title`: English Title of the movie (nullable) (max 255)
- `user_id`: Which [user](#user) added This
- `description`: The description of the movie (nullable) (unlimited)
- `img`: Image filename (nullable) (max 255)
- `type`: `0` is movie and `1` is serial
- `is_free`: Can be watched without subscription (boolean) (default 0)
- `is_show`: Is enable for showing (boolean) (default 0)

## Crew
The crews are directors, artists... of the [movies](#movie).

Columns:
- `title`: Name of the crew (max 255)
- `en_title`: English Name of the crew (nullable) (max 255)
- `img`: Image filename (nullable) (max 255)
- `description`: A description for crew (nullable) (unlimited)
- `user_id`: Which [user](#user) added this

## MovieCrew
The relation between [movies](#movie) and [crews](#crew) is a N2N relation.
This table makes the N2N relation for them.

Columns:
- `movie_id`: Id of the [movie](#movie)
- `crew_id`: Id of the [crew](#crew)
- `role`: Role of the crew in the movie (for example `director`) (max 255)

## Genre
The genres table.

Columns:
- `title`: Title of the genre (max 255)
- `en_title`: English Title of the genre (nullable) (max 255)
- `img`: Image filename (nullable) (max 255)
- `description`: Description (nullable) (unlimited)
- `user_id`: Which [user](#user) added this genre

## MovieGenre
The [movies](#movie) and the [genres](#genre) have N2N relation.
This table makes the N2N relation for them.

Columns:
- `movie_id`: Id of the [movie](#movie)
- `genre_id`: Id of the [genre](#genre)

## MovieImage
Each [movie](#movie) has some videos and images as preview.

- `title`: A title for image/video (max 255)
- `src`: Filename (max 255)
- `movie_id`: Id of the [movie](#movie)
- `is_video`: Is video or not (boolean) (default 0)

## Comment
The comments are here.

Columns:
- `user_id`: Which [user](#user) commented this
- `movie_id`: Which [movie](#movie) this comment is sent under
- `body`: Content of the comment (max 1000)
- `is_show`: Is enable for showing (boolean) (default 0)
- `is_spoil`: Does spoil the movie (boolean) (default 0)
- `comment_id`: Id of the comment that this comment is reply to (nullable)

## Subscription
The subscription plans are stored dynamically here.

Columns:
- `title`: Title of the plan (max 255)
- `days`: Plan Days count (int)
- `price`: Price of the plan (int)
- `caption`: A caption for the plan (max 255)
- `off`: The off (%) (default 0)
- `user_id`: Which [user](#user) added this

## Score
This table keeps score of the users to the movies.
Means User A gives score B to movie C.

Columns:
- `user_id`: The ID of the [user](#user)
- `movie_id`: The ID of the [movie](#movie)
- `score`: The score that user gives to the movie (int)

## Season
Each [movie](#movie) (serial) has some seasons.

- `movie_id`: Id of the [movie](#movie)
- `title`: Title of the season (max 255)
- `sort`: integer that determines sort of the seasons
- `caption`: A caption for episode (nullable) (max 1000)
- `is_single`: Is the movie single-season (default false) (boolean)

## Episode
Each [season](#season) has some episodes.

- `movie_id`: Id of the [movie](#movie)
- `season_id`: Id of the [season](#season)
- `title`: Title of the episode (max 255)
- `sort`: integer that determines sort of the episodes
- `caption`: A caption for episode (nullable) (max 1000)

## Media
Each [movie](#movie)/[episode](#episode) has some medias.
The medias actually are the files like video files in different qualities,
subtitle files, etc.

- `title`: A title for media (max 255)
- `src`: filename (max 255)
- `is_playable`: Is a playable video file (boolean) (default false)
- `movie_id`: Id of the [movie](#movie) (nullable)
- `episode_id`: Id of the [episode](#episode) (nullable)

(Note: the both `movie_id` and `episode_id` are nullable, but one of them are required).
