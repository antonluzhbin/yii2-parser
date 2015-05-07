<?php

namespace app\models;
use \yii\db\Expression;
use app\models\Parser;
use yii\data\ActiveDataProvider;

class Catalog extends \yii\db\ActiveRecord
{
    public function __construct() 
    {
        self::createTable();        
        parent::__construct();
    }
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className=__CLASS__)
    {               
        return parent::model($className);
    }
    
    public function rules()
    {
        return [
            // String
            [['section', 'subsection', 'article', 'brend', 'model', 'name', 'size', 'color', 'orientation'], 'string'],
            [['id'], 'integer']
        ];
    }
     
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'catalog';
    }
 
    /**
     * @return array primary key of the table
     **/
    public static function primaryKey()
    {
        return array('id');
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'section' => 'Раздел',
            'subsection' => 'Подраздел',
            'article' => 'Артикул',
            'brend' => 'Бренд',
            'model' => 'Модель',
            'name' => 'Наименование',
            'size' => 'Размер',
            'color' => 'Цвет',
            'orientation' => 'Ориентация',
            'cnt' => 'Количество'
        );
    }
    
    public function createTable()
    {
        $com = "CREATE TABLE IF NOT EXISTS `catalog` (" .
            "`id` int(11) NOT NULL AUTO_INCREMENT," .
            "`section` varchar(30) NOT NULL," .
            "`subsection` varchar(50) NOT NULL," .
            "`article` varchar(20) NOT NULL," .
            "`brend` varchar(30) NOT NULL," .
            "`model` varchar(50) NOT NULL," .
            "`name` varchar(255) NOT NULL," .
            "`size` varchar(10) NOT NULL," .
            "`color` varchar(20) NOT NULL," .
            "`orientation` varchar(1) NOT NULL," .
            "`cnt` int(11) NOT NULL," .
            "PRIMARY KEY (`id`)" .
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
            
        static::getDb()->createCommand($com)->execute();
    }
    
    public function parse() 
    {
        $file = fopen('../test.csv', 'r');
        $arr = Array();
        while(!feof($file)) 
        { 
            $str = fgets($file);
            $parser = new Parser($str);
            if (!isset($arr[$str]))
            {
                $arr[$str]['article'] = $parser->getArticle();  
                $arr[$str]['brend'] = $parser->getBrend();  
                $arr[$str]['model'] = $parser->getModel();  
                $arr[$str]['section'] = $parser->getSection();
                $arr[$str]['subsection'] = $parser->getSubsection();
                $arr[$str]['name'] = $parser->getName() . ' ' . $arr[$str]['brend'] . ' ' . $arr[$str]['model'];
                $arr[$str]['size'] = $parser->getSize();
                $arr[$str]['color'] = $parser->getColor();
                $arr[$str]['orientation'] = $parser->getOrientation();
                $arr[$str]['cnt'] = 1;
            }
            else
            {
                $arr[$str]['cnt']++;
            }
        }

        fclose($file);
        
        static::getDb()->createCommand('TRUNCATE TABLE ' . $this->tableName())->execute();

        $i = 1;
        foreach ($arr as $key => $value) 
        {
            if (trim($value['name']) !== '')
            {
                $model = new Catalog;
                $model->id = $i++;
                $model->article = $value['article'];
                $model->section = $value['section'];
                $model->subsection = $value['subsection'];
                $model->brend = $value['brend'];
                $model->model = $value['model'];
                $model->name = $value['name'];
                $model->size = $value['size'];
                $model->color = $value['color'];
                $model->orientation = $value['orientation'];
                $model->cnt = $value['cnt'];
                $model->save(); 
            }
        }
    }
}

