<?php

class InfrastructureTypes
{
    private $TABLE_NAME = "infrastructuretypes";
    private $con;
    private $id;
    private $name;
    private $iconpath;
    private $created_at;


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT `id`, `name`,`iconpath`, `created_at` FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'");
        $ins_fetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->id = null;
            $this->name = null;
            $this->created_at = null;

        } else {

            $this->id = $ins_fetched['id'];
            $this->name = $ins_fetched['name'];
            $this->iconpath = $ins_fetched['iconpath'];
            $this->created_at = $ins_fetched['created_at'];

        }
    }


    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getIconpath()
    {
        $baseur = "http://yugimap.com/admin/pages/";
        return $baseur.$this->iconpath;
    }


    public function getCreatedAT()
    {
        $php_date = strtotime($this->created_at);
        $mysql_date = date('d M Y h:i A', $php_date);

        return $mysql_date;
    }





}