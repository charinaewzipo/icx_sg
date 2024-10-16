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
  if (statusCode === "N18"||"N15"||"N16") {
    //policy issuance
    setTimeout(()=>{
      window.close(); 
    },2000)
    return
}
  if(quoteList&&quoteList.length>0){
    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);
   
    await getProductDetail(data?.productId);
    const transformedData = transformQuoteData(data, quotationData);
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
  }
  
}
async function fetchGetDwelling(productId) {
  if (!productId) return;

  let checkPlan = null;
  // Determine dwelling type based on productId
  if (Number(productId) === 600000060) {
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
async function fetchGetFlatType(dwellingId) {
  if (!dwellingId) return;

  let filterValue=null
  if(Number(dwellingId)===1||Number(dwellingId)===2||Number(dwellingId)===3||Number(dwellingId)===4||Number(dwellingId)===5){
    filterValue='Flat Type'
  }else{

    filterValue='Flat Typessss'
  }

  const url = `../scripts/get_dwelling.php?name=${filterValue}`;
  document.body.classList.add('loading');

  try {
    // Await the fetch response
    const response = await fetch(url);
    const data = await response.json();
    console.log("data:", data)

    // Ensure the select element exists
    const flatTypeSelect = document.querySelector('select[name="insured_home_flatType"]');
    if (!flatTypeSelect) {
      console.error("Dropdown not found!");
      return;
    }

    // Clear existing options
    flatTypeSelect.innerHTML = `
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
        flatTypeSelect.appendChild(option);
      });
    }else {
      // Display a message when no data is available
      const option = document.createElement('option');
      option.value = "";
      option.textContent = "No options available";
      flatTypeSelect.appendChild(option);
      flatTypeSelect.required = false;
    }
  } catch (error) {
    console.error('Error fetching plans:', error);
  } finally {
    document.body.classList.remove('loading');
  }
}
const handleClearPromoCode=(planPoi)=>{
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  let formType = urlParams.get("formType");
  if(formType==="home" && Number(planPoi)===12){
    console.log("changepromocode")
   document.getElementById("promocode-input").value="";
  }else{
    const promoInput=document.getElementById("promocode-input")
    console.log("calllistDetail:", calllistDetail)
    console.log("campaignDetailsFromAPI:", productDetail)
    if (promoInput && calllistDetail && productDetail?.udf_field_promo_code) {
      const promoCodeField = productDetail.udf_field_promo_code;
      console.log("promoCodeField:", promoCodeField)
      promoInput.value = calllistDetail[promoCodeField] || "";
  } else {
      promoInput.value = "";
  }
  }
}

document.addEventListener('DOMContentLoaded', () => {

  document.querySelector('select[name="insured_home_dwellingType"]').addEventListener('change', (event) => {
    const selectedValue = event.target.value;  
    console.log("Selected value:", selectedValue);
    fetchGetFlatType(selectedValue)
  });

});

