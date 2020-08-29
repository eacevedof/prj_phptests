<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name ComponentArrayquery
 * @file component_arrayquery.php
 * @date 29-08-2020 16:14 (SPAIN)
 * @observations:
 */
namespace TheFramework\Components;

class ComponentArrayquery
{
    private $array;
    
    public function __construct(array $array)
    {
        $this->array = $array;
    }

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
        $glue = "|*|";
        $repeated = [];
        if($this->array) {
            foreach ($this->array as $i => $row)
            {
                $imploed = implode($glue,$row);
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
                if($colname == $column && strtolower($value) == strtolower($colval))
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

    public function where($column, $value, $oper="=")
    {
        switch ($oper){
            case "=":
                $this->_equal($column,$value);
            break;
            case "==":
                $this->_equal_strict($column,$value);
            break;
        }
        return $this;
    }

    public function get_result(){return $this->array;}
}