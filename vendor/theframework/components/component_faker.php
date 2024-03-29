<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name ComponentFaker
 * @file component_faker.php
 * @version 1.0.0
 * @date 06-11-2021 18:18
 * @observations
 */
namespace TheFramework\Components;

class ComponentFaker 
{
    public function get_int(?int $maxl=null, ?int $minl=null): int
    {
        if(!$minl) $minl = 1;
        if(!$maxl) $maxl = 10;

        if($maxl<$minl) return 1;

        $all = [];
        for($i=0; $i<$minl; $i++)
            if($i!==0)
                $all[] = rand(0,9);
            else
                $all[] = rand(1,9);

        if(rand(0,1))
            (int) implode("", $all);

        $missing = $maxl-count($all);
        for($i=0; $i<$missing; $i++) {
            if(rand(0,1)) continue;
            $all[] = rand(0, 9);
        }

        return (int) implode("", $all);
    }

    public function get_rndint(int $min=0, int $max=9): int
    {
        if($max<$min) {
            $min = 0;
            $max = 9;
        }

        return rand($min, $max);
    }
    
    public function get_float(int $intl=3, int $decl=2): float
    {
        $float = [];
        for($i=0; $i<$intl; $i++)
            $float[] = $this->get_rndint();
        
        $float[] = ".";
        for($i=0; $i<$decl; $i++)
            $float[] = $this->get_rndint();
        
        return (float) implode("",$float);
    }

    private function _rand_value(array $array)
    {
        $i = array_rand($array,1);
        return $array[$i];
    }
    
    public function get_vouwel(): string
    {
        $chars = [
            "a","e","i","o","u","A","E","I","O","U"
        ];

        return $this->_rand_value($chars);
    }
    
    public function get_consonant(): string
    {
        $chars = [
            "b","c","d","f","g","h","j","k","l","m","n","p","q","r","s","t","v","w","x","y","z",
            "B","C","D","F","G","H","J","K","L","M","N","P","Q","R","S","T","V","W","X","Y","Z",
        ];

        return $this->_rand_value($chars);
    }
    
    public function get_letter(): string
    {
        $chars = [
            "b","c","d","f","g","h","j","k","l","m","n","p","q","r","s","t","v","w","x","y","z",
            "B","C","D","F","G","H","J","K","L","M","N","P","Q","R","S","T","V","W","X","Y","Z",
            "a","e","i","o","u","A","E","I","O","U"
        ];

        return $this->_rand_value($chars);
    }

    public function get_time(): string
    {
        $all = [];
        $int = $this->get_rndint(0,23);
        $all["hh"] = sprintf("%02d", $int);

        $int = $this->get_rndint(0,59);
        $all["mm"] = sprintf("%02d", $int);

        $int = $this->get_rndint(0,59);
        $all["ss"] = sprintf("%02d", $int);

        return implode(":", $all);
    }

    public function get_date(string $mindate="2000-01-01", string $maxdate="2021-01-01"): string
    {
        if(!trim($mindate)) $mindate = "1900-01-01";
        if(!trim($maxdate)) $maxdate = date("Y-m-d");

        $armindate = explode("-",$mindate);
        $armaxdate = explode("-",$maxdate);

        if($maxdate<$mindate) $armaxdate[0] = (string)(((int) $mindate[0])+1);

        $mindate = implode("-",$armindate);
        $maxdate = implode("-",$armaxdate);

        $dates = [$mindate];
        while($mindate<$maxdate) {
            $mindate = date("Y-m-d", strtotime("$mindate 00:00:00") + 86400);
            $dates[] = $mindate;
        }
        
        return $this->_rand_value($dates);
    }

    public function get_datetime(string $mindate="1900-01-01", string $maxdate="2021-01-01"): string
    {
        $all["date"] = $this->get_date();
        $all["time"] = $this->get_time();
        return implode(" ", $all);
    }

    public function get_hash(int $len=16): string
    {
        $timestamp = time();
        $hash = md5($timestamp);
        return substr($hash,0, $len);
    }

    public function get_word(int $len=10): string
    {
        $options = ["c","v"];
        $start = $this->_rand_value($options);
        $word = [];
        for($i=0; $i<$len; $i++) {
            if($start==="c") {
                $word[] = $this->get_consonant();
                $start = "v";
            }
            else {
                $word[] = $this->get_vouwel();
                $start = "c";
            }
        }
        return implode("",$word);
    }

    public function get_paragraph(int $words=20, int $maxwlen=10): string
    {
        $paragraph=[];
        for ($i=0; $i<$words; $i++) {
            $ilen = $this->get_rndint(1, $maxwlen);
            $paragraph[] = $this->get_word($ilen);
            //break;
        }
        return implode(" ",$paragraph);
    }
    
    public function get_email(): string
    {
        $email["user"] = strtolower($this->get_word(5));
        $email["at"] = "@";
        $email["domain"] = strtolower($this->get_word(5));
        $email["dot"] = ".";
        $email["extension"] = strtolower($this->get_word(3));
        return implode("", $email);
    }
}//ComponentFaker