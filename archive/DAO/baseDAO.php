<?php

/**
 * DAO progress has been suspended indefinitely, as of 7.50 pm, 24 Feb 2013, Sunday.
 * 
 * This file contains the BaseDAO class definition. This object 
 * serves as the abstract base class from which all DAO classes shall inherit.
 * It contains methods useful for all DAOs.
 */

abstract class BaseDAO {
    
    private $databaseTableName;
    protected $fetchedData = array();
    
    /**
     * Constructor.
     * Provides a convenient way to make a BaseDAO object, optionally initialised
     * with values fetched from the database.
     * 
     * @param string $databaseTableName
     * The name of the database table this BaseDAO object will be associated with.
     * 
     * @param mixed $fetchConditions
     * This is an optional argument to allow data to be fetched selectively
     * at construction, where 
     * (a) If it is a number, this constructor will
     * look for it under the 'id' column in the database.
     * (b) If it is an array, this constructor will treat it as an array of
     * conditions for the SQL statement, SELECT. Ie. given an array where
     * array[$key] = $value, the database will be queried with
     * "SELECT * from $table WHERE $key = $value".
     * 
     * @throws Exception
     * if $databaseTableName is not a string, or
     * if $fetchConditions is not of a type this constructor can
     * handle.
     */
    public function __construct($databaseTableName, $fetchConditions = NULL) {
        
        if (is_null($databaseTableName) || !is_string($databaseTableName)) {
            throw new Exception(
                    'Please specify the name of a database table.' . 
                    'You gave: ' . $databaseTableName);
        }
        
        // asssuming program flow doesn't continue to here if the exception above
        // has been triggered.
        $this->databaseTableName = $databaseTableName;
        
        if (!is_null($fetchConditions)) {
            
            $buffer = array();
            
            if (is_numeric($fetchConditions)) {
                $buffer = array('id'=>$fetchConditions);
                
            } else if (is_array($fetchConditions)) {
                $buffer = $fetchConditions;
                
            } else {
                throw new Exception('Cannot initialise with the specified value');
            }
            
            // Finally make the call to the data source (database).
            $this->fetch($buffer);
        }
    }
    
    /**
     * Method: fetch
     * 
     * Executes a SELECT-type SQL query against the database, and stores
     * the resulting data if there is any.
     * 
     * @param array $fetchConditions
     * An array containing conditions for a SELECT statement in SQL.
     * Ie, "WHERE $key = value". The array shall have the form array[$key] = $value.
     */
    protected function fetch($fetchConditions){
        
        $connection = DatabaseConnection::getInstance();
        $selectStatement = "SELECT * FROM {$this->databaseTableName}";
        
        // Set up WHERE conditions, if any.
        if (!empty($fetchConditions)) {
            $whereStatement = " WHERE ";
            $conditions  = $whereStatement;
            
            foreach($fetchConditions as $tableColumn=>$value) {
                if ($conditions != $whereStatement) {
                    $conditions .= " AND ";
                }
                $conditions .= "`{$tableColumn}`='" . 
                        $connection->sanitize($value) . 
                        "' ";
            }
            
            $selectStatement .= $conditions;
        }
        
        $resultArray = $connection->getQueryResultAsArray($selectStatement);
        
        // handle non-existent zero-th element, according to code on pg 180 of
        // the book (for book details, see introductory comments at top of this file).
        if(!isset($resultArray[0])) {
            $resultArray[0] = array();
        }
        
        // store into internal state.
        foreach($resultArray as $index=>$innerArray) {
            $this->setValue($index, $innerArray);
        }
    }
}
?>
