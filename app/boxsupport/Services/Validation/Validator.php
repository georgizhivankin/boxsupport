<?php
namespace boxsupport\Services\Validation;

use Illuminate\Validation\Factory as IlluminateValidator;
use boxsupport\Exceptions\ValidationException;

/**
 * Base Validation class.
 * All entity specific validation classes inherit
 * this class and can override any function if they need to
 */
abstract class Validator
{

    /**
     *
     * @var Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Construct validator
     *
     * @param IlluminateValidator $validator            
     */
    public function __construct(IlluminateValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate function
     *
     * @param array $data            
     * @param array $rules            
     * @param array $custom_errors            
     * @throws ValidationException
     * @return boolean
     */
    public function validate(array $data, array $rules = array(), array $custom_errors = array())
    {
        if (empty($rules) && ! empty($this->rules) && is_array($this->rules)) {
            // no rules passed to function, use the default rules defined in sub-class
            $rules = $this->rules;
        }
        
        // use Laravel's Validator and validate the data
        $validation = $this->validator->make($data, $rules, $custom_errors);
        
        if ($validation->fails()) {
            // validation failed, throw an exception
            throw new ValidationException($validation->messages());
        }
        // Validation passed successfully
        return true;
    }
    
}
