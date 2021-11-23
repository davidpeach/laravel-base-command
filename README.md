# Laravel Base Command

A little package to help create an automated flow in a Laravel project.

Let's say you or your company build Laravel sites / apps regularly. And let's say that there are a bunch of steps 
you go through each and every time you start a new project.

Wouldn't it be nice if you could automate that whole process?

Well that is exactly what Laravel Base Command tries to help you with.

By extending this package with your own, and with minimal setup, you can get a working setup flow.

## Quick Start

### Installation

```bash
composer require davidpeach/laravel-base-command
```

### Usage

#### Required files in your child package

As Laravel Base Command attempts to do most of the heavy lifting for you, you only really need to create your `Step` 
classes -- one for each step that you wish to perform.

 - A `ServiceProvider` class that extends `BaseCommandServiceProvider`
 - A set of `Step` classes in your package's `/src/Steps` folder. A step class must extend either `StepAlways`, 
   `StepBinary` or `StepChoice`.

#### Process

1. Extend the base command service provider with your own.
2. Add your command class that extends BaseCommand and add it to your service provider.
3. Create your command classes.
4. Add a list of your command classes in your command class that extends BaseCommand.
5. Run your setup command.

When extending `laravel-base-command`, you define a command to run in order to run through your setup process. "Your 
setup command" is just the command that you run. e.g. `php artisan mycompany:setup`.

Essentially, your own package's Service Provider should extend the one in this project. Then you just create as many Task classes as is needed for your own setup steps.

Your own steps should extend either `StepAlways`, `StepBinary` or `StepChoices`.

A full explanation and documentation is coming soon.

Thanks for your patience,
Dave.
