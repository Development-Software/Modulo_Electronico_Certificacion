<?php

class campus
{
    private $database;
    private $idCampus;
    private $estatus_campus;
    private $idusuario;
    private $estatus_usuario;

    public function __construct()
    {
        $this->database = new db();
    }
    public function setIdCampus($idCampus)
    {
        $this->idCampus = $idCampus;
    }
    public function setidUsuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }
    public function setEstatusUsuario($estatus_usuario)
    {
        $this->estatus_usuario = $estatus_usuario;
    }
    public function setEstatusCampus($estatus_campus)
    {
        $this->estatus_campus = $estatus_campus;
    }
    public function getIdCampus()
    {
        return $this->idCampus;
    }
    public function getidUsuario()
    {
        return $this->idusuario;
    }
    public function getEstautsCampus()
    {
        return $this->estatus_campus;
    }
    public function getEstatusUsuario()
    {
        return $this->estatus_usuario;
    }

    public function getReporteCampus()
    {

        $this->database->query("SELECT DISTINCT A.Id_Campus,A.Descripcion Campus,COUNT(B.idUsuario) Usuarios 
        FROM Campus A
        LEFT JOIN Usuarios_Campus B ON B.idCampus=A.Id_Campus
        WHERE Activo=1
        GROUP BY A.Id_Campus,A.Descripcion
        ORDER BY 1;");

        $this->database->execute();

        return $this->database->resultset();
        $this->database = null;
    }
    public function getReporteCampusUsuario()
    {

        $this->database->query("SELECT A.idUsuario,concat(A.Nombre,\" \",A.Apellido_Paterno,\" \",A.Apellido_Materno) Nombre,A.Correo
        FROM Usuarios A
        WHERE A.Activo=1 AND A.idUsuario NOT IN (SELECT DISTINCT idUsuario
        FROM Usuarios_Campus
        WHERE idCampus=:idCampus)
        ORDER BY 1;");
        $this->database->bind(':idCampus', $this->getIdCampus());
        $this->database->execute();

        return $this->database->resultset();
        $this->database = null;
    }

    public function getReporteCampusasignado()
    {

        $this->database->query("SELECT A.idUsuario,concat(A.Nombre,\" \",A.Apellido_Paterno,\" \",A.Apellido_Materno) Nombre,A.Correo
        FROM Usuarios A
        WHERE A.Activo=1 AND A.idUsuario IN (SELECT DISTINCT idUsuario
        FROM Usuarios_Campus
        WHERE idCampus=:idCampus)
        ORDER BY 1;");
        $this->database->bind(':idCampus', $this->getIdCampus());
        $this->database->execute();

        return $this->database->resultset();
        $this->database = null;
    }
    public function getInsertCampusUsuario()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("INSERT INTO Usuarios_Campus VALUES (:idCampus,:idUsuario);");
			$this->database->bind(':idCampus', $this->getIdCampus());
			$this->database->bind(':idUsuario', $this->getidUsuario());
			$this->database->execute();

			if ($this->database->endTransaction()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			$this->database->cancelTransaction();
			return false;
		}
    }

    public function getdeleteCampusUsuario()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("DELETE FROM mecv2.Usuarios_Campus WHERE idCampus=:idCampus AND idUsuario=:idUsuario;");
			$this->database->bind(':idCampus', $this->getIdCampus());
			$this->database->bind(':idUsuario', $this->getidUsuario());
			$this->database->execute();

			if ($this->database->endTransaction()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			$this->database->cancelTransaction();
			return false;
		}
    }
    
    public function getReporteCampusxUsuario()
    {

        $this->database->query("SELECT A.idCampus
        FROM Usuarios_Campus A
        INNER JOIN Campus B ON B.Id_Campus=A.idCampus 
        INNER JOIN Usuarios C ON C.idUsuario=A.idUsuario
        WHERE B.Activo=1 AND C.Activo=1
        AND A.idUsuario=:idUsuario        
        ORDER BY 1;");
        $this->database->bind(':idUsuario', $this->getidUsuario());
        $this->database->execute();

        return $this->database->resultset();
        $this->database = null;
    }

    public function getvalidacampus()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT DISTINCT idCampus FROM Usuarios_Campus WHERE idUsuario=:idUsuario AND IdCampus=:IdCampus ;");
            $this->database->bind(':idUsuario', $this->getidUsuario());
            $this->database->bind(':IdCampus', $this->getIdCampus());
            $this->database->execute();
            if ($this->database->endTransaction()) {
                if ($this->database->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }

                $this->database = null;
            }
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }
}
