<?php
/**
 * ShiftTradeResponse
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
 * ShiftTradeResponse Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ShiftTradeResponse implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ShiftTradeResponse';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'weekDate' => '\DateTime',
        'schedule' => '\PureCloudPlatform\Client\V2\Model\WeekScheduleReference',
        'state' => 'string',
        'initiatingUser' => '\PureCloudPlatform\Client\V2\Model\UserReference',
        'initiatingShiftId' => 'string',
        'initiatingShiftStart' => '\DateTime',
        'initiatingShiftEnd' => '\DateTime',
        'receivingUser' => '\PureCloudPlatform\Client\V2\Model\UserReference',
        'receivingShiftId' => 'string',
        'receivingShiftStart' => '\DateTime',
        'receivingShiftEnd' => '\DateTime',
        'expiration' => '\DateTime',
        'oneSided' => 'bool',
        'acceptableIntervals' => 'string[]',
        'reviewedBy' => '\PureCloudPlatform\Client\V2\Model\UserReference',
        'reviewedDate' => '\DateTime',
        'metadata' => '\PureCloudPlatform\Client\V2\Model\WfmVersionedEntityMetadata'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'weekDate' => 'date',
        'schedule' => null,
        'state' => null,
        'initiatingUser' => null,
        'initiatingShiftId' => null,
        'initiatingShiftStart' => 'date-time',
        'initiatingShiftEnd' => 'date-time',
        'receivingUser' => null,
        'receivingShiftId' => null,
        'receivingShiftStart' => 'date-time',
        'receivingShiftEnd' => 'date-time',
        'expiration' => 'date-time',
        'oneSided' => null,
        'acceptableIntervals' => null,
        'reviewedBy' => null,
        'reviewedDate' => 'date-time',
        'metadata' => null
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
        'weekDate' => 'weekDate',
        'schedule' => 'schedule',
        'state' => 'state',
        'initiatingUser' => 'initiatingUser',
        'initiatingShiftId' => 'initiatingShiftId',
        'initiatingShiftStart' => 'initiatingShiftStart',
        'initiatingShiftEnd' => 'initiatingShiftEnd',
        'receivingUser' => 'receivingUser',
        'receivingShiftId' => 'receivingShiftId',
        'receivingShiftStart' => 'receivingShiftStart',
        'receivingShiftEnd' => 'receivingShiftEnd',
        'expiration' => 'expiration',
        'oneSided' => 'oneSided',
        'acceptableIntervals' => 'acceptableIntervals',
        'reviewedBy' => 'reviewedBy',
        'reviewedDate' => 'reviewedDate',
        'metadata' => 'metadata'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'weekDate' => 'setWeekDate',
        'schedule' => 'setSchedule',
        'state' => 'setState',
        'initiatingUser' => 'setInitiatingUser',
        'initiatingShiftId' => 'setInitiatingShiftId',
        'initiatingShiftStart' => 'setInitiatingShiftStart',
        'initiatingShiftEnd' => 'setInitiatingShiftEnd',
        'receivingUser' => 'setReceivingUser',
        'receivingShiftId' => 'setReceivingShiftId',
        'receivingShiftStart' => 'setReceivingShiftStart',
        'receivingShiftEnd' => 'setReceivingShiftEnd',
        'expiration' => 'setExpiration',
        'oneSided' => 'setOneSided',
        'acceptableIntervals' => 'setAcceptableIntervals',
        'reviewedBy' => 'setReviewedBy',
        'reviewedDate' => 'setReviewedDate',
        'metadata' => 'setMetadata'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'weekDate' => 'getWeekDate',
        'schedule' => 'getSchedule',
        'state' => 'getState',
        'initiatingUser' => 'getInitiatingUser',
        'initiatingShiftId' => 'getInitiatingShiftId',
        'initiatingShiftStart' => 'getInitiatingShiftStart',
        'initiatingShiftEnd' => 'getInitiatingShiftEnd',
        'receivingUser' => 'getReceivingUser',
        'receivingShiftId' => 'getReceivingShiftId',
        'receivingShiftStart' => 'getReceivingShiftStart',
        'receivingShiftEnd' => 'getReceivingShiftEnd',
        'expiration' => 'getExpiration',
        'oneSided' => 'getOneSided',
        'acceptableIntervals' => 'getAcceptableIntervals',
        'reviewedBy' => 'getReviewedBy',
        'reviewedDate' => 'getReviewedDate',
        'metadata' => 'getMetadata'
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

    const STATE_UNMATCHED = 'Unmatched';
    const STATE_MATCHED = 'Matched';
    const STATE_APPROVED = 'Approved';
    const STATE_DENIED = 'Denied';
    const STATE_EXPIRED = 'Expired';
    const STATE_CANCELED = 'Canceled';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getStateAllowableValues()
    {
        return [
            self::STATE_UNMATCHED,
            self::STATE_MATCHED,
            self::STATE_APPROVED,
            self::STATE_DENIED,
            self::STATE_EXPIRED,
            self::STATE_CANCELED,
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
        $this->container['weekDate'] = isset($data['weekDate']) ? $data['weekDate'] : null;
        $this->container['schedule'] = isset($data['schedule']) ? $data['schedule'] : null;
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
        $this->container['initiatingUser'] = isset($data['initiatingUser']) ? $data['initiatingUser'] : null;
        $this->container['initiatingShiftId'] = isset($data['initiatingShiftId']) ? $data['initiatingShiftId'] : null;
        $this->container['initiatingShiftStart'] = isset($data['initiatingShiftStart']) ? $data['initiatingShiftStart'] : null;
        $this->container['initiatingShiftEnd'] = isset($data['initiatingShiftEnd']) ? $data['initiatingShiftEnd'] : null;
        $this->container['receivingUser'] = isset($data['receivingUser']) ? $data['receivingUser'] : null;
        $this->container['receivingShiftId'] = isset($data['receivingShiftId']) ? $data['receivingShiftId'] : null;
        $this->container['receivingShiftStart'] = isset($data['receivingShiftStart']) ? $data['receivingShiftStart'] : null;
        $this->container['receivingShiftEnd'] = isset($data['receivingShiftEnd']) ? $data['receivingShiftEnd'] : null;
        $this->container['expiration'] = isset($data['expiration']) ? $data['expiration'] : null;
        $this->container['oneSided'] = isset($data['oneSided']) ? $data['oneSided'] : null;
        $this->container['acceptableIntervals'] = isset($data['acceptableIntervals']) ? $data['acceptableIntervals'] : null;
        $this->container['reviewedBy'] = isset($data['reviewedBy']) ? $data['reviewedBy'] : null;
        $this->container['reviewedDate'] = isset($data['reviewedDate']) ? $data['reviewedDate'] : null;
        $this->container['metadata'] = isset($data['metadata']) ? $data['metadata'] : null;
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
     * @param string $id The ID of this shift trade
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets weekDate
     *
     * @return \DateTime
     */
    public function getWeekDate()
    {
        return $this->container['weekDate'];
    }

    /**
     * Sets weekDate
     *
     * @param \DateTime $weekDate The start week date of the associated schedule in yyyy-MM-dd format. Dates are represented as an ISO-8601 string. For example: yyyy-MM-dd
     *
     * @return $this
     */
    public function setWeekDate($weekDate)
    {
        $this->container['weekDate'] = $weekDate;

        return $this;
    }

    /**
     * Gets schedule
     *
     * @return \PureCloudPlatform\Client\V2\Model\WeekScheduleReference
     */
    public function getSchedule()
    {
        return $this->container['schedule'];
    }

    /**
     * Sets schedule
     *
     * @param \PureCloudPlatform\Client\V2\Model\WeekScheduleReference $schedule The ID of the associated schedule
     *
     * @return $this
     */
    public function setSchedule($schedule)
    {
        $this->container['schedule'] = $schedule;

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
     * @param string $state The state of this shift trade
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
     * Gets initiatingUser
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserReference
     */
    public function getInitiatingUser()
    {
        return $this->container['initiatingUser'];
    }

    /**
     * Sets initiatingUser
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserReference $initiatingUser The user who initiated this trade
     *
     * @return $this
     */
    public function setInitiatingUser($initiatingUser)
    {
        $this->container['initiatingUser'] = $initiatingUser;

        return $this;
    }

    /**
     * Gets initiatingShiftId
     *
     * @return string
     */
    public function getInitiatingShiftId()
    {
        return $this->container['initiatingShiftId'];
    }

    /**
     * Sets initiatingShiftId
     *
     * @param string $initiatingShiftId The ID of the shift offered for trade by the initiating user
     *
     * @return $this
     */
    public function setInitiatingShiftId($initiatingShiftId)
    {
        $this->container['initiatingShiftId'] = $initiatingShiftId;

        return $this;
    }

    /**
     * Gets initiatingShiftStart
     *
     * @return \DateTime
     */
    public function getInitiatingShiftStart()
    {
        return $this->container['initiatingShiftStart'];
    }

    /**
     * Sets initiatingShiftStart
     *
     * @param \DateTime $initiatingShiftStart The start date/time of the shift being offered for trade. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setInitiatingShiftStart($initiatingShiftStart)
    {
        $this->container['initiatingShiftStart'] = $initiatingShiftStart;

        return $this;
    }

    /**
     * Gets initiatingShiftEnd
     *
     * @return \DateTime
     */
    public function getInitiatingShiftEnd()
    {
        return $this->container['initiatingShiftEnd'];
    }

    /**
     * Sets initiatingShiftEnd
     *
     * @param \DateTime $initiatingShiftEnd The end date/time of the shift being offered for trade. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setInitiatingShiftEnd($initiatingShiftEnd)
    {
        $this->container['initiatingShiftEnd'] = $initiatingShiftEnd;

        return $this;
    }

    /**
     * Gets receivingUser
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserReference
     */
    public function getReceivingUser()
    {
        return $this->container['receivingUser'];
    }

    /**
     * Sets receivingUser
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserReference $receivingUser The user matching the trade, or if the state is not Matched, the user to whom the trade request was sent
     *
     * @return $this
     */
    public function setReceivingUser($receivingUser)
    {
        $this->container['receivingUser'] = $receivingUser;

        return $this;
    }

    /**
     * Gets receivingShiftId
     *
     * @return string
     */
    public function getReceivingShiftId()
    {
        return $this->container['receivingShiftId'];
    }

    /**
     * Sets receivingShiftId
     *
     * @param string $receivingShiftId The ID of the shift being exchanged for the initiating shift, null if the receiving user is picking up a shift
     *
     * @return $this
     */
    public function setReceivingShiftId($receivingShiftId)
    {
        $this->container['receivingShiftId'] = $receivingShiftId;

        return $this;
    }

    /**
     * Gets receivingShiftStart
     *
     * @return \DateTime
     */
    public function getReceivingShiftStart()
    {
        return $this->container['receivingShiftStart'];
    }

    /**
     * Sets receivingShiftStart
     *
     * @param \DateTime $receivingShiftStart The start date/time of the receiving shift. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setReceivingShiftStart($receivingShiftStart)
    {
        $this->container['receivingShiftStart'] = $receivingShiftStart;

        return $this;
    }

    /**
     * Gets receivingShiftEnd
     *
     * @return \DateTime
     */
    public function getReceivingShiftEnd()
    {
        return $this->container['receivingShiftEnd'];
    }

    /**
     * Sets receivingShiftEnd
     *
     * @param \DateTime $receivingShiftEnd The end date/time of the receiving shift. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setReceivingShiftEnd($receivingShiftEnd)
    {
        $this->container['receivingShiftEnd'] = $receivingShiftEnd;

        return $this;
    }

    /**
     * Gets expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->container['expiration'];
    }

    /**
     * Sets expiration
     *
     * @param \DateTime $expiration When this shift trade offer will expire if not matched or approved. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setExpiration($expiration)
    {
        $this->container['expiration'] = $expiration;

        return $this;
    }

    /**
     * Gets oneSided
     *
     * @return bool
     */
    public function getOneSided()
    {
        return $this->container['oneSided'];
    }

    /**
     * Sets oneSided
     *
     * @param bool $oneSided Whether this is a one-sided shift trade (e.g. the initiating user is not asking for a shift in return)
     *
     * @return $this
     */
    public function setOneSided($oneSided)
    {
        $this->container['oneSided'] = $oneSided;

        return $this;
    }

    /**
     * Gets acceptableIntervals
     *
     * @return string[]
     */
    public function getAcceptableIntervals()
    {
        return $this->container['acceptableIntervals'];
    }

    /**
     * Sets acceptableIntervals
     *
     * @param string[] $acceptableIntervals acceptableIntervals
     *
     * @return $this
     */
    public function setAcceptableIntervals($acceptableIntervals)
    {
        $this->container['acceptableIntervals'] = $acceptableIntervals;

        return $this;
    }

    /**
     * Gets reviewedBy
     *
     * @return \PureCloudPlatform\Client\V2\Model\UserReference
     */
    public function getReviewedBy()
    {
        return $this->container['reviewedBy'];
    }

    /**
     * Sets reviewedBy
     *
     * @param \PureCloudPlatform\Client\V2\Model\UserReference $reviewedBy The user who reviewed this shift trade
     *
     * @return $this
     */
    public function setReviewedBy($reviewedBy)
    {
        $this->container['reviewedBy'] = $reviewedBy;

        return $this;
    }

    /**
     * Gets reviewedDate
     *
     * @return \DateTime
     */
    public function getReviewedDate()
    {
        return $this->container['reviewedDate'];
    }

    /**
     * Sets reviewedDate
     *
     * @param \DateTime $reviewedDate The timestamp when this shift trade was reviewed. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setReviewedDate($reviewedDate)
    {
        $this->container['reviewedDate'] = $reviewedDate;

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
     * @param \PureCloudPlatform\Client\V2\Model\WfmVersionedEntityMetadata $metadata Version data for this trade
     *
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->container['metadata'] = $metadata;

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


