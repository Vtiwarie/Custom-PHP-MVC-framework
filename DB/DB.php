<?php

class DB extends PDO {

    protected $query;
    protected $table;
    protected $errorMessages = array();

    public function submitQuery() {

        $stmt = $this->query($this->query);

        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->table);

        $result = $stmt->fetchAll();

        if (empty($result))
            return false;

        return $result;
    }

    public function setTable($table) {
    

        try {
            $this->table = (class_exists($table)) ? $table : '';
            if($this->table !== '')
                return;
            
        } catch (Exception $e) {
            $this->table = strtolower($table);
            $this->table = explode('_', $table);

            foreach ($this->table AS &$v)
                $v = ucfirst($v);
            $this->table = (implode('_', ($this->table)));

            if ($this->table[strlen($this->table) - 1] == 's')
                $this->table = substr($this->table, 0, -1);
        }

    }

    public function select($table, $fields = '*', $where = '1=1', $order = 'id', $limit = '', $desc = false, $limitBegin = 0, $groupby = null) {
        $this->setTable($table);
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
        $this->setTable($table);

        $stmt = $this->query($this->query);

        if ($stmt->rowCount() <= 0)
            return false;

        return $this;
    }

    public function update($table, $data, $where) {
        $this->setTable($table);

        if (is_array($data)) {
            $update = array();
            foreach ($data as $key => $val) {
                $update[] .= $key . '=\'' . $val . '\'';
            }

            $this->query = 'UPDATE ' . $table . ' SET ' . implode(',', $update) . ' WHERE ' . $where;

            $stmt = $this->query($this->query);
            if ($stmt->rowCount() <= 0)
                return false;

            return $this;
        }
    }

    public function Delete($table, $where = 'id=0') {
        $this->setTable($table);

        $this->query = 'DELETE FROM ' . $table . ' WHERE ' . $where;
        $stmt = $this->query($this->query);
        if ($stmt->rowCount() <= 0)
            return false;

        return $this;
    }

    public function truncate($table) {
        $this->query = 'TRUNCATE TABLE ' . $table;

        $stmt = $this->query($this->query);
        if ($stmt->rowCount() <= 0)
            return false;

        return $this;
    }

}

?>
