<?php
class Csqldumper extends CModel{

	public function table2sql($tab){
		$this -> table($tab);
		$tabledump = "DROP TABLE IF EXISTS $tab;\n";
		$createtable = $this -> query("SHOW CREATE TABLE $tab") -> row();
		$create = $createtable['Create Table'];
		$tabledump .= $create.";\n\n";
		return $tabledump;
	}

	public function data2sql($tab){
		$this -> table($tab);
		$tabledump = "DROP TABLE IF EXISTS $tab;\n";
		$createtable = $this -> query("SHOW CREATE TABLE $tab") -> row();
		$create = $createtable['Create Table'];
		$tabledump .= $create.";\n\n";
		$rows = $this -> table($tab) -> select() -> all();
		$comma = "";
		foreach ($rows as $row){
			$tabledump .= "INSERT INTO $tab ";
			$item = array();
			$keys = array();
			foreach($row as $fk => $fv){
				$keys[] = "`".$fk."`";
				$item [] = $comma."'".mysql_escape_string($fv)."'";
			}
			$tabledump .= "(".join(",",$keys).")VALUES(".join(",",$item).");\n";			 
		}
		$tabledump .= "\n";
		return $tabledump;
	}
	
}