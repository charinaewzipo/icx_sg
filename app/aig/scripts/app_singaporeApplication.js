let selectedType = null;
let campaignDetails = null;
let productDetail = null;


window.onload = function () {
  const defaultShowForm = (document.querySelector('input[name="customerType"]:checked'));
  if (defaultShowForm) {
    showForm(defaultShowForm)
  }
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  var annualRadio = document.getElementById('paymentFrequencyAnnual');
  var displayMonthly = document.getElementById('display-paymentFrequencyMonthly');

  if (formType === "home" || formType==="auto") {
    annualRadio.checked = true;

    displayMonthly.style.display = "none";

    const paymentModeSelect = document.getElementById("paymentModeSelect");
    const recurringOption = paymentModeSelect.querySelector('option[value="124"]')
    if (recurringOption) {
      recurringOption.textContent = "Annual Recurring Credit Card";
      if(formType==='auto'){
        recurringOption.disabled=true;
      }
    }
  }
};


const getTypeSelectForm = () => {
  const selectedItems = document.getElementsByClassName("selectable selected");
  if (selectedItems.length > 0) {
    const selectedItem = selectedItems[0];
    const selectTypeDe = selectedItem.getAttribute("data-type");
    return selectTypeDe;
  } else {
    return null;
  }
};

function getTypeCustomerType() {
  const selectedRadio = document.querySelector(
    'input[name="customerType"]:checked'
  );
  return selectedRadio ? selectedRadio.value : null;
}

