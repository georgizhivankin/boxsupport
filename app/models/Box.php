<?php

/**
 * Box model class
 * Defines the relationships of the box MySQL table
 * 
 */
class Box extends Eloquent
{

    /**
     * The database table used by the box model.
     * By default, it uses the model name as the table name, but I love to explicitly set it, just in case
     *
     * @var string
     */
    protected $table = 'box';

    /**
     * Set a special variable to false that Laravel uses for ignoring timestamp columns in a table as none were defined in our custom .
     *
     *
     *
     *
     *
     *
     *
     *
     * sql schema
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * Create an accessor that formats the boxes' delivery date in order to return a proper readable date to the view
     *
     * @param datetime $deliveryDate            
     * @return string
     */
    public function getDeliveryDateAttribute($deliveryDate)
    {
        // Laravel does not have a date method that could format it properly, so I will use PHP's DateTime class to parce and reformat the date, I have included the old strtotime function in case the app is being ran on PHP 5.1 or less, so just uncomment it if you need to use it instead
        $formattedDeliveryDate = (new DateTime($deliveryDate))->format('l, d F Y');
        // Return the date in a readable format
        return $this->attributes['delivery_date'] = $formattedDeliveryDate;
        /*
         * Uncomment to use strtotime instead of PHP 5.2X DateTime class and comment the two lines above
         * return $this->attributes['delivery_date'] = date('l, d F Y', strtotime($deliveryDate));
         */
    }

    /**
     * Define the relationships to the other models
     */
    
    // One box can be associated to only one account, so there is a one-to-one relationship to the account model
    public function account()
    {
        return $this->belongsTo('account', 'account_id', 'id');
    }
    
    // One box may contain multiple products, and each product could be associated to more than one box, so here we use an intermediate table box_to_product to build the relationship, therefore, the box has a many-to-many relationship to the box_to_product model
    public function products()
    {
        return $this->belongsToMany('product', 'box_to_product', 'box_id', 'product_id');
    }

    /**
     * Static method that Gets the possible ratings for all products in the database
     * Decided to use it to populate the combo box in the boxes products' view (it's possible to hard code it, but in a production environment it is better to fetch it from the database as it may change)
     *
     * @return array
     */
    public static function ratingValues()
    {
        // Initialize an array to store the results
        $ratingValues = array();
        // Fetch the results
        $results = DB::select(DB::raw("select distinct(rating) from rating ORDER BY rating ASC"));
        // Go through the rating results and add them to an array
        foreach ($results as $result) {
            // Add the rating to the array
            $ratingValues[$result->rating] = $result->rating;
        }
        // Return the array with rating values
        return $ratingValues;
    }

    /**
     * Static method that gets all products with their ratings per box per account
     *
     * @param int $boxID            
     * @param int $accountID            
     * @return boolean|array
     */
    public static function getProductsPerBoxPerAccount($boxID, $accountID)
    {
        // Check if variables are set
        if ((! isset($boxID)) && (! isset($accountID))) {
            // Cannot get any results, so return false
            return false;
        } else {
            $results = DB::select(DB::raw("SELECT product.*, box_to_product.box_id AS pivot_box_id, box_to_product.product_id AS pivot_product_id, (SELECT rating.rating from rating, account WHERE rating.product_id=product.id and account.id=rating.account_id and account.id = :accountID) AS rating from product INNER JOIN box_to_product ON product.id = box_to_product.product_id WHERE box_to_product.box_id = :boxID"), array(
                'accountID' => $accountID,
                'boxID' => $boxID
            ));
        }
        // Return the results
        return $results;
    }
    
}
