<?php
include 'database.php';
class prepare_request extends database
{
    public $prepare_request = false;
    public $bd;
    public function prepare_request($e = false, $condition = null, $end = false)
    { 
        $i = 0;
        if (is_string($e) == false)
            return false;
            
        if (is_array($condition) == true && $i <= (count($condition) - 1))
            foreach ($condition as $i => $value) {

                    if (is_array($value) && $i == array_key_first($condition) && count($value) >= 1)
                        $e .= " where ". $value[0] ." like ?";
                    else if (is_array($value) && count($value) >= 2 && $value[1] == 0)
                        $e .=  " and "; 
                    else if (is_array($value) && count($value) >= 2 && $value[1] == 1)
                        $e .=  " or ";
                    else
                        return false;
                    if (is_array($value) && count($value) == 3 && $value[2] == '(')
                        $e .=  '(';
                    if (is_array($value) && $i != array_key_first($condition) && count($value) >= 1)
                        $e = $e . $value[0] ." like ?";
                    if (is_array($value) && count($value) == 3 && $value[2] == ')')
                        $e .=  ')';
            }
        if (is_string($end))
                $e .= $end;
        if ($e != false && is_string($e))
                $this->prepare_request = $this->bd->prepare($e);
        return $e;
    }

    public function __construct($e = false,$condition = false,$end = false)
    {
        $this->bd = Database::connect();
        $this->prepare_request($e,$condition,$end);
    }
}
