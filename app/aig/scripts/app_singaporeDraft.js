// let draftid = null;
let isEditing = false;

document.addEventListener("DOMContentLoaded", function () {
  if (id) {
    document.getElementById("btnSaveDraftForm").style.display = "block";
    document.getElementById("btnDraftForm").style.display = "none";
    // jQuery.agent
    //   .getDraftDataWithId(id)
    //   .then((response) => {
    //     console.log("response", response)
    //     if (response?.result == "success") {
    //       setDefaultValueForm(response?.data);
    //     }
    //   })
    //   .catch((error) => {
    //     console.error("Error occurred:", error);
    //   });


  }


})
const handleClickDraftButton = async () => {
  console.log("handleClickDraft");
  const requestBody = handleForm();
  try {
    const responseId = await jQuery.agent.insertQuotationData(requestBody, null, campaignDetails);
    let currentUrl = window.location.href;
    const url = new URL(currentUrl); 
    
    if (url.searchParams.has('id')) {
    
      url.searchParams.set('id', responseId);
    } else {
    
      url.searchParams.append('id', responseId);
    }
    
    window.location.href = url.toString(); 
  } catch (error) {
    console.error("Error while inserting quotation:", error);
  }
};


const handleClickSaveDraftButton = () => {
  console.log("handleClickSaveDraft")
  const requestBody = handleForm();
  jQuery.agent.updateQuoteData(requestBody, null, id,campaignDetails);
}
const handleEditQuote = () => {
  const btnEditForm = document.getElementById('btnEditForm');
  console.log("Edit")
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let campaign_id = url.searchParams.get('campaign_id');
  let formType = url.searchParams.get('formType');
  let id = url.searchParams.get('id');
  
 
  
  if (!isEditing) {
    event.preventDefault();
    let formElements=null;
    if(campaignDetailsFromAPI?.incident_type==="Renewal" &&quotationData?.type==="home"){
       formElements = document.querySelectorAll(
        "input:not([name='PolicyEffectiveDate']):not([name='firstName']):not([name='dateOfBirth']):not([name='customerIdNo']), " + 
        "select:not(#planPoiSelect1):not(#select-product):not([name='gender']):not([name='residentStatus']):not([name='customerIdType']), " + 
        "textarea, " + 
        "button:not(#btnSaveForm)"
      );
    }else if(quotationData?.type==="home"){
      formElements = document.querySelectorAll("input, select:not(#planPoiSelect1):not(#select-product),textarea, button:not(#btnSaveForm)");
    }else if(quotationData?.type==="auto"){
      formElements = document.querySelectorAll("input, select:not(#planPoiSelect1):not(#select-product):not([name='Ncd_Level_gears']):not([name='automaticRenewalFlag']):not([name='insured_auto_vehicle_vehicleUsage']),button:not(#btnSaveForm),textarea");
    }
    else{
      formElements = document.querySelectorAll("input, select:not(#planPoiSelect1),textarea, button:not(#btnSaveForm)");
    }
   
    

    
    unhideFormData(formElements);

    btnEditForm.textContent = "Save"
    document.getElementById("btnPayment").disabled=true;
    document.getElementById("btnPayment").style.opacity="0.65";
    btnEditForm.hidden=false
    isEditing = true;

    if(formType==="auto"){
      document.getElementById("premium-amount-label").hidden=false;
      document.getElementById("premium-amount-withgst-label").hidden=false;
      document.getElementById("payment_amount_label").hidden=true;

    }
  } else {
    // if(formType==="auto"&&campaignDetailsFromAPI?.incident_type==="Renewal" ){
    //    event.preventDefault();
    //    handleValidateForm()
    //    window.alert("Fetch Recalculate Quote")
    //    console.log("campaignDetails",campaignDetails)
    //    const url = `singaporeAutoRecalculatePage.php?campaign_id=${campaignDetails?.campaign_id}&calllist_id=${campaignDetails?.calllist_id}&agent_id=${campaignDetails?.agent_id}&import_id=${campaignDetails?.import_id}&formType=${formType}&id=${id}`;

    //    // Open a new window for payment
    //    window.open(url, 'childWindow', 'width=1024,height=768');
   
    // }
    
  }
}