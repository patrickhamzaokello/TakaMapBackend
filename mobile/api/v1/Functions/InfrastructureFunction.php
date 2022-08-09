<?php
class InfrastructureFunction
{

    private $itemsTable = "infrastructure";
    public $id;
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
            $no_of_records_per_page = 100;
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


            $stmt = $this->conn->prepare("SELECT `id` FROM " . $this->itemsTable . " Limit $offset, $no_of_records_per_page ");
            $stmt->execute();
            $stmt->bind_result($this->id);

            $ins_id =array();

            while ($stmt->fetch()){
                array_push($ins_id, $this->id);
            }
            foreach ($ins_id as $id){
                $temp = array();



                $type = new Infrastructure($this->conn,$id);

                $temp['id'] = $type->getId();
                $temp['aim'] = $type->getAim();
                $temp['description'] = $type->getDescription();
                $temp['longitude'] = $type->getLongitude();
                $temp['latitude'] = $type->getLatitude();
                $temp['type'] = $type->getType();
//
                array_push($itemRecords["infrastructure"], $temp);
            }

            return $itemRecords;
        } else {
            return "No Record";
        }
    }
}