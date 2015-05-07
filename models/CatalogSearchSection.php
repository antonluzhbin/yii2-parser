<?php
namespace app\models;
use \yii\db\Expression;
use app\models\Catalog;
use yii\data\ActiveDataProvider;

class CatalogSearchSection extends Catalog
{    
    public function attributeLabels()
    {
        return array(
            'section' => 'Раздел',
            'subsection' => 'Подраздел',
            'cnt' => 'Количество'
        );
    }
        
    public function search($params)
    {
        $query = CatalogSearchSection::find()->select(['section','subsection','sum(cnt) as cnt'])->groupBy([ 'section', 'subsection' ]);        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);        
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere(['like', 'section', $this->section]);
        $query->andFilterWhere(['like', 'subsection', $this->subsection]);
        
        return $dataProvider;
    }
}

