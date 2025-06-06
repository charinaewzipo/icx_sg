<?php
/**
 * OAuthClient
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
 * OAuthClient Class Doc Comment
 *
 * @category Class
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class OAuthClient implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'OAuthClient';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'name' => 'string',
        'accessTokenValiditySeconds' => 'int',
        'description' => 'string',
        'registeredRedirectUri' => 'string[]',
        'secret' => 'string',
        'roleIds' => 'string[]',
        'dateCreated' => '\DateTime',
        'dateModified' => '\DateTime',
        'createdBy' => '\PureCloudPlatform\Client\V2\Model\DomainEntityRef',
        'modifiedBy' => '\PureCloudPlatform\Client\V2\Model\DomainEntityRef',
        'authorizedGrantType' => 'string',
        'scope' => 'string[]',
        'roleDivisions' => '\PureCloudPlatform\Client\V2\Model\RoleDivision[]',
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
        'accessTokenValiditySeconds' => 'int64',
        'description' => null,
        'registeredRedirectUri' => 'uri',
        'secret' => null,
        'roleIds' => null,
        'dateCreated' => 'date-time',
        'dateModified' => 'date-time',
        'createdBy' => null,
        'modifiedBy' => null,
        'authorizedGrantType' => null,
        'scope' => null,
        'roleDivisions' => null,
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
        'accessTokenValiditySeconds' => 'accessTokenValiditySeconds',
        'description' => 'description',
        'registeredRedirectUri' => 'registeredRedirectUri',
        'secret' => 'secret',
        'roleIds' => 'roleIds',
        'dateCreated' => 'dateCreated',
        'dateModified' => 'dateModified',
        'createdBy' => 'createdBy',
        'modifiedBy' => 'modifiedBy',
        'authorizedGrantType' => 'authorizedGrantType',
        'scope' => 'scope',
        'roleDivisions' => 'roleDivisions',
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
        'accessTokenValiditySeconds' => 'setAccessTokenValiditySeconds',
        'description' => 'setDescription',
        'registeredRedirectUri' => 'setRegisteredRedirectUri',
        'secret' => 'setSecret',
        'roleIds' => 'setRoleIds',
        'dateCreated' => 'setDateCreated',
        'dateModified' => 'setDateModified',
        'createdBy' => 'setCreatedBy',
        'modifiedBy' => 'setModifiedBy',
        'authorizedGrantType' => 'setAuthorizedGrantType',
        'scope' => 'setScope',
        'roleDivisions' => 'setRoleDivisions',
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
        'accessTokenValiditySeconds' => 'getAccessTokenValiditySeconds',
        'description' => 'getDescription',
        'registeredRedirectUri' => 'getRegisteredRedirectUri',
        'secret' => 'getSecret',
        'roleIds' => 'getRoleIds',
        'dateCreated' => 'getDateCreated',
        'dateModified' => 'getDateModified',
        'createdBy' => 'getCreatedBy',
        'modifiedBy' => 'getModifiedBy',
        'authorizedGrantType' => 'getAuthorizedGrantType',
        'scope' => 'getScope',
        'roleDivisions' => 'getRoleDivisions',
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

    const AUTHORIZED_GRANT_TYPE_CODE = 'CODE';
    const AUTHORIZED_GRANT_TYPE_TOKEN = 'TOKEN';
    const AUTHORIZED_GRANT_TYPE_SAML2_BEARER = 'SAML2BEARER';
    const AUTHORIZED_GRANT_TYPE_PASSWORD = 'PASSWORD';
    const AUTHORIZED_GRANT_TYPE_CLIENT_CREDENTIALS = 'CLIENT_CREDENTIALS';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getAuthorizedGrantTypeAllowableValues()
    {
        return [
            self::AUTHORIZED_GRANT_TYPE_CODE,
            self::AUTHORIZED_GRANT_TYPE_TOKEN,
            self::AUTHORIZED_GRANT_TYPE_SAML2_BEARER,
            self::AUTHORIZED_GRANT_TYPE_PASSWORD,
            self::AUTHORIZED_GRANT_TYPE_CLIENT_CREDENTIALS,
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
        $this->container['accessTokenValiditySeconds'] = isset($data['accessTokenValiditySeconds']) ? $data['accessTokenValiditySeconds'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['registeredRedirectUri'] = isset($data['registeredRedirectUri']) ? $data['registeredRedirectUri'] : null;
        $this->container['secret'] = isset($data['secret']) ? $data['secret'] : null;
        $this->container['roleIds'] = isset($data['roleIds']) ? $data['roleIds'] : null;
        $this->container['dateCreated'] = isset($data['dateCreated']) ? $data['dateCreated'] : null;
        $this->container['dateModified'] = isset($data['dateModified']) ? $data['dateModified'] : null;
        $this->container['createdBy'] = isset($data['createdBy']) ? $data['createdBy'] : null;
        $this->container['modifiedBy'] = isset($data['modifiedBy']) ? $data['modifiedBy'] : null;
        $this->container['authorizedGrantType'] = isset($data['authorizedGrantType']) ? $data['authorizedGrantType'] : null;
        $this->container['scope'] = isset($data['scope']) ? $data['scope'] : null;
        $this->container['roleDivisions'] = isset($data['roleDivisions']) ? $data['roleDivisions'] : null;
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

        if ($this->container['name'] === null) {
            $invalidProperties[] = "'name' can't be null";
        }
        if ($this->container['authorizedGrantType'] === null) {
            $invalidProperties[] = "'authorizedGrantType' can't be null";
        }
        $allowedValues = $this->getAuthorizedGrantTypeAllowableValues();
        if (!is_null($this->container['authorizedGrantType']) && !in_array($this->container['authorizedGrantType'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'authorizedGrantType', must be one of '%s'",
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
     * @param string $name The name of the OAuth client.
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets accessTokenValiditySeconds
     *
     * @return int
     */
    public function getAccessTokenValiditySeconds()
    {
        return $this->container['accessTokenValiditySeconds'];
    }

    /**
     * Sets accessTokenValiditySeconds
     *
     * @param int $accessTokenValiditySeconds The number of seconds, between 5mins and 48hrs, until tokens created with this client expire. If this field is omitted, a default of 24 hours will be applied.
     *
     * @return $this
     */
    public function setAccessTokenValiditySeconds($accessTokenValiditySeconds)
    {
        $this->container['accessTokenValiditySeconds'] = $accessTokenValiditySeconds;

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
     * Gets registeredRedirectUri
     *
     * @return string[]
     */
    public function getRegisteredRedirectUri()
    {
        return $this->container['registeredRedirectUri'];
    }

    /**
     * Sets registeredRedirectUri
     *
     * @param string[] $registeredRedirectUri List of allowed callbacks for this client. For example: https://myap.example.com/auth/callback
     *
     * @return $this
     */
    public function setRegisteredRedirectUri($registeredRedirectUri)
    {
        $this->container['registeredRedirectUri'] = $registeredRedirectUri;

        return $this;
    }

    /**
     * Gets secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->container['secret'];
    }

    /**
     * Sets secret
     *
     * @param string $secret System created secret assigned to this client. Secrets are required for code authorization and client credential grants.
     *
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->container['secret'] = $secret;

        return $this;
    }

    /**
     * Gets roleIds
     *
     * @return string[]
     */
    public function getRoleIds()
    {
        return $this->container['roleIds'];
    }

    /**
     * Sets roleIds
     *
     * @param string[] $roleIds Deprecated. Use roleDivisions instead.
     *
     * @return $this
     */
    public function setRoleIds($roleIds)
    {
        $this->container['roleIds'] = $roleIds;

        return $this;
    }

    /**
     * Gets dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->container['dateCreated'];
    }

    /**
     * Sets dateCreated
     *
     * @param \DateTime $dateCreated Date this client was created. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setDateCreated($dateCreated)
    {
        $this->container['dateCreated'] = $dateCreated;

        return $this;
    }

    /**
     * Gets dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->container['dateModified'];
    }

    /**
     * Sets dateModified
     *
     * @param \DateTime $dateModified Date this client was last modified. Date time is represented as an ISO-8601 string. For example: yyyy-MM-ddTHH:mm:ss.SSSZ
     *
     * @return $this
     */
    public function setDateModified($dateModified)
    {
        $this->container['dateModified'] = $dateModified;

        return $this;
    }

    /**
     * Gets createdBy
     *
     * @return \PureCloudPlatform\Client\V2\Model\DomainEntityRef
     */
    public function getCreatedBy()
    {
        return $this->container['createdBy'];
    }

    /**
     * Sets createdBy
     *
     * @param \PureCloudPlatform\Client\V2\Model\DomainEntityRef $createdBy User that created this client
     *
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->container['createdBy'] = $createdBy;

        return $this;
    }

    /**
     * Gets modifiedBy
     *
     * @return \PureCloudPlatform\Client\V2\Model\DomainEntityRef
     */
    public function getModifiedBy()
    {
        return $this->container['modifiedBy'];
    }

    /**
     * Sets modifiedBy
     *
     * @param \PureCloudPlatform\Client\V2\Model\DomainEntityRef $modifiedBy User that last modified this client
     *
     * @return $this
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->container['modifiedBy'] = $modifiedBy;

        return $this;
    }

    /**
     * Gets authorizedGrantType
     *
     * @return string
     */
    public function getAuthorizedGrantType()
    {
        return $this->container['authorizedGrantType'];
    }

    /**
     * Sets authorizedGrantType
     *
     * @param string $authorizedGrantType The OAuth Grant/Client type supported by this client. Code Authorization Grant/Client type - Preferred client type where the Client ID and Secret are required to create tokens. Used where the secret can be secured. Implicit grant type - Client ID only is required to create tokens. Used in browser and mobile apps where the secret can not be secured. SAML2-Bearer extension grant type - SAML2 assertion provider for user authentication at the token endpoint. Client Credential grant type - Used to created access tokens that are tied only to the client.
     *
     * @return $this
     */
    public function setAuthorizedGrantType($authorizedGrantType)
    {
        $allowedValues = $this->getAuthorizedGrantTypeAllowableValues();
        if (!in_array($authorizedGrantType, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'authorizedGrantType', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['authorizedGrantType'] = $authorizedGrantType;

        return $this;
    }

    /**
     * Gets scope
     *
     * @return string[]
     */
    public function getScope()
    {
        return $this->container['scope'];
    }

    /**
     * Sets scope
     *
     * @param string[] $scope The scope requested by this client. Scopes only apply to clients not using the client_credential grant
     *
     * @return $this
     */
    public function setScope($scope)
    {
        $this->container['scope'] = $scope;

        return $this;
    }

    /**
     * Gets roleDivisions
     *
     * @return \PureCloudPlatform\Client\V2\Model\RoleDivision[]
     */
    public function getRoleDivisions()
    {
        return $this->container['roleDivisions'];
    }

    /**
     * Sets roleDivisions
     *
     * @param \PureCloudPlatform\Client\V2\Model\RoleDivision[] $roleDivisions Set of roles and their corresponding divisions associated with this client. Roles and divisions only apply to clients using the client_credential grant
     *
     * @return $this
     */
    public function setRoleDivisions($roleDivisions)
    {
        $this->container['roleDivisions'] = $roleDivisions;

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


