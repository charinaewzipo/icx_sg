async function logApiCall(endpoint, requestPayload, responsePayload, statusCode, errorMessage = null, executionTime = null, calllist_id = null,agent_id=null,import_id=null) {
  const logApiUrl = '../Application/logAPICall.php';
  const logPayload = {
    action: 'insertLogApiCall',
    endpoint: endpoint,
    requestPayload: requestPayload,
    responsePayload: responsePayload,
    statusCode: statusCode,
    errorMessage: errorMessage,
    executionTime: executionTime,
    calllist_id: calllist_id,
    agent_id:agent_id,
    import_id:import_id
  };

  try {
    await fetch(logApiUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(logPayload),
    });
  } catch (error) {
    console.error('Failed to log API call:', error);
  }
}
