<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\rest\controllers\content;

use Yii;
use humhub\modules\rest\components\BaseController;
use humhub\modules\rest\definitions\ContentDefinitions;
use humhub\modules\content\models\ContentContainer;


class ContainerController extends BaseController
{

    public function actionList()
    {
        $class = $this -> getContentContainerActiveRecordClass();
        $ids = [];

        $q = Yii::$app->request -> get('q');

        $query = ContentContainer::find()
            -> where(['class' => $class]);

        $pagination = $this->handlePagination($query);

        foreach ($query->all() as $contentcontainer) {
            $ids[] = $contentcontainer -> id;
        }

        $results =  $this -> returnContentContainerDefinition($ids, $q);

        return $this->returnPagination($query, $pagination, $results);
    }

    public function actionView($id)
    {
        $class = $this -> getContentContainerActiveRecordClass();

        $contentContainer = ContentContainer::findOne(['class' => $class, 'pk' => $id]);

        if ($contentContainer == null){
            return $this->returnError(404, 'Container not found!');
        }

        return $this-> returnContentContainerDefinition(array($contentContainer -> id), null)[0];
    }

    public function actionDelete($id){
        $class = $this -> getContentContainerActiveRecordClass();

        $contentContainer = $class::findOne(['id' => $id]);

        if ($contentContainer == null){
            return $this->returnError(404, 'Container not found!');
        }

        if ($contentContainer->delete()) {
            return $this->returnSuccess('Conatiner successfully deleted!');
        }
        return $this->returnError(500, 'Internal error while soft delete container!');
    }

    public function actionCreate(){
        $containerClass = $this -> getContentContainerActiveRecordClass();
        $container = new $containerClass;
        $postData = Yii::$app->getRequest()->getBodyParams();

        if (!empty($postData)) {
            $container->load($postData, '');
            $container->validate();
        }
         if ((!empty($postData) && $container->hasErrors())
        ) {
            return $this->returnError(400, 'Validation failed', [
                'message' => ($container !== null) ? $container->getErrors() : null,
            ]);
        }
         if (!$container->save()) {
            return $this->returnError(500, 'Internal error while add container!');
        }

        return $this-> returnContentContainerDefinition(array($container -> contentcontainer_id), null)[0];
    }

    public function actionUpdate($id){
        $class = $this -> getContentContainerActiveRecordClass();

        $container = $class::findOne(['id' => $id]);

        if ($container == null){
            return $this->returnError(404, 'Container not found!');
        }


        $postData = Yii::$app->getRequest()->getBodyParams();

        if (!empty($postData)) {
            $container->load($postData, '');
            $container->validate();
        }

        if ((!empty($postData) && $container->hasErrors())
        ) {
            return $this->returnError(400, 'Validation failed', [
                'message' => ($container !== null) ? $container->getErrors() : null,
            ]);
        }
         if (!$container->save()) {
            return $this->returnError(500, 'Internal error while add container!');
        }

        return $this-> returnContentContainerDefinition(array($container -> contentcontainer_id), null)[0];
    }

}
