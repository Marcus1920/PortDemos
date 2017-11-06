<?php namespace App;

use App\FormField;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB as DB;

class Form extends Eloquent {
	protected $table    = 'forms';
	protected $fillable = ['name','slug','active', 'table', 'purpose', 'created_by', 'updated_by', 'fff'];
	protected $appends = array( "fields" );
	protected $hidden = array( "fields" );

	//public $fields = array();

	function __construct(array $attributes = array()) {
		ini_set("display_errors", 1);
		error_reporting(-1);
		static::bootIfNotBooted();
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$attributes) \$booted - ".print_r($this->booted,1).", \$exists - {$this->exists}, \$attributes - ".print_r($attributes,1);
		/////echo ("<pre>$txtDebug</pre>");
		/*echo "<pre>";
		debug_print_backtrace(0, 10);
		echo "</pre>";*/
		//$txtDebug .= PHP_EOL."  \$this A - ".print_r($this->toArray(),1);
		parent::__construct($attributes);
		$txtDebug .= PHP_EOL."  \$this B - ".print_r($this->toArray(),1);
		///$this->load($this->getRelations());
		//$this->fill($attributes);
		//$this->forceFill(array('id'=>5));
		//if (count($attributes))
		/////$txtDebug .= PHP_EOL."  \$this C - ".print_r($this->toArray(),1);
		/////$txtDebug .= PHP_EOL."  \$original - ".print_r($this->getoriginal(),1);
		$txtDebug .= PHP_EOL."  \$this->getKeyName() - ".var_export($this->getKeyName().", \$this->getKey() - ".var_export($this->getKey(), 1),1);
		//$fresh = $this->fresh( array('id'=>5) );
		///$txtDebug .= PHP_EOL."  getDirty() - ".var_export($this->getDirty(),1);
		///$txtDebug .= PHP_EOL."  getFillable() - ".var_export($this->getFillable(),1);
		///$txtDebug .= PHP_EOL."  getHidden() - ".var_export($this->getHidden(),1);
		///$txtDebug .= PHP_EOL."  getRelations() - ".var_export($this->getRelations(),1);
		///$txtDebug .= PHP_EOL."  getVisible() - ".var_export($this->getVisible(),1);
		//$txtDebug .= PHP_EOL."  \$fresh - ".var_export($fresh,1);

