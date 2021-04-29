<?php
namespace Ipblocker\Components;

class StringComponent
{
    private string $string;
    private string $matches;

    public function __construct(string $string)
    {
        $this->string = strtolower(trim($string));
    }

    private function _in_string(string $search, string $string): bool
    {
        if(strstr($string, $search))
            return true;
        return false;
    }

    public function has_some(array $substr=[]): bool
    {
        if(!$substr) return true;

        foreach ($substr as $search)
            if($this->_in_string($search, $this->string))
                return true;
        return false;
    }

    //!has_all => is_none
    public function has_all(array $substr=[]): bool
    {
        if(!$substr) return true;
        foreach ($substr as $search)
            if(!$this->_in_string($search, $this->string))
                return false;
        return true;
    }

    public function is_empty(){ return $this->string==="" || $this->string===null;}

    public function match($pattern)
    {
        $pattern = "/$pattern/im";
        $matches = [];
        $r = preg_match($pattern, $this->string, $matches);
        if($r) $this->matches[][$pattern] = $matches;
        return $r;
    }

    public function is_equal($string) {return $this->string === $string;}

    public function get_matches(){return $this->matches;}

    public function starts_with($string)
    {
        if(strpos($this->string, $string)===0) return true;
        return false;
    }

    public function is_larger($string){return strlen($this->string)>strlen($string);}

    public function is_shorter($string){return strlen($this->string)<strlen($string);}

    public function samelen($string){return strlen($this->string)==strlen($string);}

    public function ends_with($string)
    {
        if($this->is_shorter($string) || $this->samelen($string)) return false;
        $ipos = strpos($this->string, $string);
        if(!$ipos) return false;
        return (($ipos + strlen($string)) === strlen($this->string));
    }
}