const handleSelectType = () => {
  const selectableItems = document.querySelectorAll(
    "#header-select-type .selectable"
  );
  const defaultItem = document.querySelector(
    `#header-select-type [data-type="${selectedType}"]`
  );
  if (defaultItem) {
    defaultItem.classList.add("selected");
  }
  selectableItems.forEach((item) => {
    item.addEventListener("click", function () {
      selectableItems.forEach((el) => el.classList.remove("selected"));
      this.classList.add("selected");
      selectedType = this.getAttribute("data-type");
      console.log("Selected Type:", selectedType);
      handleTypeConfirmQuote();
    });
  });
  handleTypeConfirmQuote();
};
const handleTypeConfirmQuote = () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const formType = urlParams.get("formType");
  const ncdinfoContainer = document.getElementById("ncd-info-container");
  const insuredListHome = document.getElementById("insured-list-home");
  const insuredListAuto = document.getElementById("insured-list-auto");
  const insuredListAh = document.getElementById("insured-list-ah");
  const properateForm = document.getElementById("properateForm");
  const ncdNoExperience = document.getElementById(
    "insured_auto_driverInfo_claimExperience"
  );
  const isPolicyHolderDrivingRow = document.getElementById(
    "isPolicyHolderDrivingRow"
  );
  const planInfoContainer = document.getElementById("plan-info-container-main");
  ncdinfoContainer.style.display = "none";
  insuredListHome.style.display = "none";
  insuredListAuto.style.display = "none";
  insuredListAh.style.display = "none";
  isPolicyHolderDrivingRow.style.display = "none";
  if (formType === "home") {
    [ncdinfoContainer, properateForm, insuredListAuto, insuredListAh].forEach(
      (container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      }
    );
    document.getElementById("remark-c-container").style.display = "none";
  } else if (formType === "auto") {
    [properateForm, insuredListHome, insuredListAh].forEach(
      (container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      }
    );
    document.getElementById("remark-c-container").style.display = "none";
    document.getElementById("promocode-label").style.display = "none";
    document.getElementById("promocode-label2").style.display = "none";
    isPolicyHolderDrivingRow.style.display = "table-row";
  } else if (formType === "ah") {
    [ncdinfoContainer, properateForm, insuredListHome, insuredListAuto, planInfoContainer].forEach(
      (container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      }
    );
    document.getElementById("promocode-label").style.display = "none";
    document.getElementById("promocode-label2").style.display = "none";
  }

  if (formType === "home") {
    insuredListHome.style.display = "block";
  } else if (formType === "auto") {
    ncdinfoContainer.style.display = "block";
    insuredListAuto.style.display = "block";
  } else if (formType === "ah") {
    insuredListAh.style.display = "block";
    planInfoContainer.style.display = "none"
  }
};
const toggleNcdLevel = () => {
  const ncdLevel = document.getElementById("ncdLevel").value;
  console.log("ncdLevel:", ncdLevel)
  const haveExperienceRow = document.getElementById("haveExperienceRow");
  const noClaimExperienceRow = document.getElementById("noClaimExperienceRow");
  const ncdNoExperience = document.getElementById("ncdNoExperience");
  
  if (ncdLevel < 1) {
    noClaimExperienceRow.style.display = "";
    haveExperienceRow.style.display = "none"; // Hide have experience row
    
    // Remove required attribute
    const previousInsurerSelect = haveExperienceRow.querySelector('select[name="haveEx-PreviousInsurer"]');
    const previousPolicyNoInput = haveExperienceRow.querySelector('input[name="haveEx-PreviousPolicyNo"]');

    if (previousInsurerSelect) {
        previousInsurerSelect.removeAttribute('required'); // Remove required
    
    }
    if (previousPolicyNoInput) {
        previousPolicyNoInput.removeAttribute('required'); // Remove required
    }

} else {
    noClaimExperienceRow.style.display = "none"; // Hide no claim experience row
    haveExperienceRow.style.display = ""; // Show have experience row
    // Add required attribute back
    const previousInsurerSelect = haveExperienceRow.querySelector('select[name="haveEx-PreviousInsurer"]');
    const previousPolicyNoInput = haveExperienceRow.querySelector('input[name="haveEx-PreviousPolicyNo"]');
    if(ncdNoExperience){
      ncdNoExperience.removeAttribute('required'); 
    }
    if (previousInsurerSelect) {
        previousInsurerSelect.setAttribute('required', ''); // Add required
    }
    if (previousPolicyNoInput) {
        previousPolicyNoInput.setAttribute('required', ''); // Add required
    }
}
};
const toggleNcdNoExperience = () => {
  const ncdNoExperience = document.getElementById("ncdNoExperience").value;
  const displayStyle = ncdNoExperience == "4" ? "block" : "none";
  document.getElementById("otherExperience-display").style.display = displayStyle;
  document.getElementById("otherExperience").style.display = displayStyle;
};
const toggleClaimExperience = (selectedOption) => {
  console.log("toggleClaimExperience:")
  const ncdNoExperience = document.getElementById("claim-info");
  const displayStyle = selectedOption.value == "Y" ? "block" : "none";
  ncdNoExperience.style.display = displayStyle;

  const claimInfo = document.querySelectorAll("#claim-info");
 
  if (selectedOption.value === "N") {
    claimInfo.forEach((container) => {
      container.querySelectorAll("input, select").forEach((field) => {
        field.removeAttribute("required");
      });
    });
  } else {
    claimInfo.forEach((container) => {
      container.querySelectorAll("input, select").forEach((field) => {
        field.setAttribute("required", "required");
      });
    });
  }
  if(selectedOption.value === "morethan1"){
    alert("We regret that we are unable to provide you with a quote due to your claim experience. ")
    selectedOption.value=''
    return 
  }
};
function showForm(selectedOption) {
  document.getElementById("individualForm").style.display = "none";
  document.getElementById("properateForm").style.display = "none";
  if (selectedOption) {
    if (selectedOption.value === "0") {
      document.getElementById("individualForm").style.display = "block";
    } else if (selectedOption.value === "1") {
      document.getElementById("properateForm").style.display = "block";
    }
  } else {
    // Show default form
    document.getElementById("individualForm").style.display = "block";
  }
}

