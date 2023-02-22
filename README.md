
# **QRM Backend**


## **Requeriments** 

 ### *Hardware*

| Characteristic      | Requirement |
| ----------- | ----------- |
| Processor    | 2 Cores   |
| RAM           | 8-16 GB     |
| Storage| 12GB        |

### *Software*

| Characteristic      | Version |  Link |
| ----------- | ----------- | -----------
| XAMPP    |  >  8.0  | https://www.apachefriends.org/es/index.html |
| VS Code           | > 1.75.1   | https://code.visualstudio.com/ |
| Postman | > 10.10.6 |  https://www.postman.com/downloads/


### *Recommended Extensions (VS Code)*
| Extension      | Version |
| ----------- | ----------- |
| Laravel Snippets    | 1.15.0   |
| Material Icon Theme           | 4.24.0  |
| PHP Intelephense|  1.9.5   |  
| Dracula Oficial | 2.24.2        

---
## **Installation**

*Clone repository*
``` 
https://github.com/Oscar-CR/QRM-backend-laravel.git
```

*Install dependencies*
``` 
composer i
```

``` 
npm  i
```

*Configure environment*
``` 
cp .env.example .env
```
``` 
php artisan key:generate
```
```
php artisan storage:link
```
*Load initial data to database*
``` 
php artisan migrate:fresh --seed
```

*Run proyect*
``` 
npm run dev
```

``` 
php artisan serve
```
---

## **Documentation**

[`> general`](./documentation/general.md)

[`> apis`](./documentation/apis.md)