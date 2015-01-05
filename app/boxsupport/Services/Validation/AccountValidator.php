<?php
namespace boxsupport\Services\Validation;

class AccountValidator extends Validator
{

    /**
     *
     * @var array Validation rules for our account check
     */
    public $rules = array(
        'accountID' => array(
            'required',
            'numeric',
            'min:1',
        )
    );
}
