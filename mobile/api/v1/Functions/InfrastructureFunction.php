<?php
class InfrastructureFunction
{

    private $itemsTable = "infrastructure";
    public $id;
    public $aim;
    public $description;
    public $longitude;
    public $latitude;
    public $type;
    private $conn;
    public $page;

    public function __construct($con)
    {
        $this->conn = $con;
    }


    function All_Infrastructure()
    {
        $itemRecords = array();

        $this->page = htmlspecialchars(strip_tags($_GET["page"]));

        if ($this->page) {
            $this->page = floatval($this->page);
            $no_of_records_per_page = 10;
            $offset = ($this->page - 1) * $no_of_records_per_page;

            $sql = "SELECT COUNT(*) as count FROM " . $this->itemsTable . " limit 1";
            $result = mysqli_query($this->conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $total_rows = floatval($data['count']);
            $total_pages = ceil($total_rows / $no_of_records_per_page);



            $itemRecords["page"] = $this->page;
            $itemRecords["infrastructure"] = array();
            $itemRecords["total_pages"] = $total_pages;
            $itemRecords["total_results"] = $total_rows;


            $stmt = $this->conn->prepare("SELECT `id`, `aim`, `description`, `longitude`, `latitude`, `type` FROM " . $this->itemsTable . " Limit $offset, $no_of_records_per_page ");
            $stmt->execute();
            $stmt->bind_result($this->id, $this->aim, $this->description, $this->longitude, $this->latitude, $this->type);


            while ($stmt->fetch()) {

                $temp = array();

                $temp['id'] = $this->id;
                $temp['aim'] = $this->aim;
                $temp['description'] = $this->description;
                $temp['longitude'] = $this->longitude;
                $temp['latitude'] = $this->latitude;
                $temp['type'] = $this->type;

                array_push($itemRecords["infrastructure"], $temp);
            }
            return $itemRecords;
        } else {
            return "No Record";
        }
    }
}
