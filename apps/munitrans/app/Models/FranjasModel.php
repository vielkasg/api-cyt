<?php

namespace App\Models;

use CodeIgniter\Model;

class FranjasModel extends Model
{
    protected $table = 'tru_mfranjas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [];

    public function getAllFranjas($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        $builder = $this->db->table($this->table . ' m');
        $builder->select('m.id, m.cod, m.nombre, m.cedula, m.ruta, m.ficha')
            ->where('m.stad', 1)
            ->limit($perPage, $offset);

        return [
            'data' => $builder->get()->getResultArray(),
            'total' => $this->getTotalFranjas(),
            'perPage' => $perPage,
            'currentPage' => $page
        ];
    }

    public function getFranjaById($id)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }

    public function getFranjasByFilter($filter)
    {
        $builder = $this->db->table($this->table . ' m');
        $builder->select('m.id, m.cod, m.nombre, m.cedula, m.ruta, m.ficha')
            ->where('m.stad', 1)
            ->where($filter);

        return $builder->get()->getResultArray();
    }

    public function getCatalogoRutas()
    {
        $query = "SELECT clave as cod, nombre FROM tru_cat_rutas";
        return $this->db->query($query)->getResultArray();
    }

    public function getTotalFranjas()
    {
        return $this->db->table($this->table)
            ->where('stad', 1)
            ->countAllResults();
    }
}
