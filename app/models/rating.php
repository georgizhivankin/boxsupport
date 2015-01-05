<?php

/**
 * Rating model class
 * 
 * Defines the relationships of the rating MySQL table
 */
class Rating extends Eloquent
{

    /**
     * The database table used by the account model.
     * By default, it uses the model name as the table name, but I love to explicitly set it, just in case
     *
     * @var string
     */
    protected $table = 'rating';

    /**
     * Set a special variable to false that Laravel uses for ignoring timestamp columns in a table as none were defined in our custom .
     *
     *
     *
     * sql schema
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * Define the relationships to the other models
     */
    
    // A rating belongs to just one product
    public function product()
    {
        return $this->belongsTo('product', 'id', 'product_id');
    }
    
    // A rating belongs to just one account
    public function account()
    {
        return $this->belongsTo('account', 'id', 'account_id');
    }
    
}
