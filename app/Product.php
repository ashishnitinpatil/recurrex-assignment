<?php

namespace App;

use DateTime;
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
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

    // Serving times
    const OPENING_HOUR = 4;  // 24-hour format
    const CLOSING_HOUR = 21; // 24-hour format

    /**
     * Get the user that owns the product
     *
     * @return object \App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Checks whether given user is owner of this product
     *
     * @return boolean
     */
    public function isOwner($userID)
    {
        // Since user_id can be nullable, default should be -1 (!unsigned int)
        $userID = !is_null($userID) ? $userID : -1;
        return $this->user_id == $userID;
    }

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

    /**
     * Returns $servingUptoHour for given $servingTime
     *
     * @return integer $hour (24-hour format)
     */
    public static function getServingUptoHourByType($servingTime)
    {
        switch ($servingTime) {
            case self::BREAKFAST:
                return 7;
            case self::LUNCH:
                return 12;
            case self::DINNER:
                return 21;
            default:
                throw \Exception('Bad servingTime value given');
        }
    }

    /**
     * Returns current instance's $servingUptoHour
     *
     * @return integer $hour (24-hour format)
     */
    public function getServingUptoHour()
    {
        return self::getServingUptoHourByType($this->serving_time);
    }

    /**
     * Returns operational hours string (e.g. "from 4am to 9pm")
     *
     * @return string
     */
    public static function operationalHoursString()
    {
        $from = DateTime::createFromFormat('H', self::OPENING_HOUR);
        $to   = DateTime::createFromFormat('H', self::CLOSING_HOUR);

        return "from $from to $to";
    }

    /**
     * Returns whether ordering is operational according to current hour
     *
     * @return boolean
     */
    public static function isOperational()
    {
        $now  = new DateTime();
        $from = DateTime::createFromFormat('H', self::OPENING_HOUR);
        $to   = DateTime::createFromFormat('H', self::CLOSING_HOUR);

        return $from <= $now && $now <= $to;
    }

    /**
     * Checks whether product can be ordered now according to it's serving time
     *
     * @return boolean
     */
    public function canBeOrderedNow()
    {
        $now  = new DateTime();
        $upto = DateTime::createFromFormat('H', $this->getServingUptoHour());

        return $now < $upto;
    }

    /**
     * Checks whether product can be ordered now according to it's serving time
     *
     * @return boolean
     */
    public function isInStock($toOrder=0)
    {
        return $this->stock > max(0, $toOrder);
    }
}
