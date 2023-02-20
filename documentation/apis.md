# APIS

## Admin



## Provider

## Visualizer

## Global

<details>
	<summary>Login</summary>
<br>

POST
```php
{url}/login
```
BODY
```php
"rfc": "USER RFC",
```
RESPONSE 
```php
"fullname": "USER NAME",
"token": "USER TOKEN",
"role": "USER ROLE"
```
</details>


<details>
	<summary>Reset Password</summary>
<br>

POST
```php
{url}/reset-password
```
BODY
```php
"rfc": "USER RFC",
"password": "USER PASSWORD",
```
RESPONSE
```php
"message": "REQUEST MESSAGE",
```
</details>



### <  [`volver`](../README.md)