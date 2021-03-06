<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\rest;

use Yii;
use yii\web\JsonParser;
use yii\helpers\Url;

class Events
{
    public static function onBeforeRequest($event)
    {

        // Only prepare if API request
        if (substr(Yii::$app->request->pathInfo, 0, 4) != 'api/') {
            return;
        }

        // JSON for all API requests except the API configuration
        if (substr(Yii::$app->request->pathInfo, 0, 9) != 'rest/admin') {
            Yii::$app->response->format = 'json';
        }

        Yii::$app->urlManager->addRules([

            // User: Default Controller
            ['pattern' => 'api/v1/user/<id:\d+>/spaces', 'route' => 'rest/user/user/spaces', 'verb' => 'GET'],
            ['pattern' => 'api/v1/user/username/<username:\w+>', 'route' => 'rest/user/user/view-by-username', 'verb' => 'GET'],
            ['pattern' => 'api/v1/user/email/<email:[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}>', 'route' => 'rest/user/user/view-by-email', 'verb' => 'GET'],
            ['pattern' => 'api/v1/user/subscribe/<userId:\d+>/', 'route' => 'rest/user/user/subscribe', 'verb' => 'POST'],
            ['pattern' => 'api/v1/user/', 'route' => 'rest/user/user/index', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/user/<id:\d+>', 'route' => 'rest/user/user/view', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/user/<id:\d+>', 'route' => 'rest/user/user/update', 'verb' => ['PUT', 'PATCH']],
            ['pattern' => 'api/v1/user/<id:\d+>', 'route' => 'rest/user/user/delete', 'verb' => ['DELETE']],
            ['pattern' => 'api/v1/user/full/<id:\d+>', 'route' => 'rest/user/user/hard-delete', 'verb' => ['DELETE']],
            ['pattern' => 'api/v1/user/', 'route' => 'rest/user/user/create', 'verb' => 'POST'],

            // User: Invite Controller
            //['pattern' => 'api/v1/user/invite', 'route' => 'api/user/invite/index', 'verb' => 'POST'],

            // User: Session Controller
            ['pattern' => 'api/v1/user/session/all/<id:\d+>', 'route' => 'rest/user/session/delete-from-user', 'verb' => 'DELETE'],

            // Content
            ['pattern' => 'api/v1/content/find-by-container/<id:\d+>', 'route' => 'rest/content/content/find-by-container', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/content/container', 'route' => 'rest/content/container/list', 'verb' => 'GET'],
            //['pattern' => 'api/v1/content/<id:\d+>', 'route' => 'api/user/content/view', 'verb' => ['GET', 'HEAD']],
            //['pattern' => 'api/v1/content/', 'route' => 'api/user/content/delete', 'verb' => 'DELETE'],
            //['pattern' => 'api/v1/content/pin/<id:\d+>', 'route' => 'api/user/content/pin', 'verb' => 'POST'],
            //['pattern' => 'api/v1/content/unpin/<id:\d+>', 'route' => 'api/user/content/unpin', 'verb' => 'POST'],
            //['pattern' => 'api/v1/content/archive/<id:\d+>', 'route' => 'api/user/content/archive', 'verb' => 'POST'],
            //['pattern' => 'api/v1/content/unarchive/<id:\d+>', 'route' => 'api/user/content/unarchive', 'verb' => 'POST'],

            // Comment
            ['pattern' => 'api/v1/comment/<id:\d+>', 'route' => 'rest/comment/comment/view', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/comment/<id:\d+>', 'route' => 'rest/comment/comment/delete', 'verb' => 'DELETE'],

            // Like
            ['pattern' => 'api/v1/like/<id:\d+>', 'route' => 'rest/like/like/view', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/like/<id:\d+>', 'route' => 'rest/like/like/delete', 'verb' => 'DELETE'],
            ['pattern' => 'api/v1/like/', 'route' => 'rest/like/like/list', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/like/<model:[0-9a-zA-Z\-]+>/<id:\d+>', 'route' => 'rest/like/like/create', 'verb' => 'PUT'],


            // Post
            ['pattern' => 'api/v1/post/', 'route' => 'rest/post/post/find', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/post/<id:\d+>', 'route' => 'rest/post/post/view', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/post/<id:\d+>', 'route' => 'rest/post/post/update', 'verb' => ['PUT', 'PATCH']],
            ['pattern' => 'api/v1/post/<id:\d+>', 'route' => 'rest/post/post/delete', 'verb' => ['DELETE']],
            ['pattern' => 'api/v1/post/container/<containerId:\d+>', 'route' => 'rest/post/post/create', 'verb' => 'POST'],
            ['pattern' => 'api/v1/post/container/<containerId:\d+>', 'route' => 'rest/post/post/find-by-container', 'verb' => 'GET'],

            // File
            ['pattern' => 'api/v1/file/download/<id:\d+>', 'route' => 'rest/file/file/download', 'verb' => ['GET', 'HEAD']],

            // Space
            ['pattern' => 'api/v1/space/', 'route' => 'rest/space/space/list', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/space/<id:\d+>', 'route' => 'rest/space/space/delete', 'verb' => ['DELETE']],
            ['pattern' => 'api/v1/space/', 'route' => 'rest/space/space/create', 'verb' => 'POST'],
            ['pattern' => 'api/v1/space/<id:\d+>', 'route' => 'rest/space/space/view', 'verb' => 'GET'],
            ['pattern' => 'api/v1/space/<id:\d+>', 'route' => 'rest/space/space/update', 'verb' => ['PUT', 'PATCH']],

            // Wiki (temp)
            ['pattern' => 'api/v1/wiki/', 'route' => 'rest/wiki/wiki/find', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/wiki/<id:\d+>', 'route' => 'rest/wiki/wiki/view', 'verb' => ['GET', 'HEAD']],
            ['pattern' => 'api/v1/wiki/<id:\d+>', 'route' => 'rest/wiki/wiki/delete', 'verb' => ['DELETE']],
            ['pattern' => 'api/v1/wiki/<id:\d+>', 'route' => 'rest/wiki/wiki/update', 'verb' => ['PUT', 'PATCH']],
            ['pattern' => 'api/v1/wiki/container/<containerId:\d+>', 'route' => 'rest/wiki/wiki/create', 'verb' => 'POST'],
            ['pattern' => 'api/v1/wiki/container/<containerId:\d+>', 'route' => 'rest/wiki/wiki/find-by-container', 'verb' => 'GET'],
            ['pattern' => 'api/v1/wiki/migrate/<fromContainerId:\d+>/<toContainerId:\d+>/', 'route' => 'rest/wiki/wiki/migrate', 'verb' => 'POST'],

            // API Config
            ['pattern' => 'rest/admin/index', 'route' => 'rest/admin', 'verb' => ['POST', 'GET']],

            // Catch all to ensure verbs
            ['pattern' => 'rest/<tmpParam:.*>', 'route' => 'rest/error/notfound']

        ], true);
    }

    /**
     * Adds an api administration item to the admin menu.
     *
     * @param type $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('base', '<strong>HumHub</strong> API'),
            'url' => Url::toRoute('/rest/admin/index'),
            'group' => 'settings',
            'icon' => '<i class="fa fa-object-group"></i>',
            'isActive' => Yii::$app->controller->module && Yii::$app->controller->module->id == 'rest' && Yii::$app->controller->id == 'admin',
            'sortOrder' => 650
        ]);
    }
}
