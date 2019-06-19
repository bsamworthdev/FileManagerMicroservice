# FileManagerMicroservice

----------------------------------------------------------------------------------------------------
INTRODUCTION

This is a simple file manager microservice.

It provides a HTTP API for clients to manage any type of file providing the abilities listed below:
- Store files (Storing eventual files metadata as well) 
- Get list of stored files
- Delete files
- Download files
- Retrieve total used storage space

----------------------------------------------------------------------------------------------------
EXPLANATION

Ability: Store files |
Request: POST |
URL: /api/file

Ability: Get list of stored files |
Request: GET  |
URL: /api/file/all

Ability: Delete files |
Request: DELETE  |
URL: /api/file/{filename}

Ability: Download files |
Request: GET  |
URL: /api/file/{filename}


Ability: Retrieve total used storage space |
Request: GET |
URL: /api/file/space

----------------------------------------------------------------------------------------------------

TESTING

Run phpunit to run the tests.

----------------------------------------------------------------------------------------------------

IF I HAD MORE TIME...

1) I would record filenames in a database and log all additions/deletions with timestamps.
2) I would hash the filenames for security reasons, and to prevent duplicates occurring.
3) I would put in a maximum limit to the possible filesize, or - better - scale down all images over a certain size.
4) I would write a more thorough set of tests. 




