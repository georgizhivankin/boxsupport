<?php
namespace boxsupport\Helpers;

/**
 * This class instantiates a helper that is being used to get and set the account ID to and from a session
 * The idea is to abstract out Laravel's session functionality into a separate class because if the account neesd to be saved not in a session, but rather in a cookie later, I would want to be able to change that easily without tracing and rewriting each instance of the session code that was being used
 */
class AuthenticationHelper extends BaseHelper
{

    /**
     * Check if account ID is set in the current session
     *
     * @param int $id            
     * @return boolean
     */
    public static function checkAuth($id)
    {
        if (\Session::has($id)) {
            // Return the ID
            return \Session::get($id);
        } else {
            // Account ID not found, return false
            return false;
        }
    }

    /**
     * Set an account ID into the session
     *
     * @param int $id            
     * @return boolean
     */
    public static function setAccountID($id)
    {
        // First check if an ID is set
        if (! \Session::has('accountID')) {
            // Set the id
            \Session::put('accountID', $id);
        } else {
            // Account ID already set, destroy it and set the new one in its place
            \Session::forget('accountID');
            \Session::put('accountID');
        }
    }

    /**
     * Get an account ID from the session if one is set
     *
     * @return boolean
     */
    public static function getAccountID()
    {
        // First check if an ID is set
        if (\Session::has('accountID')) {
            // Return the ID
            return \Session::get('accountID');
        } else {
            // Account ID not found, return false
            return false;
        }
    }

    /**
     * Whipe out the accountID from the session
     *
     * @return boolean
     */
    public static function forgetAccountID()
    {
        // Destroy the session variable containing the account ID
        \Session::forget('accountID');
        // Return true
        return true;
    }
    
}
