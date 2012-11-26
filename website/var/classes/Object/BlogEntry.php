<?php 

class Object_BlogEntry extends Object_Concrete {

public $o_classId = 2;
public $o_className = "BlogEntry";
public $title;
public $date;
public $summary;
public $content;
public $categories;


/**
* @param array $values
* @return Object_BlogEntry
*/
public static function create($values = array()) {
	$object = new self();
	$object->setValues($values);
	return $object;
}

/**
* @return string
*/
public function getTitle () {
	$preValue = $this->preGetValue("title"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->title;
	 return $data;
}

/**
* @param string $title
* @return void
*/
public function setTitle ($title) {
	$this->title = $title;
}

/**
* @return Pimcore_Date
*/
public function getDate () {
	$preValue = $this->preGetValue("date"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->date;
	 return $data;
}

/**
* @param Pimcore_Date $date
* @return void
*/
public function setDate ($date) {
	$this->date = $date;
}

/**
* @return string
*/
public function getSummary () {
	$preValue = $this->preGetValue("summary"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->summary;
	 return $data;
}

/**
* @param string $summary
* @return void
*/
public function setSummary ($summary) {
	$this->summary = $summary;
}

/**
* @return string
*/
public function getContent () {
	$preValue = $this->preGetValue("content"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->getClass()->getFieldDefinition("content")->preGetData($this);
	 return $data;
}

/**
* @param string $content
* @return void
*/
public function setContent ($content) {
	$this->content = $content;
}

/**
* @return array
*/
public function getCategories () {
	$preValue = $this->preGetValue("categories"); 
	if($preValue !== null && !Pimcore::inAdmin()) { return $preValue;}
	$data = $this->getClass()->getFieldDefinition("categories")->preGetData($this);
	 return $data;
}

/**
* @param array $categories
* @return void
*/
public function setCategories ($categories) {
	$this->categories = $this->getClass()->getFieldDefinition("categories")->preSetData($this, $categories);
}

protected static $_relationFields = array (
  'categories' => 
  array (
    'type' => 'objects',
  ),
);

public $lazyLoadedFields = array (
  0 => 'categories',
);

}

