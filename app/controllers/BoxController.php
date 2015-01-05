<?php
use boxsupport\Helpers\AuthenticationHelper;

/**
 * This is a class that defines a box controller which is responsible for pulling up the boxes associated to a given account from the database and passing a list of all of them to the relevant view or allows a single box to be pulled by its ID and all of the products in that box shown to the user
 */
class BoxController extends \BaseController
{

    /**
     * Define the main layout used to display that controller's view
     *
     * @var string
     */
    protected $layout = 'layouts.default';

    /**
     *
     * @var boxsupport\Helpers\AuthenticationHelper
     */
    protected $authenticationHelper;

    /**
     * Construct the class by injecting the authentication helper into its constructor
     *
     * @param AuthenticationHelper $authenticationHelper            
     */
    public function __construct(AuthenticationHelper $authenticationHelper)
    {
        $this->authenticationHelper = $authenticationHelper;
    }

    /**
     * Display the specified account and its boxes.
     *
     * @param int $accountID            
     * @return Response
     */
    public function showBoxes($accountID)
    {
        // Fetch all boxes for a given account from the DB
        try {
            $accountBoxes = account::findOrFail($accountID)->boxes()->paginate(10);
            // Sort the boxes by their delivery date using a closure
            $accountBoxes->sortByDesc(function ($model)
            {
                return $model->delivery_date;
            });
            // Pass the fetched object from the DB to the view and display the result
            $this->layout->content = View::make('pages.box.list')->with(array(
                'accountBoxes' => $accountBoxes,
                'accountID' => $accountID
            ));
        } catch (Exception $e) {
            // The account is not valid or there is another problem in retrieving the results, so return back to the same page, and display an error to notify the user of the problem
            // Destroy the accountID session variable
            $this->authenticationHelper->forgetAccountID();
            return Redirect::action('IndexController@index')->withErrors('Wrong account ID, please try again.');
        }
    }

    /**
     * Show an individual box and all of its products along with their ratings
     *
     * @param int $accountID            
     * @param int $boxID            
     * @return Response
     */
    public function show($accountID, $boxID)
    {
        // Get the products in the given box along with their ratings
        // Note that for this relationship, I would use raw SQL as the Eloquent ORM does not support such complicated relations and I've struggled to find a way to do it with it for almost a day
        $boxProducts = Box::getProductsPerBoxPerAccount($boxID, $accountID);
        // Fetch all possible rating values
        $ratingValues = Box::ratingValues();
        // Prepare and display the list view by passing the $boxProducts and $ratingValues data to the view
        $this->layout->content = View::make('pages.product.list')->with(array(
            'accountID' => $accountID,
            'boxProducts' => $boxProducts,
            'boxID' => $boxID,
            'ratingValues' => $ratingValues
        ));
    }

    /**
     * Update the specified box by updating the ratings of all of its products.
     * Note that I am aware that this method should have been included in a dedicated products controller in order to follow the MVC architecture properly, but for the sake of simplisity and maintainability, and as the requirements do not stipulate any additional actions for the box's products, I have decided to leave it as the update method of the box controller
     *
     * @param int $accountID            
     * @param int $boxID            
     * @return Response
     */
    public function update($accountID, $boxID)
    {
        // Get the input data for the products' rating
        $productRatings = Input::get('selectRating');
        // Go through all ratings and update them accordingly
        foreach ($productRatings as $productID => $rating) {
            Product::setProductRatingPerBoxPerAccount($productID, $accountID, $rating);
        }
        // Redirect the page after the update back to the same page with the boxes' products to see the update
        return Redirect::action('BoxController@show', array(
            $accountID,
            $boxID
        ));
    }
    
}
