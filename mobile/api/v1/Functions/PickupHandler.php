<?php

class PickupHandler
{

    private $pickup_table = "pickup";
    private $conn;
    private $exe_status;
    private $id;
    public $user_id;
    public $full_name;
    public $phone_number;
    public $address;
    public $trash_description;
    public $date_created;



    public function __construct($con)
    {
        $this->conn = $con;
        $this->exe_status = "failure";
    }

    function create()
    {

        $stmt = $this->conn->prepare("SELECT `id`, `full_name`, `phone_number`, `address`, `user_id`, `trash_description`, `date_created` FROM " . $this->pickup_table . " WHERE user_id = ? AND (trash_description = ? AND address = ? )");
        $stmt->bind_param("iss", $this->user_id, $this->trash_description, $this->address);
        $stmt->execute();
        $stmt->store_result();

        //if the pickup already exist in the database
        if ($stmt->num_rows > 0) {
            return false;
        } else {

            $stmt = $this->conn->prepare("INSERT INTO " . $this->pickup_table . "( `full_name`, `phone_number`, `address`, `user_id`,`trash_description`) VALUES(?,?,?,?,?)");

            $this->full_name = htmlspecialchars(strip_tags($this->full_name));
            $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->trash_description = htmlspecialchars(strip_tags($this->trash_description));

            $stmt->bind_param("sssis", $this->full_name, $this->phone_number, $this->address, $this->user_id, $this->trash_description);

            if ($stmt->execute()) {
                $this->exe_status = "success";
            } else {
                $this->exe_status = "failure";
            }


            if ($this->exe_status == "success") {
                return true;
            }

            return false;
        }


    }


    function readUserPickup()
    {

        $itemRecords = array();

        $userID = htmlspecialchars(strip_tags($_GET["userId"]));
        $userAddressPage = htmlspecialchars(strip_tags($_GET["page"]));


        if ($userID) {
            $this->pageno = floatval($userAddressPage);
            $no_of_records_per_page = 10;
            $offset = ($this->pageno - 1) * $no_of_records_per_page;


            $sql = "SELECT COUNT(*) as count FROM " . $this->pickup_table . " WHERE user_id = " . $userID . " limit 1";
            $result = mysqli_query($this->conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $total_rows = floatval($data['count']);
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $itemRecords["page"] = $this->pageno;
            $itemRecords["user_pickup_requests"] = array();
            $itemRecords["total_pages"] = $total_pages;
            $itemRecords["total_results"] = $total_rows;

            if ($total_rows > 0) {
                $address_ids = array();
                $stmt = $this->conn->prepare("SELECT `id` FROM addresses WHERE user_id = " . $userID . " ORDER BY created_at DESC LIMIT " . $offset . "," . $no_of_records_per_page . " ");
                $stmt->execute();
                $stmt->bind_result($this->id);

                while ($stmt->fetch()) {
                    array_push($address_ids, $this->id);
                }
                foreach ($address_ids as $address_id) {
                    $temp = array();
                    $address = new Addresses($this->conn, $address_id);
                    $temp['id'] = $address->getId();
                    $temp['user_id'] = $address->getUser_id();
                    $temp['username'] = $address->getUser_Name();
                    $temp['email'] = $address->getUser_email();
                    $temp['address'] = $address->getAddress();
                    $temp['country'] = $address->getCountry();


                    array_push($itemRecords["user_pickup_requests"], $temp);
                }

            }


            return $itemRecords;
        }

    }


    function readAllAddress()
    {

        $itemRecords = array();

        $userAddressPage = htmlspecialchars(strip_tags($_GET["page"]));


        $this->pageno = floatval($userAddressPage);
        $no_of_records_per_page = 100;
        $offset = ($this->pageno - 1) * $no_of_records_per_page;


        $sql = "SELECT COUNT(*) as count FROM " . $this->pickup_table . " limit 1";
        $result = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $total_rows = floatval($data['count']);
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $itemRecords["page"] = $this->pageno;
        $itemRecords["user_address"] = array();
        $itemRecords["total_pages"] = $total_pages;
        $itemRecords["total_results"] = $total_rows;

        if ($total_rows > 0) {
            $address_ids = array();
            $stmt = $this->conn->prepare("SELECT `id` FROM addresses WHERE (`longitude` IS NOT NULL AND `latitude` IS NOT NULL) AND (`longitude` != 0 AND `latitude` != 0) ORDER BY created_at DESC LIMIT " . $offset . "," . $no_of_records_per_page . " ");
            $stmt->execute();
            $stmt->bind_result($this->id);

            while ($stmt->fetch()) {
                array_push($address_ids, $this->id);
            }
            foreach ($address_ids as $address_id) {
                $temp = array();
                $address = new Addresses($this->conn, $address_id);
                $cphpdate = strtotime($address->getCreated_at());
                $uphpdate = strtotime($address->getUpdated_at());

                $cdate = date('d M Y h:i A', $cphpdate);
                $udate = date('d M Y h:i A', $uphpdate);

                $temp['id'] = $address->getId();
                $temp['user_id'] = $address->getUser_id();
                $temp['username'] = $address->getUser_Name();
                $temp['email'] = $address->getUser_email();
                $temp['address'] = $address->getAddress();
                $temp['country'] = $address->getCountry();
                $temp['city'] = $address->getCity();
                $temp['phone'] = $address->getPhone();
                $temp['set_default'] = $address->getSet_default();
                $temp['created_at'] = $cdate;
                $temp['updated_at'] = $udate;
                $temp['longitude'] = $address->getLongitude();
                $temp['latitude'] = $address->getLatitude();
                $temp['postal_code'] = $address->getPostal_code();
                $temp['shipping_cost'] = $address->getShippingCost();
                array_push($itemRecords["user_address"], $temp);
            }


            return $itemRecords;
        }

    }


    function delete()
    {

        $stmt = $this->conn->prepare(" DELETE FROM " . $this->pickup_table . " WHERE id = ?");

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
