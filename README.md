# Impersonate

A lightweight, yet useful package for user impersonation.

Impersonation can be a nice way to track down issues / bugs beyond our tests.
With this package, it's easy to implement it, without touching the core of our app.

Configure the package as you need and it's ready to go!

## Getting Started

You can install the package with composer, using the ``composer require thepinecode/impersonate`` command.

### Laravel 5.5

If you are using version 5.5, there is nothing else to do.
Since the package supports autodiscovery, Laravel will register the service provider automatically, behind the scenes.

### Laravel 5.4 and below

You have to register the service provider manually.
Go to the ``config/app.php`` file and add the ``Pine\Impersonate\ImpersonateServiceProvider::class`` to the providers array.

### Disable the autodiscovery for the package

In some cases you may disable autodiscovery for this package.
You can add the provider class to the ``dont-discover`` array to disable it.

Then you need to register it manually again.

## Configuration

You may override the default configurations. To do that, first you have to publish the config file with the following command:
``php artisan vendor:publish --provider=Pine\Impersonate\ImpersonateServiceProvider``.
Then you can find the config file, at ``config/impersonate.php``.

## Middlewares

By default the impersonating routes have with two middlewares, the ``web`` and the ``auth``.
But of course, it's definetly not enough.
In the config file, at the middlewares section, you can add more middlewares,
what you registered in your ``Kernel.php`` before, or you can add fully qualified classnames as well.

## Routes

The package brings two routes. One for imopersonating a user and one for revert to the original one.

The impersonate route's properties are the following:
- Path: ``/impersonate/{user}``
- Name: ``impersonate.impersonate``
- Controller@action: ``Pine\Impersonate\Http\Controllers\ImpersonateController@impersonate``

The revert route's properties are the following:
- Path: ``/impersonate/revert``
- Name: ``impersonate.revert``
- Controller@action: ``Pine\Impersonate\Http\Controllers\ImpersonateController@revert``

As you see, when we navigate a user to these routes, the action has to hit the server.
That means, if you use something like Vue Router, please take care to use a normal link for these instead of the router's.

```html
<!-- Bad, it will hit the router -->
<router-link to="/impersonate/revert">Revert</router-link>

<!-- Good, it will hit the server -->
<a href="/impersonate/revert">Revert</a>
```

## Redirection

After impersonating a user, or reverting we return with a redirection response.
By default both action redirects to the ``/home`` path.
You can configure both routes individually in the config file, at the redirect section.

## Events

Both actions trigger an event when we hit them.
You can setup your own listeners for these events, in the ``EventServiceProvider``. For example:

```php
protected $listen = [
    \Pine\Impersonate\Events\ChangedToUser::class => [
        // Listeners
    ],
    \Pine\Impersonate\Events\Reverted::class => [
        // Listeners
    ],
];
```

Also, you can access the impersonated user via the ``ChangedToUser`` event.
Here is an example listener for that:

```php
public function handle(ChangedToUser $event)
{
    // $event->user
}
```

## Blade Directive

The package brings a blade directive to check easily if the user is in an impersonation mode or not.
It's like a basic if statement.

```
@impersonate
    // You are impersonating
@else
    // You are in your own profile
@endimpersonate
```

## Working with JS

Since the whole process is session based, we have the information about the current state only on the server-side.
That means, if we want to integrate the package with an SPA, we need to extract the info and make it accessible in the front-end.

At the first load, we have the chance to fetch the current status to the ``window`` object. For example:

```html
<script>
    @impersonate
        window.isImpersonating = true;
    @else
        window.isImpersonating = false;
    @endimpersonate
</script>
```

## Contribute

If you found a bug or you have an idea connecting the package, feel free to open an issue.
