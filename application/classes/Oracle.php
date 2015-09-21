<?php defined('SYSPATH') or die('No direct script access.');

class Oracle{
	private static $_conn = null;
	private static $_instance = null;

	private function __construct() {}
    public function __destruct() {
        oci_close(self::$_conn);
    }
	protected function __clone() {}

	static public function getInstance() {
		if(is_null(self::$_instance))
		{
			$config = Kohana::$config->load('database');

            if(Access::check(4, true)){
                self::$_conn = oci_connect($config['name1'], $config['password1'], $config['db'], 'UTF8');
            }else{
                self::$_conn = oci_connect($config['name'], $config['password'], $config['db'], 'UTF8');
            }

			if (!self::$_conn) {
				$e = oci_error();
				trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}

			self::$_instance = new self();
		}
		return self::$_instance;
	}

	static public function query($sql, $type='select'){
		if($type == 'select'){
			$ret = array();
			$res = oci_parse(self::$_conn, $sql);
			
			oci_execute($res);
			while ($row = oci_fetch_array($res, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$ret[] = $row;
			}
			return $ret;
		}else{
			$res = oci_parse(self::$_conn, $sql);
			oci_execute($res);
			return 1;
		}
	}
	
	static public function ora_proced($sql, $params)
	{
		$res = oci_parse(self::$_conn, $sql);
		
		foreach($params as $key=>&$param){
			if($param == 'out'){
				oci_bind_by_name($res, ':'.$key, $param, 255);
			}else{
				oci_bind_by_name($res, ':'.$key, $param);
			}
		}
		
		oci_execute($res, OCI_DEFAULT);
		return $params;
	}

	static public function update($sql){
		return self::query($sql, "update");
	}
	
	static public function insert($sql){
		return self::query($sql, "update");
	}

	static public function row($sql){
		$r = self::query($sql);
		if(!empty($r) && !empty($r[0])){
			return $r[0];
		}
		return false;
	}

	static public function column($sql, $column_key){
		$r = self::query($sql);

		if(!empty($r) && count($r)){
			$arr = array();

			foreach($r as $row){
				foreach($row as $k=>$elem){
					if(strtolower($column_key) == strtolower($k)){
						$arr[] = $elem;
					}
				}	
			}
			return $arr;
		}
		return false;
	}	

	static public function one($sql){
		$r = self::query($sql);
		if(!empty($r) && !empty($r[0])){
			return array_pop($r[0]);
		}
		return false;
	}	
}