		//if (count($attributes) > 0) die("<pre>$txtDebug</pre>");
		///echo ("<pre>$txtDebug</pre>");
	}

	public function fill(array $attributes = array()) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$attributes) \$booted - ".print_r($this->booted,1).", \$exists - {$this->exists}, \$attributes - ".print_r($attributes,1);
		parent::fill($attributes);
		/////$txtDebug .= PHP_EOL."  \$this: attributes -  ".print_r($this->getAttributes(),1);
		/////$txtDebug .= PHP_EOL."  \$this C - ".print_r($this->toArray(),1);
		$txtDebug .= PHP_EOL."  \$original - ".print_r($this->getoriginal(),1);
		///echo "<pre>";
		///debug_print_backtrace(0, 10);
		////echo "</pre>";
		///$inst = new static;
		///$it = $inst->newQuery()->get(array("*"));
		///$txtDebug .= PHP_EOL."  SQL - ".print_r($this->get(),1);
		///if (count($attributes) > 0)
		//die("<pre>$txtDebug</pre>");
		///echo("<pre>$txtDebug</pre>");
	}

	public function find($id, $columns = ['*'])
	{
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "(\$id) \$id - " . print_r($id, 1);
		die("<pre>$txtDebug</pre>");
	}

	/*public static function findOrNew($id, $columns = ['*']) {
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "(\$id) \$id - " . print_r($id, 1);
		die("<pre>$txtDebug</pre>");
	}*/

	public function getBindings() {
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "() ";
		die("<pre>$txtDebug</pre>");
	}

	/*public static function where($column, $operator = null, $value = null, $boolean = 'and') {
		$txtDebug = __CLASS__ . "." . __FUNCTION__ . "(\$column) \$column - " . print_r($column, 1);
		die("<pre>$txtDebug</pre>");
	}*/

	/*public function fresh(array $with = []) {
		die("fresh");
	}*/

	/*public function get(array $cols = array()) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$cols) \$cols - ".print_r($cols,1);
		die("<pre>$txtDebug</pre>");
		///echo("<pre>$txtDebug</pre>");
	}*/

	/*function newInstance(array $attributes = array(), $exists = false) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$attributes) \$exists - {$exists}, \$attributes - ".print_r($attributes,1);
		//parent::fill($attributes);
		//die("<pre>$txtDebug</pre>");
		echo("<pre>$txtDebug</pre>");
	}*/

	public function newFromBuilder($attributes = [], $connection = null) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$attributes) \$exists - {$this->exists}, \$attributes - ".print_r($attributes,1);
		$attributes = (array) $attributes;
		//echo "<pre>";
		//debug_print_backtrace(0, 10);
		//echo "</pre>";
		//$model = ( (Form) (parent::newFromBuilder($attributes, $connection)) );
		$model = parent::newFromBuilder($attributes, $connection);
		$fresh = self::newInstance( (array) $attributes );
		$model->fill( $attributes );
		///$model->setAttribute("fuck", "you");
		/////$model->setAttribute("fields", $this->getFields($attributes[$model->getKeyName()]));
		//$model->setAttribute("fields", array());
		//////////$model->setAttribute("id", $attributes[$model->getKeyName()]);
		$txtDebug .= PHP_EOL."  \$model: attributes - ".print_r($model->getAttributes(),1).", dirty - ".print_r($model->getDirty(),1).", guarded - ".print_r($model->getGuarded(),1).", hidde - ".print_r($model->getHidden(),1).", original - ".print_r($model->getOriginal(),1);
		$txtDebug .= PHP_EOL."  \$model->getAttrbute(id) - {$model->getAttribute('id')}, \$model->getKeyName() - ".print_r($model->getKeyName().", \$model->getKey() - ".print_r($model->getKey(), 1),1);
		////$txtDebug .= PHP_EOL."  \$mde l - ".print_r($model, 1);
		//$txtDebug .= PHP_EOL."  \$fresh - ".print_r($fresh,1);
		///$model->getFi
		//$txtDebug .= PHP_EOL."  \$this - ".print_r($this, 1);
		/////die("<pre>$txtDebug</pre>");
		/////echo("<pre>$txtDebug</pre>");
		return $model;
	}

	public function newInstance($attributes = [], $exists = false)
	{
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$attributes) \$exists - {$exists}, \$attributes - ".print_r($attributes,1);
		$ret = parent::newInstance($attributes, $exists); // TODO: Change the autogenerated stub
		///$ret = $this->fresh();
		$txtDebug .= PHP_EOL."  \$this B - ".print_r($this->toArray(),1);
		$txtDebug .= PHP_EOL."  \$this B - ".print_r($this->__get("id"),1);
		$txtDebug .= PHP_EOL."  \$ret - ".print_r($ret,1);
		return $ret;
		//$txtDebug .= PHP_EOL."  stack - ".print_r(debug_backtrace(false, 2),1);
		//$txtDebug .= PHP_EOL."  stack - ".print_r(debug_print_backtrace(),1);
		//die("<pre>$txtDebug</pre>");
		echo("<pre>$txtDebug</pre>");
		echo "<pre>";
		debug_print_backtrace(0, 10);
		echo "</pre>";
		die();
	}

	public function setRawAttributes_(array $attributes, $sync = false) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$attributes, \$sync = false) \$exists - {$this->exists}, \$sync - {$sync}, \$attributes - ".print_r($attributes,1);
		///die("<pre>$txtDebug</pre>");
		//echo("<pre>$txtDebug</pre>");
	}

	/*protected static function boot() {
		$txtDebug = __CLASS__.".".__FUNCTION__."()";
		//$txtDebug .= PHP_EOL."  \$this - ".print_r($this->toArray(),1);
		//die("<pre>$txtDebug</pre>");
		//echo("<pre>$txtDebug</pre>");
	}*/

	/*public function load($relations) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$relations) \$relations - ".print_r($relations,1);
		parent::load($relations);
		die("<pre>$txtDebug</pre>");
		echo("<pre>$txtDebug</pre>");
		return $this;
	}*/

	public function getDates() {
		$txtDebug = __CLASS__.".".__FUNCTION__."()";
		//parent::fill($attributes);
		///$txtDebug .= PHP_EOL."  \$this C - ".print_r($this,1);
		//die("<pre>$txtDebug</pre>");
		///echo("<pre>$txtDebug</pre>");
		return parent::getDates();
	}

	public function getFields($form_id) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$form_id) \$form_id - {$form_id}";
		//$txtDebug .= PHP_EOL."  \$this A - ".print_r($this->get(array("*"))->toArray(),1);
		$fields = array();
		$fields = FormField::where("form_id", $form_id)->get()->toArray();
		$txtDebug .= PHP_EOL."  \$fields - ".print_r($fields,1);
		//die("<pre>$txtDebug<pre>");
		return $fields;
	}

	public function getFieldsAttribute($form_id) {
		$txtDebug = __CLASS__.".".__FUNCTION__."(\$form_id) \$form_id - ".print_r($form_id, 1);
		//$txtDebug .= PHP_EOL."  \$this - ".print_r($this,1);
		/*$txtDebug .= PHP_EOL."  id - ".print_r($this->id,1);
		$txtDebug .= PHP_EOL."  id - ".print_r($this['id'],1);
		$txtDebug .= PHP_EOL."  id - ".print_r($this->toArray()['id'],1);*/
		//die("<pre>$txtDebug<pre>");
		//return array( array(1,2,3), array(4,5,6), array(7,8,9) );
		return $this->getFields($this['id']);
		//return array(1,2,3);
	}
	
	public function save(array $options = array()) {
		$txtDebug = "save(\$options) \$options - ".print_r($options,1);
		//echo "<pre>$txtDebug<pre>";
		//die("<pre>$txtDebug<pre>");
		return parent::save($options);
	}
	
	public function saveFields($req, $fff) {
		$form_id = $req['formId'];
		$fields = array_key_exists("field", $req) ? $req['field'] : array();
		$table = $req['table'];
		//$txtDebug = "saveFields(req) form_id - {$form_id}, fields<pre>".print_r($fields, 1)."</pre>";
		/*$txtDebug = "saveFields(req) form_id - {$form_id}";
		$txtDebug .= "\n  \$fields - ".print_r($fields, 1)."";
		$txtDebug .= "\n  \$fff - ".print_r($fff, 1)."";
		$txtDebug .= "\n  fullUrlWithQuery - ".print_r($req,1)."";
		*/
		$txtDebug = "saveFields(req) form_id - {$form_id}";
		$txtDebug .= "\n  \$fields - ".print_r($fields, 1)."";
		$txtDebug .= "\n  \$fff - ".print_r($fff, 1)."";
		$txtDebug .= "\n  fullUrlWithQuery - ".print_r($req,1)."";
		//die("<pre>$txtDebug<pre>");
		\Session::flash('success', "saveFields(req)");
		\Session::flash('success', "fields<pre>".print_r($fields, 1)."</pre>");
		$saved = true;
		$ids = [];
		if (count($fields) > 0) foreach ($fields AS $i=>$field) if ($field['id']) {
			$ids[] = $field['id'];
		}
		$txtDebug .= "\n  \$ids - ".print_r($ids, 1)."";
		$sqlDelete = "DELETE FROM forms_fields WHERE form_id = {$form_id}";
		if (count($ids) > 0) $sqlDelete .= " AND id NOT IN (".implode(",", $ids).") ";
		$txtDebug .= "\n  \$sqlDelete - {$sqlDelete}";
		//die("<pre>$txtDebug<pre>");
		\DB::delete($sqlDelete);
		//die("<pre>$txtDebug<pre>");
		if (count($fields) > 0) {
			$order = 0;
			foreach ($fields AS $i=>$field) {
				$field['form_id'] = $form_id;
				$field['order'] = $order;
				$field['table'] = $table;
				/*$fff->validate($field, [
					'name'=>"required"
				]);*/
				if (array_key_exists($field['type'], $field['opts'])) {
					if ($field['type'] == "rel") {
						//$field['opts'][$field['type']]['display'] = "";
					}
					$field['options'] = json_encode($field['opts'][$field['type']]);
				}	else $field['options'] = json_encode($field['opts']);
				/////$field = array('id'=>$field_id);
				/////if ($field_id == -1) $field = array('form_id'=>$form_id, 'name'=>$fields['name'][$i]);
				//if ($field_id == -1) $field = array('form_id'=>$form_id, 'name'=>$fields['name'][$i], 'type'=>$fields['type'][$i]);
				//$ff = FormField::where(array('form_id'=>$form_id))->first();
				/*$ff = FormField::where(array('id'=>$field['id']))->first();
				$txtDebug .= "\n  ff A - ".print_r(($ff != null ? $ff->toArray() : null), 1)."";
				if (!$ff) $ff = new FormField();*/
				$txtDebug .= "\n  \$field - ".print_r($field, 1)."";
				$ff = FormField::findOrNew($field['id']);
				//$ff = FormField::findOrFail(1);
				$txtDebug .= "\n  ff Ca - ".print_r($ff->toArray(), 1)."";
				$ff->fill($field);
				$txtDebug .= "\n  ff Cb - ".print_r($ff->toArray(), 1)."";
				$saved = $ff->save();
				$order++;
			}
		}
		//parent::save();
		\Log::info($txtDebug);
		///die("<pre>$txtDebug<pre>");
		//echo "<pre>$txtDebug<pre>";
		return $saved;
	}

	public function getOneAttribute() {
		return "One Attribute";
	}
}
