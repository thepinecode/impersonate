<?php

namespace Pine\Impersonate\Events;

use Illuminate\Queue\SerializesModels;

class ChangedToUser
{
    use  SerializesModels;

    /**
     * The user instance.
     *
     * @var mixed
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}

