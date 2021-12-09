<?php

class roles
{
	private $database;
	private $idrol;
	private $nombre_rol;
	private $Adminrol;
	private $fecha_registro;
	private $fecha_modificacion;
	private $estatus;
	private $idPermiso;

	public function __construct()
	{
		$this->database = new db();
	}
	public function setIdRol($idrol)
	{
		$this->idrol = $idrol;
	}
	public function setNombre_rol($nombre_rol)
	{
		$this->nombre_rol = $nombre_rol;
	}
	public function setAdminrol($Adminrol)
	{
		$this->Adminrol = $Adminrol;
	}
	public function setfecha_registro($fecha_registro)
	{
		$this->fecha_registro = $fecha_registro;
	}
	public function setfecha_mod($fecha_modificacion)
	{
		$this->fecha_modificacion = $fecha_modificacion;
	}
	public function setestatus($estatus)
	{
		$this->estatus = $estatus;
	}
	public function setidPermiso($idPermiso)
	{
		$this->idPermiso = $idPermiso;
	}

	public function getIdRol()
	{
		return $this->idrol;
	}
	public function getNombre_rol()
	{
		return $this->nombre_rol;
	}
	public function getAdminrol()
	{
		return $this->Adminrol;
	}
	public function getFecharegistro()
	{
		return $this->fecha_registro;
	}
	public function getFechamod()
	{
		return $this->fecha_modificacion;
	}
	public function getEstatus()
	{
		return $this->estatus;
	}

	public function getidPermiso()
	{
		return $this->idPermiso;
	}

	public function getReporteRoles()
	{

		$this->database->query("SELECT R.idRol,R.Descripcion,R.Activo,R.Administrador,ifnull(Usuarios_activos,0)Usuarios_activos,ifnull(Usuarios_inactivos,0)Usuarios_inactivos,R.Fecha_registro,R.Ultima_mod
        FROM Roles R
        LEFT JOIN (SELECT DISTINCT COUNT(idUsuario) Usuarios_activos,idRol FROM Usuarios WHERE Activo=1 GROUP BY idRol) UA ON UA.idRol=R.idRol
        LEFT JOIN (SELECT DISTINCT COUNT(idUsuario) Usuarios_inactivos,idRol FROM Usuarios WHERE Activo=0 GROUP BY idRol) UD ON UD.idRol=R.idRol
        ORDER BY 1");

		$this->database->execute();

		return $this->database->resultset();
		$this->database = null;
	}
	public function getReportePermisos()
	{

		$this->database->query("SELECT A.idPermiso,A.SubMenu,A.Privilegio,A.Descripcion,CASE WHEN B.idPermiso IS NULL THEN 0 ELSE 1 END Activo,
		CASE WHEN A.idPermiso IN (SELECT idPermiso FROM Permisos WHERE idPrivilegio<>1) THEN 'style=\"display:none;\"' 
		WHEN A.idPermiso IN (SELECT idPermiso FROM Permisos WHERE idPrivilegio=1 AND idSubmenu=1) THEN 'style=\"font-weight: bold;\"'
		WHEN A.idPermiso IN (SELECT idPermiso FROM Permisos WHERE idPrivilegio=1 AND idSubmenu<>1) THEN 'style=\"font-weight: bold;text-indent: 1em;\"' ELSE '' END Menu_Style,
		CASE WHEN A.Privilegio='Acceso' THEN 'style=\"display:none;\"'
		WHEN A.idPermiso IN (SELECT idPermiso FROM Permisos WHERE idPrivilegio<>1) THEN 'style=\"text-indent: 2em;\"' ELSE '' END Permiso_Style,
		CASE WHEN A.idPermiso=1 THEN 'style=\"display:none;\"' ELSE '' END tr_Style
		FROM Permisos A
		LEFT JOIN  (SELECT DISTINCT idPermiso FROM Roles_Permisos WHERE idRol=:idrol) B ON B.idPermiso=A.idPermiso
		 ORDER BY 1;");
		$this->database->bind(':idrol', $this->getIdRol());
		$this->database->execute();

		return $this->database->resultset();
		$this->database = null;
	}

	public function getInsertRol()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("INSERT INTO Roles (Descripcion,Activo,Administrador,Fecha_registro,Ultima_mod) VALUES (:Descripcion,:activo,:admin_1,CURDATE(),CURDATE())");
			$this->database->bind(':Descripcion', $this->getNombre_rol());
			$this->database->bind(':activo', $this->getEstatus());
			$this->database->bind(':admin_1', $this->getAdminrol());
			$this->database->execute();

			if ($this->database->endTransaction()) {
				$res = array('res' => true, 'msg' => 'El perfil se ha registrado correctamente');
				return $res;
			} else {
				$res = array('res' => false, 'msg' => 'Registro Incorrecto intenta nuevamente');
				return $res;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			$this->database->cancelTransaction();
			$res = array('res' => false, 'msg' => 'Registro Incorrecto intenta nuevamente');
			return $res;
		}
	}

	public function getInsertPermisosRol()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("INSERT INTO Roles_Permisos (idRol,idPermiso) VALUES (:idRol,:idPermiso);");
			$this->database->bind(':idRol', $this->getIdRol());
			$this->database->bind(':idPermiso', $this->getidPermiso());
			$this->database->execute();

			if ($this->database->endTransaction()) {
				$res = array('res' => true, 'msg' => 'Los permisos se han registrado correctamente');
				return $res;
			} else {
				$res = array('res' => false, 'msg' => 'Registro Incorrecto intenta nuevamente');
				return $res;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			$this->database->cancelTransaction();
			$res = array('res' => false, 'msg' => 'Registro Incorrecto intenta nuevamente');
			return $res;
		}
	}

	public function getUpdateRol()
	{

		try {
			$this->database->beginTransaction();

			$this->database->query("UPDATE Roles SET Descripcion=:Descripcion,Activo=:idestatus,Administrador=:admin_1 WHERE idRol=:idRol");
			$this->database->bind(':Descripcion', $this->getNombre_rol());
			$this->database->bind(':idRol', $this->getIdRol());
			$this->database->bind(':idestatus', $this->getEstatus());
			$this->database->bind(':admin_1', $this->getAdminrol());
			$this->database->execute();

			if ($this->database->endTransaction()) {
				$res = array('res' => true, 'msg' => 'El perfil se ha actualizado correctamente');
				
				return $res;
			} else {
				$res = array('res' => false, 'msg' => 'Registro Incorrecto intenta nuevamente');
				return $res;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			$this->database->cancelTransaction();
			$res = array('res' => false, 'msg' => 'Registro Incorrecto intenta nuevamente');
			return $res;
		}
	}

	public function getDeletePermisos()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("DELETE FROM Roles_Permisos WHERE idRol=:idRol");
			$this->database->bind(':idRol', $this->getIdRol());
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

	public function getdesactivarRol()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("UPDATE Roles SET Activo=0 WHERE idRol=:idRol");
			$this->database->bind(':idRol', $this->getIdRol());
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

	public function getdesactivarUsuariosRol()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("UPDATE Usuarios SET Activo=0 WHERE IdRol=:idRol");
			$this->database->bind(':idRol', $this->getIdRol());
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
	public function getactivarRol()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("UPDATE Roles SET Activo=1 WHERE idRol=:idRol");
			$this->database->bind(':idRol', $this->getIdRol());
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

	public function getactivarUsuariosRol()
	{
		try {
			$this->database->beginTransaction();

			$this->database->query("UPDATE Usuarios SET Activo=1 WHERE IdRol=:idRol");
			$this->database->bind(':idRol', $this->getIdRol());
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
}
