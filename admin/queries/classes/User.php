<?php

class User
{
    private $TABLE_NAME = "users";
    private $con;
    private $id;
    private $username;
    private $Fullname;
    private $Phone;
    private $Email;
    private $Password;
    private $Role;
    private $Date_created;


    /**
     * @param $con
     * @param $id
     */
    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $sql = "SELECT  `id`, `username`, `Fullname`, `Phone`, `Email`, `Password`, `Role`, `Date_created` FROM ". $this->TABLE_NAME ." WHERE id ='$this->id'";
        $query = mysqli_query($this->con,$sql );
        $user_fetched = mysqli_fetch_array($query);

        if (mysqli_num_rows($query) < 1) {
            $this->id = null;
            $this->username = null;
            $this->Fullname = null;
            $this->Phone = null;
            $this->Email = null;
            $this->Password = null;
            $this->Role = null;
            $this->Date_created = null;
        } else {
            $this->id = $user_fetched['id'];
            $this->username = $user_fetched['username'];
            $this->Fullname = $user_fetched['Fullname'];
            $this->Phone = $user_fetched['Phone'];
            $this->Email = $user_fetched['Email'];
            $this->Password = $user_fetched['Password'];
            $this->Role = $user_fetched['Role'];
            $this->Date_created = $user_fetched['Date_created'];
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed|null
     */
    public function getFullname()
    {
        return $this->Fullname;
    }

    /**
     * @return mixed|null
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @return mixed|null
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @return mixed|null
     */
    public function getRole()
    {
        return $this->Role;
    }

    /**
     * @return mixed|null
     */
    public function getDateCreated()
    {
        return date('d M Y h:i A', strtotime($this->Date_created));
    }




}