function handleForm() {
  const formType = getTypeSelectForm();
  const customerType = getTypeCustomerType();
  const formData = new FormData(document.getElementById("application"));
  let insuredList = [];
  const paymentDetails = [{
    paymentMode: Number(formData.get('Payment_Mode')),
    paymentFrequency: Number(formData.get('Payment_Frequency')),
  }]
  const policyDetail = {
    policyId: policyid ? policyid : "",
    productId: formData.get("select-product"),
    distributionChannel: 10,
    producerCode: quotationData?.producerCode ? quotationData?.producerCode : (calllistDetail[productDetail?.udf_field_producer_code] || ""),
    propDate:"",
    policyEffDate: formData.get("PolicyEffectiveDate")
      ? transformDate(formData.get("PolicyEffectiveDate"))
      : "",
    policyExpDate: formType==="auto" ?formData.get("PolicyExpiryDate")
      ? transformDate(formData.get("PolicyExpiryDate"))
      : "":"" ,
    
    campaignCode: formData.get("campaignCode"),
    efulfillmentFlag: Number(formData.get('Email_Fulfillment_Flag')),
  };
  if (formType === "auto") {
    policyDetail.ncdInfo = {};
    policyDetail.ncdInfo.ncdLevel = Number(formData.get("Ncd_Level"));
 
    policyDetail.ncdInfo.previousInsurer = formData.get(
      "haveEx-PreviousInsurer"
    );
    policyDetail.ncdInfo.previousPolicyNo = formData.get(
      "haveEx-PreviousPolicyNo"
    );
    policyDetail.ncdInfo.noClaimExperience = formData.get("NoClaimExperience");
    policyDetail.ncdInfo.noClaimExperienceOther =
      formData.get("otherExperience");
      if(policyDetail.ncdInfo.ncdLevel<1){
        policyDetail.ncdInfo.previousInsurer="",
        policyDetail.ncdInfo.previousPolicyNo=""
      }else{
        policyDetail.ncdInfo.noClaimExperience=""
        policyDetail.ncdInfo.noClaimExperienceOther=""
      }
  } 
  
  else if (formType === "ah") {
    policyDetail.remarksC = formData.get("RemarkCInput");
  }

  ////////////////handlePolicyholder form

  const fullName = formData.get("firstName");
  policyHolderInfo = {
    customerType: formData.get("customerType"),
    individualPolicyHolderInfo: {
      courtesyTitle: formData.get("courtesyTitle"),
      fullName: fullName,
      residentStatus: formData.get("residentStatus"),
      customerIdType: formData.get("customerIdType"),
      customerIdNo: formData.get("customerIdNo"),
      nationality: formData.get("nationality"),
      gender: formData.get("gender"),

      dateOfBirth: formData.get("dateOfBirth")
        ? transformDate(formData.get("dateOfBirth"))
        : "",
      maritalStatus: formData.get("maritalStatus"),
      occupation: formData.get("occupation"),
    },
    contactInfo: {
      postCode:
        customerType === "0"
          ? formData.get("postCode")
          : formData.get("Organization_postCode"),
      unitNo:
        customerType === "0"
          ? formData.get("unitNo")
          : formData.get("Organization_unitNo"),
      blockNo:
        customerType === "0"
          ? formData.get("blockNo")
          : formData.get("Organization_blockNo"),
      streetName:
        customerType === "0"
          ? formData.get("streetName")
          : formData.get("Organization_streetName"),
      buildingName:
        customerType === "0"
          ? formData.get("buildingName")
          : formData.get("Organization_buildingName"),
      emailId: formData.get("emailId"),
      mobileNo: formData.get("mobileNo"),
    },
  };
  if (formType === "auto") {
    policyHolderInfo.individualPolicyHolderInfo.isPolicyHolderDriving =
      formData.get("isPolicyHolderDriving");
  }

  ////////////////handlePolicyInsureList form
  let insuredObject = {};
  if (formType === "home") {
    insuredObject.addressInfo = {};
    for (const [name, value] of formData.entries()) {
      if (name.includes("insured_home_")) {
        insuredObject.addressInfo[name.replace("insured_home_", "")] = value;
      }
    }
  } else if (formType === "auto") {
    insuredObject = {
      vehicleInfo: {
        make: formData.get("insured_auto_vehicle_make") || "",
        model: formData.get("insured_auto_vehicle_model") || "",
        vehicleRegYear:
          formData.get("insured_auto_vehicle_vehicleRegYear") || "",
        regNo: formData.get("insured_auto_vehicle_regNo") || "",
        insuringWithCOE:
          formData.get("insured_auto_vehicle_insuringWithCOE") || "",
        ageConditionBasis:
          formData.get("insured_auto_vehicle_ageConditionBasis") || "",
        offPeakCar: formData.get("insured_auto_vehicle_offPeakCar") || "",
        vehicleUsage: formData.get("insured_auto_vehicle_vehicleUsage") || "",

        mileageCondition:
          formData.get("insured_auto_vehicle_mileageCondition") || "",
        engineNo: formData.get("insured_auto_vehicle_engineNo") || "",
        chassisNo: formData.get("insured_auto_vehicle_chassisNo") || "",
        mileageDeclaration:
          formData.get("insured_auto_vehicle_mileageDeclaration") || "",
        hirePurchaseCompany:
          formData.get("insured_auto_vehicle_hirePurchaseCompany") || "",
      },
      driverInfo: [
        {
          driverType: formData.get("insured_auto_driverInfo_driverType") || "",
          driverDOB: formData.get("insured_auto_driverInfo_driverDOB")
            ? transformDate(formData.get("insured_auto_driverInfo_driverDOB"))
            : "",
          driverGender:
            formData.get("insured_auto_driverInfo_driverGender") || "",
          driverMaritalStatus:
            formData.get("insured_auto_driverInfo_maritalStatus") || "",
          drivingExperience:
            formData.get("insured_auto_driverInfo_drivingExperience") || "",
          occupation: formData.get("insured_auto_driverInfo_occupation") || "",
          // occupation: "18",
          claimExperience:
            formData.get("insured_auto_driverInfo_claimExperience") || "",
          claimInfo:
            formData.get("insured_auto_driverInfo_claimExperience") === "Y"
              ? [
                {
                  dateOfLoss: formData.get(
                    "insured_auto_driverInfo_claimInfo_dateOfLoss"
                  )
                    ? transformDate(
                      formData.get(
                        "insured_auto_driverInfo_claimInfo_dateOfLoss"
                      )
                    )
                    : "",
                  lossDescription:
                    formData.get(
                      "insured_auto_driverInfo_claimInfo_lossDescription"
                    ) || "",
                  claimNature:
                    formData.get(
                      "insured_auto_driverInfo_claimInfo_claimNature"
                    ) || "",
                  claimsAmount:
                    parseFloat(
                      formData.get(
                        "insured_auto_driverInfo_claimInfo_claimAmount"
                      )
                    ) || 0,
                  status:
                    parseInt(
                      formData.get(
                        "insured_auto_driverInfo_claimInfo_claimStatus"
                      ),
                      10
                    ) || 0,
                  insuredLiability:
                    parseInt(
                      formData.get(
                        "insured_auto_driverInfo_claimInfo_insuredLiability"
                      ),
                      10
                    ) || 0,
                },
              ]
              : [],
          driverName: formData.get("insured_auto_driverInfo_driverName") || "",
          driverIdNumber:
            formData.get("insured_auto_driverInfo_driverIdNumber") || "",
          driverIdType:
            formData.get("insured_auto_driverInfo_driverIdType") || "",
          driverResidentStatus:
            formData.get("insured_auto_driverInfo_driverResidentStatus") || "",
          driverNationality:
            formData.get("insured_auto_driverInfo_driverNationality") || "",
        },
      ],
    };
  } else if (formType === "ah") {
    insuredList = collectFormData()

   
    const fullForm = {
      ...policyDetail,
      policyHolderInfo,
      insuredList,
      paymentDetails
    };
    return fullForm
  }


  insuredObject.planInfo = {};
  const planDetail = getPlanDetail();
  insuredObject.planInfo = planDetail;
  insuredList.push(insuredObject);
  let fullForm = {
    ...policyDetail,
    policyHolderInfo,
    insuredList,
    paymentDetails
  };


  if(formType === "auto"){
    fullForm={...fullForm,
      quoteVersionMemo: formData.get("commentHistory"),
      campaignInfoList:getCampaignInfoList(),
      campaignCode:""
    }
    campaignDetails={...campaignDetails,cardType:formData.get("cardType")}
  }

  return fullForm;
}


