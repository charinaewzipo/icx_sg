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
  //กรณียังไม่มีid
  console.log("handleClickDraft");
  const requestBody = handleForm();

  try {
    let responseId = null;
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    const formType = url.searchParams.get("formType");

    if (formType === "auto") {
      const updateRequestData = {
        ...requestBody,
        insuredList:
          Array.isArray(requestBody.insuredList) && requestBody.insuredList.length > 0
            ? requestBody.insuredList.map((insured) => {
                return {
                  ...insured,
                  planInfo: {
                    ...insured.planInfo,
                    coverList:
                      insured?.planInfo?.coverList?.length > 0
                        ? insured.planInfo.coverList.map((cover) =>
                            Number(cover.id) === 600000162
                              ? { ...cover, selectedFlag: false }
                              : cover
                          )
                        : [], // Fallback to an empty array
                  },
                };
              })
            : [], // Fallback if insuredList is empty or not an array
      };

      console.log("updateRequestData:", updateRequestData);
      responseId = await jQuery.agent.insertQuotationData(
        updateRequestData,
        null,
        campaignDetails,
        premiumCalculationData
      );
    } else {
      responseId = await jQuery.agent.insertQuotationData(
        requestBody,
        null,
        campaignDetails,
        premiumCalculationData
      );
    }

    if (url.searchParams.has("id")) {
      url.searchParams.set("id", responseId);
    } else {
      url.searchParams.append("id", responseId);
    }

    window.location.href = url.toString();
  } catch (error) {
    console.error("Error while inserting quotation:", error);
  }
};




const handleClickSaveDraftButton = () => {
  console.log("handleClickSaveDraft");

  // Retrieve form data
  const requestBody = handleForm();

  // Safely update request data with validation
  const updateRequestData = {
    ...requestBody,
    insuredList: Array.isArray(requestBody.insuredList)
      ? requestBody.insuredList.map((insured) => {
          return {
            ...insured,
            planInfo: {
              ...insured.planInfo,
              coverList:
                insured?.planInfo?.coverList?.length > 0
                  ? insured.planInfo.coverList.map((cover) =>
                      cover.id === 600000162
                        ? { ...cover, selectedFlag: false }
                        : cover
                    )
                  : [], // Fallback to an empty array if coverList is undefined or empty
            },
          };
        })
      : [], // Fallback to an empty array if insuredList is not valid
  };

  console.log("updateRequestData:", updateRequestData);

  // Get current URL and extract query parameters
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  const formType = url.searchParams.get("formType");

  // Determine whether to use the updated request data
  if (formType === "auto") {
    jQuery.agent.updateQuoteData(
      updateRequestData,
      null,
      id,
      campaignDetails,
      premiumCalculationData
    );
  } else {
    jQuery.agent.updateQuoteData(
      requestBody,
      null,
      id,
      campaignDetails,
      premiumCalculationData
    );
  }
};
const disableRadioButtons = (radioButtons) => {
  radioButtons.forEach((radio) => {
    radio.style.backgroundColor = "#e9ecef"; // สีพื้นหลังเหมือน disabled
    radio.style.border = "1px solid rgb(118, 118, 118)"; // ขอบสีเทาอ่อน
    radio.style.opacity = "0.65"; // ซีดลงเพื่อให้เหมือน disabled
    radio.style.pointerEvents = "none"; // ปิดการโต้ตอบ
    radio.nextElementSibling.style.color = "#6c757d"; // ทำให้ label เป็นสีเทา
  });
};
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
    } else if (quotationData?.type === "auto") {
      const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";
      if (isRenewal) {
        formElements = document.querySelectorAll(
          "input:not([name='PolicyEffectiveDate']):not([name='firstName'])" +
          ":not([name='dateOfBirth']):not([name='customerIdNo']):not([name='insured_auto_vehicle_regNo'])" +
          // ":not([name='isPolicyHolderDriving'])" +
          ":not([name='insured_auto_driverInfo_driverName']):not([name='insured_auto_driverInfo_driverIdNumber'])" +
          ":not([name='insured_auto_driverInfo_driverDOB']):not([name='haveEx-PreviousPolicyNo'])" +
          ":not([name='insured_auto_driverInfo_claimInfo_dateOfLoss']):not([name='insured_auto_driverInfo_claimInfo_lossDescription'])" +
          ":not([name='insured_auto_driverInfo_claimInfo_claimAmount']):not([name='otherExperience'])" +
          ":not([name='insured_auto_vehicle_engineNo']):not([name='insured_auto_vehicle_chassisNo']), " +
      
          "select:not(#planPoiSelect1):not(#select-product)" +
          ":not([name='Ncd_Level_gears']):not([name='automaticRenewalFlag'])" +
          ":not([name='insured_auto_vehicle_vehicleUsage']):not([name='Ncd_Level'])" +
          ":not([name='NoClaimExperience']):not([name='haveEx-PreviousInsurer'])" +
          ":not([name='residentStatus']):not([name='customerIdType'])" +
          ":not([name='nationality']):not([name='courtesyTitle'])" +
          ":not([name='insured_auto_vehicle_make']):not([name='insured_auto_vehicle_model'])" +
          ":not([name='insured_auto_driverInfo_driverType']):not([name='insured_auto_driverInfo_driverResidentStatus'])" +
          ":not([name='insured_auto_driverInfo_driverIdType']):not([name='insured_auto_driverInfo_driverNationality'])" +
          ":not([name='insured_auto_driverInfo_claimInfo_claimNature']):not([name='insured_auto_driverInfo_claimInfo_claimStatus'])" +
          ":not([name='insured_auto_driverInfo_claimInfo_insuredLiability']):not([name='insured_auto_driverInfo_claimExperience'])" +
          ":not([name='insured_auto_vehicle_vehicleRegYear']), " +
      
          "button:not(#btnSaveForm), " +
      
          "textarea:not([name='discountList'])"
      );
      const radioButtons = document.querySelectorAll(
        'input[type="radio"][name="isPolicyHolderDriving"]'
      );
      const trIsPolicyHolder = document.getElementById('isPolicyHolderDrivingRow')
      trIsPolicyHolder.style.pointerEvents='none'
      disableRadioButtons(radioButtons);
      }
      else {
        formElements = document.querySelectorAll("input, select:not(#planPoiSelect1):not(#select-product):not([name='Ncd_Level_gears']):not([name='automaticRenewalFlag']):not([name='insured_auto_vehicle_vehicleUsage']),button:not(#btnSaveForm),textarea");

      }
  
    }
    else{
      formElements = document.querySelectorAll("input, select:not(#planPoiSelect1),textarea, button:not(#btnSaveForm)");
    }
   
    
    //เพราะไม่อยู่ในform
   
    unhideFormData(formElements);


    if(formType==='auto'){
      handleMileageCondition()
    }
    //paymentsecureflow
    const secureFlowButton = document.getElementById('secure_flow');
    const paymentComment = document.getElementById('payment_comment');
    const paymentCheckbox = document.getElementById('payment_checkbox');
    paymentCheckbox.addEventListener('change', function () {
      const isChecked = this.checked;
      paymentComment.disabled = !isChecked;
      paymentComment.required = isChecked;
    });
    if (secureFlowButton) {
      secureFlowButton.disabled = true;
      secureFlowButton.style.opacity = "0.65";
    }


    btnEditForm.textContent = "Save"
    document.getElementById("btnPayment").disabled=true;
    document.getElementById("btnPayment").style.opacity="0.65";
    btnEditForm.hidden=false
    isEditing = true;


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