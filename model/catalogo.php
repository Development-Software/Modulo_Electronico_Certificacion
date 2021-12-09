<?php
class Catalogo
{

    private $database;
    private $idcargo;
    private $idinstitucionAut;
    private $descripcionAut;
    private $nombreAut;
    private $apellidoPAut;
    private $apellidoMAut;
    private $curpAut;
    private $idCampus;
    private $descripcionCampus;
    private $idNivel;
    private $idCarrera;
    private $claveCarrera;
    private $descripcionCarrera;

    private $idMateria;
    private $claveMateria;
    private $descripcionMateria;

    private $idRvoe;
    private $idFechaRvoe;
    private $idMinimaRvoe;
    private $idMaximaRvoe;
    private $idMinimaAprobatoriaRvoe;

    private $creditosTotalesPE;
    private $anioPlanPE;
    private $tipoAsignaturaPE;
    private $creditosPE;
    private $idPeriodoPE;

    public function __construct()
    {
        $this->database = new db();
    }


    //PLAN DE ESTUDIOS
    public function setCreditosTotales($creditosTotalesPE)
    {
        $this->creditosTotalesPE = $creditosTotalesPE;
    }
    public function setAnioPlan($anioPlanPE)
    {
        $this->anioPlanPE = $anioPlanPE;
    }
    public function setIdTipoAsignatura($tipoAsignaturaPE)
    {
        $this->tipoAsignaturaPE = $tipoAsignaturaPE;
    }
    public function setCreditos($creditosPE)
    {
        $this->creditosPE = $creditosPE;
    }
    public function setIdPeriodo($idPeriodoPE)
    {
        $this->idPeriodoPE = $idPeriodoPE;
    }

    public function getCreditosTotales()
    {
        return $this->creditosTotalesPE;
    }
    public function getAnioPlan()
    {
        return $this->anioPlanPE;
    }
    public function getIdTipoAsignatura()
    {
        return $this->tipoAsignaturaPE;
    }
    public function getCreditos()
    {
        return $this->creditosPE;
    }
    public function getIdPeriodo()
    {
        return $this->idPeriodoPE;
    }


    //CATALOGO
    public function setIdCargo($idcargo)
    {
        $this->idcargo = $idcargo;
    }
    public function setIdInstitucion($idinstitucionAut)
    {
        $this->idinstitucionAut = $idinstitucionAut;
    }
    public function setDescripcionAut($descripcionAut)
    {
        $this->descripcionAut = $descripcionAut;
    }
    public function setNombreAut($nombreAut)
    {
        $this->nombreAut = $nombreAut;
    }
    public function setApellidoPAut($apellidoPAut)
    {
        $this->apellidoPAut = $apellidoPAut;
    }
    public function setApellidoMAut($apellidoMAut)
    {
        $this->apellidoMAut = $apellidoMAut;
    }
    public function setCurpAut($curpAut)
    {
        $this->curpAut = $curpAut;
    }
    public function setIdCampus($idCampus)
    {
        $this->idCampus = $idCampus;
    }
    public function setDescripcionCampus($descripcionCampus)
    {
        $this->descripcionCampus = $descripcionCampus;
    }
    public function setIdNivel($idNivel)
    {
        $this->idNivel = $idNivel;
    }
    public function setIdCarrera($idCarrera)
    {
        $this->idCarrera = $idCarrera;
    }
    public function setClaveCarrera($claveCarrera)
    {
        $this->claveCarrera = $claveCarrera;
    }
    public function setDescripcionCarrera($descripcionCarrera)
    {
        $this->descripcionCarrera = $descripcionCarrera;
    }
    public function setIdMateria($idMateria)
    {
        $this->idMateria = $idMateria;
    }
    public function setClaveLegalMateria($claveMateria)
    {
        $this->claveMateria = $claveMateria;
    }
    public function setDescripcionMateria($descripcionMateria)
    {
        $this->descripcionMateria = $descripcionMateria;
    }

    public function setIdRvoe($idRvoe)
    {
        $this->idRvoe = $idRvoe;
    }
    public function setFechaRegistroRvoe($idFechaRvoe)
    {
        $this->idFechaRvoe = $idFechaRvoe;
    }
    public function setMinimaRvoe($idMinimaRvoe)
    {
        $this->idMinimaRvoe = $idMinimaRvoe;
    }
    public function setMaximaRvoe($idMaximaRvoe)
    {
        $this->idMaximaRvoe = $idMaximaRvoe;
    }
    public function setMinimaAprobatoriaRvoe($idMinimaAprobatoriaRvoe)
    {
        $this->idMinimaAprobatoriaRvoe = $idMinimaAprobatoriaRvoe;
    }




