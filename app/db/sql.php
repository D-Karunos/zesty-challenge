<?php
class sql
{
    private $servername = "zesty_db";
    private $username = "root";
    private $password = "root";
    private $dbName = "zesty";
    protected $conn = null;
    public $timezone = 'GMT+1'; //France

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function getOpeningTimes()
    {
        $sql = ("SELECT * FROM `opening_hours` ORDER BY `weight`");
        $result = $this->conn->query($sql);
        return $this->renderData($result);
    }

    private function renderData($result)
    {
        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[$row['weekday']] = $row;
                $opening = DateTime::createFromFormat('D H:i:s', $data[$row['weekday']]['weekday'] . ' ' . $data[$row['weekday']]['timeOpening'], new DateTimeZone('GMT+1'));
                $closing = DateTime::createFromFormat('D H:i:s', $data[$row['weekday']]['weekday'] . ' ' . $data[$row['weekday']]['timeClosing'], new DateTimeZone('GMT+1'));

                if ($_SESSION['timezone'] != 'GMT+1') {
                    $opening->setTimezone(new DateTimeZone($_SESSION['timezone']));
                    $closing->setTimezone(new DateTimeZone($_SESSION['timezone']));

                }

                $data[$row['weekday']]['timeOpening'] = $opening->format('H:i:s');
                $data[$row['weekday']]['timeClosing'] = $closing->format('H:i:s');
            }
            return $data;
        }
        return false;
    }
}