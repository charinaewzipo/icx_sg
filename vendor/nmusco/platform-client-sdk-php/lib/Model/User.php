<?php
/**
 * User
 *
 * PHP version 5
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * PureCloud Platform API
 *
 * With the PureCloud Platform API, you can control all aspects of your PureCloud environment. With the APIs you can access the system configuration, manage conversations and more.
 *
 * OpenAPI spec version: v2
 * Contact: DeveloperEvangelists@genesys.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.9
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace PureCloudPlatform\Client\V2\Model;

use \ArrayAccess;
use \PureCloudPlatform\Client\V2\ObjectSerializer;

/**
 * User Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class User implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'User';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'name' => 'string',
        'division' => '\PureCloudPlatform\Client\V2\Model\Division',
        'chat' => '\PureCloudPlatform\Client\V2\Model\Chat',
        'department' => 'string',
        'email' => 'string',
        'primaryContactInfo' => '\PureCloudPlatform\Client\V2\Model\Contact[]',
        'addresses' => '\PureCloudPlatform\Client\V2\Model\Contact[]',
        'state' => 'string',
        'title' => 'string',
        'username' => 'string',
        'manager' => '\PureCloudPlatform\Client\V2\Model\User',
        'images' => '\PureCloudPlatform\Client\V2\Model\UserImage[]',
        'version' => 'int',
        'certifications' => 'string[]',
        'biography' => '\PureCloudPlatform\Client\V2\Model\Biography',
        'employerInfo' => '\PureCloudPlatform\Client\V2\Model\EmployerInfo',
        'routingStatus' => '\PureCloudPlatform\Client\V2\Model\RoutingStatus',
        'presence' => '\PureCloudPlatform\Client\V2\Model\UserPresence',
        'conversationSummary' => '\PureCloudPlatform\Client\V2\Model\UserConversationSummary',
        'outOfOffice' => '\PureCloudPlatform\Client\V2\Model\OutOfOffice',
        'geolocation' => '\PureCloudPlatform\Client\V2\Model\Geolocation',
        'station' => '\PureCloudPlatform\Client\V2\Model\UserStations',
        'authorization' => '\PureCloudPlatform\Client\V2\Model\UserAuthorization',
        'profileSkills' => 'string[]',
        'locations' => '\PureCloudPlatform\Client\V2\Model\Location[]',
        'groups' => '\PureCloudPlatform\Client\V2\Model\Group[]',
        'skills' => '\PureCloudPlatform\Client\V2\Model\UserRoutingSkill[]',
        'languages' => '\PureCloudPlatform\Client\V2\Model\UserRoutingLanguage[]',
        'acdAutoAnswer' => 'bool',
        'languagePreference' => 'string',
        'selfUri' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'name' => null,
        'division' => null,
        'chat' => null,
        'department' => null,
        'email' => null,
        'primaryContactInfo' => null,
        'addresses' => null,
        'state' => null,
        'title' => null,
        'username' => null,
        'manager' => null,
        'images' => null,
        'version' => 'int32',
        'certifications' => null,
        'biography' => null,
        'employerInfo' => null,
        'routingStatus' => null,
        'presence' => null,
        'conversationSummary' => null,
        'outOfOffice' => null,
        'geolocation' => null,
        'station' => null,
        'authorization' => null,
        'profileSkills' => null,
        'locations' => null,
        'groups' => null,
        'skills' => null,
        'languages' => null,
        'acdAutoAnswer' => null,
        'languagePreference' => null,
        'selfUri' => 'uri'
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'name' => 'name',
        'division' => 'division',
        'chat' => 'chat',
        'department' => 'department',
        'email' => 'email',
        'primaryContactInfo' => 'primaryContactInfo',
        'addresses' => 'addresses',
        'state' => 'state',
        'title' => 'title',
        'username' => 'username',
        'manager' => 'manager',
        'images' => 'images',
        'version' => 'version',
        'certifications' => 'certifications',
        'biography' => 'biography',
        'employerInfo' => 'employerInfo',
        'routingStatus' => 'routingStatus',
        'presence' => 'presence',
        'conversationSummary' => 'conversationSummary',
        'outOfOffice' => 'outOfOffice',
        'geolocation' => 'geolocation',
        'station' => 'station',
        'authorization' => 'authorization',
        'profileSkills' => 'profileSkills',
        'locations' => 'locations',
        'groups' => 'groups',
        'skills' => 'skills',
        'languages' => 'languages',
        'acdAutoAnswer' => 'acdAutoAnswer',
        'languagePreference' => 'languagePreference',
        'selfUri' => 'selfUri'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'name' => 'setName',
        'division' => 'setDivision',
        'chat' => 'setChat',
        'department' => 'setDepartment',
        'email' => 'setEmail',
        'primaryContactInfo' => 'setPrimaryContactInfo',
        'addresses' => 'setAddresses',
        'state' => 'setState',
        'title' => 'setTitle',
        'username' => 'setUsername',
        'manager' => 'setManager',
        'images' => 'setImages',
        'version' => 'setVersion',
        'certifications' => 'setCertifications',
        'biography' => 'setBiography',
        'employerInfo' => 'setEmployerInfo',
        'routingStatus' => 'setRoutingStatus',
        'presence' => 'setPresence',
        'conversationSummary' => 'setConversationSummary',
        'outOfOffice' => 'setOutOfOffice',
        'geolocation' => 'setGeolocation',
        'station' => 'setStation',
        'authorization' => 'setAuthorization',
        'profileSkills' => 'setProfileSkills',
        'locations' => 'setLocations',
        'groups' => 'setGroups',
        'skills' => 'setSkills',
        'languages' => 'setLanguages',
        'acdAutoAnswer' => 'setAcdAutoAnswer',
        'languagePreference' => 'setLanguagePreference',
        'selfUri' => 'setSelfUri'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'name' => 'getName',
        'division' => 'getDivision',
        'chat' => 'getChat',
        'department' => 'getDepartment',
        'email' => 'getEmail',
        'primaryContactInfo' => 'getPrimaryContactInfo',
        'addresses' => 'getAddresses',
        'state' => 'getState',
        'title' => 'getTitle',
        'username' => 'getUsername',
        'manager' => 'getManager',
        'images' => 'getImages',
        'version' => 'getVersion',
        'certifications' => 'getCertifications',
        'biography' => 'getBiography',
        'employerInfo' => 'getEmployerInfo',
        'routingStatus' => 'getRoutingStatus',
        'presence' => 'getPresence',
        'conversationSummary' => 'getConversationSummary',
        'outOfOffice' => 'getOutOfOffice',
        'geolocation' => 'getGeolocation',
        'station' => 'getStation',
        'authorization' => 'getAuthorization',
        'profileSkills' => 'getProfileSkills',
        'locations' => 'getLocations',
        'groups' => 'getGroups',
        'skills' => 'getSkills',
        'languages' => 'getLanguages',
        'acdAutoAnswer' => 'getAcdAutoAnswer',
        'languagePreference' => 'getLanguagePreference',
        'selfUri' => 'getSelfUri'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    const STATE_ACTIVE = 'active';
    const STATE_INACTIVE = 'inactive';
    const STATE_DELETED = 'deleted';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getStateAllowableValues()
    {
        return [
            self::STATE_ACTIVE,
            self::STATE_INACTIVE,
            self::STATE_DELETED,
        ];
    }
    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['division'] = isset($data['division']) ? $data['division'] : null;
        $this->container['chat'] = isset($data['chat']) ? $data['chat'] : null;
        $this->container['department'] = isset($data['department']) ? $data['department'] : null;
        $this->container['email'] = isset($data['email']) ? $data['email'] : null;
        $this->container['primaryContactInfo'] = isset($data['primaryContactInfo']) ? $data['primaryContactInfo'] : null;
        $this->container['addresses'] = isset($data['addresses']) ? $data['addresses'] : null;
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
        $this->container['title'] = isset($data['title']) ? $data['title'] : null;
        $this->container['username'] = isset($data['username']) ? $data['username'] : null;
        $this->container['manager'] = isset($data['manager']) ? $data['manager'] : null;
        $this->container['images'] = isset($data['images']) ? $data['images'] : null;
        $this->container['version'] = isset($data['version']) ? $data['version'] : null;
        $this->container['certifications'] = isset($data['certifications']) ? $data['certifications'] : null;
        $this->container['biography'] = isset($data['biography']) ? $data['biography'] : null;
        $this->container['employerInfo'] = isset($data['employerInfo']) ? $data['employerInfo'] : null;
        $this->container['routingStatus'] = isset($data['routingStatus']) ? $data['routingStatus'] : null;
        $this->container['presence'] = isset($data['presence']) ? $data['presence'] : null;
        $this->container['conversationSummary'] = isset($data['conversationSummary']) ? $data['conversationSummary'] : null;
        $this->container['outOfOffice'] = isset($data['outOfOffice']) ? $data['outOfOffice'] : null;
        $this->container['geolocation'] = isset($data['geolocation']) ? $data['geolocation'] : null;
        $this->container['station'] = isset($data['station']) ? $data['station'] : null;
        $this->container['authorization'] = isset($data['authorization']) ? $data['authorization'] : null;
        $this->container['profileSkills'] = isset($data['profileSkills']) ? $data['profileSkills'] : null;
        $this->container['locations'] = isset($data['locations']) ? $data['locations'] : null;
        $this->container['groups'] = isset($data['groups']) ? $data['groups'] : null;
        $this->container['skills'] = isset($data['skills']) ? $data['skills'] : null;
        $this->container['languages'] = isset($data['languages']) ? $data['languages'] : null;
        $this->container['acdAutoAnswer'] = isset($data['acdAutoAnswer']) ? $data['acdAutoAnswer'] : null;
        $this->container['languagePreference'] = isset($data['languagePreference']) ? $data['languagePreference'] : null;
        $this->container['selfUri'] = isset($data['selfUri']) ? $data['selfUri'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getStateAllowableValues();
        if (!is_null($this->container['state']) && !in_array($this->container['state'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'state', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['version'] === null) {
            $invalidProperties[] = "'version' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id The globally unique identifier for the object.
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets division
     *
     * @return \PureCloudPlatform\Client\V2\Model\Division
     */
    public function getDivision()
    {
        return $this->container['division'];
    }

    /**
     * Sets division
     *
     * @param \PureCloudPlatform\Client\V2\Model\Division $division The division to which this entity belongs.
     *
     * @return $this
     */
    public function setDivision($division)
    {
        $this->container['division'] = $division;

        return $this;
    }

    /**
     * Gets chat
     *
     * @return \PureCloudPlatform\Client\V2\Model\Chat
     */
    public function getChat()
    {
        return $this->container['chat'];
    }

    /**
     * Sets chat
     *
     * @param \PureCloudPlatform\Client\V2\Model\Chat $chat chat
     *
     * @return $this
     */
    public function setChat($chat)
    {
        $this->container['chat'] = $chat;

        return $this;
    }

    /**
     * Gets department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->container['department'];
    }

    /**
     * Sets department
     *
     * @param string $department department
     *
     * @return $this
     */
    public function setDepartment($department)
    {
        $this->container['department'] = $department;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     *
     * @param string $email email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->container['email'] = $email;

        return $this;
    }

    /**
     * Gets primaryContactInfo
     *
     * @return \PureCloudPlatform\Client\V2\Model\Contact[]
     */
    public function getPrimaryContactInfo()
    {
        return $this->container['primaryContactInfo'];
    }

    /**
     * Sets primaryContactInfo
     *
     * @param \PureCloudPlatform\Client\V2\Model\Contact[] $primaryContactInfo Auto populated from addresses.
     *
     * @return $this
     */
    public function setPrimaryContactInfo($primaryContactInfo)
    {
        $this->container['primaryContactInfo'] = $primaryContactInfo;

        return $this;
    }

    /**
     * Gets addresses
     *
     * @return \PureCloudPlatform\Client\V2\Model\Contact[]
     */
    public function getAddresses()
    {
        return $this->container['addresses'];
    }

    /**
     * Sets addresses
     *
     * @param \PureCloudPlatform\Client\V2\Model\Contact[] $addresses Email addresses and phone numbers for this user
     *
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->container['addresses'] = $addresses;

        return $this;
    }

    /**
     * Gets state
     *
     * @return string
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param string $state The current state for this user.
     *
     * @return $this
     */
    public function setState($state)
    {
        $allowedValues = $this->getStateAllowableValues();
        if (!is_null($state) && !in_array($state, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'state', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['state'] = $state;

        return $this;
    }

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container['title'];
    }

    /**
     * Sets title
     *
     * @param string $title title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->container['title'] = $title;

        return $this;
    }

    /**
     * Gets username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->container['username'];
    }

    /**
     * Sets username
     *
     * @param string $username username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->container['username'] = $username;

        return $this;
    }

    /**
     * Gets manager
     *
     * @return \PureCloudPlatform\Client\V2\Model\User
     */
    public function getManager()
    {
        return $this->container['manager'];
    }

    /**
     * Sets manager
     *
     * @param \PureCloudPlatform\Client\V2\Model\User $manager manager
     *
     * @return $this
     */
    public function setManager($manager)
    {
        $this->container['manager'] = $manager;

        return $this;
    }

    /**
     * Gets images
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserImage[]
     */
    public function getImages()
    {
        return $this->container['images'];
    }

    /**
     * Sets images
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserImage[] $images images
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->container['images'] = $images;

        return $this;
    }

    /**
     * Gets version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->container['version'];
    }

    /**
     * Sets version
     *
     * @param int $version Required when updating a user, this value should be the current version of the user.  The current version can be obtained with a GET on the user before doing a PATCH.
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->container['version'] = $version;

        return $this;
    }

    /**
     * Gets certifications
     *
     * @return string[]
     */
    public function getCertifications()
    {
        return $this->container['certifications'];
    }

    /**
     * Sets certifications
     *
     * @param string[] $certifications certifications
     *
     * @return $this
     */
    public function setCertifications($certifications)
    {
        $this->container['certifications'] = $certifications;

        return $this;
    }

    /**
     * Gets biography
     *
     * @return \PureCloudPlatform\Client\V2\Model\Biography
     */
    public function getBiography()
    {
        return $this->container['biography'];
    }

    /**
     * Sets biography
     *
     * @param \PureCloudPlatform\Client\V2\Model\Biography $biography biography
     *
     * @return $this
     */
    public function setBiography($biography)
    {
        $this->container['biography'] = $biography;

        return $this;
    }

    /**
     * Gets employerInfo
     *
     * @return \PureCloudPlatform\Client\V2\Model\EmployerInfo
     */
    public function getEmployerInfo()
    {
        return $this->container['employerInfo'];
    }

    /**
     * Sets employerInfo
     *
     * @param \PureCloudPlatform\Client\V2\Model\EmployerInfo $employerInfo employerInfo
     *
     * @return $this
     */
    public function setEmployerInfo($employerInfo)
    {
        $this->container['employerInfo'] = $employerInfo;

        return $this;
    }

    /**
     * Gets routingStatus
     *
     * @return \PureCloudPlatform\Client\V2\Model\RoutingStatus
     */
    public function getRoutingStatus()
    {
        return $this->container['routingStatus'];
    }

    /**
     * Sets routingStatus
     *
     * @param \PureCloudPlatform\Client\V2\Model\RoutingStatus $routingStatus ACD routing status
     *
     * @return $this
     */
    public function setRoutingStatus($routingStatus)
    {
        $this->container['routingStatus'] = $routingStatus;

        return $this;
    }

    /**
     * Gets presence
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserPresence
     */
    public function getPresence()
    {
        return $this->container['presence'];
    }

    /**
     * Sets presence
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserPresence $presence Active presence
     *
     * @return $this
     */
    public function setPresence($presence)
    {
        $this->container['presence'] = $presence;

        return $this;
    }

    /**
     * Gets conversationSummary
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserConversationSummary
     */
    public function getConversationSummary()
    {
        return $this->container['conversationSummary'];
    }

    /**
     * Sets conversationSummary
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserConversationSummary $conversationSummary Summary of conversion statistics for conversation types.
     *
     * @return $this
     */
    public function setConversationSummary($conversationSummary)
    {
        $this->container['conversationSummary'] = $conversationSummary;

        return $this;
    }

    /**
     * Gets outOfOffice
     *
     * @return \PureCloudPlatform\Client\V2\Model\OutOfOffice
     */
    public function getOutOfOffice()
    {
        return $this->container['outOfOffice'];
    }

    /**
     * Sets outOfOffice
     *
     * @param \PureCloudPlatform\Client\V2\Model\OutOfOffice $outOfOffice Determine if out of office is enabled
     *
     * @return $this
     */
    public function setOutOfOffice($outOfOffice)
    {
        $this->container['outOfOffice'] = $outOfOffice;

        return $this;
    }

    /**
     * Gets geolocation
     *
     * @return \PureCloudPlatform\Client\V2\Model\Geolocation
     */
    public function getGeolocation()
    {
        return $this->container['geolocation'];
    }

    /**
     * Sets geolocation
     *
     * @param \PureCloudPlatform\Client\V2\Model\Geolocation $geolocation Current geolocation position
     *
     * @return $this
     */
    public function setGeolocation($geolocation)
    {
        $this->container['geolocation'] = $geolocation;

        return $this;
    }

    /**
     * Gets station
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserStations
     */
    public function getStation()
    {
        return $this->container['station'];
    }

    /**
     * Sets station
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserStations $station Effective, default, and last station information
     *
     * @return $this
     */
    public function setStation($station)
    {
        $this->container['station'] = $station;

        return $this;
    }

    /**
     * Gets authorization
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserAuthorization
     */
    public function getAuthorization()
    {
        return $this->container['authorization'];
    }

    /**
     * Sets authorization
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserAuthorization $authorization Roles and permissions assigned to the user
     *
     * @return $this
     */
    public function setAuthorization($authorization)
    {
        $this->container['authorization'] = $authorization;

        return $this;
    }

    /**
     * Gets profileSkills
     *
     * @return string[]
     */
    public function getProfileSkills()
    {
        return $this->container['profileSkills'];
    }

    /**
     * Sets profileSkills
     *
     * @param string[] $profileSkills Profile skills possessed by the user
     *
     * @return $this
     */
    public function setProfileSkills($profileSkills)
    {
        $this->container['profileSkills'] = $profileSkills;

        return $this;
    }

    /**
     * Gets locations
     *
     * @return \PureCloudPlatform\Client\V2\Model\Location[]
     */
    public function getLocations()
    {
        return $this->container['locations'];
    }

    /**
     * Sets locations
     *
     * @param \PureCloudPlatform\Client\V2\Model\Location[] $locations The user placement at each site location.
     *
     * @return $this
     */
    public function setLocations($locations)
    {
        $this->container['locations'] = $locations;

        return $this;
    }

    /**
     * Gets groups
     *
     * @return \PureCloudPlatform\Client\V2\Model\Group[]
     */
    public function getGroups()
    {
        return $this->container['groups'];
    }

    /**
     * Sets groups
     *
     * @param \PureCloudPlatform\Client\V2\Model\Group[] $groups The groups the user is a member of
     *
     * @return $this
     */
    public function setGroups($groups)
    {
        $this->container['groups'] = $groups;

        return $this;
    }

    /**
     * Gets skills
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserRoutingSkill[]
     */
    public function getSkills()
    {
        return $this->container['skills'];
    }

    /**
     * Sets skills
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserRoutingSkill[] $skills Routing (ACD) skills possessed by the user
     *
     * @return $this
     */
    public function setSkills($skills)
    {
        $this->container['skills'] = $skills;

        return $this;
    }

    /**
     * Gets languages
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserRoutingLanguage[]
     */
    public function getLanguages()
    {
        return $this->container['languages'];
    }

    /**
     * Sets languages
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserRoutingLanguage[] $languages Routing (ACD) languages possessed by the user
     *
     * @return $this
     */
    public function setLanguages($languages)
    {
        $this->container['languages'] = $languages;

        return $this;
    }

    /**
     * Gets acdAutoAnswer
     *
     * @return bool
     */
    public function getAcdAutoAnswer()
    {
        return $this->container['acdAutoAnswer'];
    }

    /**
     * Sets acdAutoAnswer
     *
     * @param bool $acdAutoAnswer acd auto answer
     *
     * @return $this
     */
    public function setAcdAutoAnswer($acdAutoAnswer)
    {
        $this->container['acdAutoAnswer'] = $acdAutoAnswer;

        return $this;
    }

    /**
     * Gets languagePreference
     *
     * @return string
     */
    public function getLanguagePreference()
    {
        return $this->container['languagePreference'];
    }

    /**
     * Sets languagePreference
     *
     * @param string $languagePreference preferred language by the user
     *
     * @return $this
     */
    public function setLanguagePreference($languagePreference)
    {
        $this->container['languagePreference'] = $languagePreference;

        return $this;
    }

    /**
     * Gets selfUri
     *
     * @return string
     */
    public function getSelfUri()
    {
        return $this->container['selfUri'];
    }

    /**
     * Sets selfUri
     *
     * @param string $selfUri The URI for this object
     *
     * @return $this
     */
    public function setSelfUri($selfUri)
    {
        $this->container['selfUri'] = $selfUri;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


