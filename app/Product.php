<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    const DEFAULT_IMAGE = 'http://hakkaking.com/img/default_food.png';

    // Meal course types
    const STARTER     = 'starter';
    const MAIN_COURSE = 'main_course';
    const DESSERT     = 'dessert';

    // Serving times
    const BREAKFAST = 'breakfast';
    const LUNCH     = 'lunch';
    const DINNER    = 'dinner';
}
