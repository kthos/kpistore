<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[KpiArchive]].
 *
 * @see KpiArchive
 */
class KpiArchiveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KpiArchive[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KpiArchive|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
