<?php
/**
 * This file contains the class definition for a UserDAO object.
 */

class UsersDAO extends BaseDAO {
    
    private $userDatabaseTableName = 'users';
    
    /**
     * Constructor.
     * 
     * Instantiates a UsersDAO object.
     * This constructor overrides the one for the parent BaseDAO class.
     * 
     * @param mixed $fetchConditions
     * This is an optional argument to allow data to be fetched selectively
     * at construction, where 
     * (a) If it is a number, this constructor will
     * look for it under the 'id' column in the database table for suggestions.
     * (b) If it is an array, this constructor will treat it as an array of
     * conditions for the SQL statement, SELECT. Ie. given an array where
     * array[$key] = $value, the database will be queried with
     * "SELECT * from $suggestionTable WHERE $key = $value".
     * 
     * @throws Exception
     * if $fetchConditions is not of a type this constructor can
     * handle. Inherited from parent BaseDAO class.
     */
    public function __construct($fetchConditions = NULL) {
        parent::__construct($this->userDatabaseTableName, $fetchConditions);
    }
    
    /**
     * Method: getAllUsers
     * 
     * @return array An array of all User objects from the database.
     */
    public function getAllUsers() {
        
        $userList = array();
        
        foreach ($this->fetchedData as $index => $innerArray) {

            // fetchedData exists in parent BaseDAO class as a 2-dimensional array.

            foreach ($innerArray as $key => $value) {
                
                // Gather details of the suggestion currently being iterated through.
                $userEmail;
                $userPassword;
                // TODO all user variables go above.
                
                switch($key) {
                    case "email":
                        $userEmail = $value;
                        break;
                    
                    case "password":
                        $userPassword = $value;
                        break;
                }
                
                // -------- debug -----------
                if (is_null($userEmail)) {
                    echo "Warning: userEmail detected as NULL at fetchedData[{$index}].";
                }
                // -----  end debug ----------
                
                // Construct the corresponding User object and populate
                // with the values gathered.
                $user = new User(
                            $userEmail,
                            $userPassword);

                // Store the freshly created User object in the array that this method will return.
                $userList[$userEmail] = $user;
            }
        }
        
        return $userList;
    }
}
?>
