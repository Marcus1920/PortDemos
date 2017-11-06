<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB as DB;
use Illuminate\Database\Query\Builder as Builder;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;


class DatabaseController extends Controller {
	static function getData($table) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$table) \$table - {$table}";
		/*$data = DB::select("select * from {$table}", [], true);
		for ($i = 0; $i < count($data); $i++) {
			foreach ($data[$i] AS $key=>$val) {
				//$data[$i][$key] = "123";
			}
		}*/

		$data1 = DB::select("select * from {$table}", [], true);
		$data = array();
		foreach ($data1 AS $i=>$d) {
			$dtmp = json_decode( 	json_encode($d), true );
			foreach ($dtmp AS $key=>$val) {
				if (strlen($val) > 50) $dtmp[$key] = substr ($val, 0, 50)."..";
			}
			$data[] = $dtmp;
		}

		$txtDebug .= PHP_EOL."  \$data - ".print_r($data,1);
		//die("<pre>{$txtDebug}</pre>");
		return $data;
	}
	
	static function getTable($name, $form_id = -1) {
		$txtDebug = "DatabaseController::getTable(\$name, \$form_id = -1) \$name - {$name}, \$form_id - {$form_id}";
		$tables = self::getTables(false, $form_id);
		$table = "";
		foreach ($tables AS $table_tmp) {
			if ($table_tmp['name'] == $name) $table = $table_tmp;
		}
		$txtDebug .= "\n\$table - ".print_r($table,1);
		/*error_reporting(-1);
		$txtDebug .= $a;*/
		//die("<pre>{$txtDebug}</pre>");
		return $table;
	}
	
	static public function getTables($basic = false, $form_id = -1) {
		$txtDebug = "DatabaseController->getTables(\$basic = false, \$form_id = -1) \$basic - {$basic}, \$form_id - {$form_id}";
		$tables = [];
		$schema = \DB::getDoctrineSchemaManager();
		$schema->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");
		$tables_tmp = $schema->listTables();
		foreach ($tables_tmp AS $table_tmp) {
			if ($basic) $tables[$table_tmp->getName()] = $table_tmp->getName();
			else {
				$table = array('name'=>$table_tmp->getName(), 'columns'=>array(), 'primary'=>"");
				if ($table_tmp->hasPrimaryKey()) $table['primary'] = $table_tmp->getPrimaryKey()->getColumns();
				foreach ($table_tmp->getColumns() AS $col_tmp) {
					$col = $col_tmp->toArray();
					$col['label'] = ucwords( strtolower( str_replace(array("_"),array(" "),$col['name']) ) );
					$col['type'] = $col['type']->getName();
					$col['field_id'] = -1;
					if ($form_id != -1) {
						$field = DB::table("forms_fields")->select("*")->where("table","=",$table['name'])->where("form_id","=",$form_id)->where("name","=",$col['name']);
						//;
						if ($field->count()>0) {
							//die("<pre>".print_r($field->get(),1)."</pre>");
							$col['field_id'] = $field->get()[0]->id;
							$col['order'] = $field->get()[0]->order;
						}
					}
					//$tables[$table->getName()][] = 
					//$table['columns'][] = $col;
					$table['columns'][] = $col;
				}
				$tables[] = $table;
			}
		}
		$txtDebug .= "\n\$tables - ".print_r($tables,1);
		//die("<pre>{$txtDebug}</pre>");
		return $tables;
	}
}  
?>
