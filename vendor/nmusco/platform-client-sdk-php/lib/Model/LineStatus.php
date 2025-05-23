<?php
/**
 * LineStatus
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
 * LineStatus Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class LineStatus implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'LineStatus';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'reachable' => 'bool',
        'addressOfRecord' => 'string',
        'contactAddresses' => 'string[]',
        'reachableStateTime' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'reachable' => null,
        'addressOfRecord' => null,
        'contactAddresses' => null,
        'reachableStateTime' => 'date-time'
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
        'reachable' => 'reachable',
        'addressOfRecord' => 'addressOfRecord',
        'contactAddresses' => 'contactAddresses',
        'reachableStateTime' => 'reachableStateTime'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'reachable' => 'setReachable',
        'addressOfRecord' => 'setAddressOfRecord',
        'contactAddresses' => 'setContactAddresses',
        'reachableStateTime' => 'setReachableStateTime'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'reachable' => 'getReachable',
        'addressOfRecord' => 'getAddressOfRecord',
        'contactAddresses' => 'getContactAddresses',
        'reachableStateTime' => 'getReachableStateTime'
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
        $this->container['reachable'] = isset($data['reachable']) ? $data['reachable'] : null;
        $this->container['addressOfRecord'] = isset($data['addressOfRecord']) ? $data['addressOfRecord'] : null;
        $this->container['contactAddresses'] = isset($data['contactAddresses']) ? $data['contactAddresses'] : null;
        $this->container['reachableStateTime'] = isset($data['reachableStateTime']) ? $data['reachableStateTime'] : null;
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
     * @param string $id The id of this line
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets reachable
     *
     * @return bool
     */
    public function getReachable()
    {
        return $this->container['reachable'];
    }

    /**
     * Sets reachable
     *
     * @param bool $reachable Indicates whether the edge can reach the line.
     *
     * @return $this
     */
    public function setReachable($reachable)
    {
        $this->container['reachable'] = $reachable;

        return $this;
    }

    /**
     * Gets addressOfRecord
     *
     * @return string
     */
    public function getAddressOfRecord()
    {
        return $this->container['addressOfRecord'];
    }

    /**
     * Sets addressOfRecord
     *
     * @param string $addressOfRecord The line's address of record.
     *
     * @return $this
     */
    public function setAddressOfRecord($addressOfRecord)
    {
        $this->container['addressOfRecord'] = $addressOfRecord;

        return $this;
    }

    /**
     * Gets contactAddresses
     *
     * @return string[]
     */
    public function getContactAddresses()
    {
        return $this->container['contactAddresses'];
    }

    /**
     * Sets contactAddresses
     *
     * @param string[] $contactAddresses The addresses used to contact the line.
     *
     * @return $this
     */
    public function setContactAddresses($contactAddresses)
    {
        $this->container['contactAddresses'] = $contactAddresses;

        return $this;
    }

    /**
     * Gets reachableStateTime
     *
     * @return \DateTime
     */
    public function getReachableStateTime()
    {
        return $this->container['reachableStateTime'];
    }

    /**
     * Sets reachableStateTime
     *
     * @param \DateTime $reachableStateTime The time the line entered its current reachable state. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setReachableStateTime($reachableStateTime)
    {
        $this->container['reachableStateTime'] = $reachableStateTime;

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


