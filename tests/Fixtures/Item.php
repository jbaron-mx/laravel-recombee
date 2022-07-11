<?php

namespace Baron\Recombee\Tests\Fixtures;

use Baron\Recombee\Recommendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Recommendable;
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function toRecommendableProperties()
    {
        return [
            'price' => 'double',
            'active' => 'boolean',
        ];
    }
}
