# ZF2 API module: 
    - backend web-console for testing api requests
    - logs api data(platform, headers, request, respons, etc.)
    - API documentation

<pre>
CREATE TABLE `api_logs` (
  `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `platform` VARCHAR(255),
  `resource` VARCHAR(255) NOT NULL,
  `request_method` VARCHAR(255) NOT NULL,
  `request_body` TEXT,
  `request_headers` TEXT,
  `response_code` VARCHAR(255) NOT NULL,
  `response_body` TEXT,
  `created_dt` DATETIME,
  `ip` VARCHAR(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
</pre>

http://swagger.io/

https://github.com/zircote/swagger-php

https://github.com/Rebilly/ReDoc

## Samples

https://rebilly.github.io/ReDoc/

## Tools

 - [Swagger Editor](http://editor.swagger.io)
 
## Swagger documentations

 - [Specification](http://swagger.io/specification) 
 - [OpenAPI Specification v2.0](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md) 
 - [OpenAPI Specification v3.0](https://github.com/OAI/OpenAPI-Specification/blob/OpenAPI.next/versions/3.0.md) 