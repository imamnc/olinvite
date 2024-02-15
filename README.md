
<!-- ![Logo](https://waysolve.com/assets/img/waysolve.png) -->
<p align="center">
    <a href="https://waysolve.com" target="_blank">
        <img src="https://waysolve.com/assets/img/waysolve.png" width="250" alt="Logo">
    </a>
</p>


# About Olinvite

Olinvite is an online web invitation platform. This is main project of olinvite for handling traffic and API Services. The API was build on REST Architecture using Laravel Framework, Storing data using MySQL Database, and Securing resource using API Tokens from Laravel Sanctum.


## A. Installation

- Clone this project repository :
```bash
  git clone https://github.com/imamnc/olinvite.git
```

- Run compose install :
```bash
  composer install
```

- Run installer :
```bash
  php artisan olinvite:install
```

Setup should be completed after the setup commands was running out. So now you can setting virtual hosts to access your project or access this project on *http://localhost:8000* by running :
```bash
  php artisan serve
```

## B. Built in Commands

- Run/Reset database migration :
```bash
  php artisan olinvite:migrate
```

- Generate/Update API Docs :
```bash
  php artisan olinvite:swagger-generate
```

## C. Documentation

You can see the documentation of this API after you have finished the project setup. (http://localhost:8000/docs)


## D. Dev Environment

- **Language :** PHP 8.3

- **Database :** MySQL 8.0.33

- **Web Server :** Nginx/1.23.4


## E. Tech Stack

**Framework :** Laravel 10 (PHP)

**Database :** MySQL

**Web Server :** Nginx

**Authentication :** API Bearer Tokens

## F. Development Support

We already build a visual studio code snippets for all contributors to can easily create comments template for generate API Documentation using swagger

- Copy this code
```bash
  {
    "Swagger Controller Comment": {
		"prefix": "api_comments",
		"description": "Creating swagger documentation comment template",
		"body": [
			"/**",
			" * @OA\\ ${1:Get}(",
			" *     path=\"${2:/auth/user}\",",
			" *     summary=\"${3:Get user detail}\",",
			" *     tags={\"${4:Authentication}\"},",
			" *     security={{\"sanctum\":{}}},",
			" *		@OA\\Parameter(",
			" *         name=\"${5:id}\",",
			" *         in=\"query\",",
			" *         description=\"${6:To get sepesific data by ID}\",",
			" *         required=${7:false},",
			" *     ),",
			" *     @OA\\RequestBody(",
			" *         @OA\\MediaType(",
			" *             mediaType=\"application/json\",",
			" *				@OA\\Schema(",
			" *                 @OA\\Property(",
			" *                     property=\"name\",",
			" *                     type=\"string\"",
			" *                 )",
			" *             ),",
			" *				example={",
			" *					\"${8:key}\": \"${9:value}\"",
			" *				}",
			" *         )",
			" *     ),",
			" *     @OA\\Response(",
			" *         response=200,",
			" *         description=\"OK\",",
			" *         @OA\\MediaType(",
			" *             mediaType=\"application/json\",",
			" *             @OA\\Schema(",
			" *                 @OA\\Property(",
			" *                     property=\"success\",",
			" *                     type=\"boolean\"",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"message\",",
			" *                     type=\"string\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"data\",",
			" *                     type=\"object\",",
			" *                 ),",
			" *             ),",
			" *             example={",
			" *                  \"success\": true,",
			" *                  \"message\": \"${7:Get user successfull}\",",
			" *                  \"data\": ${10:{}}",
			" *             }",
			" *         )",
			" *     ),",
			" *     @OA\\Response(",
			" *         response=422,",
			" *         description=\"Validation Error\",",
			" *         @OA\\MediaType(",
			" *             mediaType=\"application/json\",",
			" *             @OA\\Schema(",
			" *                 @OA\\Property(",
			" *                     property=\"success\",",
			" *                     type=\"boolean\"",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"message\",",
			" *                     type=\"string\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"error_code\",",
			" *                     type=\"integer\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"data\",",
			" *                     type=\"object\",",
			" *                 ),",
			" *             ),",
			" *             example={",
			" *                  \"success\": false,",
			" *                  \"message\": \"Validation errors\",",
			" *                  \"error_code\": 422,",
			" *                  \"data\": {",
			" *                      \"errors\": {",
			" *                          \"email\": \"<Error Messages>\"",
			" *                      }",
			" *                  }",
			" *             }",
			" *         )",
			" *     ),",
			" *     @OA\\Response(",
			" *         response=401,",
			" *         description=\"Unauthenticated Request\",",
			" *         @OA\\MediaType(",
			" *             mediaType=\"application/json\",",
			" *             @OA\\Schema(",
			" *                 @OA\\Property(",
			" *                     property=\"success\",",
			" *                     type=\"boolean\"",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"message\",",
			" *                     type=\"string\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"error_code\",",
			" *                     type=\"integer\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"data\",",
			" *                     type=\"object\",",
			" *                 ),",
			" *             ),",
			" *             example={",
			" *                 \"success\": false,",
			" *                 \"message\": \"Unauthenticated\",",
			" *                 \"error_code\": 401,",
			" *                 \"data\": {}",
			" *             }",
			" *         )",
			" *     ),",
			" *     @OA\\Response(",
			" *         response=500,",
			" *         description=\"Internal Server Error\",",
			" *         @OA\\MediaType(",
			" *             mediaType=\"application/json\",",
			" *             @OA\\Schema(",
			" *                 @OA\\Property(",
			" *                     property=\"success\",",
			" *                     type=\"boolean\"",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"message\",",
			" *                     type=\"string\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"error_code\",",
			" *                     type=\"integer\",",
			" *                 ),",
			" *                 @OA\\Property(",
			" *                     property=\"data\",",
			" *                     type=\"object\",",
			" *                 ),",
			" *             ),",
			" *             example={",
			" *                  \"success\": false,",
			" *                  \"message\": \"<Error Messages>\",",
			" *                  \"error_code\": 500,",
			" *                  \"data\": {}",
			" *             }",
			" *         )",
			" *     ),",
			" * )",
			" */",
		]
	}
  }
```

- Open Visual Studio Code

- Open Menu File > Preferences > Configure User Snippets > New Global Snippets File...

- Then paste the code that you was copied before inside your created snippets file, save

- Ready

## G. Support

For support, email contact@imamnc.com.

