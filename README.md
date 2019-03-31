#CMPE 332 - Forum Project

This project is implemented for CMPE 332 Course, by using `PHP` programming
language, `MySQL` SQL Database. 

For web pages, `TypeScript` language is used and for styling `SCSS` is used.
`TypeScript` is compiled to `JavaScript` and `SCSS` compiled to `CSS`.

##Folder Structure
- `api`: API for handling requests
  - `index.php`: Main definitions and handling provider file.
    - `register_handler($name: string, $handler_function: string, $type: 'gp' | 'p' | 'g')`:
      This function is used for handling requests by name. When `$name`
      is the request function name, the `handler_function` function is called.
      `$type` is for determining whether the request is allowed for `GET` or `POST`.
      
    - `handle_requests()`: Function for handling requests, looks up the request
      url in `$API_FUNCTIONS` and calls the related handler. Returns `JSON`
      always in `{ success: boolean, data: any }` form. `success` determines 
      the success state of the connection, even if the result is falsy.
      `data` is the result returned from the request.
      
      Also when there is an error, `error: { code: number, message: string, location: string }`
      is returned for information.
      
- `assets`: The folder for containing required style files, logic files (i.e. `JavaScript`), 
  images and others.
  
- `db`: Database connection and query files for related operations.
- `helpers`: Helper files of the project, containing:
  - `commons.php`: Common functions for the project. **ALSO STARTS THE SESSION**
  - `config.php`: Project-wide configuration of the project, such as DB connection.
  - `db`: Database initialization and connection provider function definitions.
  
- `layout`: Common layout files of the project. Include `_layout_top.php`
and `_layout_bottom.php` for inner pages.

- `.`: The rest of the `PHP` pages.
