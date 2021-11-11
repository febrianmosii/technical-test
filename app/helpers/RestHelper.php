<?php ;

/**
 * Helper methods that useful for REST development
 *
 * @author Mohamad Febrian Mosii <febrianaries@gmail.com>
 */
class RestHelper
{
    /**
     * Function to draw response
     *
     * @param   array  $statusCode  HTTP Status Code (Reference: https://en.wikipedia.org/wiki/List_of_HTTP_status_codes)
     * @param   array  $message     Response message
     * @param   array  $message     Response Data
     * @return  Json
     */
    public static function set_response($statusCode, $message = null, $data = [])
	{
		$arr = [
			'status'  => ($statusCode === 200) ? true : false,
			'message' => (isset($message)) ? $message : 'error'
		];

		if ( ! empty($data)) {
			$arr['data'] = $data;
		}

        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json');
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($statusCode);

		echo json_encode($arr);
        exit();
	}

    /**
     * Helper for form validations
     *
     * @param   array  $requiredFields
     * @return  array
     */
    public static function empty_form_validations($requiredFields = []) {
        $status  = true;
        $message = [];

        foreach ($requiredFields as $field) {
            $value = $_SERVER['REQUEST_METHOD'] === 'GET' ? $_GET : $_POST; 
            
            if (substr($field, 0, 6) === 'array_') {
                if (empty($value[str_replace('array_', '', $field)])) {
                    $message[] = "Parameter '" . $field . "' is required (Body `Form-data`)";
                    $status    = false;
                }
            } else if (empty($value[$field])) {
                $message[] = "Parameter '" . $field . "' is required (Body `Form-data`)";
                $status  = false;
            }
        }

        return ['status' => $status, 'message' => $message];
    }

    /**
     * Helper for length validation
     *
     * @param   string  $field           
     * @param   int     $maxLength
     * @return  boolean
     */
    public static function length_validations($field, $maxLength) {
        return strlen($field) <= $maxLength; 
    }

    
    /**
     * Database Migration function
     * 
     * @return  void
     */
    public static function migrate_database() {
        $server_name   = getenv("APP_HOST");
        $username      = getenv("APP_USERNAME");
        $password      = getenv("APP_PASSWORD");
        $database_name = getenv("APP_DATABASE");

        try {
            $dbo = new PDO('mysql:host='.$server_name.';dbname='.$database_name, $username, $password);
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    
        $sql = str_replace('{{database_name}}', $database_name,  file_get_contents(PATH_DB . 'migration.sql'));
        
        $sql = $dbo->prepare("$sql");
        
        if($sql->execute()){
            echo "Database has migrated successfully";
        } else {
            echo "Database is not configured properly, or import manually database using db/dump.sql to your mysql database.";
        }
    }
}
