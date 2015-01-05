<?php

/**
 * Product model class
 * 
 * Defines the relationships of the product MySQL table
 */
class Product extends Eloquent
{

    /**
     * The database table used by the product model.
     * By default, it uses the model name as the table name, but I love to explicitly set it, just in case
     *
     * @var string
     */
    protected $table = 'product';

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
    
    // One product may belong to many boxes, so we have a many-to-many relationship to the box model through an intermediate table
    public function boxes()
    {
        return $this->belongsToMany('box', 'box_to_product', 'product_id', 'box_id');
    }

    /**
     * Static method that updates a product's rating if the user changes the corresponding combo-box on the boxes page
     *
     * @param int $productID            
     * @param int $accountID            
     * @param int $rating            
     * @return boolean
     */
    public static function setProductRatingPerBoxPerAccount($productID, $accountID, $rating)
    {
        // Check if variables are set
        if ((! isset($productID)) && (! isset($accountID)) && (! isset($rating))) {
            // Cannot update the rating, so return false
            return false;
        } else {
            // Sanitize variables first through the sprinf function, making them to accept only numbers in order to prevent simple SQL attacks as the prepare statement that Laravel's eloquent engine uses to implement this functionality, does not want to work with PDO prepared statements for some reason
            $accountID = sprintf("%d", $accountID);
            $productID = sprintf("%d", $productID);
            $rating = sprintf("%d", $rating);
            // Try to update the rating
            DB::statement(DB::raw("INSERT INTO rating (product_id, account_id, rating) VALUES($productID, $accountID, $rating) ON DUPLICATE KEY UPDATE product_id=$productID, account_id=$accountID, rating=$rating"));
            // Original Statement that should have workd, but it didn't DB::statement(DB::raw("INSERT INTO rating (product_id, account_id, rating) VALUES('?', '?', '?') ON DUPLICATE KEY UPDATE product_id='?', account_id='?', rating='?'"), array('accountID' => $accountID, 'productID' => $productID, 'rating' => $rating, 'accountID1' => $accountID, 'productID1' => $productID, 'rating1' => $rating));
        }
        // Return true
        // return true;
    }
    
}
