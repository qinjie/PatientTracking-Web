<?php
namespace console\controllers;

use api\common\models\CarPark;
use common\components\rbac\UserRoleRule;
use common\models\auth\CarParkOwnerRule;
use common\models\auth\CreatorRule;
use Yii;
use yii\console\Controller;

## Excecute the action on command line
## "php ..\..\yii rbac/init"

class RbacController extends Controller
{
    public function actionInit()
    {
        $this->actionClearAll();
        $this->actionCreateRoles();
        $this->actionAssignRoles();
        $this->actionCreateRules();

        $this->actionCreatePermsRules();
    }

    public function actionClearAll()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    public function actionCreateRoles()
    {
        $auth = Yii::$app->authManager;

        # Create Roles
        $user = $auth->createRole('user');
        $auth->add($user);
        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $master = $auth->createRole('master');
        $auth->add($master);

        $auth->addChild($manager, $user);
        $auth->addChild($admin, $manager);
        $auth->addChild($master, $admin);
    }

    public function actionAssignRoles()
    {
        $auth = Yii::$app->authManager;

        $master = $auth->getRole('master');
        $admin = $auth->getRole('admin');
        $manager = $auth->getRole('manager');
        $user = $auth->getRole('user');

        $auth->assign($master, 1);
        $auth->assign($admin, 2);
        $auth->assign($manager, 3);
        $auth->assign($manager, 4);
        $auth->assign($user, 5);
        $auth->assign($user, 6);
        $auth->assign($user, 7);
        $auth->assign($user, 8);
    }

    public function actionCreateRules()
    {
        $auth = Yii::$app->authManager;

        # Add CreatorRule
        $rule_creator = new CreatorRule;
        $rule_creator->name = CreatorRule::name;
        $auth->add($rule_creator);

        #Add CarParkOwnerRule
        $rule_car_park_owner = new CarParkOwnerRule;
        $rule_car_park_owner->name = CarParkOwnerRule::name;
        $auth->add($rule_car_park_owner);
    }

    public function actionCreatePermsRules()
    {
        $this->actionCreatePermsRules_demo_test_post();

        $this->actionCreatePermsRules_v1_car_park();
        $this->actionCreatePermsRules_v1_sensor_gantry();
        $this->actionCreatePermsRules_v1_traffic_flow();
    }

    public function actionCreatePermsRules_v1_car_park()
    {
        $model = 'v1/car-park';
        $name_create = "{$model}/create";
        $name_update = "{$model}/update";
        $name_view = "{$model}/view";
        $name_index = "{$model}/index";
        $name_delete = "{$model}/delete";
        $name_search = "{$model}/search";

        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $manager = $auth->getRole('manager');
        $user = $auth->getRole('user');

        # test/Post for testing purpose
        $create = $auth->createPermission($name_create);
        $auth->add($create);
        $update = $auth->createPermission($name_update);
        $auth->add($update);
        $view = $auth->createPermission($name_view);
        $auth->add($view);
        $index = $auth->createPermission($name_index);
        $auth->add($index);
        $delete = $auth->createPermission($name_delete);
        $auth->add($delete);
        $search = $auth->createPermission($name_search);
        $auth->add($search);

        $auth->addChild($user, $view);
        $auth->addChild($user, $index);
        $auth->addChild($user, $search);
        $auth->addChild($manager, $create);
        $auth->addChild($manager, $update);
        $auth->addChild($manager, $delete);

        # Create permission to update own test-post
        $updateOwn = $auth->createPermission("{$name_update}_own");
        $updateOwn->description = "{$name_update}_own";
        $updateOwn->ruleName = CreatorRule::name;
        $auth->add($updateOwn);
        $auth->addChild($updateOwn, $update);
        $auth->addChild($user, $updateOwn);

        # Create permission to delete own test-post
        $deleteOwn = $auth->createPermission("{$name_delete}_own");
        $deleteOwn->description = "{$name_update}_own";
        $deleteOwn->ruleName = CreatorRule::name;
        $auth->add($deleteOwn);
        $auth->addChild($deleteOwn, $delete);
        $auth->addChild($user, $deleteOwn);
    }

    public function actionCreatePermsRules_v1_sensor_gantry()
    {
        $model = 'v1/sensor-gantry';
        $name_create = "{$model}/create";
        $name_update = "{$model}/update";
        $name_view = "{$model}/view";
        $name_index = "{$model}/index";
        $name_delete = "{$model}/delete";
        $name_search = "{$model}/search";

        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $manager = $auth->getRole('manager');
        $user = $auth->getRole('user');

        # test/Post for testing purpose
        $create = $auth->createPermission($name_create);
        $auth->add($create);
        $update = $auth->createPermission($name_update);
        $auth->add($update);
        $view = $auth->createPermission($name_view);
        $auth->add($view);
        $index = $auth->createPermission($name_index);
        $auth->add($index);
        $delete = $auth->createPermission($name_delete);
        $auth->add($delete);
        $search = $auth->createPermission($name_search);
        $auth->add($search);

        $auth->addChild($user, $view);
        $auth->addChild($user, $index);
        $auth->addChild($user, $search);
        $auth->addChild($manager, $create);
        $auth->addChild($manager, $update);
        $auth->addChild($manager, $delete);

        # Create permission to create
        $createOwn = $auth->createPermission("{$name_create}_own");
        $createOwn->description = "{$name_create}_own";
        $createOwn->ruleName = CarParkOwnerRule::name;
        $auth->add($createOwn);
        $auth->addChild($createOwn, $create);
        $auth->addChild($user, $createOwn);

        # Create permission to update own
        $updateOwn = $auth->createPermission("{$name_update}_own");
        $updateOwn->description = "{$name_update}_own";
        $updateOwn->ruleName = CarParkOwnerRule::name;
        $auth->add($updateOwn);
        $auth->addChild($updateOwn, $update);
        $auth->addChild($user, $updateOwn);

        # Create permission to delete own
        $deleteOwn = $auth->createPermission("{$name_delete}_own");
        $deleteOwn->description = "{$name_update}_own";
        $deleteOwn->ruleName = CarParkOwnerRule::name;
        $auth->add($deleteOwn);
        $auth->addChild($deleteOwn, $delete);
        $auth->addChild($user, $deleteOwn);
    }

