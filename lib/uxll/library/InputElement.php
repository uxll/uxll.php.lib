<?php
class CInputElement{
	protected $_filters;
	protected $_value;

	public function addFilter(IFilter $filter){
		$this -> _filters[] = $filter;
		return $this;
	}

	public function setValue($value){
		$this -> _value = $this -> _filter($value);
	}

	protected function _filter($value){
		foreach ($this->_filters as $filter) {
			$value = $filter -> filter($value);
		}
		return $value;
	}

	public function getValue(){
		return $this -> _value;
	}
}