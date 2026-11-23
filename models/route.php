<?php

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


    /**
     * __construct
     * initialise une instance de Route.
     * @param PDO $db connexion à la base de donnée.
     * @return void
     */
    public function __construct(PDO $db) {
        $this->db=$db;
    }

    /**
     * getId
     * retourne l'identifiant du trajet.
     * @return Number l'identifiant du trajet
     */
    public function getId(){
        return $this->id;
    }

    /**
     * getStartAgency
     * retourne l'agence de départ d'un trajet.
     * @return Agency l'agence de départ
     */
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

    /**
     * setStartAgency
     * modifie l'agence de départ du trajet.
     * @param mixed $agencyId l'identifiant de la nouvelle agence de départ
     * @return Bool true si la modification a fonctionné, false sinon
     */
    public function setStartAgency($agencyId){
        if($agencyId==$this->endAgency){ // si la nouvelle agence de départ est déjà l'agence d'arrivée on indique une erreur.
            return false;
        }
        $this->startAgencyId=$agencyId;
        $this->startAgency = null;
        return true;
    }

    /**
     * getStartDate
     * Retourne la date de départ du trajet au format JJ/MM/AAAA.
     * @return String la date départ du trajet formatée.
     */
    public function getStartDate(){
        return date('m/d/Y',$this->startDatetime);
    }

    /**
     * getStartTime
     * Retourne l'heure de départ du trajet au format HH:MM.
     * @return String l'heure de départ du trajet formatée.
     */
    public function getStartTime(){
        return date('H:i',$this->startDatetime);
    }

    /**
     * setStartDatetime
     * Modifie le timestamp de départ du trajet.
     * @param String $datetime la date et l'heure de départ formatées.
     * @return Bool true si la modification a fonctionné, false sinon.
     */
public function setStartDatetime($datetime){


    $timestamp = strtotime($datetime); // on transforme la date formatée en timestamp pour faciliter le traitement.

    if ($timestamp === false) { // on vérifie qu'on a bien affaire à une date.
        return false;
    }

    if (($this->endDatetime - $timestamp) <= 1800) { // on vérifie que le trajet a une durée minimum (ici arbitrairement définie à 30min mais qui serait à définir avec le client).
        return false;
    }

    $this->startDatetime = $timestamp;
    return true;
}

    /**
     * getEndAgency
     * retourne l'agence d'arrivée d'un trajet.
     * @return Agency l'agence d'arrivée
     */
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

    /**
     * setEndAgency
     * modifie l'agence d'arrivée du trajet.
     * @param mixed $agencyId l'identifiant de la nouvelle agence d'arrivée
     * @return Bool true si la modification a fonctionné, false sinon
     */
    public function setEndAgency($agencyId){
        if($agencyId==$this->startAgency){ // si la nouvelle agence d'arrivée est déjà l'agence de départ on indique une erreur.
            return false;
        }
        $this->endAgencyId=$agencyId;
        $this->endAgency = null;
        return true;
    }

    /**
     * getEndDate
     * Retourne la date d'arrivée du trajet au format JJ/MM/AAAA.
     * @return String la date d'arrivée du trajet formatée.
     */
    public function getEndDate(){
        return date('m/d/Y',$this->endDatetime);
    }
    
    /**
     * getEndime
     * Retourne l'heure d'arrivée du trajet au format HH:MM.
     * @return String l'heure d'arrivée du trajet formatée.
     */
    public function getEndTime(){
        return date('H:i',$this->endDatetime);
    }

    /**
     * setStartDatetime
     * Modifie le timestamp de d'arrivée du trajet.
     * @param String $datetime la date et l'heure de d'arrivée formatées.
     * @return Bool true si la modification a fonctionné, false sinon.
     */
public function setEndDatetime($datetime){


    $timestamp = strtotime($datetime); // on transforme la date formatée en timestamp pour faciliter le traitement.

    if ($timestamp === false) { // on vérifie qu'on a bien affaire à une date.
        return false;
    }

    if (($timestamp - $this->startDatetime) <= 1800) { // on vérifie que le trajet a une durée minimum (ici arbitrairement définie à 30min mais qui serait à définir avec le client).
        return false;
    }

    $this->endDatetime = $timestamp;
    return true;
}

    /**
     * getSeats
     * Retourne un tableau indiquant les places totales et occupées du trajet au format ['total'=>(places totales),'taken'=>(places prises)].
     * @return Array un tableau au format susmentionné.
     */

    public function getSeats(){
        return ['total'=>$this->seats,'taken'=>$this->takenSeats];
    }

    /**
     * setSeats
     * Modifie le nombre de places totales sur le trajet
     * @param Number $seats la nouvelle valeur des places totales.
     * @return Bool true si la modification a fonctionné, false sinon.
     */
    public function setSeats($seats){
        if($seats<$takenSeats){
            return false;
        }
        $this->seats=$seats;
        return true;
    }

    /**
     * setTakenSeats
     * Modifie le nombre de places prises sur le trajet
     * @param Number $seats la nouvelle valeur des places prises.
     * @return Bool true si la modification a fonctionné, false sinon.
     */
    public function setTakenSeats($seats){
        if($seats<$takenSeats){
            return false;
        }
        $this->takenSeats=$seats;
        return true;
    }

    /**
     * getOrganizer
     * Retourne l'organisateur du trajet.
     * @return User l'organisateur du trajet.
     */

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

    /**
     * setOrganizer
     * Modifie l'organisateur du trajet.
     * @param mixed $organizerId le nouvel utilisateur.
     * @return void
     */

    public function setOrganizer($organizerId){
        $this->organizerId=$organizerId;
        $this->organizer = null;

    }

    /**
     * findById
     * charge un trajet en fonction de son identifiant.
     * @param mixed $id l'identifiant du trajet à charger.
     * @return Bool true si un trajet est trouvé, false sinon.
     */
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

    /**
     * getList
     * retourne la liste de tous les trajets.
     * @return Array un tableau contenant tous les trajet
     */
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
    
    /**
     * getCurrents
     * Retourne la liste des trajets futurs sur lesquels il reste des places.
     * @return Array un tableau contenant les trajets.
     */
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
    
    /**
     * create
     * Enregistre le trajet dans la base de donnée.
     * @return Bool true si la requête est réussie, false sinon.
     */

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

    /**
     * update
     * Modifie le trajet dans la base de donnée
     * @return Bool true si la requête est réussie, false sinon.
     */

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

    /**
     * delete
     * Supprime un trajet dans la base de donnée.
     * @return Bool true si la requête est réussie, false sinon.
     */
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
    
    /**
     * isEditableBy
     * Vérifie si un utilisateur peut modifier le trajet (s'il en est le créateur ou s'il est administrateur).
     * @param User $user l'utilisateur dont les droits sont testés
     * @return Bool true si l'utilisateur peut modifier le trajet, false sinon.
     */
    public function isEditableBy(User $user){
        return ($user->isAdmin() || $user->getId()==$this->organizerId);
    }

    /**
     * hydrate
     * remplit les attributs du trajet à partir d'un tableau.
     * @param Array $data le tableau source.
     * @return void
     */
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