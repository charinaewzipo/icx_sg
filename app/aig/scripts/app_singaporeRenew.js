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
  alert(statusMessage);
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
async function fetchGetDwelling(productId) {
  if (!productId) return;

  let checkPlan = null;
  // Determine dwelling type based on productId
  if (productId === 600000060) {
    checkPlan = "HE Dwelling Type";
  } else {
    checkPlan = "Dwelling Type";
  }

  console.log("checkPlan:", checkPlan);

  const url = `../scripts/get_dwelling.php?name=${checkPlan}`;
  document.body.classList.add('loading');

  try {
    // Await the fetch response
    const response = await fetch(url);
    const data = await response.json();

    // Ensure the select element exists
    const dwellingSelect = document.querySelector('select[name="insured_home_dwellingType"]');
    if (!dwellingSelect) {
      console.error("Dropdown not found!");
      return;
    }

    // Clear existing options
    dwellingSelect.innerHTML = `
      <option value="">
        <-- Please select an option -->
      </option>
    `;

    // Populate new options from the fetched data
    if (data && Array.isArray(data)) {
      data.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.description;
        dwellingSelect.appendChild(option);
      });
    }
  } catch (error) {
    console.error('Error fetching plans:', error);
  } finally {
    document.body.classList.remove('loading');
  }
}


