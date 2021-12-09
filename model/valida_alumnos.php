<?php

class Alumno
{
    public $database;
    public $Folio;
    public $Id_Institucion; //Se valida contra table Institucion
    public $Id_Campus; //Se valida contra table campus
    public $Id_Oferta_Académica; //(id_carrera)Se valida contra table Carreras
    public $Anio_Plan;
    public $CURP_Alumno;
    public $Matricula_Alumno;
    public $Nombre_Alumno;
    public $Apellido_Paterno_Alumno;
    public $Apellido_Materno_Alumno;
    public $Fecha_Nacimiento_Alumno;
    public $Id_Entidad_Federativa; //Se valida contra table Entidades (SEP)
    public $Id_Genero_Alumno; //Se valida contra table Genero (SEP)
    public $Id_Materia; //Se valida contra table Materias
    public $Id_Observacion_Materia; //Se valida contra table Observaciones (SEP)
    public $Ciclo_Materia;
    public $Calificacion_Materia;
    public $Id_Entidad_Federativa_Expedicion;
    public $Fecha_Expedicion;
    public $userid;

    public function __construct()
    {
        $this->database = new db();
    }

    public function setFolioRegistro($Folio)
    {
        return $this->Folio = $Folio;
    }

    public function setIdInstitucion($Id_Institucion)
    {
        return $this->Id_Institucion = $Id_Institucion;
    }
    public function setIdCampus($Id_Campus)
    {
        return $this->Id_Campus = $Id_Campus;
    }
    public function setIdOfertaAcadémica($Id_Oferta_Académica)
    {
        return $this->Id_Oferta_Académica = $Id_Oferta_Académica;
    }
    public function setAnio_Plan($Anio_Plan)
    {
        return $this->Anio_Plan = $Anio_Plan;
    }
    public function setCURP($CURP_Alumno)
    {
        return $this->CURP_Alumno = $CURP_Alumno;
    }
    public function setMatricula($Matricula_Alumno)
    {
        return $this->Matricula_Alumno = $Matricula_Alumno;
    }
    public function setNombre($Nombre_Alumno)
    {
        return $this->Nombre_Alumno = $Nombre_Alumno;
    }
    public function setApellidoP($Apellido_Paterno_Alumno)
    {
        return $this->Apellido_Paterno_Alumno = $Apellido_Paterno_Alumno;
    }
    public function setApellidoM($Apellido_Materno_Alumno)
    {
        return $this->Apellido_Materno_Alumno = $Apellido_Materno_Alumno;
    }
    public function setFechaN($Fecha_Nacimiento_Alumno)
    {
        return $this->Fecha_Nacimiento_Alumno = $Fecha_Nacimiento_Alumno;
    }
    public function setIdEntidadFederativa($Id_Entidad_Federativa)
    {
        return $this->Id_Entidad_Federativa = $Id_Entidad_Federativa;
    }
    public function setIdGeneroAlumno($Id_Genero_Alumno)
    {
        return $this->Id_Genero_Alumno = $Id_Genero_Alumno;
    }
    public function setIdMateria($Id_Materia)
    {
        return $this->Id_Materia = $Id_Materia;
    }
    public function setIdObservacionMateria($Id_Observacion_Materia)
    {
        return $this->Id_Observacion_Materia = $Id_Observacion_Materia;
    }
    public function setCiclo($Ciclo_Materia)
    {
        return $this->Ciclo_Materia = $Ciclo_Materia;
    }
    public function setCalificacion($Calificacion_Materia)
    {
        return $this->Calificacion_Materia = $Calificacion_Materia;
    }
    public function setEntidadExp($Id_Entidad_Federativa_Expedicion)
    {
        return $this->Id_Entidad_Federativa_Expedicion = $Id_Entidad_Federativa_Expedicion;
    }
    public function setFechaExp($Fecha_Expedicion)
    {
        return $this->Fecha_Expedicion = $Fecha_Expedicion;
    }
    public function setUser($userid)
    {
        return $this->userid = $userid;
    }

