<?php

class funciones_alumnos
{

    private $idUsuario;
    private $idEstatus;

    public function __construct()
    {
        $this->database = new db();
    }

    public function setidUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function setidEstatus($idEstatus)
    {
        $this->idEstatus = $idEstatus;
    }

    public function getidUsuario()
    {
        return $this->idUsuario;
    }

    public function getidEstatus()
    {
        return $this->idEstatus;
    }

    public function getRegistrosUser()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Folio_Registro FROM Datos_Alumnos WHERE Id_Estatus=1 AND Id_Usuario=:idParametro");
            $this->database->bind(':idParametro', $this->idUsuario);
            $this->database->execute();
            if ($this->database->endTransaction()) {
                if ($this->database->rowCount() > 0) {
                    return 1;
                } else {
                    return 0;
                }

                $this->database = null;
            }
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function query_alumnos()
    {
        try {
            $this->database->query("SELECT(@row_number:=@row_number + 1) AS Id,Q1.Folio_Registro,Q1.CURP ,Q1.Matricula,Q1.Nombre,Q1.Campus,Q1.Clave_Carrera,Q1.Nombre_Carrera,CASE WHEN Q1.Creditos_Totales<=Q1.T_Creditos THEN 'Total' ELSE 'Parcial' END Tipo_Certificado,Q1.Username,Q1.Fecha_Registro,Q1.Fecha_XML
            FROM (
            SELECT A.Folio_Registro,A.CURP,A.Matricula,concat(A.Nombre,\" \",A.Apellido_Paterno,\" \",A.Apellido_Materno) as Nombre,X.Descripcion as Campus,Y.Clave_Carrera,Y.Descripcion as Nombre_Carrera, sum(T.Creditos) T_Creditos, T.Creditos_Totales,F.Username,A.Fecha_Registro,XM.Fecha_Registro AS Fecha_XML
    FROM Datos_Alumnos A
    INNER JOIN Datos_Materias DM ON DM.Id_Folio=A.Folio_Registro AND DM.Matricula=A.Matricula
    INNER JOIN (SELECT DISTINCT  P.Id_Institucion,P.Id_Campus,P.Id_Carrera,P.RVOE,P.Creditos_Totales,P.Anio_Plan,P.Id_Materia,P.Id_Tipo_Asignatura,P.Creditos,P.Id_Periodo
                        FROM Plan_Estudios P
                        INNER JOIN Institucion I ON I.Id_Institucion=P.Id_Institucion
                        INNER JOIN Campus C ON C.Id_Campus=P.Id_Campus AND C.Id_Institucion=I.Id_Institucion
                        INNER JOIN Carreras CA ON CA.Id_Carrera=P.Id_Carrera AND CA.Id_Institucion=I.Id_Institucion
                        INNER JOIN RVOE R ON R.RVOE=P.RVOE AND R.Id_Institucion=I.Id_Institucion
                        INNER JOIN Materias M ON M.Id_Materia=P.Id_Materia AND M.Id_Institucion=I.Id_Institucion
                        WHERE I.Activo=1 AND C.Activo=1 AND CA.Activo=1 AND R.Activo=1 AND M.Activo=1) T ON T.Id_Institucion=A.Id_Institucion AND T.Id_Campus=A.Id_Campus AND T.Id_Carrera=A.Id_Carrera AND T.Id_Materia=DM.Id_Materia AND T.Anio_Plan=A.Anio_Plan
    INNER JOIN Campus X ON X.Id_Campus=T.Id_Campus
    INNER JOIN Carreras Y ON Y.Id_Carrera=T.Id_Carrera
    INNER JOIN Usuarios F ON F.idUsuario=A.Id_Usuario
    LEFT JOIN XML_Firmados XM ON XM.Id_Registro=A.Folio_Registro
    WHERE A.Id_Estatus =:Id_Estatus AND  (1=(SELECT COUNT(*) ID FROM Datos_Alumnos WHERE Id_Usuario=:idUsuario ) OR 1= ( SELECT COUNT(*) ID FROM Usuarios YY INNER JOIN Roles ZZ ON ZZ.idRol=YY.idRol WHERE ZZ.Administrador=1 AND YY.idUsuario=:idUsuario ))
    GROUP BY A.Folio_Registro,A.CURP,A.Matricula,A.Nombre,A.Apellido_Paterno,A.Apellido_Materno,X.Descripcion,Y.Clave_Carrera,Y.Descripcion, T.Creditos_Totales
    ORDER BY A.Fecha_Registro
            )Q1,(SELECT @row_number:=0) AS Q2");

            $this->database->bind(':idUsuario', $this->idUsuario);
            $this->database->bind(':Id_Estatus', $this->idEstatus);
            $this->database->execute();
            if ($this->database->rowCount() > 0) {
                return $this->database->resultset();
                $this->database = null;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function delete_registros($idRegistro)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("DELETE FROM Datos_Alumnos WHERE Folio_Registro = :idRegistro");
            $this->database->bind(':idRegistro', $idRegistro);
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
    public function update_registros($idEstatus, $idRegistro)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("UPDATE Datos_Alumnos SET Id_Estatus=:idEstatus WHERE Folio_Registro = :idRegistro");
            $this->database->bind(':idRegistro', $idRegistro);
            $this->database->bind(':idEstatus', $idEstatus);
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

    public function query_firma()
    {
        try {
            $this->database->query("SELECT(@row_number:=@row_number + 1) AS Id,Q1.Folio_Registro,Q1.CURP ,Q1.Matricula,Q1.Nombre,Q1.Campus,Q1.Clave_Carrera,Q1.Nombre_Carrera,CASE WHEN Q1.Creditos_Totales<=Q1.T_Creditos THEN 'Total' ELSE 'Parcial' END Tipo_Certificado,Q1.Username,Q1.Fecha_Registro,Q1.Fecha_XML
            FROM (
            SELECT A.Folio_Registro,A.CURP,A.Matricula,concat(A.Nombre,\" \",A.Apellido_Paterno,\" \",A.Apellido_Materno) as Nombre,X.Descripcion as Campus,Y.Clave_Carrera,Y.Descripcion as Nombre_Carrera, sum(T.Creditos) T_Creditos, T.Creditos_Totales,F.Username,A.Fecha_Registro,XM.Fecha_Registro AS Fecha_XML
    FROM Datos_Alumnos A
    INNER JOIN Datos_Materias DM ON DM.Id_Folio=A.Folio_Registro AND DM.Matricula=A.Matricula
    INNER JOIN (SELECT DISTINCT  P.Id_Institucion,P.Id_Campus,P.Id_Carrera,P.RVOE,P.Creditos_Totales,P.Anio_Plan,P.Id_Materia,P.Id_Tipo_Asignatura,P.Creditos,P.Id_Periodo
                        FROM Plan_Estudios P
                        INNER JOIN Institucion I ON I.Id_Institucion=P.Id_Institucion
                        INNER JOIN Campus C ON C.Id_Campus=P.Id_Campus AND C.Id_Institucion=I.Id_Institucion
                        INNER JOIN Carreras CA ON CA.Id_Carrera=P.Id_Carrera AND CA.Id_Institucion=I.Id_Institucion
                        INNER JOIN RVOE R ON R.RVOE=P.RVOE AND R.Id_Institucion=I.Id_Institucion
                        INNER JOIN Materias M ON M.Id_Materia=P.Id_Materia AND M.Id_Institucion=I.Id_Institucion
                        WHERE I.Activo=1 AND C.Activo=1 AND CA.Activo=1 AND R.Activo=1 AND M.Activo=1) T ON T.Id_Institucion=A.Id_Institucion AND T.Id_Campus=A.Id_Campus AND T.Id_Carrera=A.Id_Carrera AND T.Id_Materia=DM.Id_Materia AND T.Anio_Plan=A.Anio_Plan
    INNER JOIN Campus X ON X.Id_Campus=T.Id_Campus
    INNER JOIN Carreras Y ON Y.Id_Carrera=T.Id_Carrera
    INNER JOIN Usuarios F ON F.idUsuario=A.Id_Usuario
    LEFT JOIN XML_Firmados XM ON XM.Id_Registro=A.Folio_Registro
    WHERE A.Id_Estatus=:Id_Estatus
    GROUP BY A.Folio_Registro,A.CURP,A.Matricula,A.Nombre,A.Apellido_Paterno,A.Apellido_Materno,X.Descripcion,Y.Clave_Carrera,Y.Descripcion, T.Creditos_Totales
    ORDER BY A.Fecha_Registro
            )Q1,(SELECT @row_number:=0) AS Q2");

            $this->database->bind(':Id_Estatus', $this->idEstatus);
            $this->database->execute();
            if ($this->database->rowCount() > 0) {
                return $this->database->resultset();
                $this->database = null;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function consulta_xml($id_folio)
    {
        try {
            $this->database->query("SELECT Id_Registro,XML,Fecha_Registro FROM XML_Firmados WHERE Id_Registro= :Id_Registro");

            $this->database->bind(':Id_Registro', $id_folio);
            $this->database->execute();
            if ($this->database->rowCount() > 0) {
                return $this->database->resultset();
                $this->database = null;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function query_alumnos_descarga()
    {
        try {
            $this->database->query("SELECT(@row_number:=@row_number + 1) AS Id,Q1.Folio_Registro,Q1.CURP ,Q1.Matricula,Q1.Nombre,Q1.Campus,Q1.Clave_Carrera,Q1.Nombre_Carrera,CASE WHEN Q1.Creditos_Totales<=Q1.T_Creditos THEN 'Total' ELSE 'Parcial' END Tipo_Certificado,Q1.Username,Q1.Fecha_Registro,Q1.Fecha_XML
            FROM (
            SELECT A.Folio_Registro,A.CURP,A.Matricula,concat(A.Nombre,\" \",A.Apellido_Paterno,\" \",A.Apellido_Materno) as Nombre,X.Descripcion as Campus,Y.Clave_Carrera,Y.Descripcion as Nombre_Carrera, sum(T.Creditos) T_Creditos, T.Creditos_Totales,F.Username,A.Fecha_Registro,XM.Fecha_Registro AS Fecha_XML
    FROM Datos_Alumnos A
    INNER JOIN Datos_Materias DM ON DM.Id_Folio=A.Folio_Registro AND DM.Matricula=A.Matricula
    INNER JOIN (SELECT DISTINCT  P.Id_Institucion,P.Id_Campus,P.Id_Carrera,P.RVOE,P.Creditos_Totales,P.Anio_Plan,P.Id_Materia,P.Id_Tipo_Asignatura,P.Creditos,P.Id_Periodo
                        FROM Plan_Estudios P
                        INNER JOIN Institucion I ON I.Id_Institucion=P.Id_Institucion
                        INNER JOIN Campus C ON C.Id_Campus=P.Id_Campus AND C.Id_Institucion=I.Id_Institucion
                        INNER JOIN Carreras CA ON CA.Id_Carrera=P.Id_Carrera AND CA.Id_Institucion=I.Id_Institucion
                        INNER JOIN RVOE R ON R.RVOE=P.RVOE AND R.Id_Institucion=I.Id_Institucion
                        INNER JOIN Materias M ON M.Id_Materia=P.Id_Materia AND M.Id_Institucion=I.Id_Institucion) T ON T.Id_Institucion=A.Id_Institucion AND T.Id_Campus=A.Id_Campus AND T.Id_Carrera=A.Id_Carrera AND T.Id_Materia=DM.Id_Materia AND T.Anio_Plan=A.Anio_Plan
    INNER JOIN Campus X ON X.Id_Campus=T.Id_Campus
    INNER JOIN Carreras Y ON Y.Id_Carrera=T.Id_Carrera
    INNER JOIN Usuarios F ON F.idUsuario=A.Id_Usuario
    LEFT JOIN XML_Firmados XM ON XM.Id_Registro=A.Folio_Registro
    WHERE A.Id_Estatus in (3,4) AND  (1=(SELECT COUNT(*) ID FROM Datos_Alumnos WHERE Id_Usuario=:idUsuario ) OR 1= ( SELECT COUNT(*) ID FROM Usuarios YY INNER JOIN Roles ZZ ON ZZ.idRol=YY.idRol WHERE ZZ.Administrador=1 AND YY.idUsuario=:idUsuario) )
    GROUP BY A.Folio_Registro,A.CURP,A.Matricula,A.Nombre,A.Apellido_Paterno,A.Apellido_Materno,X.Descripcion,Y.Clave_Carrera,Y.Descripcion, T.Creditos_Totales
    ORDER BY A.Fecha_Registro DESC
            )Q1,(SELECT @row_number:=0) AS Q2");

            $this->database->bind(':idUsuario', $this->idUsuario);
            $this->database->execute();
            if ($this->database->rowCount() > 0) {
                return $this->database->resultset();
                $this->database = null;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function delete_registros_xml($idRegistro)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("DELETE FROM Datos_Alumnos WHERE Folio_Registro = :idRegistro");
            $this->database->bind(':idRegistro', $idRegistro);
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
