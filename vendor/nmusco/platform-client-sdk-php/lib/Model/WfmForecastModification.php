<?php
/**
 * WfmForecastModification
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
 * WfmForecastModification Class Doc Comment
 *
 * @category Class
 * @description A modification to a short term forecast
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class WfmForecastModification implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'WfmForecastModification';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'type' => 'string',
        'startIntervalIndex' => 'int',
        'endIntervalIndex' => 'int',
        'metric' => 'string',
        'value' => 'double',
        'values' => '\PureCloudPlatform\Client\V2\Model\WfmForecastModificationIntervalOffsetValue[]',
        'enabled' => 'bool',
        'attributes' => '\PureCloudPlatform\Client\V2\Model\WfmForecastModificationAttributes'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'type' => null,
        'startIntervalIndex' => 'int32',
        'endIntervalIndex' => 'int32',
        'metric' => null,
        'value' => 'double',
        'values' => null,
        'enabled' => null,
        'attributes' => null
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
        'type' => 'type',
        'startIntervalIndex' => 'startIntervalIndex',
        'endIntervalIndex' => 'endIntervalIndex',
        'metric' => 'metric',
        'value' => 'value',
        'values' => 'values',
        'enabled' => 'enabled',
        'attributes' => 'attributes'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'type' => 'setType',
        'startIntervalIndex' => 'setStartIntervalIndex',
        'endIntervalIndex' => 'setEndIntervalIndex',
        'metric' => 'setMetric',
        'value' => 'setValue',
        'values' => 'setValues',
        'enabled' => 'setEnabled',
        'attributes' => 'setAttributes'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'type' => 'getType',
        'startIntervalIndex' => 'getStartIntervalIndex',
        'endIntervalIndex' => 'getEndIntervalIndex',
        'metric' => 'getMetric',
        'value' => 'getValue',
        'values' => 'getValues',
        'enabled' => 'getEnabled',
        'attributes' => 'getAttributes'
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

    const TYPE_MINIMUM_PER_INTERVAL = 'MinimumPerInterval';
    const TYPE_MAXIMUM_PER_INTERVAL = 'MaximumPerInterval';
    const TYPE_SET_VALUE_PER_INTERVAL = 'SetValuePerInterval';
    const TYPE_CHANGE_VALUE_PER_INTERVAL = 'ChangeValuePerInterval';
    const TYPE_CHANGE_PERCENT_PER_INTERVAL = 'ChangePercentPerInterval';
    const TYPE_SET_VALUE_OVER_RANGE = 'SetValueOverRange';
    const TYPE_CHANGE_VALUE_OVER_RANGE = 'ChangeValueOverRange';
    const TYPE_SET_VALUES_FOR_INTERVAL_SET = 'SetValuesForIntervalSet';
    const METRIC_OFFERED = 'Offered';
    const METRIC_AVERAGE_TALK_TIME_SECONDS = 'AverageTalkTimeSeconds';
    const METRIC_AVERAGE_AFTER_CALL_WORK_TIME_SECONDS = 'AverageAfterCallWorkTimeSeconds';
    const METRIC_AVERAGE_HANDLE_TIME_SECONDS = 'AverageHandleTimeSeconds';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_MINIMUM_PER_INTERVAL,
            self::TYPE_MAXIMUM_PER_INTERVAL,
            self::TYPE_SET_VALUE_PER_INTERVAL,
            self::TYPE_CHANGE_VALUE_PER_INTERVAL,
            self::TYPE_CHANGE_PERCENT_PER_INTERVAL,
            self::TYPE_SET_VALUE_OVER_RANGE,
            self::TYPE_CHANGE_VALUE_OVER_RANGE,
            self::TYPE_SET_VALUES_FOR_INTERVAL_SET,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getMetricAllowableValues()
    {
        return [
            self::METRIC_OFFERED,
            self::METRIC_AVERAGE_TALK_TIME_SECONDS,
            self::METRIC_AVERAGE_AFTER_CALL_WORK_TIME_SECONDS,
            self::METRIC_AVERAGE_HANDLE_TIME_SECONDS,
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
        $this->container['type'] = isset($data['type']) ? $data['type'] : null;
        $this->container['startIntervalIndex'] = isset($data['startIntervalIndex']) ? $data['startIntervalIndex'] : null;
        $this->container['endIntervalIndex'] = isset($data['endIntervalIndex']) ? $data['endIntervalIndex'] : null;
        $this->container['metric'] = isset($data['metric']) ? $data['metric'] : null;
        $this->container['value'] = isset($data['value']) ? $data['value'] : null;
        $this->container['values'] = isset($data['values']) ? $data['values'] : null;
        $this->container['enabled'] = isset($data['enabled']) ? $data['enabled'] : null;
        $this->container['attributes'] = isset($data['attributes']) ? $data['attributes'] : null;
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

        if ($this->container['metric'] === null) {
            $invalidProperties[] = "'metric' can't be null";
        }
        $allowedValues = $this->getMetricAllowableValues();
        if (!is_null($this->container['metric']) && !in_array($this->container['metric'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'metric', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['enabled'] === null) {
            $invalidProperties[] = "'enabled' can't be null";
        }
        if ($this->container['attributes'] === null) {
            $invalidProperties[] = "'attributes' can't be null";
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
     * @param string $type The type of the modification
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
     * Gets startIntervalIndex
     *
     * @return int
     */
    public function getStartIntervalIndex()
    {
        return $this->container['startIntervalIndex'];
    }

    /**
     * Sets startIntervalIndex
     *
     * @param int $startIntervalIndex The number of 15 minute intervals past referenceStartDate representing the first interval to which to apply this modification. Must be null if values is populated
     *
     * @return $this
     */
    public function setStartIntervalIndex($startIntervalIndex)
    {
        $this->container['startIntervalIndex'] = $startIntervalIndex;

        return $this;
    }

    /**
     * Gets endIntervalIndex
     *
     * @return int
     */
    public function getEndIntervalIndex()
    {
        return $this->container['endIntervalIndex'];
    }

    /**
     * Sets endIntervalIndex
     *
     * @param int $endIntervalIndex The number of 15 minute intervals past referenceStartDate representing the last interval to which to apply this modification.  Must be null if values is populated
     *
     * @return $this
     */
    public function setEndIntervalIndex($endIntervalIndex)
    {
        $this->container['endIntervalIndex'] = $endIntervalIndex;

        return $this;
    }

    /**
     * Gets metric
     *
     * @return string
     */
    public function getMetric()
    {
        return $this->container['metric'];
    }

    /**
     * Sets metric
     *
     * @param string $metric The metric to which this modification applies
     *
     * @return $this
     */
    public function setMetric($metric)
    {
        $allowedValues = $this->getMetricAllowableValues();
        if (!in_array($metric, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'metric', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['metric'] = $metric;

        return $this;
    }

    /**
     * Gets value
     *
     * @return double
     */
    public function getValue()
    {
        return $this->container['value'];
    }

    /**
     * Sets value
     *
     * @param double $value The value of the modification.  Must be null if \"values\" is populated
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->container['value'] = $value;

        return $this;
    }

    /**
     * Gets values
     *
     * @return \PureCloudPlatform\Client\V2\Model\WfmForecastModificationIntervalOffsetValue[]
     */
    public function getValues()
    {
        return $this->container['values'];
    }

    /**
     * Sets values
     *
     * @param \PureCloudPlatform\Client\V2\Model\WfmForecastModificationIntervalOffsetValue[] $values The list of values to update.  Only applicable for grid-type modifications. Must be null if \"value\" is populated
     *
     * @return $this
     */
    public function setValues($values)
    {
        $this->container['values'] = $values;

        return $this;
    }

    /**
     * Gets enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->container['enabled'];
    }

    /**
     * Sets enabled
     *
     * @param bool $enabled Whether the modification is enabled for the forecast
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->container['enabled'] = $enabled;

        return $this;
    }

    /**
     * Gets attributes
     *
     * @return \PureCloudPlatform\Client\V2\Model\WfmForecastModificationAttributes
     */
    public function getAttributes()
    {
        return $this->container['attributes'];
    }

    /**
     * Sets attributes
     *
     * @param \PureCloudPlatform\Client\V2\Model\WfmForecastModificationAttributes $attributes The attributes defining how this modification applies to the forecast
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->container['attributes'] = $attributes;

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