    public function getFolio_Registro()
    {
        return $this->Folio;
    }
    public function getIdInstitucion()
    {
        return $this->Id_Institucion;
    }
    public function getIdCampus()
    {
        return $this->Id_Campus;
    }
    public function getIdOfertaAcadémica()
    {
        return $this->Id_Oferta_Académica;
    }
    public function getAnioPlan()
    {
        return $this->Anio_Plan;
    }
    public function getCURP()
    {
        return $this->CURP_Alumno;
    }
    public function getMatricula()
    {
        return $this->Matricula_Alumno;
    }
    public function getNombre()
    {
        return $this->Nombre_Alumno;
    }
    public function getApellidoP()
    {
        return $this->Apellido_Paterno_Alumno;
    }
    public function getApellidoM()
    {
        return $this->Apellido_Materno_Alumno;
    }
    public function getFechaN()
    {
        return $this->Fecha_Nacimiento_Alumno;
    }

    public function getIdEntidadFederativa()
    {
        return $this->Id_Entidad_Federativa;
    }
    public function getIdGeneroAlumno()
    {
        return $this->Id_Genero_Alumno;
    }
    public function getIdMateria()
    {
        return $this->Id_Materia;
    }
    public function getIdObservacionMateria()
    {
        return $this->Id_Observacion_Materia;
    }
    public function getCiclo()
    {
        return $this->Ciclo_Materia;
    }
    public function getCalificacion()
    {
        return $this->Calificacion_Materia;
    }
    public function getEntidadExp()
    {
        return $this->Id_Entidad_Federativa_Expedicion;
    }
    public function getFechaExp()
    {
        return $this->Fecha_Expedicion;
    }
    public function getUser()
    {
        return $this->userid;
    }

    public function getFolio($Folio)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Folio_Registro FROM Datos_Alumnos where Folio_Registro=:idParametro");
            $this->database->bind(':idParametro', $this->Folio = $Folio);
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

