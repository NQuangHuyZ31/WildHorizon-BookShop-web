<?php 

namespace App\Models;

use App\Models\Model;

class FlashSales extends Model{

  protected $table = 'flashsales';
  protected $primary_key = 'flashsale_id';

  public function getAll(){

    $query = "SELECT *FROM $this->table f JOIN products p ON f.product_id = p.product_id";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  public function find($id){

    $query = "SELECT *FROM flashsales WHERE product_id = ?";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(1,$id);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function getLimit($limit,$offset){

    $query = "SELECT *FROM $this->table f JOIN products p ON f.product_id = p.product_id LIMIT $limit OFFSET $offset";

    $stmt = $this->db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function searchKeyword($keyword){

    $query = "SELECT p.product_id,name,price,image,discount_price,quantity FROM $this->table f 
              JOIN products p ON f.product_id = p.product_id WHERE name LIKE :keyword";

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(':keyword','%'.$keyword.'%');

    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);

  }

}