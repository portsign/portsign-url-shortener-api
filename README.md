<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Portsign Short URL API

requirement :
php-bcmath


```
Register URL:
http://localhost:8000/api/register -> POST
Format:
[
    {
      "name": "Ghani Nafiansyah",
      "email": "portsign@gmail.com",
      "password": "yourPassword",
      "c_password": "yourConfirmationPassword"
    }
]

Login URL:
http://localhost:8000/api/login -> POST
[
    {
      "email": "portsign@gmail.com",
      "password": "yourPassword",
    }
]

List Short-URL URL:
http://localhost:8000/api/list -> GET

Generate Short-URL URL:
http://localhost:8000/api/shortener
[
    {
      "long_url": "https://www.instagram.com/portsign/"
    }
]

GET Detail Short-URL URL:
http://localhost:8000/api/get-data -> POST
[
    {
      "short_url": "https://s.id/SnvvP"
    }
]

Custom URL:
http://localhost:8000/api/custom-url -> POST
[
    {
      "short_url": "https://s.id/SnvvP",
      "custom_url": "grmskes",
    }
]

Delete Data URL:
http://localhost:8000/api/destroy -> POST
[
    {
      "id": 23,
    }
]
```