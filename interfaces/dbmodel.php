<?php
class DbModel{
    function getTableName(){
        return strtolower(get_called_class())."s";
    }
}