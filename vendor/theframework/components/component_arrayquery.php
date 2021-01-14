<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name ComponentArrayquery
 * @file component_arrayquery.php
 * @date 30-12-2020 22:00 (SPAIN)
 * @observations:
 */
namespace TheFramework\Components;

class ComponentArrayquery
{
    private $array;
    private const GLUE = "|*|";
    private const HASHCOL = "*hashkey*";
    private const LEFTCOL = "*leftjoin*";
    
    public function __construct(array $array=[])
    {
        $this->array = $array;
    }

    private function _loopcond(){}

    public function remove_column($colnames)
    {
        if($this->array && is_array($colnames))
        {
            foreach ($this->array as $i => $row)
                foreach ($row as $colname => $value)
                    if(in_array($colname,$colnames))
                        unset($this->array[$i][$colname]);
        }
        return $this;
    }

    public function columns($colnames)
    {
        if($this->array && is_array($colnames))
        {
            foreach ($this->array as $i => $row)
                foreach ($row as $colname => $value)
                    if(!in_array($colname,$colnames))
                        unset($this->array[$i][$colname]);
        }
        return $this;
    }

    public function distinct()
    {
        $lines = [];
        $repeated = [];
        if($this->array) {
            foreach ($this->array as $i => $row)
            {
                $imploed = implode(self::GLUE,$row);
                if(in_array($imploed,$lines))
                    $repeated[] = $i;
                else
                    $lines[] = $imploed;
            }

            foreach ($repeated as $idx)
                unset($this->array[$idx]);
        }
        unset($lines);
        return $this;
    }

