<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Christian Kogler
 * Date: 22.04.13
 * Time: 23:27
 */
Class Deployment_Instance_Wrapper {

    const ENV_DEV = 'development';
    const ENV_STAGING = 'staging';
    const ENV_LIVE = 'live';


    protected $instanceIdentifier;
    protected $domain;
    protected $deployable;
    protected $webserviceApiKey;
    protected $webserviceEndpointRest;

    protected $concreteDeploymentInstance;

    public static function getEnvironmentTypes(){
        $environments = array();
        $reflection = new ReflectionClass(__CLASS__);

        foreach($reflection->getConstants() as $constantName => $constantValue){
            if(substr($constantName,0,4) == 'ENV_'){
                $environments[$constantName] = $constantValue;
            }
        }

        return $environments;
    }

    public function setFieldMapping($fieldMapping = array()){
        $this->fieldMapping = $fieldMapping;
        return $this;
    }

    protected function applyFieldMapping(){
        $fieldMapping = Deployment_Factory::getInstance()->getInstanceAdapter()->getFieldMapping();
        $concreteDeploymentInstance = $this->getConcreteDeploymentInstance();
        foreach((array)$fieldMapping as $wrapperField => $sourceField){
            $wrapperGetter = "get" . ucfirst($wrapperField);
            $wrapperSetter = "set" . ucfirst($wrapperField);

            if(method_exists($this,$wrapperSetter) && method_exists($this,$wrapperGetter)){
                $sourceGetter = "get" . ucfirst($sourceField);
                //if getter exists use the getter
                if(is_object($concreteDeploymentInstance) && method_exists($concreteDeploymentInstance,$sourceGetter)){
                    $this->$wrapperSetter($concreteDeploymentInstance->$sourceGetter());
                }
                //if no getter exists use the public property
                elseif(is_object($concreteDeploymentInstance) && !method_exists($concreteDeploymentInstance,$sourceGetter)){
                    $this->$wrapperSetter($concreteDeploymentInstance->$sourceField);
                //use array key
                }elseif(is_array($concreteDeploymentInstance)){
                    $this->$wrapperSetter($concreteDeploymentInstance[$sourceField]);
                }
            }
        }
        return $this;
    }

    protected function setSystemData(){
        $apiUserId = (int)$this->getApiUser();
        $apiUser = User::getById($apiUserId);

        if($apiUser){
            $apiKey = $apiUser->getApiKey();
            if($apiKey && $apiUser->isAdmin()){
                try{

                    $this->setWebserviceEndpointRest('http://' . $this->getDomain() . '/webservice/rest/');
                    $this->setWebserviceApiKey($apiKey);

                    if($this->checkWebserviceRest()){
                        $this->setDeployable(1);
                    }else{
                        $this->setDeployable(0);
                    }
                }catch (Exception $e){
                    $this->setDeployable(0);
                }

            }else{
                Logger::warn("REST API user has no API key or is not an admin." . $this->getInstanceIdentifier());
                $this->setDeployable(0);
            }
        }else{
            Logger::warn("No REST API user set for deployment Instance." . $this->getInstanceIdentifier());
            $this->setDeployable(0);
        }

        if($this->instanceIsCurrentSystem()){
            $this->setDeployable(0);
        }
        return $this;
    }

    public function checkWebserviceRest(){
        if($this->instanceIsCurrentSystem()){
            return false;
        }
        try{
            $restClient = $this->getRestClient();
            $serverInfo = $restClient->getServerInfo();
            $success = true;
        }catch(Exception $e){
            $success = false;
        }
        return $success;
    }

    public function instanceIsCurrentSystem(){
        return ($this->getInstanceIdentifier() == Pimcore_Tool_Deployment::getInstanceIdentifier());
    }

    public function setInstanceIdentifier($instanceIdentifier)
    {
        $this->instanceIdentifier= $instanceIdentifier;
        return $this;
    }

    public function getInstanceIdentifier()
    {
        return $this->instanceIdentifier;
    }

    public function setConcreteDeploymentInstance($concreteDeploymentInstance)
    {
        $this->concreteDeploymentInstance = $concreteDeploymentInstance;
        $this->applyFieldMapping();
        $this->setSystemData();
        return $this;
    }

    public function getConcreteDeploymentInstance()
    {
        return $this->concreteDeploymentInstance;
    }

    public function setDeployable($deployable)
    {
        $this->deployable = (int)$deployable;
        return $this;
    }

    public function getDeployable()
    {
        return $this->deployable;
    }

    /**
     * wrapper function for getDeployable()
     * @return bool
     */
    public function isDeployable(){
        return (bool)$this->getDeployable();
    }

    public function setWebserviceEndpointRest($webserviceEndpointRest)
    {
        $this->webserviceEndpointRest = $webserviceEndpointRest;
    }

    public function getWebserviceEndpointRest()
    {
        return $this->webserviceEndpointRest;
    }

    public function setWebserviceApiKey($webserviceApiKey)
    {
        $this->webserviceApiKey = $webserviceApiKey;
    }

    public function getWebserviceApiKey()
    {
        return $this->webserviceApiKey;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return Pimcore_Tool_RestClient
     */
    public function getRestClient(){
        $restClient = new Pimcore_Tool_RestClient();
        $restClient->setHost($this->getDomain());
        $restClient->setBaseUrl($this->getWebserviceEndpointRest());
        $restClient->setApiKey($this->getWebserviceApiKey());
        return $restClient;
    }

    /**
     * proxy to concrete deployment instance object if method doesn't exists
     *
     * @param $method
     * @param $args
     */
    public function __call($method,$args){
        $concreteDeploymentInstance = $this->getConcreteDeploymentInstance();
        return $concreteDeploymentInstance->$method($args);
    }

}