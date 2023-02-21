# APIS

## Admin

<details>
	<summary>Edit user</summary>
Get specific information for a user

<br>

GET
```php
{url}/editUser/{user_id}
```
BODY
```php
// no data
```
RESPONSE 
```json
[	
	{
		"id": 1,
		"fullname": "Oscar Chavez Rosales",
		"rfc": "123456789012",
		"email": "admin@test.com",
		"status_id": 1,
		"company_id": 1,
		"role": 1
	}
]
```

ERROR RESPONSE 
```json
[
	{
		 "message": "Usuario no encontrado"
	}
]
```
</details>


<details>
	<summary>Update user</summary>
Update specific information for a user

<br>

POST
```php
{url}/updateUser
```
BODY
```json
{

	"id": 1,
	"fullname": "fullname",
	"rfc": "rfc",
	"email": "email@email.com",
	"role_id": 1,
	"company_id": 1,
}
```
RESPONSE 
```json
[	
	{
		"message": "usuario actualizado satisfactoriamente",
	}
]
```
</details>


<details>
	<summary>Delete user</summary>
Delete specific information for a user (Change status)

<br>

POST
```php
{url}/deleteUser
```
BODY
```json
{
	"id": 1,
	"fullname": "fullname",
	"rfc": "rfc",
	"email": "email@email.com",
	"role_id": 1,
	"company_id": 1,
}
```
RESPONSE 
```json
[	
	{
		 "message": "usuario eliminado satisfactoriamente"
	}
]
```

ERROR RESPONSE 
```json
[
	{
		 "message": "Usuario no encontrado"
	}
]
```
</details>

## Provider

<details>
	<summary>Provider orders</summary>
Get all the orders by provider that match with the logged user.

<br>

POST
```php
{url}/providerOrders/{token}
```
BODY
```json
// no data
```
RESPONSE 
```json
[
    {
        "id": 11,
        "code_sale": "PED4103",
        "type_purchase": "Pedido",
        "sequence": "COMPRAS MAQUILA",
        "company": "BH TRADEMARKET",
        "code_purchase": "OC9122",
        "order_date": "2023-02-14 15:34:24",
        "provider_name": "Bosco LLC",
        "provider_address": "96418 Aliyah Canyon\nSouth Kristyview, CA 44481",
        "planned_date": "2023-02-23 06:42:38",
        "supplier_representative": "Berry Roob",
        "total": "817.00",
        "status": "Confirmado",
        "invoice": null,
        "xml": null,
        "payment_status": "En validacion",
        "product": [
            {
                "id": 21,
                "odoo_product_id": "55",
                "product": "deleniti quia",
                "description": "At voluptatem est corrupti saepe accusantium.",
                "planned_date": "2023-02-20 21:29:21",
                "company": "PROMO LIFE",
                "quantity": "245",
                "quantity_delivered": "245",
                "quantity_invoiced": "154",
                "measurement_unit": "Pieza",
                "unit_price": "59.00",
                "subtotal": "317.00",
                "pucharse_order_id": 11
            },
            {
                "id": 22,
                "odoo_product_id": "25",
                "product": "suscipit quae",
                "description": "Et aperiam ut maxime aliquid fugit id.",
                "planned_date": "2023-02-21 04:25:31",
                "company": "BH TRADEMARKET",
                "quantity": "1711",
                "quantity_delivered": "1711",
                "quantity_invoiced": "1592",
                "measurement_unit": "Pieza",
                "unit_price": "91.00",
                "subtotal": "440.00",
                "pucharse_order_id": 11
            },
            {
                "id": 23,
                "odoo_product_id": "87",
                "product": "eos ipsam",
                "description": "Sunt magnam dolores alias quasi.",
                "planned_date": "2023-02-22 18:17:41",
                "company": "PROMO LIFE",
                "quantity": "1543",
                "quantity_delivered": "1543",
                "quantity_invoiced": "1038",
                "measurement_unit": "Pieza",
                "unit_price": "99.00",
                "subtotal": "876.00",
                "pucharse_order_id": 11
            }
        ]
    }
]
```

ERROR RESPONSE 
```json
[
	{
		 "message": "Usuario no encontrado"
	}
]
```
</details>



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
```json
[
	{
		"fullname": "USER NAME",
		"token": "USER TOKEN",
		"role": "USER ROLE"
	}
]
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
```json
[
	{
		"message": "REQUEST MESSAGE",
	}
]
```
</details>



### <  [`volver`](../README.md)