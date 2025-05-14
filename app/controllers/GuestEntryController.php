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

        if ($this->model->update($id, $data['nama'], $data['instansi'], $data['tujuan'], $data['tanggal'], $data['waktu'])) {
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

        if (empty($data['tanggal'])) {
            $errors[] = "Silakan pilih tanggal kunjungan";
        }
        
        if (empty($data['waktu'])) {
            $errors[] = "Silakan masukkan waktu kunjungan";
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
        if (!$isUpdate) {
            $formData['tanggal'] = date('Y-m-d');
            $formData['waktu'] = date('H:i:s');
        } else {
            $formData['tanggal'] = date('Y-m-d', strtotime($formData['tanggal']));
            $formData['waktu'] = date('H:i:s', strtotime($formData['waktu']));
        }

        return [
            'nama' => trim($formData['nama'] ?? ''),
            'instansi' => trim($formData['instansi'] ?? ''),
            'tujuan' => trim($formData['tujuan'] ?? ''),
            'tanggal' => $formData['tanggal'] ?? '',
            'waktu' => $formData['waktu'] ?? ''
        ];
    }
}
