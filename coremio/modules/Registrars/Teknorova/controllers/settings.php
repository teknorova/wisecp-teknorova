<?php
if (!defined("CORE_FOLDER"))
    die();

$lang    = $module->lang;
$config  = $module->config;
$is_soap = class_exists("SoapClient");

if (!$is_soap) {
    die(Utility::jencode([
        'status'  => "error",
        'message' => $lang["error7"],
    ]));
}

$username = Filter::init("POST/username", "hclear");
$whidden_amount = (float)Filter::init("POST/whidden-amount", "amount");
$whidden_curr   = (int)Filter::init("POST/whidden-currency", "numbers");
$adp            = (bool)(int)Filter::init("POST/adp", "numbers");
$cost_cid       = (int)Filter::init("POST/cost-currency", "numbers");

$sets = [];

if ($username != $config["settings"]["username"])
    $sets["settings"]["username"] = $username;


if ($whidden_amount != $config["settings"]["whidden-amount"])
    $sets["settings"]["whidden-amount"] = $whidden_amount;

if ($whidden_curr != $config["settings"]["whidden-currency"])
    $sets["settings"]["whidden-currency"] = $whidden_curr;


if (!isset($config["settings"]["adp"]) || $adp != $config["settings"]["adp"])
    $sets["settings"]["adp"] = $adp;

if (!isset($config["settings"]["cost-currency"]) || $cost_cid != $config["settings"]["cost-currency"])
    $sets["settings"]["cost-currency"] = $cost_cid;

$profit_rate = (float)Filter::init("POST/profit-rate", "amount");
$export      = Utility::array_export(Config::set("options", ["domain-profit-rate" => $profit_rate]), ['pwith' => true]);
FileManager::file_write(CONFIG_DIR . "options.php", $export);


if ($sets) {
    $config_result = array_replace_recursive($config, $sets);
    $array_export  = Utility::array_export($config_result, ['pwith' => true]);
    $file          = dirname(__DIR__) . DS . "config.php";
    $write         = FileManager::file_write($file, $array_export);

    $adata = UserManager::LoginData("admin");
    User::addAction($adata["id"], "alteration", "changed-registrars-module-settings", [
        'module' => $config["meta"]["name"],
        'name'   => $lang["name"],
    ]);
}

echo Utility::jencode([
    'status'  => "successful",
    'message' => $lang["success1"],
]);
