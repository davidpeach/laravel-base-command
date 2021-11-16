# Laravel Base Command

A little package to help create an automated setup flow in a fresh Laravel project.

This package is meant to be extended and not used on its own.

## Installation

```bash
composer require davidpeach/laravel-base-command
```

## Usage

### Commands

```bash
php artisan basecommand:always
```

```bash
php artisan basecommand:binary
```

```bash
php artisan basecommand:choice
```


Essentially, your own package's Service Provider should extend the one in this project. Then you just create as many Task classes as is needed for your own setup steps.

Your own steps should extend either `StepAlways`, `StepBinary` or `StepChoices`.

A full explanation and documentation is coming soon.

Thanks for your patience,
Dave.
