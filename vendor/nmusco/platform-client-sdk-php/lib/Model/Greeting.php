<?php
/**
 * Greeting
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
 * Greeting Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Greeting implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Greeting';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'name' => 'string',
        'type' => 'string',
        'ownerType' => 'string',
        'owner' => '\PureCloudPlatform\Client\V2\Model\DomainEntity',
        'audioFile' => '\PureCloudPlatform\Client\V2\Model\GreetingAudioFile',
        'audioTTS' => 'string',
        'createdDate' => '\DateTime',
        'createdBy' => 'string',
        'modifiedDate' => '\DateTime',
        'modifiedBy' => 'string',
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
        'type' => null,
        'ownerType' => null,
        'owner' => null,
        'audioFile' => null,
        'audioTTS' => null,
        'createdDate' => 'date-time',
        'createdBy' => 'uri',
        'modifiedDate' => 'date-time',
        'modifiedBy' => 'uri',
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
        'type' => 'type',
        'ownerType' => 'ownerType',
        'owner' => 'owner',
        'audioFile' => 'audioFile',
        'audioTTS' => 'audioTTS',
        'createdDate' => 'createdDate',
        'createdBy' => 'createdBy',
        'modifiedDate' => 'modifiedDate',
        'modifiedBy' => 'modifiedBy',
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
        'type' => 'setType',
        'ownerType' => 'setOwnerType',
        'owner' => 'setOwner',
        'audioFile' => 'setAudioFile',
        'audioTTS' => 'setAudioTTS',
        'createdDate' => 'setCreatedDate',
        'createdBy' => 'setCreatedBy',
        'modifiedDate' => 'setModifiedDate',
        'modifiedBy' => 'setModifiedBy',
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
        'type' => 'getType',
        'ownerType' => 'getOwnerType',
        'owner' => 'getOwner',
        'audioFile' => 'getAudioFile',
        'audioTTS' => 'getAudioTTS',
        'createdDate' => 'getCreatedDate',
        'createdBy' => 'getCreatedBy',
        'modifiedDate' => 'getModifiedDate',
        'modifiedBy' => 'getModifiedBy',
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

    const TYPE_STATION = 'STATION';
    const TYPE_VOICEMAIL = 'VOICEMAIL';
    const TYPE_NAME = 'NAME';
    const OWNER_TYPE_USER = 'USER';
    const OWNER_TYPE_ORGANIZATION = 'ORGANIZATION';
    const OWNER_TYPE_GROUP = 'GROUP';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_STATION,
            self::TYPE_VOICEMAIL,
            self::TYPE_NAME,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getOwnerTypeAllowableValues()
    {
        return [
            self::OWNER_TYPE_USER,
            self::OWNER_TYPE_ORGANIZATION,
            self::OWNER_TYPE_GROUP,
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
        $this->container['type'] = isset($data['type']) ? $data['type'] : null;
        $this->container['ownerType'] = isset($data['ownerType']) ? $data['ownerType'] : null;
        $this->container['owner'] = isset($data['owner']) ? $data['owner'] : null;
        $this->container['audioFile'] = isset($data['audioFile']) ? $data['audioFile'] : null;
        $this->container['audioTTS'] = isset($data['audioTTS']) ? $data['audioTTS'] : null;
        $this->container['createdDate'] = isset($data['createdDate']) ? $data['createdDate'] : null;
        $this->container['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : null;
        $this->container['modifiedDate'] = isset($data['modifiedDate']) ? $data['modifiedDate'] : null;
        $this->container['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : null;
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

        if ($this->container['type'] === null) {
            $invalidProperties[] = "'type' can't be null";
        }
        $allowedValues = $this->getTypeAllowableValues();
        if (!is_null($this->container['type']) && !in_array($this->container['type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['ownerType'] === null) {
            $invalidProperties[] = "'ownerType' can't be null";
        }
        $allowedValues = $this->getOwnerTypeAllowableValues();
        if (!is_null($this->container['ownerType']) && !in_array($this->container['ownerType'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'ownerType', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['owner'] === null) {
            $invalidProperties[] = "'owner' can't be null";
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
     * Gets type
     *
     * @return string
     */
    public function getType()
    {
        return $this->container['type'];
    }

    /**
     * Sets type
     *
     * @param string $type Greeting type
     *
     * @return $this
     */
    public function setType($type)
    {
        $allowedValues = $this->getTypeAllowableValues();
        if (!in_array($type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'type', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets ownerType
     *
     * @return string
     */
    public function getOwnerType()
    {
        return $this->container['ownerType'];
    }

    /**
     * Sets ownerType
     *
     * @param string $ownerType Greeting owner type
     *
     * @return $this
     */
    public function setOwnerType($ownerType)
    {
        $allowedValues = $this->getOwnerTypeAllowableValues();
        if (!in_array($ownerType, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'ownerType', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['ownerType'] = $ownerType;

        return $this;
    }

    /**
     * Gets owner
     *
     * @return \PureCloudPlatform\Client\V2\Model\DomainEntity
     */
    public function getOwner()
    {
        return $this->container['owner'];
    }

    /**
     * Sets owner
     *
     * @param \PureCloudPlatform\Client\V2\Model\DomainEntity $owner Greeting owner
     *
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->container['owner'] = $owner;

        return $this;
    }

    /**
     * Gets audioFile
     *
     * @return \PureCloudPlatform\Client\V2\Model\GreetingAudioFile
     */
    public function getAudioFile()
    {
        return $this->container['audioFile'];
    }

    /**
     * Sets audioFile
     *
     * @param \PureCloudPlatform\Client\V2\Model\GreetingAudioFile $audioFile audioFile
     *
     * @return $this
     */
    public function setAudioFile($audioFile)
    {
        $this->container['audioFile'] = $audioFile;

        return $this;
    }

    /**
     * Gets audioTTS
     *
     * @return string
     */
    public function getAudioTTS()
    {
        return $this->container['audioTTS'];
    }

    /**
     * Sets audioTTS
     *
     * @param string $audioTTS audioTTS
     *
     * @return $this
     */
    public function setAudioTTS($audioTTS)
    {
        $this->container['audioTTS'] = $audioTTS;

        return $this;
    }

    /**
     * Gets createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->container['createdDate'];
    }

    /**
     * Sets createdDate
     *
     * @param \DateTime $createdDate Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setCreatedDate($createdDate)
    {
        $this->container['createdDate'] = $createdDate;

        return $this;
    }

    /**
     * Gets createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->container['createdBy'];
    }

    /**
     * Sets createdBy
     *
     * @param string $createdBy createdBy
     *
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->container['createdBy'] = $createdBy;

        return $this;
    }

    /**
     * Gets modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->container['modifiedDate'];
    }

    /**
     * Sets modifiedDate
     *
     * @param \DateTime $modifiedDate Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->container['modifiedDate'] = $modifiedDate;

        return $this;
    }

    /**
     * Gets modifiedBy
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->container['modifiedBy'];
    }

    /**
     * Sets modifiedBy
     *
     * @param string $modifiedBy modifiedBy
     *
     * @return $this
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->container['modifiedBy'] = $modifiedBy;

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


