<?php 
	class Consultasbd {
		
		// metodo de conexion a base de datos
		public function __construct($host='localhost',$user='lapascua',$pass='lapascua',$db='bd_biblioteca') {
			$this->idconx = pg_connect('host='.$host.' user='.$user.' password='.$pass.'  dbname='.$db) or die ('Error al conectar con la base de datos, ');
		}

		public function select($tabla,$campos="*",$where="") {
			$sql = "SELECT ".$campos." FROM ".$tabla." ".(($where != '')?$where:'');
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function insert($table,$campos,$values) {
			//$sql = "INSERT INTO("
		}

		public function query($sql) {
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function fetch_array($res_sql) {
			return pg_fetch_assoc($res_sql);
		}

		public function num_rows($res_sql) {
			return pg_num_rows($res_sql);
		}

		// cerrar conexiones existentes
		public function __destruct() {
	       if(is_resource($this->idconx)):
				pg_close($this->idconx);
			else:
				pg_close();
			endif;
	    }

	}

	// instancia para uso
	$consultasbd  = new Consultasbd;
?>