function getPlanDetail() {
  const formData = new FormData(document.querySelector("form")); // Assuming the form element is available
  const planSelectElement = document.getElementById("planSelect");
  const selectedOption = planSelectElement.options[planSelectElement.selectedIndex];
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  let PlanDetail = {
  planId:formData.get("planId") || "",
  planPoi:formData.get("planPoi") || "",
  planCode: selectedOption.getAttribute("data-plan_group") || "" 
 }
 
  if (formType === 'auto') {
    let coverList = [];
    const planCoverLists = document.querySelectorAll('.planCoverList');

    console.log("selectedPlanselectedPlanselectedPlan:", selectedPlan)
    if (selectedPlan) {
      let coverListDataFilterAutoAttachedFalse=[]
      if(checkShouldRetrieve()){
        coverListDataFilterAutoAttachedFalse=Object.values(selectedPlan?.coverList || {})
      }else{
        coverListDataFilterAutoAttachedFalse = Object.values(selectedPlan?.coverList || {}).filter(
          (cover) => cover?.autoAttached === false
        );
      }

      // Iterate through each dropdown and gather selected data
      planCoverLists.forEach(function (selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        if (selectedOption.value !== "" && !selectedOption.disabled) {
          const excess=document.getElementById('insured_auto_buy_up_down')
          const objectCover = {
            id: selectedOption.value,
            code: selectedOption?.dataset.code || "",
            selectedFlag: true,
            buyUpOrbuyDownExcess:excess ? Number(excess.value):0 // Default to null if no value
          };
          coverList.push(objectCover);
        }
      });
      console.log("coverListcoverListcoverListcoverList",coverList)
      // Merge the existing cover list data with the new selections
      let updateCoverList = coverListDataFilterAutoAttachedFalse.map((item) => {
        const existingCover = coverList.find((cover) => cover.id === String(item.id));
        if (existingCover) {
          return {
            id: item.id,
            code: item.code,
            buyUpOrbuyDownExcess: existingCover.buyUpOrbuyDownExcess,
            selectedFlag: true
          };
        } else {
          return {
            id: item.id,
            code: item.code,
            buyUpOrbuyDownExcess: item.buyUpOrbuyDownExcess || null,
            selectedFlag: false
          };
        }
      });
      //update own damage with buyupdownvalue
      const excess=document.getElementById('insured_auto_buy_up_down')
        updateCoverList=[...updateCoverList,  
          {
          id: 600000162,
          code: "00030",
          buyUpOrbuyDownExcess: excess ? Number(excess.value):0,
          selectedFlag: true
      }]
      // Update the PlanDetail with the updated cover list
      PlanDetail = { ...PlanDetail, coverList: updateCoverList };
    }
  }

 return PlanDetail
}
function getCampaignInfoList() {
  const promoCodeInputs = document.querySelectorAll('input[name="campaignCode[]"]');
  const campaignInfoList = [];

  promoCodeInputs.forEach(input => {
      const promoCodeValue = input.value.trim(); // Get and trim the value of the input field
      if (promoCodeValue) {
          campaignInfoList.push({
              campaignCode: promoCodeValue
          });
      }
  });

  console.log("campaignInfoList:", campaignInfoList);
  return campaignInfoList;
}

