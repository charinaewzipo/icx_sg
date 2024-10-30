function checkRetrieveCampaignAuto(data){
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  console.log("checkRetrieveCampaignAuto:")
  console.log("campaignDetailsFromAPI",campaignDetailsFromAPI)
  if(!id&&(formType==="auto")){
    setTimeout(()=>{
      // handleRetrieveAuto(data)
    },2000)
  }
}

async function handleRetrieveAuto(callListData){
  const objectRetrieve = {
    "channelType": "10",
    // "idNo": callListData?.personal_id||callListData?.passport_no,
    // "policyNo": callListData?.udf4
//error
    "idNo": "S9499999F",
    "policyNo": 724000174122222222222
    //success

    // "idNo": "S9499999F",
    // "policyNo": 7240001742
  };
  const responseRetrieve = await fetchRetrieveQuote(objectRetrieve);
  console.log("responseRetrieve:", responseRetrieve);
  if (!responseRetrieve) {
    alert("Quote Retrieval List Operation failed");
    setTimeout(()=>{
      window.close(); 
    },2000)
    return;
  }

  const { statusCode, quoteList, statusMessage } = responseRetrieve;
  alert(statusMessage);
  if (statusCode !== "P00") {
    //policy issuance
    // setTimeout(()=>{
    //   window.close(); 
    // },2000)
    return
  }
  if(quoteList&&quoteList.length>0){
    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);
   
    await getProductDetail(data?.productId);
    let transformedData = transformQuoteData(data, quotationData);
    console.log("transformedData", transformedData);
    const responseId =await jQuery.agent.insertRetrieveQuote(data, transformedData,campaignDetails,objectRetrieve);
    let currentUrl = window.location.href;
    const url = new URL(currentUrl);
    if (url.searchParams.has('id')) {
      url.searchParams.set('id', responseId);
    } else {
      url.searchParams.append('id', responseId);
    }
    if (url.searchParams.has('is_firsttime')) {
      url.searchParams.set('is_firsttime', '1');
    } else {
      url.searchParams.append('is_firsttime', '1');
    }
    window.location.href = url.toString();
  }else{
    alert("The quoteList has no data")
    // setTimeout(()=>{
    //   window.close(); 
    // },2000)

  }
  
}

function populatePlanAutoPremium(planList) {
  const planSelect = document.getElementById('planSelect');
  const planPoiSelect = document.getElementById('planPoiSelect');
  const premiumAmountInput = document.getElementById('premium-amount');

  planSelect.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';

  for (const key in planList) {
      if (planList.hasOwnProperty(key)) {
          const plan = planList[key];
          const option = document.createElement('option');
          option.value = plan.planId; 
          option.textContent = `${plan.planDescription} (${plan?.planPoi})`;
          option.dataset.planPoi = plan.planPoi; 
          option.dataset.netPremium = plan.netPremium; 
          planSelect.appendChild(option);
      }
  }

  // Update planPoiSelect when an option is selected
  planSelect.addEventListener('change', function() {
    const selectedOption = planSelect.options[planSelect.selectedIndex];
    const planPoi = selectedOption.dataset.planPoi || ''; // Use empty string if undefined
    const premiumAmount = selectedOption.dataset.netPremium || ''; // Use empty string if undefined
    planPoiSelect.value = planPoi;
    premiumAmountInput.value = premiumAmount ? `${premiumAmount}(SGD)` : ''; // Update or clear the input
});
}

const handleKeepChangeButton = () => {
  const userConfirmed = window.confirm("Are you sure you want to proceed with recalculation?");
  
  if (userConfirmed) {
    if (window.opener && !window.opener.closed) {
      window.alert("Fetching Recalculate...");
      window.close();
      window.opener.showAlert('Fetch Recalculate successfully!');
    }
  }
}
const handleCloseButton=()=>{ window.close()}

function validateCustomerIdNumberAuto() {
  const idTypeSelect = document.querySelector(`select[name="insured_auto_driverInfo_driverIdType"]`);
  const idNumberInput = document.querySelector(`input[name="insured_auto_driverInfo_driverIdNumber"]`);

  if (!idTypeSelect || !idNumberInput) return; // Ensure the elements exist

  const idType = idTypeSelect.value;
  const idNumber = idNumberInput.value;

  // Regular expression for the pattern: letter-7 digits-letter
  const idPattern = /^[A-Za-z]\d{7}[A-Za-z]$/;

  if (idType === '9' || idType === '10' || idType === '6') { // NRIC, FIN, or Birth Certificate
    if (!idPattern.test(idNumber)) {
      idNumberInput.setCustomValidity("Invalid format. ID should be in the format: letter-7 digits-letter.");
    } else {
      idNumberInput.setCustomValidity("");
    }
  } else {
    idNumberInput.setCustomValidity("");
  }
  idNumberInput.reportValidity();
}

// Attach event listeners for customer's ID
function attachCustomerIdValidationAuto() {
  const idTypeSelect = document.querySelector(`select[name="insured_auto_driverInfo_driverIdType"]`);
  const idNumberInput = document.querySelector(`input[name="insured_auto_driverInfo_driverIdNumber"]`);

  if (idTypeSelect && idNumberInput) {
    idTypeSelect.addEventListener('change', validateCustomerIdNumberAuto);
    idNumberInput.addEventListener('input', validateCustomerIdNumberAuto);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  if(formType==="auto"){
    attachCustomerIdValidationAuto()
  }
})