    private function _equal($column, $value)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $column && strtolower((string) $value) == strtolower((string) $colval))
                    $r[] = $row;
        $this->array = $r;
    }

    private function _equal_strict($column, $value)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $column && $value === $colval)
                    $r[] = $row;
        $this->array = $r;
    }

    private function _like($column, $value)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $column && strstr((string) $colval, (string) $value))
                    $r[] = $row;
        $this->array = $r;
    }

    private function _like_left($column, $value)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $column && strpos((string) $colval, (string) $value)>0)
                    $r[] = $row;
        $this->array = $r;
    }

    private function _like_right($column, $value)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
            {
                if ($colname == $column) {
                    $colval = (string) $colval;
                    $value = (string) $value;
                    //pr("colval:$colval, s:$value",strpos($colval, $value));
                    if (strpos($colval, $value) === 0)
                        $r[] = $row;
                }
            }
        $this->array = $r;
    }

    private function _get_like($value)
    {
        $value = trim($value);
        //pr($value);
        if(!$value || strlen($value)===1) return "general";
        if($value[0] === "%") return "left";
        if(substr($value, -1)==="%") return "right";
        return "general";
    }

    private function _aritmetic($colum, $value, $oper)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $colum) {
                    if($oper == "<") {
                        if ($colval < $value)
                            $r[] = $row;
                    }
                    elseif($oper == ">") {
                        if ($colval > $value)
                            $r[] = $row;
                    }
                    elseif($oper == "<=") {
                        if ($colval  <= $value)
                            $r[] = $row;
                    }
                    elseif($oper == ">=") {
                        if ($colval >= $value)
                            $r[] = $row;
                    }
                }
        $this->array = $r;
    }

    public function where($column, $value, $oper="=")
    {
        switch ($oper){
            case "=":
                $this->_equal($column,$value);
            break;
            case "==":
                $this->_equal_strict($column,$value);
            break;
            case "like":
                $type = $this->_get_like($value);
                $value = str_replace("%","",$value);
                if($type=="general") $this->_like($column,$value);
                elseif($type=="left") $this->_like_left($column, $value);
                else
                    $this->_like_right($column, $value);
            break;
            case ">":
            case "<":
            case "<=":
            case ">=":
                $this->_aritmetic($column, $value, $oper);
            break;
            default: ; break;
        }
        return $this;
    }

    public function is_null($column)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $column && $colval === null)
                    $r[] = $row;
        $this->array = $r;
        return $this;
    }

    public function is_empty($column)
    {
        $r = [];
        foreach ($this->array as $i => $row)
            foreach ($row as $colname => $colval)
                if($colname == $column && empty($colval))
                    $r[] = $row;
        $this->array = $r;
        return $this;
    }

    public function in($column, array $values)
    {
        $r = [];
        if($this->array && $column && $values)
        {
            foreach ($this->array as $i => $row)
                foreach ($row as $colname => $colval)
                    if($column==$colname && in_array($colval, $values))
                        $r[] = $row;
        }
        $this->array = $r;
        return $this;
    }

    public function not_in($column, array $values)
    {
        $r = [];
        if($this->array && $column && $values)
        {
            foreach ($this->array as $i => $row)
                foreach ($row as $colname => $colval)
                    if($column==$colname && !in_array($colval, $values))
                        $r[] = $row;
        }
        $this->array = $r;
        return $this;
    }

    private function _get_hashed(array $array, $columns)
    {
        $arhased = [];
        if($array && $columns)
        {
            foreach ($array as $i => $row)
            {
                $colvals = [];
                foreach ($row as $colname => $colval)
                    if(in_array($colname, $columns)) $colvals[] = (string) $colval;
                
                $hashkey = implode(self::GLUE, $colvals);
                $arhased[$i] = $row;
                $arhased[$i][self::HASHCOL] = $hashkey;
            }
        }
        return $arhased;
    }

    private function _get_byhash(array $array, $hash)
    {
        $r = [];
        foreach ($array as $i => $row)
            if($row[self::HASHCOL] === $hash)
                $r[] = $row;
        return $r;
    }

    //aron [ar1_f1 => ar2_f1, ar1_f2 => ar2_f2]
    public function innerjoin(array $array, array $aron)
    {
        $f = [];
        
        $keys1 = array_keys($aron);
        $keys2 = array_values($aron);
        
        $ar1 = $this->_get_hashed($this->array, $keys1);
        $ar2 = $this->_get_hashed($array, $keys2);

        //pr($ar1,"ar1");pr($ar2,"ar2");

        foreach ($ar1 as $i => $row1)
        {
            $hash = $row1[self::HASHCOL];
            $arfound = $this->_get_byhash($ar2, $hash);
            if($arfound)
                $f[] = $i;
        }

        foreach($this->array as $i => $r)
            if(!in_array($i, $f))
                unset($this->array[$i]);

        return $this;
    }

    public function leftjoin(array $array, array $aron)
    {
        $f = [];

        $keys1 = array_keys($aron);
        $keys2 = array_values($aron);

        $ar1 = $this->_get_hashed($this->array, $keys1);
        $ar2 = $this->_get_hashed($array, $keys2);

        foreach ($ar1 as $i => $row1)
        {
            $hash = $row1[self::HASHCOL];
            $arfound = $this->_get_byhash($ar2, $hash);
            if($arfound)
                $f[] = $i;
        }

        foreach($this->array as $i => $r){
            $this->array[$i][self::LEFTCOL] = 0;
            if (!in_array($i, $f))
                $this->array[$i][self::LEFTCOL] = 1;
        }

        return $this;
    }

    public function orderby($column, $type="asc")
    {
        usort($this->array, function ($a, $b) use ($column, $type) {
            if($type=="asc")
                return $a[$column] > $b[$column];
            else
                return $a[$column] < $b[$column];
        });
        return $this;
    }

    public function filter($function, $array=[])
    {
        if($array) $this->array = $array;
        $this->array = array_filter($this->array, $function);
        return $this;
    }

    public function map($function, $array=[])
    {
        if($array) $this->array = $array;
        $this->array = array_map($function, $this->array);
        return $this;
    }

    public function reduce($function, $initial=null, $array=[])
    {
        if($array) $this->array = $array;
        $this->array = array_reduce($this->array, $function, $initial);
        return $this;
    }

    private function _groupby(array $dims, array $metrics)
    {
        //to-do
    }

    private function _having(array $coditions)
    {
        //to-do
    }

    public function get_result(){return $this->array;}

    public function get_count(){return count($this->array);}
}
// pasar parametros para array asociativo