function populatePlansNormal(productId,planInfo,paymentMode) {
  console.log("planInfo:", planInfo)
  console.log("populatePlansNormal:")
  const selectProduct = document.getElementById("select-product");
  const planGroup = selectProduct.options[selectProduct.selectedIndex].getAttribute("data-plan_group");
  console.log("planGroup:", planGroup)
  if (!productId) return;
  let url = "";
  if (paymentMode && planGroup) {
      let plan_poi = (Number(paymentMode) === 124) ? 12 : 60; 
      url = `../scripts/get_plan_normal.php?product_id=${productId}&plan_poi=${plan_poi}&plan_group=${planGroup}`;
  } else {
      console.error("Payment mode or plan group missing");
      return;
  }
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
              option.setAttribute('data-plan_group', plan?.plan_group||"");

              planSelect.appendChild(option);
          });
          if (planInfo) {
            console.log("planInfo:", planInfo)
            const planSelect = document.getElementById("planSelect");
            const planPoiValue = planInfo.planPoi || ""; 
            const planCodeValue = planInfo.planCode || ""; 
            
            // Loop through the options in the select dropdown
            for (let i = 0; i < planSelect.options.length; i++) {
              const option = planSelect.options[i];
              
              if (Number(option.getAttribute("data-planpoi")) === Number(planPoiValue)&&planCodeValue.startsWith(option.getAttribute('data-plan_group'))) {
                planSelect.selectedIndex = i;
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

const handleValidateForm = () => {
  console.log("handleValidateForm");
  document
    .getElementById("application")
    .addEventListener("submit", async function (event) {
      event.preventDefault();
      console.log("Form submission triggered");
      const submitButton = document.querySelector("#btnEditForm");
      console.log("submitButton:", submitButton)
      const shouldRecalculate = submitButton.getAttribute("data-recalculate") === "true";
      console.log("shouldRecalculate:", shouldRecalculate)
      // Create an instance of FormData from the form element
      const form = event.target;
      const formData = new FormData(document.getElementById("application"));

      let currentUrl = window.location.href;
      const url = new URL(currentUrl);
      let formType = url.searchParams.get('formType');
      console.log("form", handleForm());
      let isValid = true;
      document.querySelectorAll("input, select").forEach(function (field) {
        if (
          field.style.display !== "none" &&
          field.required &&
          !field.value.trim()
        ) {
          console.log(`Error: ${field.name} is empty`);
          isValid = false;
          field.classList.add("error-border");
        } else {
          field.classList.remove("error-border");
        }
      });
//bypass Policy
if (quotationData?.policyId && responsePayment?.result === "SUCCESS") {
  isValid = true; // Explicitly set to true if both conditions are met
}
      if (!isValid) {
        alert("Please fill in all required fields.");
        return;
      }


      const requestBody = handleForm();
      console.log("requestBody", requestBody)
      // const submitButton = document.querySelector("#btnEditForm");
      // const shouldRecalculate = submitButton.getAttribute("data-recalculate") === "true";
      console.log("shouldRecalculate:", shouldRecalculate)
      if (quotationData?.policyId && responsePayment?.result === "SUCCESS") {
        const paymentDetails = [
          {
            batchNo: responsePayment.batch_no,
            orderNo: responsePayment?.payment_order_id,
            paymentMode: Number(formData.get('Payment_Mode')),
            merchantId: responsePayment.merchant,
            cardExpiryMonth: responsePayment.card_expiry_month,
            cardExpiryYear: responsePayment.card_expiry_year,
            paymentDate: new Date(responsePayment.time_of_lastupdate).toISOString(),
            paymentFrequency: Number(formData.get('Payment_Mode'))===122 ? handlePaymentFrequencyIPP():quotationData.payment_frequency,
            paymentAmount: responsePayment.order_amount,
            cardType:handleCardTypeFromResponse(),
            cardNumber: responsePayment.card_number,
            currency: responsePayment.order_currency,
            cardTokenNo: responsePayment?.payment_token_id || ""
          },
        ];
        console.log("quotationData:", quotationData)

        const policyRequest ={
          policyId: quotationData.policyId || "",
          productId: quotationData.productId || "",
          distributionChannel: quotationData.distributionChannel || 0,
          producerCode: quotationData.producerCode || "",
          policyEffDate: quotationData.policyEffDate
            ? new Date(`${quotationData.policyEffDate}Z`).toISOString()
            : new Date().toISOString(), 
          policyHolderInfo: quotationData?.policyHolderInfo,
          remarksC: quotationData.remarksC || "",
          efulfillmentFlag: quotationData.efulfillmentFlag || "1",
          paymentDetails
      };
        console.log("policyRequest:", policyRequest)

        await fetchPolicy(policyRequest);
       
      } else if(shouldRecalculate&&!submitButton.hidden){
        if(formType==="ah"){
          const requestAH={...requestBody,policyId:""}
          await fetchQuotation(requestAH);
        }else{
          console.log("fetch Recalculate")
          await fetchRecalculateQuote(requestBody);
        }

      }else{
        await fetchQuotation(requestBody);
        console.log("fetch quotation")
      }
    });
};




document.addEventListener("DOMContentLoaded", () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  selectedType = urlParams.get("formType");
  handleTypeConfirmQuote();
  getCampaignDetails()

  document.getElementById("planSelect").addEventListener("change",function(){
     var selectedOption = this.options[this.selectedIndex];

    // Get the data-planpoi attribute from the selected option
    var planPoi = selectedOption.getAttribute('data-planpoi');
    document.getElementById("planPoiSelect").value=planPoi

    handleClearPromoCode(planPoi)
  })
  
});
const getCampaignDetails = () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const campaign_id = urlParams.get("campaign_id");
  const agent_id = urlParams.get("agent_id");
  const import_id = urlParams.get("import_id");
  const calllist_id = urlParams.get("calllist_id");
  campaignDetails = {
    campaign_id,
    agent_id,
    import_id,
    calllist_id
  }
}
document.addEventListener("DOMContentLoaded", () => {
  handleSelectType();
  handleValidateForm();
});

const removeKeysFromQuotationDataOnCreateQuote = (data) => {
  const keysToRemove = ['efulfillmentFlag'];

  keysToRemove.forEach(key => {
    delete data[key];
  });
  return data;
};
const removeKeysFromQuotationData = (data) => {
  const keysToRemove = ['quoteLapseDate', 'quoteNo','type', 'premiumPayable',
    'id', 'propDate','type_vouncher','vouncher_value','dont_call_ind','dont_SMS_ind','dont_email_ind','dont_Mail_ind','quote_create_date','update_date'
    ,'ncdInfo','insuredList','payment_amount','policyExpDate',
    'plan_poi', 'agent_id', 'calllist_id', 'campaignCode', 'campaign_id', 'dob'
    , 'fullname', 'import_id', 'incident_status', 'lastname', 'policyNo', 'policy_create_date','payment_mode','payment_frequency','customer_id'
  ];

  keysToRemove.forEach(key => {
    delete data[key];
  });
  if (data.policyEffDate) {
    data.policyEffDate = formatDateToISO(data.policyEffDate);
  }
  if (data.policyExpDate) {
    data.policyExpDate = formatDateToISO(data.policyExpDate);
  }


  return data;
};
const formatDateToISO = (dateStr) => {
  const [datePart, timePart] = dateStr.split(' ');
  const dateISO = new Date(`${datePart}T${timePart}Z`).toISOString();
  return dateISO.split('.')[0] + 'Z';
};
function isoToFormattedDate(isoDateStr) {
  const date = new Date(isoDateStr);
  const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
  const day = String(date.getDate()).padStart(2, '0');
  const year = date.getFullYear();
  return `${day}/${month}/${year}`;
}
//datetoISO
const transformDate = (dateString) => {
  console.log("dateString:", dateString);
  const date = moment.utc(dateString, 'DD/MM/YYYY').startOf('day');
  
  return date.format('YYYY-MM-DDTHH:mm:ss[Z]');
};
const displayDateInsured = (dateText, index) => {
  const { age, days } = calculateAge(dateText);
  console.log("productDetail:", productDetail)
  if (!productDetail) {
    alert("Please select a product")
    $(`#datepicker-${index}`).val(''); // Clear the datepicker input
    $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
    return;
  }
  if (age < productDetail?.min_age) {
    alert(`Please enter a date of birth that is more than ${productDetail?.min_age} years ago.`);
    // Reset the datepicker value
    $(`#datepicker-${index}`).val(''); // Clear the datepicker input
    $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
  } else if (age >= productDetail?.max_age) {
    alert(`Please enter a date of birth that is less than ${productDetail.max_age} years ago.`);
    // Reset the datepicker value
    $(`#datepicker-${index}`).val(''); // Clear the datepicker input
    $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
  }

  else {
    // If age is valid, set the age value
    $(`#ageInsuredPerson_${index}`).val(age);
  }
};


function handleAddChildButtonVisibility(productDetail) {
  const addButton = document.getElementById('add-insured-child');
  if (productDetail?.max_age_child) {
    addButton.style.display = 'block';
  } else {
    addButton.style.display = 'none';
  }
}
