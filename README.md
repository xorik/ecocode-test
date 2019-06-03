# ecocode coding test

We have a small application that currently can only show the users a list of movies like IMDB does. 
The final product should contain the whole IMDB database and will give the users the opportunity
to mark their favorites. 




## Setup
If you want to set up the sample project, you can load the fixtures to get some sample data.


## Tasks
suggested time limit for the whole test is between 2-4 hours.

- review/refactor/debug the php files (templates can be ignored) according to your interpretation of clean code
  
  if you have improvements/suggestions that have not been implemented write them down under 
  [further improvements](#markdown-header-further-improvements) 
- Fill the User properties "last_login" and login_count" correctly



## Results submission
create a new repository with the current code base. commit your changes and send us a link to the repository


## Further improvements
- Replace annotations with PHP7 types, e.g.
```php
    /**
     * @param string $name
     *
     * @return $this
     */
     setName($name)
```
to
```php
    setName(string $name): self
```
- Use consistent visibility for entity fields. Currently some of them are private, some are protected.
- Rewrite deprecate classes with recommended (e.g. Controller, GetResponseEvent)
- In the user manager the interface UserInterface is used. Maybe it makes sense to use the User class directly.
- Fields createdAt, updatedAt aren't working. To fix the update date it's possible to use doctrine events. For create date I recommend put it in the constructor.
