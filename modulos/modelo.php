<?php 
	class Consultasbd {
		
		// metodo de conexion a base de datos
		public function __construct($host='localhost',$user='desarrollo',$pass='aarevalo',$db='bd_biblioteca') {
			$this->idconx = pg_connect('host='.$host.' user='.$user.' password='.$pass.'  dbname='.$db) or die ('Error al conectar con la base de datos, ');
		}

		public function select($tabla,$campos="*",$where="") {
			$sql = "SELECT ".$campos." FROM ".$tabla." ".(($where != '')?$where:'');
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function insert($tabla,$campos,$values) {
			$sql = "INSERT INTO ".$tabla.$campos." VALUES(".$values.")";
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function delete($tabla,$campo,$valor) {
			$sql = "DELETE FROM ".$tabla." WHERE ".$campo."=".$valor."";
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function update($tabla,$set,$where) {
			$sql = "UPDATE ".$tabla." SET ".$set." ".$where."";
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
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

		public function max_id($tabla,$id) {
			$sql = "SELECT MAX(".$id.") AS id FROM ".$tabla."";
			$res = pg_query($this->idconx,$sql) or die ('Error al ejecutar la consulta'.pg_result_error());
			return $res;
		}

		public function select_sql($tabla,$campos="*",$where="") {
			exit("SELECT ".$campos." FROM ".$tabla." ".(($where != '')?$where:''));
		}

		public function insert_sql($tabla,$campos,$values) {
			exit("INSERT INTO ".$tabla.$campos." VALUES(".$values.")");
		}

		public function delete_sql($tabla,$campo,$valor) {
			exit("DELETE FROM ".$tabla." WHERE ".$campo."=".$valor."");
		}

		public function update_sql($tabla,$set,$where) {
			exit("UPDATE ".$tabla." SET ".$set." ".$where."");
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