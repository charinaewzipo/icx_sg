<?php
/**
 * ScimV2CreateUser
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
 * ScimV2CreateUser Class Doc Comment
 *
 * @category Class
 * @description Represents a SCIM V2 Create User
 * @package  PureCloudPlatform\Client\V2
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ScimV2CreateUser implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ScimV2CreateUser';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'schemas' => 'string[]',
        'active' => 'bool',
        'userName' => 'string',
        'displayName' => 'string',
        'password' => 'string',
        'title' => 'string',
        'phoneNumbers' => '\PureCloudPlatform\Client\V2\Model\ScimPhoneNumber[]',
        'emails' => '\PureCloudPlatform\Client\V2\Model\ScimEmail[]',
        'photos' => '\PureCloudPlatform\Client\V2\Model\Photo[]',
        'externalId' => 'string',
        'groups' => '\PureCloudPlatform\Client\V2\Model\ScimV2GroupReference[]',
        'roles' => 'string[]',
        'urnietfparamsscimschemasextensionenterprise20User' => '\PureCloudPlatform\Client\V2\Model\ScimV2EnterpriseUser'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'schemas' => null,
        'active' => null,
        'userName' => null,
        'displayName' => null,
        'password' => null,
        'title' => null,
        'phoneNumbers' => null,
        'emails' => null,
        'photos' => null,
        'externalId' => null,
        'groups' => null,
        'roles' => null,
        'urnietfparamsscimschemasextensionenterprise20User' => null
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
        'active' => 'active',
        'userName' => 'userName',
        'displayName' => 'displayName',
        'password' => 'password',
        'title' => 'title',
        'phoneNumbers' => 'phoneNumbers',
        'emails' => 'emails',
        'photos' => 'photos',
        'externalId' => 'externalId',
        'groups' => 'groups',
        'roles' => 'roles',
        'urnietfparamsscimschemasextensionenterprise20User' => 'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'schemas' => 'setSchemas',
        'active' => 'setActive',
        'userName' => 'setUserName',
        'displayName' => 'setDisplayName',
        'password' => 'setPassword',
        'title' => 'setTitle',
        'phoneNumbers' => 'setPhoneNumbers',
        'emails' => 'setEmails',
        'photos' => 'setPhotos',
        'externalId' => 'setExternalId',
        'groups' => 'setGroups',
        'roles' => 'setRoles',
        'urnietfparamsscimschemasextensionenterprise20User' => 'setUrnietfparamsscimschemasextensionenterprise20User'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'schemas' => 'getSchemas',
        'active' => 'getActive',
        'userName' => 'getUserName',
        'displayName' => 'getDisplayName',
        'password' => 'getPassword',
        'title' => 'getTitle',
        'phoneNumbers' => 'getPhoneNumbers',
        'emails' => 'getEmails',
        'photos' => 'getPhotos',
        'externalId' => 'getExternalId',
        'groups' => 'getGroups',
        'roles' => 'getRoles',
        'urnietfparamsscimschemasextensionenterprise20User' => 'getUrnietfparamsscimschemasextensionenterprise20User'
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
        $this->container['active'] = isset($data['active']) ? $data['active'] : null;
        $this->container['userName'] = isset($data['userName']) ? $data['userName'] : null;
        $this->container['displayName'] = isset($data['displayName']) ? $data['displayName'] : null;
        $this->container['password'] = isset($data['password']) ? $data['password'] : null;
        $this->container['title'] = isset($data['title']) ? $data['title'] : null;
        $this->container['phoneNumbers'] = isset($data['phoneNumbers']) ? $data['phoneNumbers'] : null;
        $this->container['emails'] = isset($data['emails']) ? $data['emails'] : null;
        $this->container['photos'] = isset($data['photos']) ? $data['photos'] : null;
        $this->container['externalId'] = isset($data['externalId']) ? $data['externalId'] : null;
        $this->container['groups'] = isset($data['groups']) ? $data['groups'] : null;
        $this->container['roles'] = isset($data['roles']) ? $data['roles'] : null;
        $this->container['urnietfparamsscimschemasextensionenterprise20User'] = isset($data['urnietfparamsscimschemasextensionenterprise20User']) ? $data['urnietfparamsscimschemasextensionenterprise20User'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['userName'] === null) {
            $invalidProperties[] = "'userName' can't be null";
        }
        if ($this->container['displayName'] === null) {
            $invalidProperties[] = "'displayName' can't be null";
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
     * Gets active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->container['active'];
    }

    /**
     * Sets active
     *
     * @param bool $active Indicates whether the user's administrative status is active.
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->container['active'] = $active;

        return $this;
    }

    /**
     * Gets userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->container['userName'];
    }

    /**
     * Sets userName
     *
     * @param string $userName The user's PureCloud email address. Must be unique.
     *
     * @return $this
     */
    public function setUserName($userName)
    {
        $this->container['userName'] = $userName;

        return $this;
    }

    /**
     * Gets displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->container['displayName'];
    }

    /**
     * Sets displayName
     *
     * @param string $displayName The display name of the user.
     *
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->container['displayName'] = $displayName;

        return $this;
    }

    /**
     * Gets password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->container['password'];
    }

    /**
     * Sets password
     *
     * @param string $password The new password for the PureCloud user. Does not return an existing password.
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->container['password'] = $password;

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
     * @param string $title The user's title.
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->container['title'] = $title;

        return $this;
    }

    /**
     * Gets phoneNumbers
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimPhoneNumber[]
     */
    public function getPhoneNumbers()
    {
        return $this->container['phoneNumbers'];
    }

    /**
     * Sets phoneNumbers
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimPhoneNumber[] $phoneNumbers The list of the user's phone numbers.
     *
     * @return $this
     */
    public function setPhoneNumbers($phoneNumbers)
    {
        $this->container['phoneNumbers'] = $phoneNumbers;

        return $this;
    }

    /**
     * Gets emails
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimEmail[]
     */
    public function getEmails()
    {
        return $this->container['emails'];
    }

    /**
     * Sets emails
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimEmail[] $emails The list of the user's email addresses.
     *
     * @return $this
     */
    public function setEmails($emails)
    {
        $this->container['emails'] = $emails;

        return $this;
    }

    /**
     * Gets photos
     *
     * @return \PureCloudPlatform\Client\V2\Model\Photo[]
     */
    public function getPhotos()
    {
        return $this->container['photos'];
    }

    /**
     * Sets photos
     *
     * @param \PureCloudPlatform\Client\V2\Model\Photo[] $photos The list of the user's photos.
     *
     * @return $this
     */
    public function setPhotos($photos)
    {
        $this->container['photos'] = $photos;

        return $this;
    }

    /**
     * Gets externalId
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->container['externalId'];
    }

    /**
     * Sets externalId
     *
     * @param string $externalId The external ID of the user. Set by the provisioning client. \"caseExact\" is set to \"true\". \"mutability\" is set to \"readWrite\".
     *
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->container['externalId'] = $externalId;

        return $this;
    }

    /**
     * Gets groups
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimV2GroupReference[]
     */
    public function getGroups()
    {
        return $this->container['groups'];
    }

    /**
     * Sets groups
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimV2GroupReference[] $groups The list of groups that the user is a member of.
     *
     * @return $this
     */
    public function setGroups($groups)
    {
        $this->container['groups'] = $groups;

        return $this;
    }

    /**
     * Gets roles
     *
     * @return string[]
     */
    public function getRoles()
    {
        return $this->container['roles'];
    }

    /**
     * Sets roles
     *
     * @param string[] $roles The list of roles assigned to the user.
     *
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->container['roles'] = $roles;

        return $this;
    }

    /**
     * Gets urnietfparamsscimschemasextensionenterprise20User
     *
     * @return \PureCloudPlatform\Client\V2\Model\ScimV2EnterpriseUser
     */
    public function getUrnietfparamsscimschemasextensionenterprise20User()
    {
        return $this->container['urnietfparamsscimschemasextensionenterprise20User'];
    }

    /**
     * Sets urnietfparamsscimschemasextensionenterprise20User
     *
     * @param \PureCloudPlatform\Client\V2\Model\ScimV2EnterpriseUser $urnietfparamsscimschemasextensionenterprise20User SCIM enterprise user attributes
     *
     * @return $this
     */
    public function setUrnietfparamsscimschemasextensionenterprise20User($urnietfparamsscimschemasextensionenterprise20User)
    {
        $this->container['urnietfparamsscimschemasextensionenterprise20User'] = $urnietfparamsscimschemasextensionenterprise20User;

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


