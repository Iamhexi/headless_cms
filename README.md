# headless_cms
The headless CMS written in PHP using the MySQL database.
The CMS uses curl and ssl extensions.

# Endpoints
The applications implements the following interface:

* /API/feed
    * GET - gets the default number of articles. 
      Parameters: -

    * POST - adds a new article. Query parameters: token (Temporary Access Token). Request body parameters (in JSON): title, content, coverPhotoURL

    * PUT - updates an existing article. Query parameters: token (Temporary Access Token), Request body parameters (in JSON): [title, content, coverPhotoURL]

    * DELETE - deletes a selected artcie. Query parameters: token (Temporary Access Token). Request body parameters (in JSON): id

* Authentication

    * POST - exchanges Personal Access Token (aka password) for Temporary Access Token, which is the token required for other endpoints. Query parameters: token (Personal Access Token).

## TODO
- [x] fix the bug setting the validity of Temporary Access Token to many years instead of minutes
- [x] implement the Auth endpoint 
- [x] implement the Feed endpoint
- [ ] implement the Page endpoint
- [ ] introduce the permission system
- [ ] 
- [ ] 
- [ ] 
- [ ] 
- [ ] 