    public function actionCreatePermsRules_v1_traffic_flow()
    {
        $model = 'v1/traffic-flow';
        $name_create = "{$model}/create";
        $name_update = "{$model}/update";
        $name_view = "{$model}/view";
        $name_index = "{$model}/index";
        $name_delete = "{$model}/delete";
        $name_search = "{$model}/search";
        $name_car_entry = "{$model}/car-entry";
        $name_car_exit = "{$model}/car-exit";
        $name_latest_by_car_park = "{$model}/latest-by-car-park";
        $name_latest_all_car_park = "{$model}/latest-all-car-park";
        $name_latest_all_car_park_today = "{$model}/latest-all-car-park-today";
        $name_list_older_than_hours = "{$model}/list-older-than-hours";
        $name_clear_days_older = "{$model}/clear_days_older";

        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $manager = $auth->getRole('manager');
        $user = $auth->getRole('user');

        # test/Post for testing purpose
        $create = $auth->createPermission($name_create);
        $auth->add($create);
        $update = $auth->createPermission($name_update);
        $auth->add($update);
        $view = $auth->createPermission($name_view);
        $auth->add($view);
        $index = $auth->createPermission($name_index);
        $auth->add($index);
        $delete = $auth->createPermission($name_delete);
        $auth->add($delete);
        $search = $auth->createPermission($name_search);
        $auth->add($search);
        $car_entry = $auth->createPermission($name_car_entry);
        $auth->add($car_entry);
        $car_exit = $auth->createPermission($name_car_exit);
        $auth->add($car_exit);
        $latest_by_car_park = $auth->createPermission($name_latest_by_car_park);
        $auth->add($latest_by_car_park);
        $latest_all_car_park = $auth->createPermission($name_latest_all_car_park);
        $auth->add($latest_all_car_park);
        $latest_all_car_park_today = $auth->createPermission($name_latest_all_car_park_today);
        $auth->add($latest_all_car_park_today);
        $list_older_than_hours = $auth->createPermission($name_list_older_than_hours);
        $auth->add($list_older_than_hours);
        $clear_days_older = $auth->createPermission($name_clear_days_older);
        $auth->add($clear_days_older);

        $auth->addChild($user, $view);
        $auth->addChild($user, $index);
        $auth->addChild($user, $search);
        $auth->addChild($manager, $car_entry);
        $auth->addChild($manager, $car_exit);
        $auth->addChild($admin, $create);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        $auth->addChild($user, $latest_by_car_park);
        $auth->addChild($user, $latest_all_car_park);
        $auth->addChild($user, $latest_all_car_park_today);
        $auth->addChild($user, $list_older_than_hours);
        $auth->addChild($admin, $clear_days_older);
    }

    public function actionCreatePermsRules_demo_test_post()
    {
        $model = 'demo/test-post';
        $name_create = "{$model}/create";
        $name_update = "{$model}/update";
        $name_view = "{$model}/view";
        $name_index = "{$model}/index";
        $name_delete = "{$model}/delete";

        $auth = Yii::$app->authManager;
        $manager = $auth->getRole('manager');
        $user = $auth->getRole('user');

        # test/Post for testing purpose
        $create = $auth->createPermission($name_create);
        $auth->add($create);
        $update = $auth->createPermission($name_update);
        $auth->add($update);
        $view = $auth->createPermission($name_view);
        $auth->add($view);
        $index = $auth->createPermission($name_index);
        $auth->add($index);
        $delete = $auth->createPermission($name_delete);
        $auth->add($delete);

        $auth->addChild($user, $view);
        $auth->addChild($user, $index);
        $auth->addChild($user, $create);
        $auth->addChild($manager, $update);
        $auth->addChild($manager, $delete);

        # Create permission to update own test-post
        $updateOwn = $auth->createPermission("{$name_update}_own");
        $updateOwn->description = "{$name_update}_own";
        $updateOwn->ruleName = CreatorRule::name;
        $auth->add($updateOwn);
        $auth->addChild($updateOwn, $update);
        $auth->addChild($user, $updateOwn);

        # Create permission to delete own test-post
        $deleteOwn = $auth->createPermission("{$name_delete}_own");
        $deleteOwn->description = "{$name_update}_own";
        $deleteOwn->ruleName = CreatorRule::name;
        $auth->add($deleteOwn);
        $auth->addChild($deleteOwn, $delete);
        $auth->addChild($user, $deleteOwn);
    }
}