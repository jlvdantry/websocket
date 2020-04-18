<?php

namespace App\AdipUtils;

class ArrayList implements IAbstractReturnType{
    protected $arreglo;
    
	public function __construct(){
		$this->arreglo = array();
	}

	public function __destruct(){
		;
	}

	public function add(Object $item){
		$this->arreglo[] = $item;
	}

	public function addFromArray(Array $a){		
		for($x=0;$x<count($a);$x++){
			if(is_object($a[$x])){
				$this->add($a[$x]);
			}
		}
	}

	public function isEmpty():bool{
		return (bool)$this->size()==0;
	}

	public function clear(){
		$this->arreglo=array();
	}

	public function remove($item){
		unset($this->arreglo[$item]);
		$artemp=$this->toArray();
		$this->arreglo=$artemp;
	}

	public function leave($item){
		$this->arreglo[$item]=NULL;
	}

	public function size():int{
		return count($this->arreglo);
	}

	public function toArray():Array{
		$ret=array();
		foreach ($this->arreglo as $item) {
		   $ret[]=$item;
		}
		return $ret;
	}

	public function getItem(int $item):Object{
		return $this->arreglo[$item];
	}
}
