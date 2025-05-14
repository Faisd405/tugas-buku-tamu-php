<?php

require_once 'config/koneksi.php';
require_once 'app/models/GuestEntry.php';
require_once 'app/utils/helpers.php';

class GuestEntryController
{
    private $model;
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();

        $this->model = new GuestEntry($this->conn);
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getAll($request = null)
    {
        return $this->model->readAll($request);
    }

    public function findById($id)
    {
        return $this->model->readOne($id);
    }

    public function create($data)
    {
        $errors = $this->validateGuestData($data);
        if (!empty($errors)) {
            return $errors;
        }
        
        if ($this->model->create($data['nama'], $data['instansi'], $data['tujuan'], $data['tanggal'], $data['waktu'])) {
            return true;
        }

        return false;
    }

    public function update($id, $data)
    {
        $errors = $this->validateGuestData($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->model->update($id, $data['nama'], $data['instansi'], $data['tujuan'])) {
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return true;
        }

        return false;
    }

    public function validateGuestData($data)
    {
        $errors = [];

        if (empty(trim($data['nama']))) {
            $errors[] = "Silakan masukkan nama";
        }

        if (empty(trim($data['instansi']))) {
            $errors[] = "Silakan masukkan instansi";
        }

        if (empty(trim($data['tujuan']))) {
            $errors[] = "Silakan masukkan tujuan kunjungan";
        }

        return $errors;
    }

    public function formatAlert($message, $type = 'info')
    {
        return showAlert($message, $type);
    }

    public function formatDate($date)
    {
        return date('d F Y', strtotime($date));
    }

    public function processFormData($formData, $isUpdate = false)
    {
        $data = [
            'nama' => trim($formData['nama'] ?? ''),
            'instansi' => trim($formData['instansi'] ?? ''),
            'tujuan' => trim($formData['tujuan'] ?? ''),
        ];

        if (!$isUpdate) {
            $data['tanggal'] = date('Y-m-d');
            $data['waktu'] = date('H:i:s');
        }

        return $data;
    }
}
