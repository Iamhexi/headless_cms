# headless_cms
The headless CMS written in PHP using the MySQL database.

# Endpoints
* /API/feed
    * GET - gets the default number of articles. Parameters: -
    * POST - adds a new article. Parameters: token (Temporary Access Token), title, content, coverPhotoURL
    * PUT - updates an existing article. Parameters: token (Temporary Access Token), [, title, content, coverPhotoURL]
    * DELETE - deletes a selected artciel. Parameters: token (Temporary Access Token), id
* Authentication
    * POST - exchanges Personal Access Token (aka password) for Temporary Access Token, which is the token required for other endpoints, parameters: token (Personal Access Token).

## TODO
- [x] fix the bug setting the validity of Temporary Access Token to many years instead of minutes
- [x] implement Auth endpoint 
- [x] implement Feed endpoint
- [ ] implement Page endpoint
- [ ] introduce the permission system
- [ ] 
- [ ] 
- [ ] 
- [ ] 
- [ ] 