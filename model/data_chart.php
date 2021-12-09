<?php

class data{


    public function __construct()
    {
        $this->database = new db();
    }

    public function reporte_estatus()
    {

        $this->database->query("SELECT COUNT(Folio_Registro)Folios,C.Descripcion Campus
        FROM Datos_Alumnos DA
        INNER JOIN Campus C ON C.Id_Campus=DA.Id_Campus
        WHERE C.Activo=1 
        AND DA.Fecha_Registro>DATE(DATE_SUB(NOW(),INTERVAL 8 DAY))
        GROUP BY C.Descripcion");
        
        $this->database->execute();

        return $this->database->resultset();
        $this->database = null;
    }
    public function reporte_estatusxml()
    {

        $this->database->query("SELECT COUNT(Folio_Registro)Folios,C.Descripcion Campus
        FROM Datos_Alumnos DA
        INNER JOIN Campus C ON C.Id_Campus=DA.Id_Campus
        WHERE C.Activo=1 AND DA.Id_Estatus NOT IN (1,2)
        AND DA.Fecha_Registro>DATE(DATE_SUB(NOW(),INTERVAL 8 DAY))
        GROUP BY C.Descripcion");
        
        $this->database->execute();

        return $this->database->resultset();
        $this->database = null;
    }

    public function registros_totales()
    {

        $this->database->query("SELECT COUNT(Folio_Registro)Folios
        FROM Datos_Alumnos DA
        INNER JOIN Campus C ON C.Id_Campus=DA.Id_Campus
        WHERE C.Activo=1");
        
        $this->database->execute();

        return $this->database->single();
        $this->database = null;
    }

    public function registros_totales_xml()
    {

        $this->database->query("SELECT COUNT(Folio_Registro)Folios
        FROM Datos_Alumnos DA
        INNER JOIN Campus C ON C.Id_Campus=DA.Id_Campus
        WHERE C.Activo=1 AND DA.Id_Estatus NOT IN (1,2)");
        
        $this->database->execute();

        return $this->database->single();
        $this->database = null;
    }

}