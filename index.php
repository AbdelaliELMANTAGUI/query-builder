<?php
function my_autoload ($className) {
    // echo $className;
    back();
    if(file_exists(__DIR__ . "/classes/" . strtolower($className) . ".php")){
        include __DIR__ . "/classes/" . strtolower($className) . ".php";
    }
    if(file_exists(__DIR__ . "/interfaces/" . strtolower($className) . ".php")){
        include __DIR__ . "/interfaces/" . strtolower($className) . ".php";
    }
    if(file_exists(__DIR__ . "/models/" . strtolower($className) . ".php")){
        include __DIR__ . "/models/" . strtolower($className) . ".php";
    }
}
spl_autoload_register("my_autoload");

function back(){
    echo "\n";
}

include "./connexion.php";
// include "./classes/queryoperations.php";
// include "./classes/orm.php";
// include "./classes/query.php";
// // include "./classes/orm.php";
// include "./interfaces/dbmodel.php";
// include "./models/user.model.php";


// select * from table
// print_r(ORM::query()->select()->from(new Model("ourTable"))->where("id=123")->build());
// back();
// print_r(ORM::query()->insert(array("id" => 3443, "name" => "john"))->into(new Model("ourTable"))->build());
// back();
// print_r(ORM::query()->update(new Model("ourTable"))->set(array("name" => "doe", "age" => 34))->where("id=342")->limit()->build());
// back();
// print_r(ORM::query()->delete()->from(new Model("ourTable"))->where("id=23")->build());
// back();
// echo(ORM::query()->insert(array("Column 1"=>123))->into(new Model("users"))->build());
// back();
$build = ORM::query($con)->insert(array("c1"=>24))->into(new User())->prepare()->execute();
echo $build;

echo "\n";
die;
back();
$query->execute();
$query = $con->prepare($build);
$result = $query->fetchAll(PDO::FETCH_OBJ);
echo "results : ";
back();
// print_r($result);
if($result){
    back();
    echo "executed";
    back();
    // $data = $query->fetchAll(PDO::FETCH_OBJ);
    // and somewhere later:
    // print_r($data);
}