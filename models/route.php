<?php
require_once 'agency.php';
require_once 'user.php';

class Route{
    protected PDO $db;

    protected $id;

    protected $startAgencyId;
    protected ?Agency $startAgency=null;

    protected $startDatetime;

    protected $endAgencyId;
    protected ?Agency $endAgency=null ;
    
    protected $endDatetime;

    protected $seats;
    protected $takenSeats;

    protected $organizerId;
    protected ?User $organizer=null;


    public function __construct(PDO $db) {
        $this->db=$db;
    }

    public function getStartAgency(){
        if ($this->startAgency === null) {
            $this->startAgency = new Agency($this->db);

            if (!$this->startAgency->findById($this->startAgencyId)) {
                $this->startAgency = null;
                return false;
            }
        }

        return $this->startAgency;
    }

    public function setStartAgency($agencyId){
        $this->startAgencyId=$agencyId;
        $this->startAgency = null;
    }

    public function getStartDate(){
        return date('m/d/Y',$this->startDatetime);
    }

    public function getStartTime(){
        return date('H:i',$this->startDatetime);
    }

    public function setStartDatetime($datetime){
        $this->startDatetime=strtotime($datetime);
    }


    public function getEndAgency(){
        if ($this->endAgency === null) {
            $this->endAgency = new Agency($this->db);

            if (!$this->endAgency->findById($this->endAgencyId)) {
                $this->endAgency = null;
                return false;
            }
        }

        return $this->endAgency;
    }

    public function setEndAgency($agencyId){
        $this->endAgencyId=$agencyId;
        $this->endAgency = null;
    }

    public function getEndDate(){
        return date('m/d/Y',$this->endDatetime);
    }
    
    public function getEndTime(){
        return date('H:i',$this->endDatetime);
    }

    public function setEndDatetime($datetime){
        $this->endDatetime=strtotime($datetime);
    }

    public function getSeats(){
        return ['total'=>$this->seats,'taken'=>$this->takenSeats];
    }

    public function setSeats($seats){
        $this->seats=$seats;
    }

    public function setTakenSeats($seats){
        $this->takenSeats=$seats;
    }

    public function getOrganizer(){
        if ($this->organizer === null) {
            $this->organizer = new User($this->db);

            if (!$this->organizer->findById($this->organizerId)) {
                $this->organizer = null;
                return false;
            }
        }

        return $this->organizer;
    }

    public function setOrganizer($organizerId){
        $this->organizerId=$organizerId;
        $this->organizer = null;

    }

    public function findById($id){
        $query = $this->db->prepare(
            'SELECT id,start_time,end_time,seats,taken_seats,start_at,end_at,organizer
            FROM route
            WHERE id=:id'
        );
        $query->execute(['id'=>$id]);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->hydrate($data);
            return true;
        }

        return false;
    }

    public function getList(){
        $query = $this->db->query(
            'SELECT id,start_time,end_time,seats,taken_seats,start_at,end_at,organizer
            FROM route 
            ORDER by start_time ASC'
        );

        $list=[];
        if($query){
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $route = new Route($this->db);
                $route->hydrate($row);
                $list[]=$route;
            }       
        }
        return $list;
    }
    
    public function getCurrents(){
        $query = $this->db->query(
            'SELECT id,start_time,end_time,seats,taken_seats,start_at,end_at,organizer
            FROM route 
            WHERE seats>taken_seats AND start_time>=NOW()
            ORDER by start_time ASC'
        );

        $list=[];
        if($query){
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $route = new Route($this->db);
                $route->hydrate($row);
                $list[]=$route;
            }
            
            
        }
        return $list;
    }

    
    
    public function create(){
        $query = $this->db->prepare(
            'INSERT INTO route(start_at,start_time,end_at,end_time,seats,taken_seats,organizer) 
            VALUES (:start_at,:start_time,:end_at,:end_time,:seats,:taken_seats,:organizer)'
        );

        $result = $query->execute([
            'start_at'=>$this->startAgencyId,
            'start_time'=>date('Y-m-d H:i:s',$this->startDatetime),
            'end_at'=>$this->endAgencyId,
            'end_time'=>date('Y-m-d H:i:s',$this->endDatetime),
            'seats'=>$this->seats,
            'taken_seats'=>$this->takenSeats,
            'organizer'=>$this->organizerId
        ]);
        
        if ($result){
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    
    }

    public function update(){
        $query = $this->db->prepare(
            'UPDATE route
            SET start_at = :start_at, start_time = :start_time, end_at = :end_at, end_time = :end_time, seats = :seats, taken_seats = :taken_seats, organizer = :organizer
            WHERE id = :id
            '
        );

        $result = $query->execute([
            'id'=>$this->id,
            'start_at'=>$this->startAgencyId,
            'start_time'=>date('Y-m-d H:i:s',$this->startDatetime),
            'end_at'=>$this->endAgencyId,
            'end_time'=>date('Y-m-d H:i:s',$this->endDatetime),
            'seats'=>$this->seats,
            'taken_seats'=>$this->takenSeats,
            'organizer'=>$this->organizerId
        ]);
        
        if ($result){
            return true;
        }
        return false;
    }

    public function delete(){
        $query = $this->db->prepare(
            'DELETE FROM route
            WHERE id = :id'
        );

        $result = $query->execute(['id'=>$this->id]);
        
        if ($result){
            return true;
        }
        return false;
        
    }

    public function isEditableBy(User $user){
        return ($user->isAdmin() || $user->id==$this->organizerId);
    }

    protected function hydrate($data) {
        $this->id = $data['id'];
        $this->startAgencyId = $data['start_at'];
        $this->startDatetime = strtotime($data['start_time']);
        $this->endAgencyId = $data['end_at'];
        $this->endDatetime = strtotime($data['end_time']);
        $this->seats = $data['seats'];
        $this->takenSeats = $data['taken_seats'];
        $this->organizerId = $data['organizer'];

        $this->startAgency = null;
        $this->endAgency = null;
        $this->organizer = null;
    }
}