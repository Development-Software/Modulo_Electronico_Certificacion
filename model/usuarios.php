<?php

class Usuario
{
	private $database;
	private $id;
	private $nombre;
	private $apellidoP;
	private $apellidoM;
	private $correo;
	private $username;
	private $pass;
	private $rol;
	private $estatus;


	public function __construct()
	{
		$this->database = new db();
	}

	public function setId($id)
	{
		$this->id = $id;
	}
	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}
	public function setApellidoP($apellidoP)
	{
		$this->apellidoP = $apellidoP;
	}
	public function setApellidoM($apellidoM)
	{
		$this->apellidoM = $apellidoM;
	}
	public function setCorreo($correo)
	{
		$this->correo = $correo;
	}
	public function setUserName($username)
	{
		$this->username = $username;
	}
	public function setPass($pass)
	{
		$this->pass = $pass;
	}
	public function setRol($rol)
	{
		$this->rol = $rol;
	}
	public function setEstatus($estatus)
	{
		$this->estatus = $estatus;
	}


	public function getId()
	{
		return $this->id;
	}
	public function getNombre()
	{
		return $this->nombre;
	}
	public function getApellidoP()
	{
		return $this->apellidoP;
	}
	public function getApellidoM()
	{
		return $this->apellidoM;
	}
	public function getCorreo()
	{
		return $this->correo;
	}
	public function getUserName()
	{
		return $this->username;
	}
	public function getPass()
	{
		return $this->pass;
	}
	public function getRol()
	{
		return $this->rol;
	}
	public function getEstatus()
	{
		return $this->estatus;
	}


	public function getRegistroUsuario()
	{
		if ($this->verificaUsuario() == true) {
			return $res = array('res' => false, 'msg' => 'El nombre de usuario/correo ya existe, intenta con otro');
		} else {

			try {
				$this->database->beginTransaction();

				$this->database->query("INSERT INTO Usuarios (nombre, apellido_paterno, apellido_materno, correo, username,password,idRol,Activo, Fecha_Registro, Ultima_mod) VALUES (:nombre,:apellidoP,:apellidoM,:correo,:username,:password,:rol,:activo,CURDATE(),CURDATE())");
				$this->database->bind(':nombre', $this->getNombre());
				$this->database->bind(':apellidoP', $this->getApellidoP());
				$this->database->bind(':apellidoM', $this->getApellidoM());
				$this->database->bind(':correo', $this->getCorreo());
				$this->database->bind(':username', $this->getUserName());
				$this->database->bind(':password', password_hash($this->getPass(), PASSWORD_BCRYPT));
				$this->database->bind(':rol', $this->getRol());
				$this->database->bind(':activo', $this->getEstatus());
				$this->database->execute();

				if ($this->database->endTransaction()) {
					$res = array('res' => true, 'msg' => 'El usuario se ha registrado correctamente');
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
	}

	public function verificaUsuario()
	{
		try {
			$this->database->query("SELECT correo,username FROM Usuarios WHERE correo=:correo OR username = :username");
			$this->database->bind(':correo', $this->getCorreo());
			$this->database->bind(':username', $this->getUserName());

			$this->database->execute();
			if ($this->database->rowCount() > 0) {
				return true;
				$this->database = null;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			return false;
		}
	}

	public function verificaUsuarioUpdate()
	{
		try {
			$this->database->query("SELECT idUsuario FROM Usuarios WHERE (correo=:correo or username=:username) and idUsuario<>:id");
			$this->database->bind(':correo', $this->getCorreo());
			$this->database->bind(':id', $this->getId());
			$this->database->bind(':username', $this->getUsername());

			$this->database->execute();
			if ($this->database->rowCount() > 0) {
				return true;
				$this->database = null;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			return false;
		}
	}


	public function updateUsuario()
	{
		if ($this->verificaUsuarioUpdate() == false) {

			try {

				if ($this->getPass() == "") {

					$this->database->beginTransaction();
					$this->database->query("UPDATE Usuarios SET nombre=:nombre,apellido_paterno=:apellidoP,apellido_materno=:apellidoM,correo=:correo,username=:username,idRol=:rol,Activo=:estatus,Ultima_mod=CURDATE() WHERE idUsuario=:id limit 1");

					$this->database->bind(':id', $this->getId());
					$this->database->bind(':nombre', $this->getNombre());
					$this->database->bind(':apellidoP', $this->getApellidoP());
					$this->database->bind(':apellidoM', $this->getApellidoM());
					$this->database->bind(':correo', $this->getCorreo());
					$this->database->bind(':username', $this->getUserName());
					$this->database->bind(':rol', $this->getRol());
					$this->database->bind(':estatus', $this->getEstatus());
				} else {

					$this->database->beginTransaction();
					$this->database->query("UPDATE Usuarios SET nombre=:nombre,apellido_paterno=:apellidoP,apellido_materno=:apellidoM,correo=:correo,username=:username,password=:password,idRol=:rol,Activo=:estatus,Ultima_mod=CURDATE() WHERE idUsuario=:id limit 1");

					$this->database->bind(':id', $this->getId());
					$this->database->bind(':nombre', $this->getNombre());
					$this->database->bind(':apellidoP', $this->getApellidoP());
					$this->database->bind(':apellidoM', $this->getApellidoM());
					$this->database->bind(':correo', $this->getCorreo());
					$this->database->bind(':username', $this->getUserName());
					$this->database->bind(':password', password_hash($this->getPass(), PASSWORD_BCRYPT));
					$this->database->bind(':rol', $this->getRol());
					$this->database->bind(':estatus', $this->getEstatus());
				}

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
		} else {
			return false;
		}
	}

	public function desactivar_usuarios($user_id)
	{
		try {
			$this->database->beginTransaction();
			$this->database->query("UPDATE Usuarios SET Activo=0 WHERE idUsuario=:iduser");
			$this->database->bind(':iduser', $user_id);
			$this->database->execute();
			if ($this->database->endTransaction()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			return false;
		}
	}
	public function activar_usuarios($user_id)
	{
		try {
			$this->database->beginTransaction();
			$this->database->query("UPDATE Usuarios SET Activo=1 WHERE idUsuario=:iduser");
			$this->database->bind(':iduser', $user_id);
			$this->database->execute();
			if ($this->database->endTransaction()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			//Rollback de la transacción.
			return false;
		}
	}

	public function updateUsuario2()
	{
		if ($this->verificaUsuarioUpdate() == false) {

			try {
				$this->database->beginTransaction();
				$this->database->query("UPDATE Usuarios SET nombre=:nombre,apellido_paterno=:apellidoP,apellido_materno=:apellidoM,correo=:correo,username=:username,idRol=:rol,Activo=:estatus,Ultima_mod=CURDATE() WHERE idUsuario=:id limit 1");

				$this->database->bind(':id', $this->getId());
				$this->database->bind(':nombre', $this->getNombre());
				$this->database->bind(':apellidoP', $this->getApellidoP());
				$this->database->bind(':apellidoM', $this->getApellidoM());
				$this->database->bind(':correo', $this->getCorreo());
				$this->database->bind(':username', $this->getUserName());
				$this->database->bind(':rol', $this->getRol());
				$this->database->bind(':estatus', $this->getEstatus());


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
		} else {
			return false;
		}
	}
}

class ReporteUsuario
{
	private $database;
	public function __construct()
	{
		$this->database = new db();
	}
	public function getReporteUsuario()
	{

		$this->database->query("SELECT u.idUsuario,
									   u.nombre,
									   u.apellido_paterno,
									   u.apellido_materno,
									   u.correo,
									   u.username,
									   u.idRol,
									   (select Descripcion from Roles r where r.idRol=u.idRol) as Rol,
									   u.Activo,
									   u.Fecha_Registro
							    FROM Usuarios u
							   ");

		$this->database->execute();

		return $this->database->resultset();
		$this->database = null;
	}

	public function getRoles()
	{

		$this->database->query("SELECT idRol,Descripcion
							    FROM Roles
							   ");
		$this->database->execute();

		return $this->database->resultset();
		$this->database = null;
	}
	public function getUsuarioData($id_user)
	{

		$this->database->query("SELECT u.idUsuario,
									   u.nombre,
									   u.apellido_paterno,
									   u.apellido_materno,
									   u.correo,
									   u.username,
									   u.idRol,
									   (select Descripcion from Roles r where r.idRol=u.idRol) as Rol,
									   u.Activo,
									   u.Fecha_Registro
							    FROM Usuarios u
								WHERE u.idUsuario=:id
							   ");
		$this->database->bind(':id', $id_user);
		$this->database->execute();

		return $this->database->resultset();
		$this->database = null;
	}
}
