<?php
namespace config;
require_once 'EnvironmentVariables.php';
require_once 'DbConnection.php';
class Config
{

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
