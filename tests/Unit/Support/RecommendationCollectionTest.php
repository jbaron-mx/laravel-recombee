<?php

use Baron\Recombee\Collection\RecommendationCollection;

it('can transform to array', function () {
    $results = new RecommendationCollection(['111', '222']);

    expect($results->toArray(request()))->toEqual(['111', '222']);
});
