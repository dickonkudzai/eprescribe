<?php
namespace config;
require_once 'EnvironmentVariables.php';
require_once 'DbConnection.php';
require_once 'InfobipConfig.php';
class Config
{
    public function getInfobipCredentials()
    {
        $env = new EnvironmentVariables("../.env");
        $baseUrl = $env->getVariable('INFOBIP_BASE_URL');
        $apiKey = $env->getVariable('INFOBIP_API_KEY');

        return [
            'baseUrl' => $baseUrl,
            'apiKey' => $apiKey
        ];
    }

    public function sendEmail($mobileNumber, $message){
        $infobigCredentials = $this->getInfobipCredentials();
        $infobigConfig = new InfobipConfig($infobigCredentials['host'], $infobigCredentials['username']);
        return $infobigConfig->getConfiguration($mobileNumber, $message);
    }

    public function getDatabaseCredentials()
    {
        $env = new EnvironmentVariables("../.env");
        $dbHost = $env->getVariable('DB_HOST');
        $dbUsername = $env->getVariable('DB_USERNAME');
        $dbPassword = $env->getVariable('DB_PASSWORD');
        $dbDatabase = $env->getVariable('DB_DATABASE');

        return [
            'host' => $dbHost,
            'username' => $dbUsername,
            'password' => $dbPassword,
            'database' => $dbDatabase
        ];
    }

    public function databaseConnection(){
        $dbVariables = $this->getDatabaseCredentials();
        $dbConnection = new DbConnection($dbVariables['host'], $dbVariables['username'], $dbVariables['password'], $dbVariables['database']);
        return $dbConnection->connect();
    }
}
