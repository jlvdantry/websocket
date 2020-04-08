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

	public function add($item){
		if(is_object($item)){
			$this->arreglo[] = $item ;
		}else{
                    
		}
	}

	public function addFromArray($a){
		if(is_array($a)){
			for($x=0;$x<count($a);$x++){
				if(is_object($a[$x])){
					$this->add($a[$x]);
				}else{
                                    
				}
			}
		}
	}

	public function isEmpty(){
		return $this->size()==0;
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

	public function size(){
		$size = 0;
		foreach ($this->arreglo as $item) {
		   $size++;
		}
		return $size;
	}

	public function toArray(){
		$ret=array();
		foreach ($this->arreglo as $item) {
		   $ret[]=$item;
		}
		return $ret;
	}

	public function getItem($item){
		return $this->arreglo[$item];
	}
}
