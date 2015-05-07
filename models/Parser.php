<?php
namespace app\models;
use \yii\db\Expression;

class Parser
{
    public $str;
    public $arr;
    public $size;
    private $sz = Array('S', 'M', 'L', 'XS', 'XL', 'XXL');
    private $cl = Array('син', 'бел', 'крас', 'черн', 'зелен', 'желт');
            
    function __construct($str)
    {
        $this -> str = preg_replace('/[\"\-\)\(=]/', ' ', $str);
        $this -> arr = explode(' ', $this -> str);
        $this -> size = sizeof($this -> arr);
        mb_internal_encoding("utf-8");
    }
    
    public function getArticle()
    {
        $arc = '';
        for ($i = 0; $i < $this -> size; ++$i)
        {
            $str = preg_replace('/[^0-9]/', ' ', $this -> arr[$i]);
            if ((int)$str > 1000000)
            {
                $arc = $this -> arr[$i];
                break;
            }
        }
        return $arc;
    }
    
    public function getBrend()
    {
        $str = preg_replace('/[^a-zA-Z\ ]/', '', $this -> str);
        $str = trim($str);
        $arr = explode(' ', $str);
        return $arr[0];
    }
    
    public function getModel()
    {
        $str = preg_replace('/[^a-zA-Z\ ]/', '', $this -> str);
        $str = preg_replace('/\ {2,}/', ' ', $str);
        $str = trim($str);
        $arr = explode(' ', $str);
        if (!isset($arr[1]))
            return '';
        else
            return trim($arr[1]);
    }
    
    public function getSection()
    {
        $str = preg_replace('/[a-zA-Z0-9\.\(\)]/', '', $this -> str);
        $str = trim($str);
        $arr = explode(' ', $str);
        return $arr[0];
    }
    
    public function getSubsection()
    {
        $str = preg_replace('/[a-zA-Z0-9\.\(\)\%\+\,]/', '', $this -> str);
        $str = preg_replace('/\ {2,}/', ' ', $str);
        $str = trim($str);
        $arr = explode(' ', $str);   
        
        if (!isset($arr[1]) || (mb_strlen($arr[1]) < 4 && !isset($arr[2])))
            return '';
        
        if (mb_strlen($arr[1]) > 3)
            return $arr[1];
        else       
            return $arr[1] . ' ' . $arr[2];
    }
    
    public function getName()
    {
        $str = preg_replace('/[a-zA-Z0-9\.\(\):\+]/', '', $this -> str);
        $str = preg_replace('/\ {2,}/', ' ', $str);
        $str = trim($str);
        return $str;
    }
    
    public function getSize()
    {
        $str = trim($this -> str);
        $arr = explode(' ', $str); 
        $tmp = array_pop($arr);
        if (((int)$tmp > 0 && (int)$tmp < 1000) || in_array($tmp, $this -> sz))
            return $tmp;
        else        
            return '';
    }
    
    public function getColor()
    {
        $str = preg_replace('/[a-zA-Z0-9\(\):\+]/', '', $this -> str);
        $str = preg_replace('/\ {2,}/', ' ', $str);
        $str = trim($str);
        $arr = explode(' ', $str); 
        $find = true;
        $color = '';
        for ($i = 0; $i < sizeof($arr) && $find; ++$i)
        {
            for ($j = 0; $j < sizeof($this -> cl); ++$j)
            {
                if (mb_strpos($arr[$i], $this -> cl[$j]) !== false && mb_strpos($arr[$i], 'белье') === false)
                {
                    $color = $arr[$i];
                    $find = false;
                    break;
                }
            }
        }
        
        return $color;
    }
    
    public function getOrientation()
    {
        $str = $this -> str;
        if (mb_strpos($str, 'Клюшка') !== false || mb_strpos($str, 'клюшка') !== false)
        {
            $arr = explode(' ', $str); 
            $tmp = trim(array_pop($arr));
            
            if ($tmp === 'L' || $tmp === 'R')
                return $tmp;
        }
        
        return '';
    }
}
?>