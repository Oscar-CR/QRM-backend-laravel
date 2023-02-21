# APIS

## Admin

<details>
	<summary>All orders</summary>
Get all orders from all providers

<br>

GET
```php
{url}/allOrders/{token}
```
BODY
```php
// no data
```
RESPONSE 
```json
[
	{
		"general_total_to_pay": 19910.01,
		"general_total_debt": 19910.01,
		"general_total_pay": 0,
		"companies": [
			{
				"id": 8,
				"social_reason": "Donnelly and Sons",
				"rfc": "SIN ASIGNAR",
				"orders_total": 1,
				"total_to_pay": 204,
				"total_debt": 204,
				"total_pay": 0,
				"orders": [
					{
						"id": 1,
						"code_sale": "PED1230",
						"type_purchase": "Pedido",
						"sequence": "COMPRAS PEDIDO",
						"company": "PROMO LIFE",
						"code_purchase": "OC9691",
						"order_date": "2023-02-13 19:16:56",
						"provider_name": "Donnelly and Sons",
						"provider_address": "8873 Hessel Square\nReillyfort, OR 59045",
						"planned_date": "2023-02-22 16:52:34",
						"supplier_representative": "Prof. Andreanne Yundt",
						"total": "204.00",
						"status": "En Proceso",
						"invoice": null,
						"xml": null,
						"payment_status": "En validacion",
						"product": [
							{
								"data": {
								"id": 1,
								"odoo_product_id": "43",
								"product": "delectus enim",
								"description": "Voluptatem voluptatum rem sint optio inventore id.",
								"planned_date": "2023-02-23 06:51:55",
								"company": "PROMO LIFE",
								"quantity": "1714",
								"quantity_delivered": "1714",
								"quantity_invoiced": "1067",
								"measurement_unit": "Pieza",
								"unit_price": "52.00",
								"subtotal": "507.00",
								"pucharse_order_id": 1,
								"created_at": "2023-02-20T19:40:01.000000Z",
								"updated_at": "2023-02-20T19:40:01.000000Z"
								}
							}
						]
					}
				]
			//More companies with more data
			},
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
"email": "USER EMAIL",
"password": "USER PASSWORD",
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
"email": "USER EMAIL",
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