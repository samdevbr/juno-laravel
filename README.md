![build status](https://github.com/samdevbr/juno-php-sdk/actions/workflows/main.yml/badge.svg)
![mit](https://camo.githubusercontent.com/6cb41a4ecf844e610d9b2e0f709dcd3456a5b41aba8989129df66708a86e8329/68747470733a2f2f696d672e736869656c64732e696f2f7061636b61676973742f6c2f6c61726176656c2f6672616d65776f726b)

## Juno Laravel
> [Juno](https://juno.com.br/) is a fintech designed to be easy to use, easy to integrate, and provide the best digital bank account experience that any company would like to have.

This package will allow you to integrate with Juno's RestAPI

## Versioning
| `juno-laravel` version | Juno's RestAPI version | Laravel version |
|------------------------|------------------------|-----------------|
| 1.x.x                  | 2                      | 8.x.x          |

## Requirements

- Laravel 8+
- PHP 7.x / 8.x
- Composer

## Installation

Using composer:
```sh
composer require samdevbr/juno-laravel
```

## Configuration

The command below will publish the configuration file to Laravel's config folder.
```sh
php artisan juno:install
```
