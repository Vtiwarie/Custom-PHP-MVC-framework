<?php

class DB extends PDO {

    protected $query;
    protected $table;
    protected $errorMessages = array();

    public function submitQuery() {

        $stmt = $this->query($this->query);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->table);

        $result = $stmt->fetchAll();


        return $result;
    }

    public function select($table, $fields = '*', $where = '1=1', $order = 'id', $limit = '', $desc = false, $limitBegin = 0, $groupby = null) {
        $this->table = ucfirst(substr($table, 0, -1));
        $this->query = 'SELECT ' . $fields . ' FROM ' . $table . ' WHERE ' . $where;

        if (!empty($groupby)) {
            $this->query .= ' GROUP BY ' . $groupby;
        }

        if (!empty($order)) {
            $this->query .= ' ORDER BY ' . $order;

            if ($desc) {
                $this->query .= ' DESC';
            }
        }

        if (!empty($limit)) {
            $this->query .= ' LIMIT ' . $limitBegin . ', ' . $limit;
        }

        return $this;
    }

    public function insert($table, array $objects) {
        $this->query = 'INSERT INTO ' . $table . ' ( ' . implode(',', array_keys($objects)) . ' ) VALUES(\'' . implode('\',\'', $objects) . '\')';
        $this->table = ucfirst(substr($table, 0, -1));
        return $this;
    }

    public function update($table, $data, $where) {
        $this->table = ucfirst(substr($table, 0, -1));

        if (is_array($data)) {
            $update = array();
            foreach ($data as $key => $val) {
                $update[] .= $key . '=\'' . $val . '\'';
            }

            $this->query = 'UPDATE ' . $table . ' SET ' . implode(',', $update) . ' WHERE ' . $where;

            return this;
        }
    }

    public function Delete() {
        
    }

    public function truncate() {
        
    }

}

?>
