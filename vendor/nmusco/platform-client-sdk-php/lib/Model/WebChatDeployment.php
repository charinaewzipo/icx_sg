<?php
/**
 * WebChatDeployment
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
 * WebChatDeployment Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class WebChatDeployment implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'WebChatDeployment';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'name' => 'string',
        'description' => 'string',
        'authenticationRequired' => 'bool',
        'authenticationUrl' => 'string',
        'disabled' => 'bool',
        'webChatConfig' => '\PureCloudPlatform\Client\V2\Model\WebChatConfig',
        'allowedDomains' => 'string[]',
        'flow' => '\PureCloudPlatform\Client\V2\Model\DomainEntityRef',
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
        'description' => null,
        'authenticationRequired' => null,
        'authenticationUrl' => null,
        'disabled' => null,
        'webChatConfig' => null,
        'allowedDomains' => null,
        'flow' => null,
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
        'description' => 'description',
        'authenticationRequired' => 'authenticationRequired',
        'authenticationUrl' => 'authenticationUrl',
        'disabled' => 'disabled',
        'webChatConfig' => 'webChatConfig',
        'allowedDomains' => 'allowedDomains',
        'flow' => 'flow',
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
        'description' => 'setDescription',
        'authenticationRequired' => 'setAuthenticationRequired',
        'authenticationUrl' => 'setAuthenticationUrl',
        'disabled' => 'setDisabled',
        'webChatConfig' => 'setWebChatConfig',
        'allowedDomains' => 'setAllowedDomains',
        'flow' => 'setFlow',
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
        'description' => 'getDescription',
        'authenticationRequired' => 'getAuthenticationRequired',
        'authenticationUrl' => 'getAuthenticationUrl',
        'disabled' => 'getDisabled',
        'webChatConfig' => 'getWebChatConfig',
        'allowedDomains' => 'getAllowedDomains',
        'flow' => 'getFlow',
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
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['authenticationRequired'] = isset($data['authenticationRequired']) ? $data['authenticationRequired'] : null;
        $this->container['authenticationUrl'] = isset($data['authenticationUrl']) ? $data['authenticationUrl'] : null;
        $this->container['disabled'] = isset($data['disabled']) ? $data['disabled'] : null;
        $this->container['webChatConfig'] = isset($data['webChatConfig']) ? $data['webChatConfig'] : null;
        $this->container['allowedDomains'] = isset($data['allowedDomains']) ? $data['allowedDomains'] : null;
        $this->container['flow'] = isset($data['flow']) ? $data['flow'] : null;
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
     * Gets description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string $description description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets authenticationRequired
     *
     * @return bool
     */
    public function getAuthenticationRequired()
    {
        return $this->container['authenticationRequired'];
    }

    /**
     * Sets authenticationRequired
     *
     * @param bool $authenticationRequired authenticationRequired
     *
     * @return $this
     */
    public function setAuthenticationRequired($authenticationRequired)
    {
        $this->container['authenticationRequired'] = $authenticationRequired;

        return $this;
    }

    /**
     * Gets authenticationUrl
     *
     * @return string
     */
    public function getAuthenticationUrl()
    {
        return $this->container['authenticationUrl'];
    }

    /**
     * Sets authenticationUrl
     *
     * @param string $authenticationUrl URL for third party service authenticating web chat clients. See https://github.com/MyPureCloud/authenticated-web-chat-server-examples
     *
     * @return $this
     */
    public function setAuthenticationUrl($authenticationUrl)
    {
        $this->container['authenticationUrl'] = $authenticationUrl;

        return $this;
    }

    /**
     * Gets disabled
     *
     * @return bool
     */
    public function getDisabled()
    {
        return $this->container['disabled'];
    }

    /**
     * Sets disabled
     *
     * @param bool $disabled disabled
     *
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->container['disabled'] = $disabled;

        return $this;
    }

    /**
     * Gets webChatConfig
     *
     * @return \PureCloudPlatform\Client\V2\Model\WebChatConfig
     */
    public function getWebChatConfig()
    {
        return $this->container['webChatConfig'];
    }

    /**
     * Sets webChatConfig
     *
     * @param \PureCloudPlatform\Client\V2\Model\WebChatConfig $webChatConfig webChatConfig
     *
     * @return $this
     */
    public function setWebChatConfig($webChatConfig)
    {
        $this->container['webChatConfig'] = $webChatConfig;

        return $this;
    }

    /**
     * Gets allowedDomains
     *
     * @return string[]
     */
    public function getAllowedDomains()
    {
        return $this->container['allowedDomains'];
    }

    /**
     * Sets allowedDomains
     *
     * @param string[] $allowedDomains allowedDomains
     *
     * @return $this
     */
    public function setAllowedDomains($allowedDomains)
    {
        $this->container['allowedDomains'] = $allowedDomains;

        return $this;
    }

    /**
     * Gets flow
     *
     * @return \PureCloudPlatform\Client\V2\Model\DomainEntityRef
     */
    public function getFlow()
    {
        return $this->container['flow'];
    }

    /**
     * Sets flow
     *
     * @param \PureCloudPlatform\Client\V2\Model\DomainEntityRef $flow The URI of the Inbound Chat Flow to run when new chats are initiated under this Deployment.
     *
     * @return $this
     */
    public function setFlow($flow)
    {
        $this->container['flow'] = $flow;

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


