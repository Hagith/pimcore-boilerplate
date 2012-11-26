<?php 

class Object_BlogCategory extends Object_Concrete {

public $o_classId = 1;
public $o_className = "BlogCategory";
public $name;
public $entryCount;


/**
* @param array $values
* @return Object_BlogCategory
*/
public static function create($values = array()) {
	$object = new self();
	$object->setValues($values);
	return $object;
}

/**
* @return string
*/
public function getName () {
	$preValue = $this->preGetValue("name"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->name;
	 return $data;
}

/**
* @param string $name
* @return void
*/
public function setName ($name) {
	$this->name = $name;
}

/**
* @return float
*/
public function getEntryCount () {
	$preValue = $this->preGetValue("entryCount"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->entryCount;
	 return $data;
}

/**
* @param float $entryCount
* @return void
*/
public function setEntryCount ($entryCount) {
	$this->entryCount = $entryCount;
}

protected static $_relationFields = array (
);

public $lazyLoadedFields = NULL;

}

