<?php
namespace app\models;
use \yii\db\Expression;
use app\models\Catalog;
use yii\data\ActiveDataProvider;

class CatalogSearch extends Catalog
{    
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'section', $this->section]);
        $query->andFilterWhere(['like', 'subsection', $this->subsection]);
        $query->andFilterWhere(['like', 'article', $this->article]);
        $query->andFilterWhere(['like', 'brend', $this->brend]);
        $query->andFilterWhere(['like', 'model', $this->model]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'size', $this->size]);
        $query->andFilterWhere(['like', 'color', $this->color]);
        $query->andFilterWhere(['like', 'orientation', $this->orientation]);
        $query->andFilterWhere(['cnt' => $this->cnt]);
        
        return $dataProvider;
    }
}

