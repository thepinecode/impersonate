# Impersonate

A lightweight, yet useful package for user impersonation.

Impersonation can be a nice way to track down issues / bugs beyond our tests.
With this package, it's easy to implement it, without touching the core of our app.

Configure the package as you need and it's ready to go!

### Requirements

### Getting Started

### Configuration

### Middlewares

By default the impersonating routes have with two middlewares, the ``web`` and the ``auth``.
But of course, it's definetly not enough.
In the config file, at the middlewares section, you can add more middlewares,
what you registered in your ``Kernel.php`` before, or you can add fully qualified classnames as well.

### Routes

The package brings two routes. One for imopersonating a user and one for revert to the original one.

The impersonate route's properties are the following:
- Path: ``/impersonate/{user}``
- Name: ``impersonate.impersonate``
- Controller@action: ``Pine\Impersonate\Http\Controllers\ImpersonateController@impersonate``

The revert route's properties are the following:
- Path: ``/impersonate/revert``
- Name: ``impersonate.revert``
- Controller@action: ``Pine\Impersonate\Http\Controllers\ImpersonateController@revert``

### Redirection

After impersonating a user, or reverting we return with a redirection response.
By default both action redirects to the ``/home`` path.
You can configure both routes individually in the config file, at the redirect section.

### Events

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

### Blade Directive

The package brings a blade directive to check easily if the user is in an impersonation mode or not.
It's like a basic if statement.

```
@impersonate
    // You are impersonating
@else
    // You are in your own profile
@endimpersonate
```

### Working with JS or SPAs
