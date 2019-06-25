<?php


function isSqlInsert(string $sql):bool{
    return strpos(mb_strtolower($sql), "insert") == 0;
}

function isSqlSelect(string $sql):bool{
    return strpos(mb_strtolower($sql), "select") == 0;
}


