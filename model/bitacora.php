<?php

class bitacora{

    public function __construct()
    {
        $this->database = new db();
    }

    public function registro_bitacora($idUsuario,$menu,$descripcion)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Auditoria VALUES (:idUsuario,:menu,:descripcion,current_timestamp());");
            $this->database->bind(':idUsuario', $idUsuario);
            $this->database->bind(':menu', $menu);
            $this->database->bind(':descripcion', $descripcion);
            $this->database->execute();
            if ($this->database->endTransaction()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            //Rollback de la transacción.
            $this->database->cancelTransaction();
            return false;
        }
    }



}