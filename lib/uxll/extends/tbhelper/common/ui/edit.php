<?php
class tbhelperEditUI{
	private $caption = null;
	private $url = "";
	private $fieldsmanifest = null;
	private $row;
	private $fieldsdisplayname = null;
	private $extrahtml = null;
	private $tbname = null;
	private $submitbtntext = null;
	private $method = null;
	private $allfields = null;

//	private $privmask = null;
	private $engine;
	
	private $tbdescription;
	
	private $editdescripton;
	private $updatedescripton;
	
	public function __construct($tbhelperBase){
		$this -> engine = $tbhelperBase;
		$this -> tbdescription = $this -> engine -> getTbDescripton();

	}
	public function setTbname($v){
		$this -> tbname = $v;
	}
	public function setCaption($v){
		$this -> caption = $v;
	}
	public function getCaption(){
		return $this -> caption;
	}
	public function setUpdateUrl($v){
		$this -> url = $v;
	}
	public function getUpdateUrl(){
		return $this -> url;
	}	


	public function setFieldsManifest($v){
		$this -> fieldsmanifest = $v;
	}
	public function getFieldsManifest(){
		return $this -> fieldsmanifest;
	}

	public function setFieldsDisplayName($v){
		$this -> fieldsdisplayname = $v;
	}
	public function getFieldsDisplayName(){
		return $this -> fieldsdisplayname;
	}
	public function setExtraHTML($v){
		$this -> extrahtml = $v;
	}
	public function getExtraHTML(){
		return $this -> extrahtml;
	}
	public function getSubmitBtnText() {
		return $this -> submitbtntext;
	}
	public function setSubmitBtnText($v) {
		$this -> submitbtntext = $v;
	}
	public function getMethod() {
		return $this -> method;
	}
	public function setMethod($v) {
		$this -> method = is_string($v) && strtolower($v) === 'get' ? 'get' : 'post';
	}

	
	public function allowedAjax(){
		return true;
	}

	public function setEditDescription($v) {
		$this -> editdescripton = $v;
	}
	public function setUpdateDescription($v) {
		$this -> updatedescripton = $v;
	}
	public function setAllFields($v) {
		$this -> allfields = $v;
	}
	
	public function getEditDescription() {
		return $this -> editdescripton;
	}
	public function getUpdateDescription() {
		return $this -> updatedescripton;
	}
	public function getAllFields() {
		return $this -> allfields;
	}
	
	public function getHTML($action,$type,$extraData) {
		return $this -> engine -> getHTML($action,$type,$extraData);
	}
	public function getFieldFlag($field) {
		return $this -> engine -> getFieldFlag($field) ;
	}
	public function html($field,$default,$pk,$action="edit") {
		$type = strtolower($this -> engine -> getFieldType($field));
		$fieldsmanifest = $this -> getFieldsManifest();
#		echo P($fieldsmanifest);
		$extravalue = array();
		if(is_array($fieldsmanifest) && array_key_exists($field,$fieldsmanifest)){

			if(array_key_exists("type",$fieldsmanifest[$field])){
				$type = $fieldsmanifest[$field]["type"];
			}
			if(array_key_exists("extravalue",$fieldsmanifest[$field])){
				$extravalue = $fieldsmanifest[$field]["extravalue"];
			}
		}
		if(!$extravalue){
			$extravalue = $this -> getFieldsExtraData($field,$type,$pk,$default);
		}else{
			$extravalue = $this -> getFieldsExtraData($field,$type,$pk,$default,$extravalue);
		}
//echo $type;
		return $this -> getHTML($action,$type,$extravalue);
	}
	public function setRows($row) {
		$this -> row = $row;
	}
	public function getRows() {
		return $this -> row;
	}
	public function getPrimaryKey(){
		return $this -> engine -> getPrimaryKey();	
	}
//--------------------------------------------------------------------------------------------------------------------
	private function getEnumByDescription($subject) {
		if(preg_match("/^[a-z]+\(('[\w-]+'(,'[\w-]+')*)\)$/", $subject, $matches)){
			return explode("','",substr($matches[1], 1,-1));
		}
		return array();
	}
	private function getFieldsExtraData($field,$type,$pk,$default=null,$extravalue=null) {
		if(is_null($extravalue)){
			$extraData = array();
		}else{
			$extraData = $extravalue;
		}
		
		$type = $this -> engine -> getType($type);

		switch($type){
			case "textarea":
				if(!array_key_exists('cols',$extraData))$extraData['cols'] = 50;
				if(!array_key_exists('rows',$extraData))$extraData['rows'] = 5;
				if(!array_key_exists('name',$extraData))$extraData['name'] = $field."[".$pk."]";
				if(!array_key_exists('defaultvalue',$extraData))$extraData['defaultvalue'] = is_null($default) ? '' : $default;
				break;
			case "datetime":
				if(!array_key_exists('name',$extraData))$extraData['name'] = $field."[".$pk."]";
				if(!array_key_exists('defaultvalue',$extraData))$extraData['defaultvalue'] = is_null($default) ? date('Y-m-d H:i:s',time() + 8*60*60) : $default;
				break;
			case "date":
				if(!array_key_exists('name',$extraData))$extraData['name'] = $field."[".$pk."]";
				if(!array_key_exists('defaultvalue',$extraData))$extraData['defaultvalue'] = is_null($default) ? date('Y-m-d',time() + 8*60*60) : $default;
				break;
			
			case "enum":
			case "set":
				$fieldsmanifest = $this -> getFieldsManifest();
				$description = array_unique(array_merge($this -> getUpdateDescription(),$this -> getEditDescription()));//
				$description_update = $this -> getUpdateDescription();//
				$description_edit = $this -> getEditDescription();//
				
				$value = null;
				$enum = null;
				if(is_array($fieldsmanifest) && array_key_exists($field,$fieldsmanifest)){
					if(array_key_exists('value',$fieldsmanifest[$field])){
						$value = $fieldsmanifest[$field]['value'];
					}
					if(array_key_exists('enum',$fieldsmanifest[$field])){
						$enum = $fieldsmanifest[$field]['enum'];
					}
				}
				if(is_null($enum)){
					$enum = $this -> getEnumByDescription(
						isset($description_update[$field]["Type"])
						? $description_update[$field]["Type"]
						: $description_edit
						[$field]["Type"]
					);
				}
				
				
#echo P($value);				
				
				if(is_null($value)){
					$value = $enum;
				}
				if(!array_key_exists('name',$extraData))$extraData['name'] = $field."[".$pk."]";
				if(!array_key_exists('defaultvalue',$extraData))$extraData['defaultvalue'] = is_null($default) ? '' : $default;
				if(!array_key_exists('enum',$extraData))$extraData['enum'] = $enum;
				if(!array_key_exists('value',$extraData))$extraData['value'] = $value;
				
				break;
			case "varbinary":
				if(!array_key_exists('name',$extraData))$extraData['name'] = $field."[".$pk."]";
				if(!array_key_exists('defaultvalue',$extraData))$extraData['defaultvalue'] = is_null($default) ? '' : $default;
				break;
			case "text":
				$len = $this -> engine -> getFieldLen($field);
				if(!array_key_exists('name',$extraData))$extraData['name'] = $field."[".$pk."]";
				if(!array_key_exists('len',$extraData))$extraData['len'] = $len;
				if(!array_key_exists('defaultvalue',$extraData))$extraData['defaultvalue'] = is_null($default) ? '' : $default;
				break;
		}
		return $extraData;
	}	
}