<?php

class Cases
{
    private $TABLE_NAME = "cases";
    private $con;
    private $id;
    private $name;
    private $userid;
    private $title;
    private $description;
    private $imagepath;
    private $status;
    private $date_created;

    /**
     * @param $con
     * @param $id
     */
    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT  `id`, `userid`, `title`,`name`, `description`, `imagepath`, `status`, `date_created` FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'");
        $cases_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->userid = null;
            $this->title = null;
            $this->name = null;
            $this->description = null;
            $this->imagepath = null;
            $this->status = null;
            $this->date_created = null;
        } else {

            $this->id = $cases_fetched['id'];
            $this->userid = $cases_fetched['userid'];
            $this->title = $cases_fetched['title'];
            $this->name = $cases_fetched['name'];
            $this->description = $cases_fetched['description'];
            $this->imagepath = $cases_fetched['imagepath'];
            $this->status = $cases_fetched['status'];
            $this->date_created = $cases_fetched['date_created'];
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
    public function getUserid()
    {
        return $this->userid;
    }

    public function getUser(){
        if($this->userid < 1){
            return $this->name;
        } else {
            $user =  new User($this->con, $this->userid);
            return $user->getFullname();
        }
    }

    /**
     * @return mixed|null
     */
    public function getTitle()
    {
        return $this->title;
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
    public function getImagepath()
    {
        return $this->imagepath;
    }

    /**
     * @return mixed|null
     */
    public function getDateCreated()
    {
        return date('d M Y h:i A', strtotime($this->date_created));
    }

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