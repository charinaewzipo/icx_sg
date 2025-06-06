<?php
/**
 * ScimServiceProviderConfig
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
 * ScimServiceProviderConfig Class Doc Comment
 *
 * @category Class
 * @description SCIM Provider Config for PureCloud.
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ScimServiceProviderConfig implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ScimServiceProviderConfig';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'schemas' => 'string[]',
        'documentationUri' => 'string',
        'patch' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature',
        'filter' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigFilterFeature',
        'etag' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature',
        'sort' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature',
        'bulk' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigBulkFeature',
        'changePassword' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature',
        'authenticationSchemes' => '\PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigAuthenticationScheme[]',
        'meta' => '\PureCloudPlatform\Client\V2\Model\ScimMetadata'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'schemas' => null,
        'documentationUri' => 'uri',
        'patch' => null,
        'filter' => null,
        'etag' => null,
        'sort' => null,
        'bulk' => null,
        'changePassword' => null,
        'authenticationSchemes' => null,
        'meta' => null
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
        'schemas' => 'schemas',
        'documentationUri' => 'documentationUri',
        'patch' => 'patch',
        'filter' => 'filter',
        'etag' => 'etag',
        'sort' => 'sort',
        'bulk' => 'bulk',
        'changePassword' => 'changePassword',
        'authenticationSchemes' => 'authenticationSchemes',
        'meta' => 'meta'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'schemas' => 'setSchemas',
        'documentationUri' => 'setDocumentationUri',
        'patch' => 'setPatch',
        'filter' => 'setFilter',
        'etag' => 'setEtag',
        'sort' => 'setSort',
        'bulk' => 'setBulk',
        'changePassword' => 'setChangePassword',
        'authenticationSchemes' => 'setAuthenticationSchemes',
        'meta' => 'setMeta'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'schemas' => 'getSchemas',
        'documentationUri' => 'getDocumentationUri',
        'patch' => 'getPatch',
        'filter' => 'getFilter',
        'etag' => 'getEtag',
        'sort' => 'getSort',
        'bulk' => 'getBulk',
        'changePassword' => 'getChangePassword',
        'authenticationSchemes' => 'getAuthenticationSchemes',
        'meta' => 'getMeta'
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
        $this->container['schemas'] = isset($data['schemas']) ? $data['schemas'] : null;
        $this->container['documentationUri'] = isset($data['documentationUri']) ? $data['documentationUri'] : null;
        $this->container['patch'] = isset($data['patch']) ? $data['patch'] : null;
        $this->container['filter'] = isset($data['filter']) ? $data['filter'] : null;
        $this->container['etag'] = isset($data['etag']) ? $data['etag'] : null;
        $this->container['sort'] = isset($data['sort']) ? $data['sort'] : null;
        $this->container['bulk'] = isset($data['bulk']) ? $data['bulk'] : null;
        $this->container['changePassword'] = isset($data['changePassword']) ? $data['changePassword'] : null;
        $this->container['authenticationSchemes'] = isset($data['authenticationSchemes']) ? $data['authenticationSchemes'] : null;
        $this->container['meta'] = isset($data['meta']) ? $data['meta'] : null;
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
     * Gets schemas
     *
     * @return string[]
     */
    public function getSchemas()
    {
        return $this->container['schemas'];
    }

    /**
     * Sets schemas
     *
     * @param string[] $schemas The list of supported schemas.
     *
     * @return $this
     */
    public function setSchemas($schemas)
    {
        $this->container['schemas'] = $schemas;

        return $this;
    }

    /**
     * Gets documentationUri
     *
     * @return string
     */
    public function getDocumentationUri()
    {
        return $this->container['documentationUri'];
    }

    /**
     * Sets documentationUri
     *
     * @param string $documentationUri The HTTP-addressable URL that points to the service provider's documentation.
     *
     * @return $this
     */
    public function setDocumentationUri($documentationUri)
    {
        $this->container['documentationUri'] = $documentationUri;

        return $this;
    }

    /**
     * Gets patch
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature
     */
    public function getPatch()
    {
        return $this->container['patch'];
    }

    /**
     * Sets patch
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature $patch The \"patch\" configuration options.
     *
     * @return $this
     */
    public function setPatch($patch)
    {
        $this->container['patch'] = $patch;

        return $this;
    }

    /**
     * Gets filter
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigFilterFeature
     */
    public function getFilter()
    {
        return $this->container['filter'];
    }

    /**
     * Sets filter
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigFilterFeature $filter The \"filter\" configuration options.
     *
     * @return $this
     */
    public function setFilter($filter)
    {
        $this->container['filter'] = $filter;

        return $this;
    }

    /**
     * Gets etag
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature
     */
    public function getEtag()
    {
        return $this->container['etag'];
    }

    /**
     * Sets etag
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature $etag The \"etag\" configuration options.
     *
     * @return $this
     */
    public function setEtag($etag)
    {
        $this->container['etag'] = $etag;

        return $this;
    }

    /**
     * Gets sort
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature
     */
    public function getSort()
    {
        return $this->container['sort'];
    }

    /**
     * Sets sort
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature $sort The \"sort\" configuration options.
     *
     * @return $this
     */
    public function setSort($sort)
    {
        $this->container['sort'] = $sort;

        return $this;
    }

    /**
     * Gets bulk
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigBulkFeature
     */
    public function getBulk()
    {
        return $this->container['bulk'];
    }

    /**
     * Sets bulk
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigBulkFeature $bulk The \"bulk\" configuration options.
     *
     * @return $this
     */
    public function setBulk($bulk)
    {
        $this->container['bulk'] = $bulk;

        return $this;
    }

    /**
     * Gets changePassword
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature
     */
    public function getChangePassword()
    {
        return $this->container['changePassword'];
    }

    /**
     * Sets changePassword
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigSimpleFeature $changePassword The \"changePassword\" configuration options.
     *
     * @return $this
     */
    public function setChangePassword($changePassword)
    {
        $this->container['changePassword'] = $changePassword;

        return $this;
    }

    /**
     * Gets authenticationSchemes
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigAuthenticationScheme[]
     */
    public function getAuthenticationSchemes()
    {
        return $this->container['authenticationSchemes'];
    }

    /**
     * Sets authenticationSchemes
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimServiceProviderConfigAuthenticationScheme[] $authenticationSchemes The list of supported authentication schemes.
     *
     * @return $this
     */
    public function setAuthenticationSchemes($authenticationSchemes)
    {
        $this->container['authenticationSchemes'] = $authenticationSchemes;

        return $this;
    }

    /**
     * Gets meta
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimMetadata
     */
    public function getMeta()
    {
        return $this->container['meta'];
    }

    /**
     * Sets meta
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimMetadata $meta Resource SCIM meta
     *
     * @return $this
     */
    public function setMeta($meta)
    {
        $this->container['meta'] = $meta;

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


