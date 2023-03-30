# APIS

## Admin/Visualizer

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
						"status": 1,
						"invoice": null,
						"xml": null,
						"payment_status": "En validacion",
						"products_data": [
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
								}
							}
						]
					},
					{
						"id": 11,
						"social_reason": "Kiehn, Mayert and Sauer",
						"rfc": "SIN ASIGNAR",
						"orders_total": 1,
						"total_to_pay": 130,
						"total_debt": 130,
						"total_pay": 0,
						"orders": [
							{
								"id": 2,
								"code_sale": "PED5656",
								"type_purchase": "Pedido",
								"sequence": "COMPRAS PEDIDO",
								"company": "BH TRADEMARKET",
								"code_purchase": "OT1093",
								"order_date": "2023-02-12 04:21:27",
								"provider_name": "Kiehn, Mayert and Sauer",
								"provider_address": "30875 Zackary Tunnel Suite 375\nLake Nolanland, MO 84295",
								"planned_date": "2023-02-23 00:53:13",
								"supplier_representative": "Dr. Oral Monahan MD",
								"total": "130.00",
								"status": 1,
								"invoice": null,
								"xml": null,
								"payment_status": "En validacion",
								"products_data": [
									{
										"id": 2,
										"odoo_product_id": "99",
										"product": "odio molestias",
										"description": "Aut atque iure saepe eos.",
										"planned_date": "2023-02-22 05:28:01",
										"company": "PROMO LIFE",
										"quantity": "1996",
										"quantity_delivered": "1996",
										"quantity_invoiced": "966",
										"measurement_unit": "Pieza",
										"unit_price": "7.00",
										"subtotal": "889.00",
										"pucharse_order_id": 2
									},
									{
										"id": 3,
										"odoo_product_id": "140",
										"product": "ut nulla",
										"description": "Voluptatibus dolorum minus repudiandae laudantium.",
										"planned_date": "2023-02-17 04:53:20",
										"company": "PROMO LIFE",
										"quantity": "1097",
										"quantity_delivered": "1097",
										"quantity_invoiced": "154",
										"measurement_unit": "Pieza",
										"unit_price": "72.00",
										"subtotal": "626.00",
										"pucharse_order_id": 2
									}
								]
							}
						]
					},
				]
			},
		]
	}
]
```

ERROR RESPONSE 
```json
[
	{
		"message": "Token invalido"
	}
]
```
```json
[
	{
		"message": "Acceso restringido"
	}
]
```
</details>




<details>
	<summary>All orders by company </summary>
Get all orders from a specific providers

<br>

GET
```php
{url}/allOrdersByCompany/{token}
```
BODY
```php
// no data
```
RESPONSE 
```json
[
	{
		"social_reason": "BH TRADE MARKET SA DE CV",
		"companies": [
			{
				"id": 48,
				"social_reason": "ABEL MANZANO SANCHEZ",
				"rfc": "SIN ASIGNAR",
				"orders_total": 1,
				"total_to_pay": 3352.4,
				"total_debt": 3352.4,
				"total_pay": 0,
				"orders": [
					{
						"id": 21,
						"code_sale": "PED-15068",
						"type_purchase": "Pedido",
						"sequence": "COMPRAS PEDIDOS",
						"company": "BH TRADE MARKET SA DE CV",
						"code_purchase": "OC-12985",
						"order_date": "2022-01-28 16:53:08",
						"provider_name": "ABEL MANZANO SANCHEZ",
						"provider_address": "TITERES, 1301 A, LOS REGUILETES, México, 67286, México, Centro",
						"planned_date": "2022-02-01 16:52:57",
						"supplier_representative": "TEAM VDE",
						"total": "3352.40",
						"status": 1,
						"invoice": null,
						"xml": null,
						"payment_status": "En validacion",
						"products_data": [
							{
								"id": 43,
								"odoo_product_id": "40215",
								"product": "GAFETE PVC 8.5X5.5 CON SUAJE PARA LANDYARD",
								"description": "GAFETE PVC 8.5X5.5 CON SUAJE PARA LANDYARD",
								"planned_date": "2022-02-01 16:52:57",
								"company": "BH TRADE MARKET SA DE CV",
								"quantity": "100",
								"quantity_delivered": "0",
								"quantity_invoiced": "100",
								"measurement_unit": "Pieza",
								"unit_price": "16.00",
								"subtotal": "1600.00",
								"pucharse_order_id": 21
							},
							{
							"id": 44,
							"odoo_product_id": "43118",
							"product": "LANDYARD SATINADO 85X2 CM SUBLIMADO 1 CARA LOGO MARGARITA VILLE",
							"description": "LANDYARD SATINADO 85X2 CM SUBLIMADO 1 CARA LOGO MARGARITA VILLE",
							"planned_date": "2022-02-01 16:53:01",
							"company": "BH TRADE MARKET SA DE CV",
							"quantity": "100",
							"quantity_delivered": "0",
							"quantity_invoiced": "100",
							"measurement_unit": "Pieza",
							"unit_price": "12.90",
							"subtotal": "1290.00",
							"pucharse_order_id": 21
							}
						]
					}
				]
			},
			{
				"id": 49,
				"social_reason": "FOR PROMOTIONAL, S.A. DE C.V.",
				"rfc": "SIN ASIGNAR",
				"orders_total": 1,
				"total_to_pay": 6436.61,
				"total_debt": 6436.61,
				"total_pay": 0,
				"orders": [
					{
						"id": 22,
						"code_sale": "PED-15006",
						"type_purchase": "Pedido",
						"sequence": "COMPRAS PEDIDOS",
						"company": "BH TRADE MARKET SA DE CV",
						"code_purchase": "OC-12957",
						"order_date": "2021-05-06 21:22:06",
						"provider_name": "FOR PROMOTIONAL, S.A. DE C.V.",
						"provider_address": " ",
						"planned_date": "2021-05-07 21:21:52",
						"supplier_representative": "FERNANDA MICHELL DIAZ HERNANDEZ",
						"total": "6436.61",
						"status": 1,
						"invoice": null,
						"xml": null,
						"payment_status": "En validacion",
						"products_data": [
							{
							"id": 45,
							"odoo_product_id": "42993",
							"product": "Cilindro color azul DEXTER de plástico con tapa enroscable",
							"description": "Cilindro color azul DEXTER de plástico con tapa enroscable",
							"planned_date": "2021-05-07 21:21:52",
							"company": "BH TRADE MARKET SA DE CV",
							"quantity": "510",
							"quantity_delivered": "510",
							"quantity_invoiced": "510",
							"measurement_unit": "Pieza",
							"unit_price": "10.88",
							"subtotal": "5548.80",
							"pucharse_order_id": 22
							}
						]
					}
				]
			}
		]
	},
	{
		"social_reason": "PROMO LIFE",
		"companies": [
			{
				"id": 48,
				"social_reason": "ABEL MANZANO SANCHEZ",
				"rfc": "SIN ASIGNAR",
				"orders_total": 1,
				"total_to_pay": 3352.4,
				"total_debt": 3352.4,
				"total_pay": 0,
				"orders": [
					{
						"id": 21,
						"code_sale": "PED-15068",
						"type_purchase": "Pedido",
						"sequence": "COMPRAS PEDIDOS",
						"company": "BH TRADE MARKET SA DE CV",
						"code_purchase": "OC-12985",
						"order_date": "2022-01-28 16:53:08",
						"provider_name": "ABEL MANZANO SANCHEZ",
						"provider_address": "TITERES, 1301 A, LOS REGUILETES, México, 67286, México, Centro",
						"planned_date": "2022-02-01 16:52:57",
						"supplier_representative": "TEAM VDE",
						"total": "3352.40",
						"status": 1,
						"invoice": null,
						"xml": null,
						"payment_status": "En validacion",
						"products_data": [
							{
								"id": 43,
								"odoo_product_id": "40215",
								"product": "GAFETE PVC 8.5X5.5 CON SUAJE PARA LANDYARD",
								"description": "GAFETE PVC 8.5X5.5 CON SUAJE PARA LANDYARD",
								"planned_date": "2022-02-01 16:52:57",
								"company": "BH TRADE MARKET SA DE CV",
								"quantity": "100",
								"quantity_delivered": "0",
								"quantity_invoiced": "100",
								"measurement_unit": "Pieza",
								"unit_price": "16.00",
								"subtotal": "1600.00",
								"pucharse_order_id": 21
							},
							{
								"id": 44,
								"odoo_product_id": "43118",
								"product": "LANDYARD SATINADO 85X2 CM SUBLIMADO 1 CARA LOGO MARGARITA VILLE",
								"description": "LANDYARD SATINADO 85X2 CM SUBLIMADO 1 CARA LOGO MARGARITA VILLE",
								"planned_date": "2022-02-01 16:53:01",
								"company": "BH TRADE MARKET SA DE CV",
								"quantity": "100",
								"quantity_delivered": "0",
								"quantity_invoiced": "100",
								"measurement_unit": "Pieza",
								"unit_price": "12.90",
								"subtotal": "1290.00",
								"pucharse_order_id": 21
							}
						]
					}
				]
			}
		]
	},
]
```

ERROR RESPONSE 
```json
[
	{
		"message": "Token invalido"
	}
]
```
```json
[
	{
		"message": "Acceso restringido"
	}
]
```
</details>

<details>
	<summary>Initial Invoinces</summary>
Get all orders by company, per a specific cut day (today) and the next orders

<br>

GET
```php
{url}/generalInitialInvoinces
```
BODY
```php
{
	// no data
}
```
RESPONSE 
```json
[
    {
        "social_reason": "BH TRADE MARKET SA DE CV",
        "order_data": [
            {
                "general_total_to_pay": 0,
                "general_total_debt": 0,
                "general_total_pay": 0,
                "first_date_data": [
                    {
                        "date": "2022-12-22",
                        "first_date_total_to_pay": 0,
                        "first_date_total_debt": 0,
                        "first_date_total_pay": 0
                    }
                ],
                "second_date_data": [
                    {
                        "date": "2023-01-22",
                        "second_date_total_to_pay": 0,
                        "second_date_total_debt": 0,
                        "second_date_total_pay": 0
                    }
                ],
                "third_date_data": [
                    {
                        "date": "2023-02-22",
                        "third_date_total_to_pay": 0,
                        "third_date_total_debt": 0,
                        "third_date_total_pay": 0
                    }
                ],
                "next_orders_data": []
            }
        ]
    },
    {
        "social_reason": "PROMO LIFE",
        "order_data": [
            {
                "general_total_to_pay": 4448,
                "general_total_debt": 4448,
                "general_total_pay": 0,
                "first_date_data": [
                    {
                        "date": "2022-12-22",
                        "first_date_total_to_pay": 0,
                        "first_date_total_debt": 0,
                        "first_date_total_pay": 0
                    }
                ],
                "second_date_data": [
                    {
                        "date": "2023-01-22",
                        "second_date_total_to_pay": 2199,
                        "second_date_total_debt": 2199,
                        "second_date_total_pay": 0
                    }
                ],
                "third_date_data": [
                    {
                        "date": "2023-02-22",
                        "third_date_total_to_pay": 2249,
                        "third_date_total_debt": 2249,
                        "third_date_total_pay": 0
                    }
                ],
                "next_orders_data": [
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
                        "planned_date": "2023-02-23 16:52:34",
                        "supplier_representative": "Prof. Andreanne Yundt",
                        "total": "204.00",
                        "status": 1,
                        "invoice": null,
                        "xml": null,
                        "payment_status": "En validacion"
                    }
                ]
            }
        ]
    },
]
```



</details>


<details>
	<summary> invoices by date</summary>
Get all orders by company, per a specific cut day and the next orders

<br>

POST
```php
{url}/invoicesByDate
```
BODY
```php
{
	"end": "2023-02-21"
}
```
RESPONSE 
```json
[
    {
        "social_reason": "BH TRADE MARKET SA DE CV",
        "order_data": [
            {
                "general_total_to_pay": 0,
                "general_total_debt": 0,
                "general_total_pay": 0,
                "first_date_data": [
                    {
                        "date": "2022-12-21",
                        "first_date_total_to_pay": 0,
                        "first_date_total_debt": 0,
                        "first_date_total_pay": 0
                    }
                ],
                "second_date_data": [
                    {
                        "date": "2023-01-21",
                        "second_date_total_to_pay": 0,
                        "second_date_total_debt": 0,
                        "second_date_total_pay": 0
                    }
                ],
                "third_date_data": [
                    {
                        "date": "2023-02-21",
                        "third_date_total_to_pay": 0,
                        "third_date_total_debt": 0,
                        "third_date_total_pay": 0
                    }
                ],
                "next_orders_data": []
            }
        ]
    },
    {
        "social_reason": "PROMO LIFE",
        "order_data": [
            {
                "general_total_to_pay": 4398,
                "general_total_debt": 4398,
                "general_total_pay": 0,
                "first_date_data": [
                    {
                        "date": "2022-12-21",
                        "first_date_total_to_pay": 0,
                        "first_date_total_debt": 0,
                        "first_date_total_pay": 0
                    }
                ],
                "second_date_data": [
                    {
                        "date": "2023-01-21",
                        "second_date_total_to_pay": 2199,
                        "second_date_total_debt": 2199,
                        "second_date_total_pay": 0
                    }
                ],
                "third_date_data": [
                    {
                        "date": "2023-02-21",
                        "third_date_total_to_pay": 2199,
                        "third_date_total_debt": 2199,
                        "third_date_total_pay": 0
                    }
                ],
                "next_orders_data": [
                    {
                        "id": 14,
                        "code_sale": "PED6659",
                        "type_purchase": "Pedido",
                        "sequence": "COMPRAS PEDIDO",
                        "company": "PROMO LIFE",
                        "code_purchase": "OT8717",
                        "order_date": "2023-02-10 14:50:18",
                        "provider_name": "Muller-Nitzsche",
                        "provider_address": "78555 Hermann Loaf Apt. 953\nKunzebury, SC 91198",
                        "planned_date": "2023-02-22 10:20:51",
                        "supplier_representative": "Mitchell Sauer",
                        "total": "50.00",
                        "status": 1,
                        "invoice": null,
                        "xml": null,
                        "payment_status": "En validacion"
                    },
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
                        "status": 1,
                        "invoice": null,
                        "xml": null,
                        "payment_status": "En validacion"
                    }
                ]
            }
        ]
    },
]
```

ERROR RESPONSE 
```json
[
	{
		"message": "ordenes no disponibles en fecha seleccionada"
	}
]
```

</details>



## Admin

<details>
	<summary>Required user data</summary>
Specific information to create, update a user, or filter information.
<br>

GET
```php
{url}/requiredUserData
```
BODY
```php
// no data
```
RESPONSE 
```json
[
	{
		"roles": [
			{
				"id": 1,
				"name": "admin",
				"display_name": "administrador",
				"description": "",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			},
			{
				"id": 2,
				"name": "provider",
				"display_name": "proveedor",
				"description": "",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			},
			{
				"id": 3,
				"name": "billtopay",
				"display_name": "cuentas por pagar",
				"description": "",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			},
			{
				"id": 4,
				"name": "visualizer",
				"display_name": "visualizador",
				"description": "",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			}
		],
		"companies": [
			{
				"id": 1,
				"social_reason": "SIN ASIGNAR",
				"rfc": "SIN ASIGNAR",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			},
			{
				"id": 2,
				"social_reason": "BH TRADE MARKET SA DE CV",
				"rfc": "0987654321",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			},
			{
				"id": 3,
				"social_reason": "PROMO LIFE S DE RL DE CV",
				"rfc": "1234123412",
				"created_at": "2023-02-22T17:25:23.000000Z",
				"updated_at": "2023-02-22T17:25:23.000000Z"
			},
		]
	}
]
```
</details>

<details>
	<summary>All users</summary>
Get all the users from the database
<br>

GET
```php
{url}/allUsers/{token}
```
BODY
```php
// no data
```
RESPONSE 
```json
[
    {
        "users": [
            {
                "id": 1,
                "fullname": "Nombre Administrador",
                "rfc": "123456789012",
                "email": "admin@test.com",
                "status_id": 1,
                "local_company_id": 1,
                "role_id": 1
            },
            {
                "id": 2,
                "fullname": "Nombre Administrador 2",
                "rfc": "35467869756",
                "email": "admin2@test.com",
                "status_id": 1,
                "local_company_id": 1,
                "role_id": 1
            },
            {
                "id": 3,
                "fullname": "Nombre Cuentas por pagar",
                "rfc": "1122334455",
                "email": "billtopay@test.com",
                "status_id": 1,
                "local_company_id": 1,
                "role_id": 3
            },
            {
                "id": 4,
                "fullname": "Nombre Visualizador",
                "rfc": "9988776655",
                "email": "visualizer@test.com",
                "status_id": 1,
                "local_company_id": 1,
                "role_id": 4
            }
        ],
        "providers": [
            {
                "id": 5,
                "fullname": "Alta Lynch II",
                "rfc": null,
                "email": "regan.stoltenberg@example.org",
                "status_id": 1,
                "provider_company": "Donnelly and Sons",
                "role_id": 2
            },
            {
                "id": 6,
                "fullname": "Ms. Marquise Mante III",
                "rfc": null,
                "email": "milo.frami@example.org",
                "status_id": 1,
                "provider_company": "Kiehn, Mayert and Sauer",
                "role_id": 2
            },
            
        ]
    }
]
```
</details>


<details>
	<summary>Create user</summary>
Create new user in database (No token required)

<br>

POST
```php
{url}/storeUser
```
BODY
```json
{
	"fullname": "User fullname",
    "rfc": "User rfc | no required",
    "email":"User email",
    "password": "User password (plaintext)",
    "role_id": 1" (Administrador = 1 | Proveedor = 2 | Cuentas por pagar = 3 | Visualizador = 4)",
    "company_id": 2 "(SIN ASIGNAR = 1 | BH TRADE MARKET SA DE CV = 2 | PROMO LIFE S DE RL DE CV = 3 | TEXTIL & PROMOTIONAL PRODUCTS S.A DE C.V = 4 ... 50) ",
	"token": "User token",
}
```
RESPONSE 
```json
[	
	{
		"message": "Usuario creado satisfactoriamente"
		
	}
]

