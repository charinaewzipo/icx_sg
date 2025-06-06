<?php
/**
 * WfmAgent
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
 * WfmAgent Class Doc Comment
 *
 * @category Class
 * @description Workforce management agent data
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class WfmAgent implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'WfmAgent';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'user' => '\PureCloudPlatform\Client\V2\Model\UserReference',
        'workPlan' => '\PureCloudPlatform\Client\V2\Model\WorkPlanReference',
        'timeZone' => '\PureCloudPlatform\Client\V2\Model\WfmTimeZone',
        'acceptDirectShiftTrades' => 'bool',
        'metadata' => '\PureCloudPlatform\Client\V2\Model\WfmVersionedEntityMetadata',
        'queues' => '\PureCloudPlatform\Client\V2\Model\QueueReference[]',
        'languages' => '\PureCloudPlatform\Client\V2\Model\LanguageReference[]',
        'skills' => '\PureCloudPlatform\Client\V2\Model\RoutingSkillReference[]',
        'schedulable' => 'bool',
        'selfUri' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'user' => null,
        'workPlan' => null,
        'timeZone' => null,
        'acceptDirectShiftTrades' => null,
        'metadata' => null,
        'queues' => null,
        'languages' => null,
        'skills' => null,
        'schedulable' => null,
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
        'user' => 'user',
        'workPlan' => 'workPlan',
        'timeZone' => 'timeZone',
        'acceptDirectShiftTrades' => 'acceptDirectShiftTrades',
        'metadata' => 'metadata',
        'queues' => 'queues',
        'languages' => 'languages',
        'skills' => 'skills',
        'schedulable' => 'schedulable',
        'selfUri' => 'selfUri'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'user' => 'setUser',
        'workPlan' => 'setWorkPlan',
        'timeZone' => 'setTimeZone',
        'acceptDirectShiftTrades' => 'setAcceptDirectShiftTrades',
        'metadata' => 'setMetadata',
        'queues' => 'setQueues',
        'languages' => 'setLanguages',
        'skills' => 'setSkills',
        'schedulable' => 'setSchedulable',
        'selfUri' => 'setSelfUri'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'user' => 'getUser',
        'workPlan' => 'getWorkPlan',
        'timeZone' => 'getTimeZone',
        'acceptDirectShiftTrades' => 'getAcceptDirectShiftTrades',
        'metadata' => 'getMetadata',
        'queues' => 'getQueues',
        'languages' => 'getLanguages',
        'skills' => 'getSkills',
        'schedulable' => 'getSchedulable',
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
        $this->container['user'] = isset($data['user']) ? $data['user'] : null;
        $this->container['workPlan'] = isset($data['workPlan']) ? $data['workPlan'] : null;
        $this->container['timeZone'] = isset($data['timeZone']) ? $data['timeZone'] : null;
        $this->container['acceptDirectShiftTrades'] = isset($data['acceptDirectShiftTrades']) ? $data['acceptDirectShiftTrades'] : null;
        $this->container['metadata'] = isset($data['metadata']) ? $data['metadata'] : null;
        $this->container['queues'] = isset($data['queues']) ? $data['queues'] : null;
        $this->container['languages'] = isset($data['languages']) ? $data['languages'] : null;
        $this->container['skills'] = isset($data['skills']) ? $data['skills'] : null;
        $this->container['schedulable'] = isset($data['schedulable']) ? $data['schedulable'] : null;
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
     * Gets user
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserReference
     */
    public function getUser()
    {
        return $this->container['user'];
    }

    /**
     * Sets user
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserReference $user The user associated with this data
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->container['user'] = $user;

        return $this;
    }

    /**
     * Gets workPlan
     *
     * @return \PureCloudPlatform\Client\V2\Model\WorkPlanReference
     */
    public function getWorkPlan()
    {
        return $this->container['workPlan'];
    }

    /**
     * Sets workPlan
     *
     * @param \PureCloudPlatform\Client\V2\Model\WorkPlanReference $workPlan The work plan associated with this agent
     *
     * @return $this
     */
    public function setWorkPlan($workPlan)
    {
        $this->container['workPlan'] = $workPlan;

        return $this;
    }

    /**
     * Gets timeZone
     *
     * @return \PureCloudPlatform\Client\V2\Model\WfmTimeZone
     */
    public function getTimeZone()
    {
        return $this->container['timeZone'];
    }

    /**
     * Sets timeZone
     *
     * @param \PureCloudPlatform\Client\V2\Model\WfmTimeZone $timeZone The time zone for this agent. Defaults to the time zone of the management unit to which the agent belongs
     *
     * @return $this
     */
    public function setTimeZone($timeZone)
    {
        $this->container['timeZone'] = $timeZone;

        return $this;
    }

    /**
     * Gets acceptDirectShiftTrades
     *
     * @return bool
     */
    public function getAcceptDirectShiftTrades()
    {
        return $this->container['acceptDirectShiftTrades'];
    }

    /**
     * Sets acceptDirectShiftTrades
     *
     * @param bool $acceptDirectShiftTrades Whether the agent accepts direct shift trade requests
     *
     * @return $this
     */
    public function setAcceptDirectShiftTrades($acceptDirectShiftTrades)
    {
        $this->container['acceptDirectShiftTrades'] = $acceptDirectShiftTrades;

        return $this;
    }

    /**
     * Gets metadata
     *
     * @return \PureCloudPlatform\Client\V2\Model\WfmVersionedEntityMetadata
     */
    public function getMetadata()
    {
        return $this->container['metadata'];
    }

    /**
     * Sets metadata
     *
     * @param \PureCloudPlatform\Client\V2\Model\WfmVersionedEntityMetadata $metadata Metadata for this agent
     *
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->container['metadata'] = $metadata;

        return $this;
    }

    /**
     * Gets queues
     *
     * @return \PureCloudPlatform\Client\V2\Model\QueueReference[]
     */
    public function getQueues()
    {
        return $this->container['queues'];
    }

    /**
     * Sets queues
     *
     * @param \PureCloudPlatform\Client\V2\Model\QueueReference[] $queues List of queues to which the agent belongs and which are defined in the service goal groups in this management unit
     *
     * @return $this
     */
    public function setQueues($queues)
    {
        $this->container['queues'] = $queues;

        return $this;
    }

    /**
     * Gets languages
     *
     * @return \PureCloudPlatform\Client\V2\Model\LanguageReference[]
     */
    public function getLanguages()
    {
        return $this->container['languages'];
    }

    /**
     * Sets languages
     *
     * @param \PureCloudPlatform\Client\V2\Model\LanguageReference[] $languages The list of languages
     *
     * @return $this
     */
    public function setLanguages($languages)
    {
        $this->container['languages'] = $languages;

        return $this;
    }

    /**
     * Gets skills
     *
     * @return \PureCloudPlatform\Client\V2\Model\RoutingSkillReference[]
     */
    public function getSkills()
    {
        return $this->container['skills'];
    }

    /**
     * Sets skills
     *
     * @param \PureCloudPlatform\Client\V2\Model\RoutingSkillReference[] $skills The list of skills
     *
     * @return $this
     */
    public function setSkills($skills)
    {
        $this->container['skills'] = $skills;

        return $this;
    }

    /**
     * Gets schedulable
     *
     * @return bool
     */
    public function getSchedulable()
    {
        return $this->container['schedulable'];
    }

    /**
     * Sets schedulable
     *
     * @param bool $schedulable Whether the agent has the permission to be included in schedule generation
     *
     * @return $this
     */
    public function setSchedulable($schedulable)
    {
        $this->container['schedulable'] = $schedulable;

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


