<?php

namespace App\AdipUtils;

/**
 * ArrayList
 * Clase para manjar arreglos de objetos
 * 
 * @implements IAbstractReturnType
 */
class ArrayList implements IAbstractReturnType{
	
	/**
	 * Array con los elementos del ArrayList
	 * 
	 * @var Array
	 */
	protected $arreglo;
    
	
	/**
	 * Crea una instancia de ArrayList
	 * 
	 * @return ArrayList
	 */
	public function __construct(){
		$this->arreglo = array();
	}

	
	/**
	 * Elimina una instancia de ArrayList
	 */
	public function __destruct(){
		
	}

	
	/**
	 * Agrega un objeto al Array
	 * 
	 * @param Object $item
	 */
	public function add(Object $item){
		$this->arreglo[] = $item;
	}

	
	/**
	 * Agrega los elementos de un Array al ArrayList, siempre que sean Objetos
	 * 
	 * @param Array $a
	 */
	public function addFromArray(Array $a){		
		for($x=0;$x<count($a);$x++){
			if(is_object($a[$x])){
				$this->add($a[$x]);
			}
		}
	}


	/**
	 * Determina si un ArrayList está vacío (sin elementos)
	 * 
	 * @return bool
	 */
	public function isEmpty():bool{
		return (bool)$this->size()==0;
	}


	/**
	 * Elimina los elementos del ArrayList
	 * 
	 */
	public function clear(){
		$this->arreglo=array();
	}

	
	/**
	 * Elimina el elemento cuyo índice sea el dado en $item
	 * 
	 * @param int $item
	 */
	public function remove($item){
		unset($this->arreglo[$item]);
		$artemp=$this->toArray();
		$this->arreglo=$artemp;
	}

	
	/**
	 * Establece a NULL el elemento cuy índice sea dado en $item
	 * 
	 * @param int $item
	 */
	public function leave($item){
		$this->arreglo[$item]=NULL;
	}


	/**
	 * Devuelve el número de elementos contenidos en el Arraylist
	 * aun si son NULL
	 * 
	 * @return int
	 */
	public function size():int{
		return count($this->arreglo);
	}

	
	/**
	 * Devuelve una representacion del Arraylist como un Array
	 * 
	 * @return Array
	 */
	public function toArray():Array{
		$ret=array();
		foreach ($this->arreglo as $item) {
		   $ret[]=$item;
		}
		return $ret;
	}

	
	/**
	 * Obtiene el elemento cuyo índice sea dado en $item
	 * 
	 * @param int $item
	 */
	public function getItem(int $item):Object{
		return $this->arreglo[$item];
	}
}
