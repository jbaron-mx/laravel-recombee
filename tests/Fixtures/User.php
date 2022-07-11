<?php

namespace Baron\Recombee\Tests\Fixtures;

use Baron\Recombee\Recommendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;

class User extends BaseUser
{
    use Recommendable;
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function toRecommendableProperties()
    {
        return ['active' => 'boolean'];
    }
}
