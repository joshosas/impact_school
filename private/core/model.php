<?php

/**
 * Main model
 */
class Model extends Database
{
    // Public property to store any validation or query errors
    public $errors = [];

    // Protected properties for the table name and function hooks
    protected $table = null; // Table name, initialized as null
    protected $afterSelect = []; // Array to store functions to run after SELECT queries
    protected $allowedColumns = []; // Array to store allowed columns for inserts/updates
    protected $beforeInsert = []; // Array to store functions to run before INSERT queries

    // Constructor: Set the table name if not already set
    public function __construct()
    {
        // If the 'table' property is not set, set it to the plural form of the class name
        if (empty($this->table)) {
            $this->table = strtolower($this::class) . "s"; // Class name pluralized
        }
    }

    /**
     * Find a specific record by column and value
     * @param string $column - The column name to search
     * @param mixed $value - The value to search for in the column
     * @return mixed - The result of the query or modified data after running afterSelect functions
     */
    public function findOne($column, $value)
    {
        // Escape the column name to prevent SQL injection
        $column = addslashes($column);

        // Prepare the SQL query to fetch the row where the column matches the value
        $query = "SELECT * FROM $this->table WHERE $column = :value";
        $data = $this->query($query, [
            'value' => $value // Bind the value parameter
        ]);

        // Run any 'afterSelect' functions if they exist
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data = $this->$func($data); // Call the functions on the retrieved data
                }
            }
        }


        return $data;
    }
    public function first($column, $value)
    {
        // Escape the column name to prevent SQL injection
        $column = addslashes($column);

        // Prepare the SQL query to fetch the row where the column matches the value
        $query = "SELECT * FROM $this->table WHERE $column = :value";
        $data = $this->query($query, [
            'value' => $value // Bind the value parameter
        ]);

        // Run any 'afterSelect' functions if they exist
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data = $this->$func($data); // Call the functions on the retrieved data
                }
            }
        }
        if (is_array($data)) {
            $data = $data[0];
        }

        return $data;
    }

    /**
     * Fetch all records from the table
     * @return mixed - The result of the query or modified data after running afterSelect functions
     */
    public function findAll()
    {
        // Prepare the SQL query to fetch all rows from the table
        $query = "SELECT * FROM $this->table";
        $data = $this->query($query);

        // Run any 'afterSelect' functions if they exist
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data = $this->$func($data); // Call the functions on the retrieved data
                }
            }
        }

        return $data;
    }

    /**
     * Insert a new record into the table
     * @param array $data - The data to be inserted
     * @return mixed - The result of the query
     */
    public function insert($data)
    {
        // Remove columns not in allowedColumns before insertion
        if (property_exists($this, 'allowedColumns')) {
            foreach ($data as $key => $column) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]); // Remove unallowed column
                }
            }
        }

        // Run any 'beforeInsert' functions on the data before inserting
        if (property_exists($this, 'beforeInsert')) {
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data); // Call the functions on the data
            }
        }

        // Dynamically generate column and value placeholders for the SQL query
        $keys = array_keys($data); // Get column names from data array
        $columns = implode(',', $keys); // Join column names as a comma-separated string
        $values = ":" . implode(',:', $keys); // Create named placeholders for values

        // Prepare the SQL query for insertion
        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        return $this->query($query, $data); // Execute the query with data bindings
    }

    /**
     * Update an existing record in the table
     * @param mixed $id - The ID of the record to be updated
     * @param array $data - The new data for the update
     * @return mixed - The result of the query
     */
    public function update($id, $data)
    {
        // Initialize the SQL query string for the SET clause
        $setQuery = "";

        // Get an array of the column names (keys) from the provided data array
        $keys = array_keys($data);

        // Loop through each key to construct the SET part of the SQL query dynamically
        foreach ($keys as $key) {
            // Append column name and placeholder to the SET string, e.g., "column_name = :column_name"
            $setQuery .= $key . " = :" . $key . ", ";
        }

        // Remove the trailing comma and space from the SET string
        $setQuery = rtrim($setQuery, ", ");

        // Construct the full SQL update query with the dynamically created SET clause and a WHERE clause for the ID
        $query = "UPDATE $this->table SET $setQuery WHERE id = :id";

        // Add the ID to the data array to bind it to the :id placeholder in the SQL query
        $data['id'] = $id;

        // Execute the SQL query using the query method, passing in the query string and data array for binding
        return $this->query($query, $data);
    }


    /**
     * Delete a record from the table
     * @param mixed $id - The ID of the record to be deleted
     * @return mixed - The result of the query
     */
    public function delete($id)
    {
        // Prepare the SQL query for deletion
        $query = "DELETE FROM $this->table WHERE id = :id";

        // Execute the query with the ID binding
        return $this->query($query, ['id' => $id]);
    }
}
