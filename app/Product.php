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
    protected $table = 'products';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at',
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

    /**
     * Returns all meal course types (< PHP 5.6, non-support of array constants)
     *
     * @return array
     */
    public static function getMealCourseTypes()
    {
        return [
            self::STARTER, self::MAIN_COURSE, self::DESSERT,
        ];
    }

    /**
     * Returns all serving times (< PHP 5.6, non-support of array constants)
     *
     * @return array
     */
    public static function getServingTimes()
    {
        return [
            self::BREAKFAST, self::LUNCH, self::DINNER,
        ];
    }
}
