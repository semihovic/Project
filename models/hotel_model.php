<?php

class Hotel_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Getters om informatie op te halen
    public function getAll() {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('hotel');
        $hotels = $query->result();

        //Model laden om OO te programmeren
        $this->load->model('locatie_model');

        //OO Land gegevens in Locatie zetten
        foreach ($hotels as $hotel) {
            $hotel->locatie = $this->locatie_model->get($hotel->locatieId);
        }
        return $hotels;
    }

    public function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('hotel');
        $hotel = $query->row();

        //Model laden om OO te programmeren
        $this->load->model('locatie_model');

        //Land gegevens OO in locatie zetten
        $hotel->locatie = $this->locatie_model->get($hotel->locatieId);
        return $hotel;
    }

    public function getAllByLocation($id) {
        $this->db->order_by('naam', 'asc');
        $this->db->where('locatieId', $id);
        $query = $this->db->get('hotel');
        $hotels = $query->result();

        //Model laden om OO te programmeren
        $this->load->model('locatie_model');

        foreach ($hotels as $hotel) {
            $hotel->locatie = $this->locatie_model->get($hotel->locatieId);
        }
        return $hotels;
    }

    // Insert/Delete/Update statements
    public function insert($hotel) {
        $this->db->insert('hotel', $hotel);
        return $this->db->insert_id();
    }

    public function update($hotel) {
        $this->db->where('id', $hotel->id);
        $this->db->update('hotel', $hotel);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('hotel');
        return $this->db->affected_rows();
    }

    public function getAllByLocationId($id) {
        $this->db->where('locatieId', $id);
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('hotel');
        $hotels = $query->result();

        //Model laden om OO te programmeren
        $this->load->model('locatie_model');

        //OO Land gegevens in Locatie zetten
        foreach ($hotels as $hotel) {
            $hotel->locatie = $this->locatie_model->get($hotel->locatieId);
        }
        return $hotels;
    }

}
