<?php
use boxsupport\Exceptions\ValidationException;
use boxsupport\Services\Validation\AccountValidator;
use boxsupport\Helpers\AuthenticationHelper;

/**
 * This is a class that defines an account controller which is responsible for pulling up the accounts from the database and passing a list of all of them to the relevant view or allows a single account to be pulled by its ID
 */
class AccountController extends \BaseController
{

    /**
     * Define the main layout used to display that controller's view
     *
     * @var string
     */
    protected $layout = 'layouts.default';

    /**
     *
     * @var boxsupport\Services\Validation\AccountValidator
     */
    protected $validator;

    /**
     *
     * @var boxsupport\Helpers\AuthenticationHelper
     */
    protected $authenticationHelper;

    /**
     * Construct the class
     * Inject the accountValidator class in order to verify the account ID on the main page (please note that I have copied the validation service from another project I'm currently working on and it has not been written from scratch for this app specifically).
     * Only the specific AccountValidator class was created for the app.
     * Also, inject the AuthenticationHelper in order to abstract out Laravel's specific Session class in order to be able to easily change the behaviour later
     *
     * @param AccountValidator $validator            
     * @param AuthenticationHelper $authenticationHelper            
     */
    public function __construct(AccountValidator $validator, AuthenticationHelper $authenticationHelper)
    {
        $this->validator = $validator;
        $this->authenticationHelper = $authenticationHelper;
    }

    /**
     * Display all accounts.
     *
     * @return Response
     */
    public function index()
    {
        // Get all accounts from the database
        $accounts = Account::with('boxes')->paginate('10');
        // Prepare and display the list view by passing the $accounts data to the view
        $this->layout->content = View::make('pages.account.list')->with('accounts', $accounts);
    }

    /**
     * Verify the account ID and redirect to its boxes page
     *
     * @return Response
     */
    public function verifyAccount()
    {
        // Fetch account_id passed from the account retrieval form
        $accountID = Input::get('accountID');
        // Try to redirect to the show resource of the box controller with that ID
        try {
            // Validate the ID
            $validateID = $this->validator->validate(array(
                'accountID' => $accountID
            ));
            // Put the account ID into a session variable, so that certain controllers could be restricted to be shown only if the user is logged in, so to speak
            $this->authenticationHelper->setAccountID($accountID);
                        // Redirect to the relevant resource
            return Redirect::action('BoxController@showBoxes', array(
                'accountID' => $accountID
            ))->withMessage('Thank you, you will now be able to see the boxes on order for account ID ' . $accountID);
        } catch (ValidationException $e) {
            // Display the validation errors to the user and let them try again
            return Redirect::action('IndexController@index')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Log out an account
     *
     * @return Response
     */
    public function logout()
    {
        // Log the account out by destroying its session
        $this->authenticationHelper->forgetAccountID();
        // Redirect back to the homepage with a message saying that the account was logged out
        return Redirect::action('IndexController@index')->withMessage('You have been successfully logged out. Thank you.');
    }
    
}
