<?php

class Pickup
{
    private $TABLE_NAME = "pickup";
    private $con;
    private $id;
    private $full_name;
    private $phone_number;
    private $address;
    private $user_id;
    private $trash_description;
    private $date_created;
    private $status;

    /**
     * @param $con
     * @param $id
     */
    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `id`, `full_name`, `phone_number`, `address`, `user_id`, `trash_description`, `status`, `date_created` FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'");
        $ins_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->full_name = null;
            $this->phone_number = null;
            $this->address = null;
            $this->user_id = null;
            $this->trash_description = null;
            $this->status = null;
            $this->date_created = null;

        } else {

            $this->id = $ins_fetched['id'];
            $this->full_name = $ins_fetched['full_name'];
            $this->phone_number = $ins_fetched['phone_number'];
            $this->address = $ins_fetched['address'];
            $this->user_id = $ins_fetched['user_id'];
            $this->trash_description = $ins_fetched['trash_description'];
            $this->status = $ins_fetched['status'];
            $this->date_created = $ins_fetched['date_created'];
        }
    }

    /**
     * @return mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed|null
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @return mixed|null
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return mixed|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed|null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUser(){
        $user = new User($this->con, $this->user_id);
        return $user->getId();
    }

    /**
     * @return mixed|null
     */
    public function getTrashDescription()
    {
        return $this->trash_description;
    }

    /**
     * @return mixed|null
     */
    public function getDateCreated()
    {
        return date('d M Y h:i A', strtotime($this->date_created));

    }


    /**
     * @return mixed|null
     */
    public function getStatusID()
    {
        return $this->status;
    }

    public function getStatus()
    {
        $status = '';

        if( $this->status == 1){
            $status = "Active";
        } else if($this->status == 2) {
            $status = "Not Active";
        }

        return $status;
    }




}