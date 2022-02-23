<?php
class MenuTypeClass
{

    private $itemsTable = "infrastructure";
    public $id;
    public $aim;
    public $description;
    public $longitude;
    public $latitude;
    public $type;
    private $conn;



    public function __construct($con, $id)
    {
        $this->conn = $con;
        $this->id = $id;

        $stmt = $this->conn->prepare("SELECT `id`, `aim`, `description`, `longitude`, `latitude`, `type` FROM " . $this->itemsTable . " WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->bind_result($this->id, $this->aim, $this->description, $this->longitude, $this->latitude, $this->type);

        while ($stmt->fetch()) {
        $this->id = $id;
        $this->aim = $this->aim;
        $this->description = $this->description;
        $this->longitude = $this->longitude;
        $this->latitude = $this->latitude;
        $this->type = $this->type;

        }
    }



    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of aim
     */ 
    public function getAim()
    {
        return $this->aim;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of longitude
     */ 
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Get the value of latitude
     */ 
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }
}