    public function getIdCargo()
    {
        return $this->idcargo;
    }
    public function getIdInstitucion()
    {
        return $this->idinstitucionAut;
    }
    public function getDescripcionAut()
    {
        return $this->descripcionAut;
    }
    public function getNombreAut()
    {
        return $this->nombreAut;
    }
    public function getApellidoPAut()
    {
        return $this->apellidoPAut;
    }
    public function getApellidoMAut()
    {
        return $this->apellidoMAut;
    }
    public function getCurpAut()
    {
        return $this->curpAut;
    }
    public function getIdCampus()
    {
        return $this->idCampus;
    }
    public function getDescripcionCampus()
    {
        return $this->descripcionCampus;
    }
    public function getIdNivel()
    {
        return $this->idNivel;
    }


    public function getIdCarrera()
    {
        return $this->idCarrera;
    }
    public function getClaveCarrera()
    {
        return $this->claveCarrera;
    }
    public function getDescripcionCarrera()
    {
        return $this->descripcionCarrera;
    }

    public function getIdMateria()
    {
        return $this->idMateria;
    }
    public function getClaveLegalMateria()
    {
        return $this->claveMateria;
    }
    public function getDescripcionMateria()
    {
        return $this->descripcionMateria;
    }



    public function getIdRvoe()
    {
        return $this->idRvoe;
    }
    public function getFechaRegistroRvoe()
    {
        return $this->idFechaRvoe;
    }
    public function getMinimaRvoe()
    {
        return $this->idMinimaRvoe;
    }
    public function getMaximaRvoe()
    {
        return $this->idMaximaRvoe;
    }
    public function getMinimaAprobatoriaRvoe()
    {
        return $this->idMinimaAprobatoriaRvoe;
    }

    public function getCargo()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT idCargo from Cargo where idCargo=:idParametro");
            $this->database->bind(':idParametro', $this->getIdCargo());
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
    public function getInstitucion()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Id_Institucion from Institucion");
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
    public function existeCatalogo($idcatalogo, $tablacatalogo)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT " . $idcatalogo . " from " . $tablacatalogo);
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

    public function existeCatalogoId($idcatalogo, $tablacatalogo, $valorId)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT " . $idcatalogo . " from " . $tablacatalogo . " where " . $idcatalogo . "=:idIns");
            $this->database->bind(':idIns', $valorId);
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
    public function existePlan($idIns,$idCampus,$idCarrera,$idRvoe, $anioplan,$idMateria)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT * FROM Plan_Estudios WHERE Id_Institucion=:Id_Institucion AND Id_Campus=:Id_Campus AND Id_Carrera=:Id_Carrera AND RVOE=:RVOE AND Anio_Plan=:Anio_Plan AND Id_Materia=:Id_Materia");
            $this->database->bind(':Id_Institucion', $idIns);
            $this->database->bind(':Id_Campus', $idCampus);
            $this->database->bind(':Id_Carrera', $idCarrera);
            $this->database->bind(':RVOE', $idRvoe);
            $this->database->bind(':Anio_Plan', $anioplan);
            $this->database->bind(':Id_Materia', $idMateria);
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
    public function getInstitucionId()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT Id_Institucion from Institucion where Id_Institucion=:idIns");
            $this->database->bind(':idIns', $this->getIdInstitucion());
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

    public function getNivel()
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("SELECT idNivelEstudios from Nivel where idNivelEstudios=:id");
            $this->database->bind(':id', $this->getIdNivel());
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


    public function deleteCatalogo($tabla)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("DELETE FROM " . $tabla);
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

    public function addCatalogoInstitucion($idIns, $descripcionAut, $nombreAut, $apellidoMAut, $apellidoPAut, $curpAut, $idcargoAut)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Institucion(Id_Institucion,Descripcion,Nombre_aut,Apellido_P_aut,Apellido_M_aut,CURP_aut,Id_Cargo_aut,Activo,Fecha_modificacion) 
            VALUES( 
                  :idIns,
                  :descripcionAut,
                  :nombreAut,
                  :apellidoMAut,
                  :apellidoPAut,
                  :curpAut,
                  :idcargoAut,
                  1,current_timestamp()
                  )");

