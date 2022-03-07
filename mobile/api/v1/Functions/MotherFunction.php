<?php

class MotherFunction
{

    private $itemsTable = "motherstbl";
    public $id;
    public $name;
    public $phone;
    public $email;
    public $temp;
    public $status;
    public $pressure;
    public $heart_beat;
    public $gps_lat;
    public $gps_long;
    public $husband_name;
    public $husband_phone;
    public $village;
    public $subcounty;
    public $district;
    public $age;
    public $concieved_month;
    public $expected_month;
    public $comments;
    public $created_at;
    public $modified_at;

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
            $itemRecords["mothers"] = array();
            $itemRecords["total_pages"] = $total_pages;
            $itemRecords["total_results"] = $total_rows;


            $stmt = $this->conn->prepare("SELECT `id`, `name`, `phone`, `email`, `temp`, `status`, `pressure`, `heart_beat`, `gps_lat`, `gps_long`, `husband_name`, `husband_phone`, `village`, `subcounty`, `district`, `age`, `concieved_month`, `expected_month`, `comments`, `created_at`, `modified_at` FROM " . $this->itemsTable . " Limit $offset, $no_of_records_per_page ");
            $stmt->execute();
            $stmt->bind_result($this->id, $this->name, $this->phone, $this->email, $this->temp, $this->status, $this->pressure, $this->heart_beat, $this->gps_lat, $this->gps_long, $this->husband_name, $this->husband_phone, $this->village, $this->subcounty, $this->district, $this->age, $this->concieved_month, $this->expected_month, $this->comments, $this->created_at, $this->modified_at);


            while ($stmt->fetch()) {

                $temp = array();

                $temp['id'] = $this->id;
                $temp['name'] = $this->name;
                $temp['phone'] = $this->phone;
                $temp['email'] = $this->email;
                $temp['temp'] = $this->temp;
                $temp['status'] = $this->status;

                $temp['pressure'] = $this->pressure;
                $temp['heart_beat'] = $this->heart_beat;
                $temp['gps_lat'] = $this->gps_lat;
                $temp['gps_long'] = $this->gps_long;
                $temp['husband_name'] = $this->husband_name;
                $temp['husband_phone'] = $this->husband_phone;

                $temp['village'] = $this->village;
                $temp['subcounty'] = $this->subcounty;
                $temp['district'] = $this->district;
                $temp['age'] = $this->age;
                $temp['concieved_month'] = $this->concieved_month;
                $temp['expected_month'] = $this->expected_month;

                $temp['comments'] = $this->comments;
                $temp['created_at'] = $this->created_at;
                $temp['modified_at'] = $this->modified_at;

                array_push($itemRecords["mothers"], $temp);
            }
            return $itemRecords;
        } else {
            return "No Record";
        }
    }
}
