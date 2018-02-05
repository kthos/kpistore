<?php

namespace frontend\controllers;

class FirstController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionKpi() {
        return $this->render('kpi');
    }

    public function actionKpi2() {
        $hello = "Nontawat Srimala";
        $a = 5;
        return $this->render('kpi2', [
                'hello' => $hello,
                'x' => $a
        ]);
    }

}
