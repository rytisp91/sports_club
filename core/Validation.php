<?php

namespace app\core;
class Validation
{
    private $password;
    /**
     * Checks if values of array is empty
     * 
     * @param $arr
     * @return bool
     */
    public function ifEmptyArr($arr)
    {
        // check if all values of array is empty
        foreach ($arr as $errorValue) {
            if (!empty($errorValue)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if field is empty
     * 
     * @param $field
     * @param $msg
     * @return mixed|string
     */
    public function validateEmpty($field, $msg)
    {
        return empty($field) ? $msg : '';
    }


    /**
     * Checks if name fiels is empty and returns message if so
     * 
     * @param $field
     * @return string
     */
    public function validateName($field)
    {
        // Validate Name
        if (empty($field)) return "Please enter your name.";

        if (!preg_match("/^[a-z ,.'-]+$/i", $field)) return "Name must only contain letters.";

        return ''; //falsy
    }


    /**
     * Checks if surname fiels is empty and returns message if so
     * 
     * @param $field
     * @return string
     */
    public function validateSurname($field)
    {
        // Validate Name
        if (empty($field)) return "Please enter your surname.";

        if (!preg_match("/^[a-z ,.'-]+$/i", $field)) return "Name must only contain letters.";

        return ''; //falsy
    }

    /**
     * Checks if email field is empty. If so returns error. 
     * Validates email if errors gives feedback.
     * 
     * @param $field
     * @param null $userModel
     * @return string
     */
    public function validateEmail($field, &$userModel = null)
    {
        // validate empty
        if (empty($field)) return "Please enter your email";

        // check email format
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Please check your email";

        if ($userModel !== null) :
            // if email already exists
            if ($userModel->findUserByEmail($field)) return 'Email already taken';
        endif;

        return '';
    }

    /**
     * Checks if email field is empty on login if so gives error.
     * Validates email and runs searching of email on db.
     * 
     * @param $field
     * @param $userModel
     * @return string
     */
    public function validateLoginEmail($field, &$userModel)
    {
        // validate empty
        if (empty($field)) return "Please enter Your Email";

        // check email format
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Please check your email";

        // if email already exists
        if (!$userModel->findUserByEmail($field)) return 'Email not found';

        return '';
    }

    /**
     * Password validation method.
     * 
     * @param $passField
     * @param $min
     * @param $max
     * @return string
     */
    public function validatePassword($passField, $min, $max)
    {
        // validate empty
        if (empty($passField)) return "Please enter a password";

        // save password for later
        $this->password = $passField;

        // if pass length is les then min
        if (strlen($passField) < $min) return "Password must be more than $min characters length";

        // if pass length is more then max
        if (strlen($passField) > $max) return "Password must be less than $max characters length";

        // check password strength
        if (!preg_match("#[0-9]+#", $passField)) return "Password must contain at least one number";

        if (!preg_match("#[a-z]+#", $passField)) return "Password must include at least one letter!";

        if (!preg_match("#[A-Z]+#", $passField)) return "Password must include at least one Capital letter!";

        // if (!preg_match("#\W+#", $passField)) return "Password must include at least one symbol!";

        return '';
    }

    /**
     * Method checks password confirmation when registering.
     * 
     * @param $repeatField
     * @return string
     */
    public function confirmPassword($repeatField)
    {
        // validate empty
        if (empty($repeatField)) return "Please repeat a password";

        if (!$this->password) return 'no password saved';

        if ($repeatField !== $this->password) return "Password must match";

        return '';
    }
}
