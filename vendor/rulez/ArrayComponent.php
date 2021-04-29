<?php
namespace Ipblocker\Components;

class ArrayComponent
{
    private array $array;
    private array $keys;
    private array $values;

    private string $matches;

    public function __construct(array $array)
    {
        $this->array = $array;
        $this->keys = array_keys($array);
        $this->values = array_values($array);
    }

    private function _in_string($search, $string){
        if(strstr($string, $search))
            return true;
        return false;
    }

    public function is_empty(){return count($this->keys)===0;}

    public function in_keys($string){ return in_array($string, $this->keys);}

    public function in_values($string){ return in_array($string, $this->values);}

    private function _has_some(array $array, array $search){
        foreach ($search as $mx)
            if(in_array($mx, $array))
                return true;
        return false;
    }

    private function _has_all(array $array, array $search){
        foreach ($search as $mx)
            if(!in_array($mx, $array))
                return false;
        return true;
    }

    public function has_somek(array $keys)
    {
        if(!$keys) return true;
        return $this->_has_some($this->keys, $keys);
    }

    public function has_somev(array $values)
    {
        if(!$values) return true;
        return $this->_has_some($this->values, $values);
    }

    public function has_allk(array $keys)
    {
        if(!$keys) return true;
        return $this->_has_all($this->keys, $keys);
    }

    public function has_allv(array $values)
    {
        if(!$values) return true;
        return $this->_has_all($this->values, $values);
    }

    private function _match($pattern, $string)
    {
        $pattern = "/$pattern/im";
        $matches = [];
        $r = preg_match($pattern, $string, $matches);
        if($r) $this->matches[] = ["string"=>$string,"pattern"=>$pattern, "matches"=>$matches];
        return $r;
    }

    public function match_somek($pattern){
        foreach ($this->keys as $key)
            if($this->_match($pattern, $key))
                return true;
        return false;
    }

    public function match_somev($pattern){
        foreach ($this->values as $value)
            if(is_string($value))
                if($this->_match($pattern, $value))
                    return true;
        return false;
    }

    public function is_equal($array) {return $this->array === $array;}

    public function get_matches(){return $this->matches;}

    public function is_larger($array){return count($this->array)>count($array);}

    public function is_shorter($array){return count($this->array)<count($array);}

    public function samesize($string){return count($this->array)==count($string);}

    public function is_firstk($key){return $this->keys[0] === $key;}

    public function is_firstv($val){return $this->values[0] === $val;}

    public function is_lastk($key){return end($this->keys) === $key;}

    public function is_lastv($val){return end($this->values[]) === $val;}

}