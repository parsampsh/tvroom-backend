# Tvroom-Backend API
You can see documentation for Tvroom backend APIs here.

Pattern of the APIs is this:

```
/api/<version>/<...>
```

For example:

```
/api/v1/user/register
```

Also, as general, the response is a json. The response HTTP statuses for each API
is described in their documentation
and all responses has two keys in their json: `error` and `message`.
If process is successful, the `message` is in response,
But if there are some errors, `error` is in response.

# Table of Contents
- [User related APIs](users)
    - [Registration](users/register.md)
    - [Login](users/login.md)
