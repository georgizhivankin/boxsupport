<?php

/**
 * Account model class
 * 
 * Defines the relationships of the account MySQL table
 */
class Account extends Eloquent
{

    /**
     * The database table used by the account model.
     * By default, it uses the model name as the table name, but I love to explicitly set it, just in case
     *
     * @var string
     */
    protected $table = 'account';

    /**
     * Set a special variable to false that Laravel uses for ignoring timestamp columns in a table as none were defined in our custom .
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
    
    // One account can order multiple boxes, so the relationship to the boxes model is a many-to-many relationship
    public function boxes()
    {
        return $this->hasMany('box', 'account_id', 'id');
    }
    
}
