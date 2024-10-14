function checkRenewCampaign(data){
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let campaign_id = url.searchParams.get('campaign_id');
  console.log("checkRenewCampaign:")
  if(!id&&(campaign_id==="9"||campaign_id==="10")){
    setTimeout(()=>{
      renewRetrieve(data)
    },2000)
  }
}
async function renewRetrieve(callListData){
  const objectRetrieve = {
    "channelType": "10",
    "idNo": callListData?.personal_id||callListData?.passport_no,
    "policyNo": callListData?.udf4
  };
  const responseRetrieve = await fetchRetrieveQuote(objectRetrieve);
  console.log("responseRetrieve:", responseRetrieve);
  if (!responseRetrieve) {
    alert("Quote Retrieval List Operation failed");
    return;
  }

  const { statusCode, quoteList, statusMessage } = responseRetrieve;
  if (statusCode !== "P00") {
    alert(statusMessage);
    return;
  }
  if(quoteList.length>0){
    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);
    const transformedData = transformQuoteData(data, quotationData);
    console.log("transformedData", transformedData);
    const responseId =await jQuery.agent.insertRetrieveQuote(data, transformedData,campaignDetails);
    let currentUrl = window.location.href;
    const url = new URL(currentUrl);
    if (url.searchParams.has('id')) {
      url.searchParams.set('id', responseId);
    } else {
      url.searchParams.append('id', responseId);
    }
    window.location.href = url.toString();
  }else{
    alert("The quoteList has no data")
  }
  
}