            $this->database->bind(':idIns', $idIns);
            $this->database->bind(':descripcionAut', $descripcionAut);
            $this->database->bind(':nombreAut', $nombreAut);
            $this->database->bind(':apellidoMAut', $apellidoMAut);
            $this->database->bind(':apellidoPAut', $apellidoPAut);
            $this->database->bind(':curpAut', $curpAut);
            $this->database->bind(':idcargoAut', $idcargoAut);

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

    public function updCatalogoInstitucion($idIns, $descripcionAut, $nombreAut, $apellidoMAut, $apellidoPAut, $curpAut, $idcargoAut,$active)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("UPDATE Institucion SET Descripcion=:descripcionAut,Nombre_aut=:nombreAut,Apellido_P_aut=:apellidoPAut,Apellido_M_aut=:apellidoMAut,
                                    CURP_aut=:curpAut,Id_Cargo_aut=:idcargoAut,Activo=:active,Fecha_modificacion=current_timestamp() WHERE Id_Institucion=:idIns");

            $this->database->bind(':idIns', $idIns);
            $this->database->bind(':descripcionAut', $descripcionAut);
            $this->database->bind(':nombreAut', $nombreAut);
            $this->database->bind(':apellidoMAut', $apellidoMAut);
            $this->database->bind(':apellidoPAut', $apellidoPAut);
            $this->database->bind(':curpAut', $curpAut);
            $this->database->bind(':idcargoAut', $idcargoAut);
            $this->database->bind(':active', $active);
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

    public function addCatalogoCampus($idcampus,$descripcionCampus,$idIns)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Campus(Id_Campus,Descripcion,Id_Institucion,Activo,Fecha_modificacion) 
                                    VALUES( 
                                          :idcampus,
                                          :descripcionCampus,
                                          :idIns,
                                          1,current_timestamp()
                                          )");

            $this->database->bind(':idcampus', $idcampus);
            $this->database->bind(':descripcionCampus', $descripcionCampus);
            $this->database->bind(':idIns', $idIns);
            /* $this->database->bind(':active', $active); */
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
    public function updCatalogoCampus($idcampus,$descripcionCampus,$idIns,$active)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("UPDATE Campus SET Descripcion=:descripcionCampus,Id_Institucion=:idIns,Activo= :active,Fecha_modificacion=current_timestamp() WHERE Id_Campus=:idcampus");

            $this->database->bind(':idcampus', $idcampus);
            $this->database->bind(':descripcionCampus', $descripcionCampus);
            $this->database->bind(':idIns', $idIns);
            $this->database->bind(':active', $active);
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
    public function addCatalogoCarreras($idcarrera,$clavecarrera,$descripcion,$idnivel,$idinstitucion)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Carreras(Id_Carrera,Clave_Carrera,Descripcion,Id_Nivel,Id_Institucion,Activo,Fecha_modificacion) 
                                    VALUES( 
                                          :idcarrera,
                                          :clavecarrera,
                                          :descripcion,
                                          :idnivel,
                                          :idinstitucion,
                                          1,CURRENT_TIMESTAMP()
                                          )");

            $this->database->bind(':idcarrera', $idcarrera);
            $this->database->bind(':clavecarrera', $clavecarrera);
            $this->database->bind(':descripcion', $descripcion);
            $this->database->bind(':idnivel', $idnivel);
            $this->database->bind(':idinstitucion', $idinstitucion);

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

    public function updCatalogoCarreras($idcarrera,$clavecarrera,$descripcion,$idnivel,$idinstitucion,$active)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("UPDATE Carreras SET Clave_Carrera=:clavecarrera,Descripcion=:descripcion,Id_Nivel=:idnivel,Id_Institucion=:idinstitucion,Activo=:active,Fecha_modificacion=current_timestamp() WHERE Id_Carrera=:idcarrera");

            $this->database->bind(':idcarrera', $idcarrera);
            $this->database->bind(':clavecarrera', $clavecarrera);
            $this->database->bind(':descripcion', $descripcion);
            $this->database->bind(':idnivel', $idnivel);
            $this->database->bind(':idinstitucion', $idinstitucion);
            $this->database->bind(':active', $active);
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

    public function addCatalogoMaterias($idmateria,$clavemateria,$descripcion,$idinstitucion)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Materias(Id_Materia,Clave_Legal,Descripcion,Id_Institucion,Activo,Fecha_modificacion) 
                                    VALUES( 
                                          :idmateria,
                                          :clavemateria,
                                          :descripcion,
                                          :idinstitucion,
                                          1,current_timestamp()
                                          )");

            $this->database->bind(':idmateria', $idmateria);
            $this->database->bind(':clavemateria', $clavemateria);
            $this->database->bind(':descripcion', $descripcion);
            $this->database->bind(':idinstitucion', $idinstitucion);

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
            return false;
        }
    }

    public function udpCatalogoMaterias($idmateria,$clavemateria,$descripcion,$idinstitucion,$active)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("UPDATE Materias SET Clave_Legal=:clavemateria,Descripcion=:descripcion,Id_Institucion=:idinstitucion,Activo=:active,Fecha_modificacion=current_timestamp() WHERE Id_Materia=:idmateria ");

            $this->database->bind(':idmateria', $idmateria);
            $this->database->bind(':clavemateria', $clavemateria);
            $this->database->bind(':descripcion', $descripcion);
            $this->database->bind(':idinstitucion', $idinstitucion);
            $this->database->bind(':active', $active);

            $this->database->execute();
            if ($this->database->endTransaction()) {
                $res = array('res' => true);
                return true;
            } else {
                $res = array('res' => false);
                return false;
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            //Rollback de la transacción.
            $this->database->cancelTransaction();
            return false;
        }
    }
    public function addCatalogoRvoe($idrvoe,$fechaRegRvoe,$minimaRvoe,$maximaRvoe,$minimaAprobatoriaRvoe,$idinstitucion)
    {
        try {
            $this->database->beginTransaction();

            $date = str_replace('/', '-', $fechaRegRvoe);
            $fecha = date('Y-m-d', strtotime($date));
            $this->database->query("INSERT INTO RVOE (RVOE,Fecha_Registro,Minima,Maxima,Minima_Aprobatoria,Id_Institucion,Activo,Fecha_modificacion) 
                                    VALUES( 
                                          :idrvoe,
                                          :fechaRegRvoe,
                                          :minimaRvoe,
                                          :maximaRvoe,
                                          :minimaAprobatoriaRvoe,
                                          :idinstitucion,
                                          1,current_timestamp()
                                          )");

            $this->database->bind(':idrvoe', $idrvoe);
            $this->database->bind(':fechaRegRvoe', $fecha); //$this->getFechaRegistroRvoe()
            $this->database->bind(':minimaRvoe', $minimaRvoe);
            $this->database->bind(':maximaRvoe', $maximaRvoe);
            $this->database->bind(':minimaAprobatoriaRvoe', $minimaAprobatoriaRvoe);
            $this->database->bind(':idinstitucion', $idinstitucion);

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

    public function updCatalogoRvoe($idrvoe,$fechaRegRvoe,$minimaRvoe,$maximaRvoe,$minimaAprobatoriaRvoe,$idinstitucion,$active)
    {
        try {
            $this->database->beginTransaction();

            $date = str_replace('/', '-', $fechaRegRvoe);
            $fecha = date('Y-m-d', strtotime($date));
            $this->database->query("UPDATE RVOE SET Fecha_Registro=:fechaRegRvoe,Minima=:minimaRvoe,Maxima=:maximaRvoe,Minima_Aprobatoria=:minimaAprobatoriaRvoe,Id_Institucion=:idinstitucion,Activo=:active,Fecha_modificacion=current_timestamp() WHERE RVOE=:idrvoe ");

            $this->database->bind(':idrvoe', $idrvoe);
            $this->database->bind(':fechaRegRvoe', $fecha); //$this->getFechaRegistroRvoe()
            $this->database->bind(':minimaRvoe', $minimaRvoe);
            $this->database->bind(':maximaRvoe', $maximaRvoe);
            $this->database->bind(':minimaAprobatoriaRvoe', $minimaAprobatoriaRvoe);
            $this->database->bind(':idinstitucion', $idinstitucion);
            $this->database->bind(':active', $active);
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
    //se elaboro para actualizar plan.
    public function addCatalogoPlanEstudios_noseusa($idIns,$idcampus,$idcarrera,$idrvoe,$creditostotales,$anioplan,$idmateria,$idtipoasignatura,$creditos,$idperiodo)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Plan_Estudios(Id_Institucion,Id_Campus,Id_Carrera,RVOE,Creditos_Totales,Anio_Plan,Id_Materia,Id_Tipo_Asignatura,Creditos,Id_Periodo) 
                                    VALUES( 
                                          :idIns,
                                          :idcampus,
                                          :idcarrera,
                                          :idrvoe,
                                          :creditostotales,
                                          :anioplan,
                                          :idmateria,
                                          :idtipoasignatura,
                                          :creditos,
                                          :idperiodo,
                                          1,current_timestamp()
                                          )");

            $this->database->bind(':idIns', $idIns);
            $this->database->bind(':idcampus', $idcampus);
            $this->database->bind(':idcarrera', $idcarrera);
            $this->database->bind(':idrvoe', $idrvoe);
            $this->database->bind(':creditostotales', $creditostotales);
            $this->database->bind(':anioplan', $anioplan);
            $this->database->bind(':idmateria', $idmateria);
            $this->database->bind(':idtipoasignatura', $idtipoasignatura);
            $this->database->bind(':creditos', $creditos);
            $this->database->bind(':idperiodo', $idperiodo);

            $this->database->execute();
            if ($this->database->endTransaction()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            //Rollback de la transacción.
            return false;
            $this->database->cancelTransaction();
        }
    }
    public function addCatalogoPlanEstudios(){
        try{    
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO Plan_Estudios(Id_Institucion,Id_Campus,Id_Carrera,RVOE,Creditos_Totales,Anio_Plan,Id_Materia,Id_Tipo_Asignatura,Creditos,Id_Periodo) 
                                    VALUES( 
                                          :idIns,
                                          :idcampus,
                                          :idcarrera,
                                          :idrvoe,
                                          :creditostotales,
                                          :anioplan,
                                          :idmateria,
                                          :idtipoasignatura,
                                          :creditos,
                                          :idperiodo
                                          )"
                                    );
          
            $this->database->bind(':idIns',$this->getIdInstitucion());
            $this->database->bind(':idcampus',$this->getIdCampus());
            $this->database->bind(':idcarrera',$this->getIdCarrera());
            $this->database->bind(':idrvoe',$this->getIdRvoe());
            $this->database->bind(':creditostotales',$this->getCreditosTotales());
            $this->database->bind(':anioplan',$this->getAnioPlan());
            $this->database->bind(':idmateria',$this->getIdMateria());
            $this->database->bind(':idtipoasignatura',$this->getIdTipoAsignatura());
            $this->database->bind(':creditos',$this->getCreditos());
            $this->database->bind(':idperiodo',$this->getIdPeriodo());
                  
            $this->database->execute();
            if($this->database->endTransaction()){
                return true;
            }else{
                return false;
                 }
                
        }catch(Exception $e){
         //echo $e->getMessage();
         //Rollback de la transacción.
         return false;
         $this->database->cancelTransaction();
       
    }


  }
    public function updCatalogoPlanEstudios($idIns,$idcampus,$idcarrera,$idrvoe,$creditostotales,$anioplan,$idmateria,$idtipoasignatura,$creditos,$idperiodo,$active)
    {
        try {
            $this->database->beginTransaction();

            $this->database->query("UPDATE Plan_Estudios SET Id_Institucion=:idIns,Id_Campus=:idcampus,Id_Carrera=:idcarrera,Creditos_Totales=:creditostotales,Id_Materia=:idmateria,Id_Tipo_Asignatura=:idtipoasignatura,Creditos=:creditos,Id_Periodo=:idperiodo,Activo=:active,Fecha_modificacion=current_timestamp() WHERE RVOE=:idrvoe AND Anio_Plan=:anioplan ");

            $this->database->bind(':idIns', $idIns);
            $this->database->bind(':idcampus', $idcampus);
            $this->database->bind(':idcarrera', $idcarrera);
            $this->database->bind(':idrvoe', $idrvoe);
            $this->database->bind(':creditostotales', $creditostotales);
            $this->database->bind(':anioplan', $anioplan);
            $this->database->bind(':idmateria', $idmateria);
            $this->database->bind(':idtipoasignatura', $idtipoasignatura);
            $this->database->bind(':creditos', $creditos);
            $this->database->bind(':idperiodo', $idperiodo);
            $this->database->bind(':active', $active);

            $this->database->execute();
            if ($this->database->endTransaction()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
            //Rollback de la transacción.
            return false;
            $this->database->cancelTransaction();
        }
    }
}