    public function getInstitucion($Id_Institucion)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Id_Institucion FROM Institucion where Activo=1 AND Id_Institucion=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Institucion = $Id_Institucion);
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
    public function getCampus($Id_Campus)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Id_Campus FROM Campus where Activo=1 AND Id_Campus=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Campus = $Id_Campus);
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
    public function getOfertaAcademica($Id_Oferta_Académica)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Id_Carrera FROM Carreras where Activo=1 AND Id_Carrera=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Oferta_Académica = $Id_Oferta_Académica);
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
    public function getEntidadF($Id_Entidad_Federativa)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT idEntidadFederativa FROM Entidad_Federativa where idEntidadFederativa=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Entidad_Federativa = $Id_Entidad_Federativa);
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
    public function getGenero($Id_Genero_Alumno)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT idGenero FROM Genero where idGenero=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Genero_Alumno = $Id_Genero_Alumno);
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
    public function getMateria($Id_Materia)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Id_Materia FROM Materias where Activo=1 AND Id_Materia=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Materia = $Id_Materia);
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
    public function getObervaciones($Id_Observacion_Materia)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT idObservaciones FROM Observaciones where idObservaciones=:idParametro");
            $this->database->bind(':idParametro', $this->Id_Observacion_Materia = $Id_Observacion_Materia);
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

    public function getPlan($Id_Carrera, $Anio_Plan)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT DISTINCT RVOE FROM Plan_Estudios WHERE Id_Carrera=:Id_Carrera AND Anio_Plan=:Anio_plan;");
            $this->database->bind(':Id_Carrera', $Id_Carrera);
            $this->database->bind(':Anio_plan', $Anio_Plan);
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

    public function registrararchivo()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO
            Datos_Alumnos (
              Folio_Registro,
              Id_Institucion,
              Id_Campus,
              Id_Carrera,
              Anio_Plan,
              CURP,
              Matricula,
              Nombre,
              Apellido_Paterno,
              Apellido_Materno,
              Fecha_Nacimiento,
              Id_Entidad_F_Alumno,
              Id_Genero,
              Id_Entidad_Exp,
              Fecha_Exp,
              Id_Estatus,
              Id_Usuario
            ) 
            VALUES (
            :folio,
            :IdInstitucion,
            :IdCampus,
            :IdOfertaAcademica,
            :Anio_Plan,
            :CURP,
            :Matricula,
            :Nombre,
            :ApellidoPaterno,
            :ApellidoMaterno,
            STR_TO_DATE(:FechaNacimiento,'%d/%m/%Y'),
            :IdEntidadFederativa,
            :IdGenero,
            :IdEntidadFederativaExpedicion,
            STR_TO_DATE(:FechaExpedicion,'%d/%m/%Y'),
            :IdEstatus,
            :IdUsuario
            );");

            $this->database->bind(':folio', $this->getFolio_Registro());
            $this->database->bind(':IdInstitucion', $this->getIdInstitucion());
            $this->database->bind(':IdCampus', $this->getIdCampus());
            $this->database->bind(':IdOfertaAcademica', $this->getIdOfertaAcadémica());
            $this->database->bind(':Anio_Plan', $this->getAnioPlan());
            $this->database->bind(':CURP', $this->getCURP());
            $this->database->bind(':Matricula', $this->getMatricula());
            $this->database->bind(':Nombre', $this->getNombre());
            $this->database->bind(':ApellidoPaterno', $this->getApellidoP());
            $this->database->bind(':ApellidoMaterno', $this->getApellidoM());
            $this->database->bind(':FechaNacimiento', $this->getFechaN());
            $this->database->bind(':IdEntidadFederativa', $this->getIdEntidadFederativa());
            $this->database->bind(':IdGenero', $this->getIdGeneroAlumno());
            $this->database->bind(':IdEntidadFederativaExpedicion', $this->getEntidadExp());
            $this->database->bind(':FechaExpedicion', $this->getFechaExp());
            $this->database->bind(':IdEstatus', 1);
            $this->database->bind(':IdUsuario', $this->getuser());
            $this->database->execute();
            if ($this->database->endTransaction()) {
                $res = array('res' => true, 'folio' => $this->getFolio_Registro());
                return $res;
            } else {
                $res = array('res' => false, 'folio' => $this->getFolio_Registro());
                return $res;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            //Rollback de la transacción.
            $this->database->cancelTransaction();
            $res = array('res' => false);
            return false;
        }
    }

    public function registrararchivoMaterias()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO
            Datos_Materias (
              Id_Folio,              
              Matricula,
              Id_Carrera,
              Id_Materia,
              Id_Observacion,
              Ciclo,
              Calificacion
            ) 
            VALUES (
            :folio,
            :Matricula,
            :IdOfertaAcademica,
            :IdMateria,
            :IdObservacionMateria,
            :CicloMateria,
            :CalificacionMateria
            )");

            $this->database->bind(':folio', $this->getFolio_Registro());
            $this->database->bind(':IdOfertaAcademica', $this->getIdOfertaAcadémica());
            $this->database->bind(':Matricula', $this->getMatricula());
            $this->database->bind(':IdMateria', $this->getIdMateria());
            $this->database->bind(':IdObservacionMateria', $this->getIdObservacionMateria());
            $this->database->bind(':CicloMateria', $this->getCiclo());
            $this->database->bind(':CalificacionMateria', $this->getCalificacion());
            $this->database->execute();
            if ($this->database->endTransaction()) {
                $res = array('res' => true);
                return true;
            } else {
                $res = array('res' => false);
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            //Rollback de la transacción.
            $this->database->cancelTransaction();
            $res = array('res' => false);
            return false;
        }
    }

    public function getDatosGenerales($idfolio)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT DISTINCT A.Folio_Registro folioControl,A.Id_Institucion,A.Id_Entidad_F_Alumno,A.Id_Campus,I.CURP_aut,I.Nombre_aut,I.Apellido_P_aut,I.Apellido_M_aut,I.Id_Cargo_aut,A.Id_Carrera,T.RVOE,R.Fecha_Registro,A.Fecha_Exp,A.Id_Entidad_Exp,Y.Clave_Carrera,T.Id_Periodo,T.Anio_Plan,Y.Id_Nivel,R.Minima,R.Maxima,R.Minima_Aprobatoria,A.CURP,A.Nombre,A.Apellido_Paterno,A.Apellido_Materno,A.Fecha_Nacimiento,A.Id_Genero,A.Matricula
            ,T.T_Materias Total_Materias,COUNT(DM.Id_Materia)Asignadas,ROUND((SUM(DM.Calificacion)/COUNT(DM.Id_Materia)),2) Promedio,CASE WHEN sum(T.Creditos)>=T.Creditos_Totales THEN 79 ELSE 80 END Tipo_Certificado,sum(T.Creditos) Creditos_Obtenidos,T.Creditos_Totales
                FROM Datos_Alumnos A
                INNER JOIN Datos_Materias DM ON DM.Id_Folio=A.Folio_Registro AND DM.Matricula=A.Matricula
                INNER JOIN (SELECT DISTINCT  P.Id_Institucion,P.Id_Campus,P.Id_Carrera,P.RVOE,P.Creditos_Totales,P.Anio_Plan,P.Id_Materia,P.Id_Tipo_Asignatura,P.Creditos,P.Id_Periodo,
									(SELECT COUNT(TM.Id_Materia) FROM Plan_Estudios TM WHERE TM.Id_Institucion=P.Id_Institucion AND TM.Id_Campus=P.Id_Campus AND TM.Id_Carrera=P.Id_Carrera AND TM.RVOE=P.RVOE AND TM.Anio_Plan=P.Anio_Plan AND TM.Id_Periodo=P.Id_Periodo) T_Materias
                                    FROM Plan_Estudios P
                                    INNER JOIN Institucion I ON I.Id_Institucion=P.Id_Institucion
                                    INNER JOIN Campus C ON C.Id_Campus=P.Id_Campus AND C.Id_Institucion=I.Id_Institucion
                                    INNER JOIN Carreras CA ON CA.Id_Carrera=P.Id_Carrera AND CA.Id_Institucion=I.Id_Institucion
                                    INNER JOIN RVOE R ON R.RVOE=P.RVOE AND R.Id_Institucion=I.Id_Institucion
                                    INNER JOIN Materias M ON M.Id_Materia=P.Id_Materia AND M.Id_Institucion=I.Id_Institucion
                                    WHERE I.Activo=1 AND C.Activo=1 AND CA.Activo=1 AND R.Activo=1 AND M.Activo=1) T ON T.Id_Institucion=A.Id_Institucion AND T.Id_Campus=A.Id_Campus AND T.Id_Carrera=A.Id_Carrera AND T.Id_Materia=DM.Id_Materia AND T.Anio_Plan=A.Anio_Plan
                INNER JOIN Institucion I ON I.Id_Institucion=T.Id_Institucion
                INNER JOIN RVOE R ON R.RVOE=T.RVOE
                INNER JOIN Campus X ON X.Id_Campus=T.Id_Campus
                INNER JOIN Carreras Y ON Y.Id_Carrera=T.Id_Carrera
                INNER JOIN Usuarios F ON F.idUsuario=A.Id_Usuario
                LEFT JOIN XML_Firmados XM ON XM.Id_Registro=A.Folio_Registro
                WHERE A.Folio_Registro=:idParametro
                GROUP BY A.Folio_Registro,A.Id_Institucion,A.Id_Entidad_F_Alumno,A.Id_Campus,I.CURP_aut,I.Nombre_aut,I.Apellido_P_aut,I.Apellido_M_aut,I.Id_Cargo_aut,A.Id_Carrera,T.RVOE,R.Fecha_Registro,A.Fecha_Exp,A.Id_Entidad_Exp,Y.Clave_Carrera,T.Id_Periodo,T.Anio_Plan,Y.Id_Nivel,R.Minima,R.Maxima,R.Minima_Aprobatoria,A.CURP,A.Nombre,A.Apellido_Paterno,A.Apellido_Materno,A.Fecha_Nacimiento,A.Matricula,T.Creditos_Totales
                ORDER BY A.Fecha_Registro
									");
            $this->database->bind(':idParametro', $idfolio);
            $this->database->execute();
            if ($this->database->endTransaction()) {
                return $this->database->resultset();
            }
            $this->database = null;
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function getMateriasAlumno($idfolio)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT DISTINCT DM.Id_Materia,A.Clave_Legal,A.Descripcion,DM.Ciclo,CASE WHEN DM.Calificacion<10 THEN CONVERT(DM.Calificacion,DECIMAL(3,2)) ELSE DM.Calificacion END Calificacion,T.Creditos,DM.Id_Observacion,T.Id_Tipo_Asignatura
            FROM (SELECT DISTINCT  P.Id_Institucion,P.Id_Campus,P.Id_Carrera,P.RVOE,P.Creditos_Totales,P.Anio_Plan,P.Id_Materia,P.Id_Tipo_Asignatura,P.Creditos,P.Id_Periodo
                                    FROM Plan_Estudios P
                                    INNER JOIN Institucion I ON I.Id_Institucion=P.Id_Institucion
                                    INNER JOIN Campus C ON C.Id_Campus=P.Id_Campus AND C.Id_Institucion=I.Id_Institucion
                                    INNER JOIN Carreras CA ON CA.Id_Carrera=P.Id_Carrera AND CA.Id_Institucion=I.Id_Institucion
                                    INNER JOIN RVOE R ON R.RVOE=P.RVOE AND R.Id_Institucion=I.Id_Institucion
                                    INNER JOIN Materias M ON M.Id_Materia=P.Id_Materia AND M.Id_Institucion=I.Id_Institucion
                                    WHERE I.Activo=1 AND C.Activo=1 AND CA.Activo=1 AND R.Activo=1 AND M.Activo=1) T
            INNER JOIN Datos_Materias DM ON DM.Id_Materia=T.Id_Materia
            INNER JOIN Materias A ON A.Id_Institucion=T.Id_Institucion AND A.Id_Materia=DM.Id_Materia
            INNER JOIN Observaciones B ON B.idObservaciones=DM.Id_Observacion
            WHERE DM.Id_Folio=:idParametro");
            $this->database->bind(':idParametro', $idfolio);
            $this->database->execute();
            if ($this->database->endTransaction()) {
                
                return $this->database->resultset();
            }
            $this->database = null;
        } catch (PDOException $e) {
            echo 'ERROR!';
            print_r($e);
        }
    }

    public function addXML($idfolio, $xml)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO
            XML_Firmados (
              Id_Registro,
			  XML
            ) 
            VALUES (
            :id,
            :xml
            )");

            $this->database->bind(':id', $idfolio);
            $this->database->bind(':xml', $xml);
            $this->database->execute();
            if ($this->database->endTransaction()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
            echo $e->getMessage();
            //Rollback de la transacción.
            $this->database->cancelTransaction();
            $res = array('res' => false);
        }
    }

    public function rollback($idfolio)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("DELETE FROM XML_Firmados WHERE Id_Registro= :idfolio");
            $this->database->bind(':idfolio', $idfolio);
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

    public function registra_errores($Id,$Nombre, $Columna, $Error, $idUsuario)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO
            Registro_logs (
                idRegistro_logs,
                Nombre,              
                Columna,
                Error,
                idUsuario
            ) 
            VALUES (
            :Id,
            :Nombre,
            :Columna,
            :Error,
            :idUsuario
            )");

            $this->database->bind(':Id', $Id);
            $this->database->bind(':Nombre', $Nombre);
            $this->database->bind(':Columna', $Columna);
            $this->database->bind(':Error', $Error);
            $this->database->bind(':idUsuario', $idUsuario);
            $this->database->execute();
            if ($this->database->endTransaction()) {
                $res = array('res' => true);
                return true;
            } else {
                $res = array('res' => false);
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            //Rollback de la transacción.
            $this->database->cancelTransaction();
            $res = array('res' => false);
            return false;
        }
    }

    public function get_uid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((float)microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = chr(123) // "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125); // "}"
            return $uuid;
        }
    }

    public function generarCSV($arreglo, $ruta, $delimitador, $encapsulador){
        $file_handle = fopen('php://memory', 'w');
        foreach ($arreglo as $linea) {
          fputcsv($file_handle, $linea, $delimitador, $encapsulador);
        }
        rewind($file_handle);
        fclose($file_handle);
      }

      public function registros_salida($guid)
      {
          try {
              $this->database->query("SELECT Nombre Nombre_archivo, Columna, Error, Fecha_registro FROM Registro_logs WHERE idRegistro_logs=:id_guid");
  
              $this->database->bind(':id_guid', $guid);
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
    
}
