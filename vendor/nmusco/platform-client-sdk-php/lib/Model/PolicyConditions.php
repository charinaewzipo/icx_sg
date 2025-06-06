<?php
/**
 * PolicyConditions
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
 * PolicyConditions Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class PolicyConditions implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'PolicyConditions';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'forUsers' => '\PureCloudPlatform\Client\V2\Model\User[]',
        'directions' => 'string[]',
        'dateRanges' => 'string[]',
        'mediaTypes' => 'string[]',
        'forQueues' => '\PureCloudPlatform\Client\V2\Model\Queue[]',
        'duration' => '\PureCloudPlatform\Client\V2\Model\DurationCondition',
        'wrapupCodes' => '\PureCloudPlatform\Client\V2\Model\WrapupCode[]',
        'timeAllowed' => '\PureCloudPlatform\Client\V2\Model\TimeAllowed'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'forUsers' => null,
        'directions' => null,
        'dateRanges' => null,
        'mediaTypes' => null,
        'forQueues' => null,
        'duration' => null,
        'wrapupCodes' => null,
        'timeAllowed' => null
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
        'forUsers' => 'forUsers',
        'directions' => 'directions',
        'dateRanges' => 'dateRanges',
        'mediaTypes' => 'mediaTypes',
        'forQueues' => 'forQueues',
        'duration' => 'duration',
        'wrapupCodes' => 'wrapupCodes',
        'timeAllowed' => 'timeAllowed'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'forUsers' => 'setForUsers',
        'directions' => 'setDirections',
        'dateRanges' => 'setDateRanges',
        'mediaTypes' => 'setMediaTypes',
        'forQueues' => 'setForQueues',
        'duration' => 'setDuration',
        'wrapupCodes' => 'setWrapupCodes',
        'timeAllowed' => 'setTimeAllowed'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'forUsers' => 'getForUsers',
        'directions' => 'getDirections',
        'dateRanges' => 'getDateRanges',
        'mediaTypes' => 'getMediaTypes',
        'forQueues' => 'getForQueues',
        'duration' => 'getDuration',
        'wrapupCodes' => 'getWrapupCodes',
        'timeAllowed' => 'getTimeAllowed'
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

    const DIRECTIONS_INBOUND = 'INBOUND';
    const DIRECTIONS_OUTBOUND = 'OUTBOUND';
    const MEDIA_TYPES_CALL = 'CALL';
    const MEDIA_TYPES_CHAT = 'CHAT';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getDirectionsAllowableValues()
    {
        return [
            self::DIRECTIONS_INBOUND,
            self::DIRECTIONS_OUTBOUND,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getMediaTypesAllowableValues()
    {
        return [
            self::MEDIA_TYPES_CALL,
            self::MEDIA_TYPES_CHAT,
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
        $this->container['forUsers'] = isset($data['forUsers']) ? $data['forUsers'] : null;
        $this->container['directions'] = isset($data['directions']) ? $data['directions'] : null;
        $this->container['dateRanges'] = isset($data['dateRanges']) ? $data['dateRanges'] : null;
        $this->container['mediaTypes'] = isset($data['mediaTypes']) ? $data['mediaTypes'] : null;
        $this->container['forQueues'] = isset($data['forQueues']) ? $data['forQueues'] : null;
        $this->container['duration'] = isset($data['duration']) ? $data['duration'] : null;
        $this->container['wrapupCodes'] = isset($data['wrapupCodes']) ? $data['wrapupCodes'] : null;
        $this->container['timeAllowed'] = isset($data['timeAllowed']) ? $data['timeAllowed'] : null;
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
     * Gets forUsers
     *
     * @return \PureCloudPlatform\Client\V2\Model\User[]
     */
    public function getForUsers()
    {
        return $this->container['forUsers'];
    }

    /**
     * Sets forUsers
     *
     * @param \PureCloudPlatform\Client\V2\Model\User[] $forUsers forUsers
     *
     * @return $this
     */
    public function setForUsers($forUsers)
    {
        $this->container['forUsers'] = $forUsers;

        return $this;
    }

    /**
     * Gets directions
     *
     * @return string[]
     */
    public function getDirections()
    {
        return $this->container['directions'];
    }

    /**
     * Sets directions
     *
     * @param string[] $directions directions
     *
     * @return $this
     */
    public function setDirections($directions)
    {
        $allowedValues = $this->getDirectionsAllowableValues();
        if (!is_null($directions) && array_diff($directions, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'directions', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['directions'] = $directions;

        return $this;
    }

    /**
     * Gets dateRanges
     *
     * @return string[]
     */
    public function getDateRanges()
    {
        return $this->container['dateRanges'];
    }

    /**
     * Sets dateRanges
     *
     * @param string[] $dateRanges dateRanges
     *
     * @return $this
     */
    public function setDateRanges($dateRanges)
    {
        $this->container['dateRanges'] = $dateRanges;

        return $this;
    }

    /**
     * Gets mediaTypes
     *
     * @return string[]
     */
    public function getMediaTypes()
    {
        return $this->container['mediaTypes'];
    }

    /**
     * Sets mediaTypes
     *
     * @param string[] $mediaTypes mediaTypes
     *
     * @return $this
     */
    public function setMediaTypes($mediaTypes)
    {
        $allowedValues = $this->getMediaTypesAllowableValues();
        if (!is_null($mediaTypes) && array_diff($mediaTypes, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'mediaTypes', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['mediaTypes'] = $mediaTypes;

        return $this;
    }

    /**
     * Gets forQueues
     *
     * @return \PureCloudPlatform\Client\V2\Model\Queue[]
     */
    public function getForQueues()
    {
        return $this->container['forQueues'];
    }

    /**
     * Sets forQueues
     *
     * @param \PureCloudPlatform\Client\V2\Model\Queue[] $forQueues forQueues
     *
     * @return $this
     */
    public function setForQueues($forQueues)
    {
        $this->container['forQueues'] = $forQueues;

        return $this;
    }

    /**
     * Gets duration
     *
     * @return \PureCloudPlatform\Client\V2\Model\DurationCondition
     */
    public function getDuration()
    {
        return $this->container['duration'];
    }

    /**
     * Sets duration
     *
     * @param \PureCloudPlatform\Client\V2\Model\DurationCondition $duration duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->container['duration'] = $duration;

        return $this;
    }

    /**
     * Gets wrapupCodes
     *
     * @return \PureCloudPlatform\Client\V2\Model\WrapupCode[]
     */
    public function getWrapupCodes()
    {
        return $this->container['wrapupCodes'];
    }

    /**
     * Sets wrapupCodes
     *
     * @param \PureCloudPlatform\Client\V2\Model\WrapupCode[] $wrapupCodes wrapupCodes
     *
     * @return $this
     */
    public function setWrapupCodes($wrapupCodes)
    {
        $this->container['wrapupCodes'] = $wrapupCodes;

        return $this;
    }

    /**
     * Gets timeAllowed
     *
     * @return \PureCloudPlatform\Client\V2\Model\TimeAllowed
     */
    public function getTimeAllowed()
    {
        return $this->container['timeAllowed'];
    }

    /**
     * Sets timeAllowed
     *
     * @param \PureCloudPlatform\Client\V2\Model\TimeAllowed $timeAllowed timeAllowed
     *
     * @return $this
     */
    public function setTimeAllowed($timeAllowed)
    {
        $this->container['timeAllowed'] = $timeAllowed;

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


