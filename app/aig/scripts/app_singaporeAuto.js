function checkRetrieveCampaignAuto(data){
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  console.log("checkRetrieveCampaignAuto:")
  console.log("campaignDetailsFromAPI",campaignDetailsFromAPI)
  if(!id&&(formType==="auto")){
    setTimeout(()=>{
      handleRetrieveAuto(data)
    },2000)
  }
}
async function handleRetrieveAuto(callListData){
  const objectRetrieve = {
    "channelType": "10",
    // "idNo": callListData?.personal_id||callListData?.passport_no,
    // "policyNo": callListData?.udf4
    // "idNo": "E1234567C",
    // "policyNo": 7240001732
    "idNo": "S9499999F",
    "policyNo": 7240001734
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

function populatePlanAuto(productId,planInfo = null) {
  if (!productId) return;

  const url = `../scripts/get_plan.php?product_id=${productId}`;
  document.body.classList.add('loading');

  fetch(url)
      .then(response => response.json())
      .then(data => {
          const planSelect = document.getElementById('planSelect');

          // Debugging
          if (!planSelect) {
              console.error(`No element found with ID: planSelect`);
              return;
          }

          // Clear previous options
          planSelect.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';

          // Handle no plans case
          if (data.length === 0) {
              const option = document.createElement('option');
              option.textContent = 'No plans available';
              option.disabled = true;
              planSelect.appendChild(option);
              return;
          }

          // Populate the dropdown with new options
          data.forEach(plan => {
              const option = document.createElement('option');
              option.value = plan.plan_code; // Use plan_code as value
              option.textContent = `${plan.plan_name} (POI:${plan.plan_poi})`; // Display plan_name
              option.setAttribute('data-desc', plan.plan_name);
              option.setAttribute('data-planpoi', plan.plan_poi);
              planSelect.appendChild(option);
          });
          if (planInfo) {
            console.log("planInfossssssssss:", planInfo)
            const planPoiValue = planInfo.planPoi || ""; 
            
         // Loop through the options in the select dropdown
         for (let i = 0; i < planSelect.options.length; i++) {
          const option = planSelect.options[i];
          
          if (Number(option.getAttribute("data-planpoi")) === Number(planPoiValue)) {
            planSelect.selectedIndex = i;
            console.log("planSelectchoose:", planSelect)
            break;
          }
        }
          
            // Also set the planPoiSelect input field with the same value
            document.getElementById("planPoiSelect").value = planPoiValue;
          }
      })
      .catch(error => console.error('Error fetching plans:', error))
      .finally(() => {
          document.body.classList.remove('loading');
      });
}
// function populateCoverAuto(productId,planInfo = null) {
//   if (!productId) return;

//   const url = `../scripts/get_cover.php?product_id=${productId}`;
//   document.body.classList.add('loading');

//   fetch(url)
//       .then(response => response.json())
//       .then(data => {
//           const plan_cover_list_ = document.getElementById('plan_cover_list');

//           // Debugging
//           if (!plan_cover_list_) {
//               console.error(`No element found with ID: plan_cover_list`);
//               return;
//           }

//           // Clear previous options
//           plan_cover_list_.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';

//           // Handle no plans case
//           if (data.length === 0) {
//               const option = document.createElement('option');
//               option.textContent = 'No covers available';
//               option.disabled = true;
//               plan_cover_list_.appendChild(option);
//               return;
//           }

//           // Populate the dropdown with new options
//           data.forEach(cover => {
//               const option = document.createElement('option');
//               option.value = cover.cover_id;
//               option.textContent = cover.cover_name;
//               option.setAttribute('data-cover-code', cover.cover_code);
//               option.setAttribute('data-cover-name', cover.cover_name);
//               plan_cover_list_.appendChild(option);


//           });
//           // if (planInfo) {
//           //     const coverSelect = section.querySelector('[name^="plan_cover_list_1[]"]');

//           //     if (coverSelect && planInfo.coverList && planInfo.coverList.length > 0 && planInfo.coverList[0]?.id) {
//           //         coverSelect.value = planInfo.coverList[0].id; // Pre-select the cover
//           //     } else {
//           //         console.log("Cover list or cover select element is missing or invalid.");
//           //     }
//           // }

//       })
//       .catch(error => console.error('Error fetching plans:', error))
//       .finally(() => {
//           document.body.classList.remove('loading');
//       });
// }

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