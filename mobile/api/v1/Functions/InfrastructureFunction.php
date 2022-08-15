<?php

class InfrastructureFunction
{

    private $itemsTable = "infrastructure";
    private $infrastructuretypesTable = "infrastructuretypes";
    public $id;
    public $typeid;
    private $conn;
    public $page;
    public $distance;

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
            $itemRecords["types"] = array();
            $itemRecords["total_pages"] = $total_pages;
            $itemRecords["total_results"] = $total_rows;


            $stmt = $this->conn->prepare("SELECT `id` FROM " . $this->itemsTable . " Limit $offset, $no_of_records_per_page ");
            $stmt->execute();
            $stmt->bind_result($this->id);

            $ins_id = array();

            while ($stmt->fetch()) {
                array_push($ins_id, $this->id);
            }
            foreach ($ins_id as $id) {
                $temp = array();


                $type = new Infrastructure($this->conn, $id);

                $temp['id'] = $type->getId();
                $temp['aim'] = $type->getAim();
                $temp['description'] = $type->getDescription();
                $temp['longitude'] = $type->getLongitude();
                $temp['latitude'] = $type->getLatitude();
                $temp['type'] = $type->getType();
                $temp['iconpath'] = $type->getIconPath();
//
                array_push($itemRecords["infrastructure"], $temp);
            }

            $stmt = $this->conn->prepare("SELECT `id` FROM $this->infrastructuretypesTable ORDER BY `infrastructuretypes`.`name` ASC");
            $stmt->execute();
            $stmt->bind_result($this->typeid);

            $ins_types_id = array();

            while ($stmt->fetch()) {
                array_push($ins_types_id, $this->typeid);
            }
            foreach ($ins_types_id as $id) {
                $temp = array();

                $type = new InfrastructureTypes($this->conn, $id);

                $temp['id'] = $type->getId();
                $temp['name'] = $type->getName();
                $temp['iconpath'] = $type->getIconPath();
                $temp['total'] = $type->getTotal();
//
                array_push($itemRecords["types"], $temp);
            }

            return $itemRecords;
        } else {
            return "No Record";
        }
    }

    function Infrastructures_Near_Me()
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
            $itemRecords["types"] = array();
            $itemRecords["total_pages"] = $total_pages;
            $itemRecords["total_results"] = $total_rows;


            $stmt = $this->conn->prepare("SELECT `id`, ROUND((6371 * acos( cos(radians(2.7847098484273696)) * cos(radians(latitude)) * cos(radians(longitude) - radians(32.3069465264721)) + sin(radians(2.7847098484273696)) * sin(radians(latitude)))), (2)) AS distance FROM " . $this->itemsTable . " HAVING distance < 50 ORDER BY distance Limit $offset, $no_of_records_per_page;");
            $stmt->execute();
            $stmt->bind_result($this->id , $this->distance);

            $ins_id = array();

            while ($stmt->fetch()) {
                array_push($ins_id, $this->id);
            }
            foreach ($ins_id as $id) {
                $temp = array();


                $type = new Infrastructure($this->conn, $id);

                $temp['id'] = $type->getId();
                $temp['aim'] = $type->getAim();
                $temp['description'] = $type->getDescription();
                $temp['longitude'] = $type->getLongitude();
                $temp['latitude'] = $type->getLatitude();
                $temp['type'] = $type->getType();
                $temp['iconpath'] = $type->getIconPath();
//
                array_push($itemRecords["infrastructure"], $temp);
            }

            $stmt = $this->conn->prepare("SELECT `id` FROM $this->infrastructuretypesTable ORDER BY `infrastructuretypes`.`name` ASC");
            $stmt->execute();
            $stmt->bind_result($this->typeid);

            $ins_types_id = array();

            while ($stmt->fetch()) {
                array_push($ins_types_id, $this->typeid);
            }
            foreach ($ins_types_id as $id) {
                $temp = array();

                $type = new InfrastructureTypes($this->conn, $id);

                $temp['id'] = $type->getId();
                $temp['name'] = $type->getName();
                $temp['iconpath'] = $type->getIconPath();
                $temp['total'] = $type->getTotal();
//
                array_push($itemRecords["types"], $temp);
            }

            return $itemRecords;
        } else {
            return "No Record";
        }
    }
}