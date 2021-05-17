# Delete a genre
This API deletes a genre.
Deleting a genre requires [`delete-genre`/`delete-any-genre` permissions](../../permissions.md).

- Uri: `/api/v1/genres/delete/{genre-id}`
- Method: `DELETE`

### Parameters
The `genre-id` is the Id of the genre that you want to delete.
Id of a genre is accessible in [genre list api](list.md).

### Response
Returns `403 Forbidden` if user has not permission for deleting the genre.
Returns `200 Ok` when the genre is deleted successfully.
