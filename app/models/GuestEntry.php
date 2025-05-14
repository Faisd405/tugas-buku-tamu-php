<?php

class GuestEntry
{
    private $conn;
    private $table_name = 'buku_tamu';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll($request)
    {
        $query = "SELECT * FROM " . $this->table_name;

        if (isset($request['search']) && !empty($request['search'])) {
            $query .= " WHERE nama LIKE ? OR instansi LIKE ?";
        }
        $query .= " ORDER BY tanggal DESC, waktu DESC";

        $stmt = $this->conn->prepare($query);
        
        if (isset($request['search']) && !empty($request['search'])) {
            $keyword = "%" . $request['search'] . "%";
            $stmt->bind_param("ss", $keyword, $keyword);
        }

        $stmt->execute();

        $result = $stmt->get_result();
        
        $entries = [];

        while ($row = $result->fetch_assoc()) {
            $entries[] = $row;
        }

        $stmt->close();

        return $entries;
    }

    public function searchEntries($keyword)
    {
        $keyword = "%{$keyword}%";
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE nama LIKE ? OR instansi LIKE ? ORDER BY tanggal DESC, waktu DESC");

        $stmt->bind_param("ss", $keyword, $keyword);

        $stmt->execute();

        $result = $stmt->get_result();
        
        $entries = [];

        while ($row = $result->fetch_assoc()) {
            $entries[] = $row;
        }

        $stmt->close();

        return $entries;
    }

    public function readOne($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1");

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $entry = $result->fetch_assoc();

        $stmt->close();

        return $entry;
    }

    public function create($nama, $instansi, $tujuan, $tanggal, $waktu)
    {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " SET nama=?, instansi=?, tujuan=?, tanggal=?, waktu=?");

        $stmt->bind_param("sssss", $nama, $instansi, $tujuan, $tanggal, $waktu);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function update($id, $nama, $instansi, $tujuan)
    {
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET nama=?, instansi=?, tujuan=? WHERE id=?");

        $stmt->bind_param("sssi", $nama, $instansi, $tujuan, $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = ?");

        $stmt->bind_param("i", $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
