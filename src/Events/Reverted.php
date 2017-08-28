<?php

namespace Pine\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Reverted
{
    use Dispatchable, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct($user)
    {
        //
    }
}

