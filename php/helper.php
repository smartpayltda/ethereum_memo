<?php

// Helper function encode memo
function makeMemo($memo)
{
    $memo = "MEMO:" . $memo;
    $nums = array();
    $convmap = array(0x0, 0xffff, 0, 0xffff);
    $strlen = mb_strlen($memo, "UTF-8");
    for ($i = 0; $i < $strlen; $i++) {
        $ch = mb_substr($memo, $i, 1, "UTF-8");
        $decimal = substr(mb_encode_numericentity($ch, $convmap, 'UTF-8'), -5, 4);
        $nums[] = base_convert($decimal, 10, 16);
    }
    return "0x" . implode("", $nums);
}

// Helper function, read .env and store in $_ENV
function importEnv()
{
    $env_file_path = realpath(__DIR__ . "/.env");
    $fopen = fopen($env_file_path, 'r');
    if (!$fopen) {
        return false;
    }
    while (($line = fgets($fopen)) !== false) {
        $line_is_comment = (substr(trim($line), 0, 1) == '#') ? true : false;
        if ($line_is_comment || empty(trim($line))) {
            continue;
        }
        $line_no_comment = explode("#", $line, 2)[0];
        $env_ex = preg_split('/(\s?)\=(\s?)/', $line_no_comment);
        $env_name = trim($env_ex[0]);
        $env_value = isset($env_ex[1]) ? trim($env_ex[1]) : "";
        $_ENV[$env_name] = $env_value;
    }

    fclose($fopen);
    return true;
}
