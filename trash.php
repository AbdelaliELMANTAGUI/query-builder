<?php
echo password_hash("1234",PASSWORD_DEFAULT)."\n";
echo uniqid()."\n";
die;
$ar = ["a" => 1, "b" => 2,"c"=>"klflk","l p"=>123];
// $str = "insert into table (cl1) values ('".$ar["a"]."')";
$str = "insert into table (";
function concatKeys(array $keys){
    foreach($keys as $index => $key){
        $keys[$index] = "`$key`";
    }
    return $keys;
}
function concatValues(array $values)
{
    foreach ($values as $index => $value) {
        if (is_string($value)) {
            $values[$index] = "'$value'";
        }
    }
    return $values;
}
$str .= join(",", concatKeys(array_keys($ar))) . ") values (";
$str .= join(",", concatValues(
                        array_values($ar)
                    )
        ) ;
        $str .= ");";
// foreach ($ar as $key => $value) {
// }

// $str = ) values ('".$ar["a"]."')";

echo $str."\n";