```

ERROR RESPONSE 
```json
[	
	{
		"message": "Este correo ya está en uso"
		
	}
]

```

```json
[	
	{
		"message": "Token invalidoe"
		
	}
]

```

```json
[	
	{
		"message": "Acceso restringido"
		
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
	"token": "user token",
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
	"token" : "User token",
}
```
RESPONSE 
```json
[	
	{
		"message": "Usuario eliminado satisfactoriamente"
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
```json
[
	{
		"message": "Token invalido"
	}
]
```
```json
[
	{
		"message": "Acceso restringido"
	}
]
```

</details>

<details>
	<summary>Update order status</summary>
Change the order status from the orders

| ID      | Status |  
| ----------- | ----------- |
| 1 | En validacion   | 
| 2 | Validado     | 
| 3 | Por pagar | 
| 4 | Pagado  | 

<br>

POST
```php
{url}/updateOrderStatus
```
BODY
```json
{
	"token": "USER_TOKEN" ,
	"order_id" : 1,
	"status" : 1,
}
```
RESPONSE 
```json
[	
	{
		"message": "Orden actualizada correctamente"
	}
]
```

ERROR RESPONSE 
```json
[
	{
		"message": "Acceso restringido"
	}
]
```
```json
[
	{
		"message": "Token invalido"
	}
]
```

</details>



## Provider

<details>
	<summary>Provider orders</summary>
Get all the orders by provider that match with the logged user.

<br>

GET
```php
{url}/providerOrders/{token}
```
BODY
```php
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
        "status": 1,
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


<details>
	<summary>Upload files</summary>
Route used to upload xml and pdf files, you can upload one document or two.

<br>

POST
```php
{url}/updateFiles
```
BODY
```json
{
	"order_id": 1,
	"xml": "xml file",
	"pdf": "pdf file",
}
```
RESPONSE 
```json
[
	{
		"xml": "storage/xml/namefile.xml",
        "pdf": "storage/pdf/namefile.pdf",
	}
]
```

ERROR RESPONSE 
```json
[
	{
		"xml": "storage/xml/namefile.xml",
        "pdf": "storage/pdf/namefile.pdf",
	}
]
```
</details>


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
		"message": "Email enviado con exito",
	}
]
```

ERROR RESPONSE
```json
[
	{
		"message": "Usuario no encontrado",
	}
]
```
</details>



[`< volver`](../README.md)