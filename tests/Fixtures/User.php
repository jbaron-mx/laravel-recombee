<?php

namespace Baron\Recombee\Tests\Fixtures;

use Baron\Recombee\Recommendable;
use Illuminate\Foundation\Auth\User as BaseUser;

class User extends BaseUser
{
    use Recommendable;

    protected $guarded = [];
}
