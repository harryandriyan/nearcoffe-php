<?php 
class near_query_handler {

    private $conn;

    function __construct() {
        require_once 'near_connect.php';
        // opening db connection
        $db = new near_connect();
        $this->conn = $db->connect();
    }
    /**
     * Fetching single record
     */
    public function getOneRecord($query) {
        $r = $this->conn->query($query.' LIMIT 1') or die($this->conn->error.__LINE__);
        return $result = $r->fetch_assoc();    
    }
    /**
     * Delete single record
     */
    public function deleteRecord($query) {
        $r = $this->conn->prepare($query) or die($this->conn->error.__LINE__);
        return $result = $r->execute();    
    }
    /**
     * Fetching multiple record
     */
    public function getRecords($query) {
        $result = array();
        $row = array();
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);
        while($result = $r->fetch_array()) {
            $row[] = array(
                    "id"=> $result['id'],
                    "name"=> $result['name'],
                    "foursquare_id"=> $result['foursquare_id'],
                    "user_id"=> $result['user_id'],
                    "note"=> $result['note'],
                    "status"=> $result['status'],
                    "saved"=> $result['saved']
                );
        }
        return $row;
    }

    public function getComments($id) {
        $result = array();
        $row = array();
        $r = $this->conn->query('
            SELECT comment.*, user.name as name FROM comment LEFT JOIN user ON user.id=comment.user_id WHERE venue_id="'.$id.'"'
        )
        or die($this->conn->error.__LINE__);
        while($result = $r->fetch_array()) {
            $row[] = array(
                    "comment_id"=> $result['comment_id'],
                    "user_id"=> $result['user_id'],
                    "user_name"=> $result['name'],
                    "venue_id"=> $result['venue_id'],
                    "comment_data"=> $result['comment_data'],
                    "comment_date"=> $result['comment_date']
                );
        }
        return $row;
    }
    /**
     * Creating new record
     */
    public function insertIntoTable($obj, $column_names, $table_name) {
        
        $c = (array) $obj;
        $keys = array_keys($c);
        $columns = '';
        $values = '';
        foreach($column_names as $desired_key){ // Check the obj received. If blank insert blank into the array.
           if(!in_array($desired_key, $keys)) {
                $$desired_key = '';
            }else{
                $$desired_key = $c[$desired_key];
            }
            $columns = $columns.$desired_key.',';
            $values = $values."'".$$desired_key."',";
        }
        $query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }

}