<?php
// objects and classes


/**
 * Flexible but longform 
 */
class Person {
	private $name;
	private $age;
	private $city;

  // Methods
  function set_props($name, $age, $city) {
    $this->name = $name;
    $this->age = $age;
    $this->city = $city;
  }
  function get_name() {
    return $this->name;
  }
    function get_age() {
    return $this->age;
  }
    function get_city() {
    return $this->city;
  }
}

$elvis = new Person();
$elvis->set_props('Elvis Krstulovic', '40', 'Ljubljana');

echo $elvis->get_name() . '<br>';
echo $elvis->get_age() . '<br>';
echo $elvis->get_city() . '<br><br>';


/**
 * perhaps more elegant version
 */ 

class Animal {
	// Structure
	private $name;
	private $age;
	private $breet;

  // Methods
  public function __construct($name, $age, $breed) {
    $this->name = $name;
    $this->age  = $age;
    $this->breed = $breed;
  }

 function __destruct() {
  	$data = "<br>{$this->name}<br>";
	  $data .= "{$this->age}<br>";
	  $data .= "{$this->breed}<br>";
  	echo $data; // this ouputs not in place where we want but at the end
  }

  public function getAsText() {
    return "$this->name <br> $this->age <br> $this->breed <br><br>";
  }

}

// Create an Object from Class, which ouputs automatically because __desctuct has echo inside
$emma = new Animal('Emma', '5', 'Istrian Hound'); // more secure, cannot modify data from outsite class


/**
 * perhaps most elegant and correct version
 * data is private and cannot be modifired from outside, but since function does not have echo inside it also renders where it is supposed to
 */ 

class Animales {
	// Structure
	private $name;
	private $age;
	private $breet;

  // Methods
  public function __construct($name, $age, $breed) {
    $this->name = $name;
    $this->age  = $age;
    $this->breed = $breed;
  }

  public function get_data() {
    return "$this->name <br> $this->age <br> $this->breed <br><br>";
  }
}

// Create an Object from Class
$toni = new Animales('Toni', '8', 'Terrier');

// Render
echo $toni->get_data();


/**
 * Simple class, but accessible from outside, so unsafe 
 */
class Animals {
	// Structure
	public $name;
	public $age;
	public $breet;

  // Methods
  public function __construct($name, $age, $breed) {
    $this->name = $name;
    $this->age  = $age;
    $this->breed = $breed;
  }
 }

// Render
$dona = new Animals('Dona', '14', 'Dogo Argentino');
echo "$dona->name <br> $dona->age <br> $dona->breed <br><br>";



