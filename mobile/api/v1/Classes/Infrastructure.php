<?php

class Infrastructure
{
    private $TABLE_NAME = "infrastructure";
    private $con;
    private $id;
    private $aim;
    private $description;
    private $longitude;
    private $latitude;
    private $type;
    private $InstallDate;
    private $Contact;
    private $status;

    /**
     * @param $con
     * @param $id
     */
    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `id`, `aim`, `description`, `longitude`, `latitude`, `type`, `InstallDate`, `Contact`, `status`  FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'");
        $ins_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->aim = null;
            $this->description = null;
            $this->longitude = null;
            $this->latitude = null;
            $this->type = null;
            $this->InstallDate = null;
            $this->Contact = null;
            $this->status = null;
        } else {

            $this->id = $ins_fetched['id'];
            $this->aim = $ins_fetched['aim'];
            $this->description = $ins_fetched['description'];
            $this->longitude = $ins_fetched['longitude'];
            $this->latitude = $ins_fetched['latitude'];
            $this->type = $ins_fetched['type'];
            $this->InstallDate = $ins_fetched['InstallDate'];
            $this->Contact = $ins_fetched['Contact'];
            $this->status = $ins_fetched['status'];
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
    public function getAim()
    {
        return $this->aim;
    }

    /**
     * @return mixed|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed|null
     */
    public function getType()
    {
        $type = new InfrastructureTypes($this->con, $this->type);
        return $type->getName();
    }


    public function getIconPath()
    {
        $type = new InfrastructureTypes($this->con, $this->type);
        return $type->getIconpath();
    }

    public function getTypeID(){
        return $this->type;
    }

    /**
     * @return mixed|null
     */
    public function getInstallDate()
    {
        $php_date = strtotime($this->InstallDate);
        $mysql_date = date('d M Y h:i A', $php_date);

        return $mysql_date;
    }

    /**
     * @return mixed|null
     */
    public function getContact()
    {
        return $this->Contact;
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

        // active(normal, GREEN =1 ) caution(Orange = 2) inactive(critical, RED = 3)

        if( $this->status == 1){
            $status = "Active";
        } else if($this->status == 2) {
            $status = "Caution";
        }else if($this->status == 3) {
            $status = "Inactive";
        }

        return $status;
    }




}