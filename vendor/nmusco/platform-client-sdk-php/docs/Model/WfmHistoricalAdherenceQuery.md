# WfmHistoricalAdherenceQuery

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**startDate** | [**\DateTime**](\DateTime.md) | Beginning of the date range to query in ISO-8601 format | 
**endDate** | [**\DateTime**](\DateTime.md) | End of the date range to query in ISO-8601 format. If it is not set, end date will be set to current time | [optional] 
**timeZone** | **string** | The time zone to use for returned results in olson format. If it is not set, the management unit time zone will be used to compute adherence | [optional] 
**userIds** | **string[]** | The userIds to report on. If null or not set, adherence will be computed for all the users in management unit | [optional] 
**includeExceptions** | **bool** | Whether user exceptions should be returned as part of the results | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


