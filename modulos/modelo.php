<?php 
	class Consultasbd {
		
		// metodo de conexion a base de datos
		public function conectar($host='localhost',$user='desarrollo',$pass='aarevalo',$db='bd_biblioteca') {
			$this->idconx = pg_connect('host='.$host.' user='.$user.' password='.$pass.'  dbname='.$db) or die ('Error al conectar con la base de datos, ');
			return $this->idconx;
		}

		// cerrar conexiones existentes
		public function cerrar_conexion($idconx) {
			if(is_resource($idconx)):
				pg_close($idconx);
			else:
				pg_close();
			endif;
		}

		public function select($idconx,$tabla,$campos="*",$where="") {
			$sql = "SELECT ".$campos." FROM ".$tabla." ".$where;
			$res = pg_query($idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function fetch_array($res_sql) {
			return pg_fetch_assoc($res_sql);
		}

		public function num_rows($res_sql) {
			return pg_num_rows($res_sql);
		}

	}
?>