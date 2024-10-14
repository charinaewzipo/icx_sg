
function clearPlanInfo() {
  console.log("clearPlanInfo")
  const planSelect = document.getElementById("planSelect");
  planSelect.selectedIndex = 0;
  const planPoiSelect = document.getElementById("planPoiSelect");
  planPoiSelect.value = "";
  const coverListBody = document.getElementById("coverListBody");
  const rows = coverListBody.querySelectorAll(".cover-row");
  rows.forEach((row, index) => {
    if (index !== 0) {
      coverListBody.removeChild(row);
    }
  });
}

const manualSetDefaultValueFormCallingList = (data) => {
  console.log("data FormCallingList:", data)

  document.querySelector('input[name="firstName"]').value = data.name;
  document.querySelector('input[name="dateOfBirth"]').value = data.dob ? isoToFormattedDate(data.dob) : "";
  const dob = data.dob;
  if (dob) {
    const { age } = calculateAge(dob);
    document.getElementById('agePolicyHolder').value = age;
  }
  document.querySelector('input[name="customerIdNo"]').value = data?.personal_id || data?.passport_no;
  document.querySelector('input[name="mobileNo"]').value = data.udf1;
  document.querySelector('input[name="emailId"]').value = data.email || "";
  document.querySelector('input[name="postCode"]').value = data.home_post_cd;

  document.querySelector('input[name="blockNo"]').value = data.home_addr1 || "";
  document.querySelector('input[name="streetName"]').value = data.home_addr2 || "";
  document.querySelector('input[name="unitNo"]').value = data.home_addr3 || "";
  document.querySelector('input[name="buildingName"]').value = data.home_city || "";
  document.querySelector('select[name="maritalStatus"]').value = data.marital_status || "";
  document.querySelector('select[name="nationality"]').value = data.nationality || "";

};
const setDefaultRemarksC = (productDetail) => {
  if (productDetail) {
    document.querySelector('textarea[name="RemarkCInput"]').value = productDetail?.remarks_c || ""
  }

}

const setInsuredPerson = (insuredData, dbData) => {

  const formSections = document.querySelectorAll('table[id^="table-form-"]');
  formSections.forEach((section, index) => {
    if (index >= insuredData.length) return; // Prevent index out of bounds
    const data = insuredData[index];
    const personInfo = data.personInfo;
    console.log("personInfo:", personInfo?.relationToPolicyholder)
    if (personInfo?.relationToPolicyholder != 2) {
      const planInfo = personInfo.planInfo;
      section.querySelector('[name^="insured_ah_insuredFirstName_"]').value =
        personInfo.insuredFirstName || "";
      section.querySelector('[name^="insured_ah_insuredResidentStatus_"]').value =
        personInfo.insuredResidentStatus || "";
      section.querySelector('[name^="insured_ah_insuredIdType_"]').value =
        personInfo.insuredIdType || "";
      section.querySelector('[name^="insured_ah_insuredIdNumber_"]').value =
        personInfo.insuredIdNumber || "";
      section.querySelector('[name^="insured_ah_insuredGender_"]').value =
        personInfo.insuredGender || "";
      const dob = personInfo.insuredDateOfBirth;
      section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value =
        dob ? isoToFormattedDate(dob) : ""
      if (dob) {
        const { age } = calculateAge(dob);
        section.querySelector('[name^="ageInsuredPerson_"]').value = age;
      }
      section.querySelector('[name^="insured_ah_insuredMaritalStatus_"]').value =
        personInfo.insuredMaritalStatus || "";
      section.querySelector('[name^="insured_ah_insuredOccupation_"]').value =
        personInfo.insuredOccupation || "";
      section.querySelector(
        '[name^="insured_ah_relationToPolicyholder_"]'
      ).value = personInfo.relationToPolicyholder || "";


      if (index === 0 && dbData?.productId && planInfo) {


        populatePlans(dbData?.productId, 1, section, planInfo)
        populateCovers(dbData?.productId, 1, section, planInfo)
      }
    }


  });
  fillInsuredSectionChild(insuredData)

};

const setDefaultPlanInfo = async (insuredData,dbData) => {
    console.log("insuredData:", insuredData)
    const planInfo = insuredData ? insuredData[0]?.planInfo : {};
    if (dbData&&planInfo) {
      populatePlansNormal(dbData?.productId,planInfo,dbData?.payment_mode)
    }

};


const setDefaultValueForm = async (dbData) => {
  console.log("setDefaultValueForm")
  console.log("dbData:", dbData)
  const ncdInfo = JSON.parse(dbData.ncdInfo);
  const individualPolicyHolderInfo = JSON.parse(dbData.policyHolderInfo);
  const insuredData = JSON.parse(dbData.insuredList);
  console.log("insuredData:", insuredData)
  const selectProductElement = document.querySelector('select[name="select-product"]');
  selectProductElement.value = dbData?.productId || "";

  if (dbData?.type === "ah") {
    if (!dbData?.quoteNo) {
      if (selectProductElement.value) {
        handleProductChange(selectProductElement);
      }
    }
  }
  else if (dbData?.type==="home"){
    if (selectProductElement.value) {
      // handleProductChange(selectProductElement);
     await fetchGetDwelling(dbData?.productId)
     console.log("fetchGetDwellingfetchGetDwellingfetchGetDwelling:")
    }
  }
  

  document.querySelector('input[id="policyid-input"]').value = dbData?.quoteNo || "";
  document.querySelector('select[name="Ncd_Level"]').value = ncdInfo?.ncdLevel;
  document.querySelector('select[name="NoClaimExperience"]').value =
    ncdInfo?.noClaimExperienceOther || "";
  document.querySelector('textarea[name="RemarkCInput"]').value = dbData?.remarksC || "";
  // const promoInput = document.getElementById("promocode-input")
  // promoInput.value=responseProduct?.promo_campaign_code||"";
  // Set Individual Policy Holder Info fields


  // Payment Frequency
  const paymentFrequencyAnnual = document.querySelector('#paymentFrequencyAnnual');
  const paymentFrequencyMonthly = document.querySelector('#paymentFrequencyMonthly');
  if (dbData?.payment_frequency === 1) {
    paymentFrequencyAnnual.checked = true;
  } else if (dbData?.payment_frequency === 2) {
    paymentFrequencyMonthly.checked = true;
  }
  document.querySelector('select[name="Payment_Mode"]').value = dbData?.payment_mode || "";

  const emailFulfillmentYes = document.querySelector('#emailFulfillmentYes');
  const emailFulfillmentNo = document.querySelector('#emailFulfillmentNo');

  if (dbData?.email_fullfillment === "1") {
    emailFulfillmentYes.checked = true;
  } else if (dbData?.email_fullfillment === "2") {
    emailFulfillmentNo.checked = true;
  }

  document.querySelector('select[name="courtesyTitle"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.courtesyTitle;
  document.querySelector('input[name="firstName"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.fullName;
  // document.querySelector('input[name="lastName"]').value =
  //   individualPolicyHolderInfo.individualPolicyHolderInfo.fullName.split(
  //     " "
  //   )[1];

  document.querySelector('select[name="residentStatus"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.residentStatus;
  document.querySelector('select[name="customerIdType"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.customerIdType;
  document.querySelector('input[name="customerIdNo"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.customerIdNo;
  document.querySelector('select[name="nationality"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.nationality;
  document.querySelector('select[name="gender"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.gender;

  const dob = individualPolicyHolderInfo.individualPolicyHolderInfo.dateOfBirth;
  document.querySelector('input[name="dateOfBirth"]').value = dob ? isoToFormattedDate(dob) : null

  if (dob) {
    const { age } = calculateAge(dob);
    document.getElementById('agePolicyHolder').value = age;
  }
  document.querySelector('select[name="maritalStatus"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.maritalStatus;
  document.querySelector('select[name="occupation"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.occupation;
  document.querySelector('input[name="mobileNo"]').value =
    individualPolicyHolderInfo.contactInfo.mobileNo;
  document.querySelector('input[name="emailId"]').value =
    individualPolicyHolderInfo.contactInfo.emailId;
  document.querySelector('input[name="blockNo"]').value =
    individualPolicyHolderInfo.contactInfo.blockNo;
  document.querySelector('input[name="streetName"]').value =
    individualPolicyHolderInfo.contactInfo.streetName;
  document.querySelector('input[name="unitNo"]').value =
    individualPolicyHolderInfo.contactInfo.unitNo;
  document.querySelector('input[name="buildingName"]').value =
    individualPolicyHolderInfo.contactInfo.buildingName;
  document.querySelector('input[name="postCode"]').value =
    individualPolicyHolderInfo.contactInfo.postCode;
  document.querySelector('input[name="PolicyEffectiveDate"]').value = dbData.policyEffDate ?
    isoToFormattedDate(dbData.policyEffDate) : ""


  document.querySelector('input[name="campaignCode"]').value =
    dbData.campaignCode;

  const drivingYes = document.querySelector("#isPolicyHolderDrivingYes");
  const drivingNo = document.querySelector("#isPolicyHolderDrivingNo");
  if (
    individualPolicyHolderInfo.individualPolicyHolderInfo
      .isPolicyHolderDriving === "2"
  ) {
    drivingYes.checked = true;
  } else {
    drivingNo.checked = true;
  }
  switch (dbData.type) {
    case "home":
      return setInsuredHome(insuredData), setDefaultPlanInfo(insuredData,dbData);
    // case "auto":
    //   return setInsuredVehicleList(insuredData), setDefaultPlanInfo(insuredData);
    case "ah":
      return setInsuredPerson(insuredData, dbData);
    default:

      return null
  }

};
const setInsuredHome = (insuredData) => {
  console.log("setInsuredList home");
  if (!insuredData || insuredData.length === 0) return;

  const addressInfo = insuredData[0].addressInfo;
  console.log("addressInfo:", addressInfo)

  // Map the addressInfo data to the form fields
  document.querySelector('[name="insured_home_dwellingType"]').value = addressInfo?.dwellingType || '';
  document.querySelector('[name="insured_home_flatType"]').value = addressInfo?.flatType || '';
  document.querySelector('[name="insured_home_ownerOccupiedType"]').value = addressInfo?.ownerOccupiedType || '';
  document.querySelector('[name="insured_home_insuredBlockNo"]').value = addressInfo?.insuredBlockNo || '';
  document.querySelector('[name="insured_home_insuredStreetName"]').value = addressInfo?.insuredStreetName || '';
  document.querySelector('[name="insured_home_insuredUnitNo"]').value = addressInfo?.insuredUnitNo || '';
  document.querySelector('[name="insured_home_insuredBuildingName"]').value = addressInfo?.insuredBuildingName || '';
  document.querySelector('[name="insured_home_insuredPostCode"]').value = addressInfo?.insuredPostCode || '';

  // if (addressInfo?.smokeDetectorAvailable === "1") {
  //   document.getElementById('smokeDetecYes').checked = true;
  // } else if (addressInfo?.smokeDetectorAvailable === "2") {
  //   document.getElementById('smokeDetecNo').checked = true;
  // }

  // if (addressInfo?.autoSprinklerAvailable === "1") {
  //   document.getElementById('autoSprinkYes').checked = true;
  // } else if (addressInfo?.autoSprinklerAvailable === "2") {
  //   document.getElementById('autoSprinkNo').checked = true;
  // }

  // if (addressInfo?.securitySystemAvailable === "1") {
  //   document.getElementById('securityYes').checked = true;
  // } else if (addressInfo?.securitySystemAvailable === "2") {
  //   document.getElementById('securityNo').checked = true;
  // }
};
const setInsuredVehicleList = (insuredData) => {
  console.log("setInsuredList vehicle")
  if (!insuredData || insuredData.length === 0) return;
  const vehicleInfo = insuredData[0].vehicleInfo;
  document.querySelector('select[name="insured_auto_vehicle_make"]').value =
    vehicleInfo.make;
  document.querySelector('select[name="insured_auto_vehicle_model"]').value =
    vehicleInfo.model;
  document.querySelector(
    'select[name="insured_auto_vehicle_vehicleRegYear"]'
  ).value = vehicleInfo.vehicleRegYear;
  document.querySelector('input[name="insured_auto_vehicle_regNo"]').value =
    vehicleInfo.regNo;
  document.querySelector(
    `input[name="insured_auto_vehicle_insuringWithCOE"][value="${vehicleInfo.insuringWithCOE}"]`
  ).checked = true;
  document.querySelector(
    'select[name="insured_auto_vehicle_ageConditionBasis"]'
  ).value = vehicleInfo.ageConditionBasis;
  document.querySelector(
    `input[name="insured_auto_vehicle_offPeakCar"][value="${vehicleInfo.offPeakCar}"]`
  ).checked = true;
  document.querySelector(
    'select[name="insured_auto_vehicle_mileageCondition"]'
  ).value = vehicleInfo.mileageCondition;
  document.querySelector(
    'select[name="insured_auto_vehicle_vehicleUsage"]'
  ).value = vehicleInfo.vehicleUsage;
  document.querySelector('input[name="insured_auto_vehicle_engineNo"]').value =
    vehicleInfo.engineNo;
  document.querySelector('input[name="insured_auto_vehicle_chassisNo"]').value =
    vehicleInfo.chassisNo;
  document.querySelector(
    'input[name="insured_auto_vehicle_mileageDeclaration"]'
  ).value = vehicleInfo.mileageDeclaration || "";
  document.querySelector(
    'select[name="insured_auto_vehicle_hirePurchaseCompany"]'
  ).value = vehicleInfo.hirePurchaseCompany;
  document.querySelector(
    'input[name="insured_auto_vehicle_declaredSI"]'
  ).value = vehicleInfo.declaredSI;

  const driverInfo = insuredData[0].driverInfo[0];
  console.log("driverInfo", driverInfo);
  document.querySelector(
    'select[name="insured_auto_driverInfo_driverType"]'
  ).value = driverInfo.driverType;
  document.querySelector(
    'input[name="insured_auto_driverInfo_driverName"]'
  ).value = driverInfo.driverName;
  document.querySelector(
    'input[name="insured_auto_driverInfo_driverIdNumber"]'
  ).value = driverInfo.driverIdNumber;
  document.querySelector(
    'select[name="insured_auto_driverInfo_driverIdType"]'
  ).value = driverInfo.driverIdType;
  document.querySelector(
    'select[name="insured_auto_driverInfo_driverResidentStatus"]'
  ).value = driverInfo.driverResidentStatus;
  document.querySelector(
    'input[name="insured_auto_driverInfo_driverDOB"]'
  ).value = driverInfo.driverDOB.split("T")[0];
  document.querySelector(
    'select[name="insured_auto_driverInfo_driverGender"]'
  ).value = driverInfo.driverGender;
  document.querySelector(
    'select[name="insured_auto_driverInfo_driverNationality"]'
  ).value = driverInfo.driverNationality;
  document.querySelector(
    'select[name="insured_auto_driverInfo_maritalStatus"]'
  ).value = driverInfo.driverMaritalStatus;
  document.querySelector(
    'input[name="insured_auto_driverInfo_drivingExperience"]'
  ).value = driverInfo.drivingExperience;
  document.querySelector(
    'select[name="insured_auto_driverInfo_occupation"]'
  ).value = driverInfo.occupation;
  document.querySelector(
    `input[name="insured_auto_driverInfo_claimExperience"][value="${driverInfo.claimExperience}"]`
  ).checked = true;



  const claimExperienceElement = document.querySelector(
    `input[name="insured_auto_driverInfo_claimExperience"][value="${driverInfo.claimExperience}"]`
  );
  const claimInfoElements = document.querySelectorAll("#claim-info input, #claim-info select");

  claimInfoElements.forEach((field) => {
    field.removeAttribute("required");
  });


  if (claimExperienceElement && claimExperienceElement.checked) {
    const claimInfo = driverInfo.claimInfo && driverInfo.claimInfo[0] ? driverInfo.claimInfo[0] : {};

    // Helper function to set value if element exists
    const setValue = (selector, value) => {
      const element = document.querySelector(selector);
      if (element) {
        element.value = value || '';
      }
    };

    setValue('input[name="insured_auto_driverInfo_claimInfo_dateOfLoss"]', claimInfo.dateOfLoss ? claimInfo.dateOfLoss.split("T")[0] : '');
    setValue('input[name="insured_auto_driverInfo_claimInfo_lossDescription"]', claimInfo.lossDescription);
    setValue('select[name="insured_auto_driverInfo_claimInfo_claimNature"]', claimInfo.claimNature);
    setValue('input[name="insured_auto_driverInfo_claimInfo_claimAmount"]', claimInfo.claimsAmount);
    setValue('select[name="insured_auto_driverInfo_claimInfo_claimStatus"]', claimInfo.status);
    setValue('select[name="insured_auto_driverInfo_claimInfo_insuredLiability"]', claimInfo.insuredLiability);
  }





};
function validateCustomerIdNumber() {
  const idTypeSelect = document.querySelector(`select[name="customerIdType"]`);
  const idNumberInput = document.querySelector(`input[name="customerIdNo"]`);

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
function attachCustomerIdValidation() {
  const idTypeSelect = document.querySelector(`select[name="customerIdType"]`);
  const idNumberInput = document.querySelector(`input[name="customerIdNo"]`);

  if (idTypeSelect && idNumberInput) {
    idTypeSelect.addEventListener('change', validateCustomerIdNumber);
    idNumberInput.addEventListener('input', validateCustomerIdNumber);
  }
}

function clearSelections() {
  // Clear the planSelect dropdown to only have the option with value=""
  const planSelect = document.getElementById("planSelect");
  if (planSelect) {
    planSelect.innerHTML = '<option value=""> &lt;-- Please select an option --&gt; </option>'; // Set inner HTML to only this option
  }

  // Clear the planPoiSelect dropdown to the first option (or empty if required)
  const planPoiSelect = document.getElementById("planPoiSelect");
  if (planPoiSelect) {
    planPoiSelect.value = null// Reset to the first option (if applicable)
  }

  // Clear all planCoverList dropdowns to only have the option with value=""
  const planCoverLists = document.querySelectorAll(".planCoverList");
  planCoverLists.forEach(select => {
    select.innerHTML = '<option value=""> &lt;-- Please select an option --&gt; </option>'; // Set inner HTML to only this option
  });
}

// Example usage
clearSelections(); // Call this function when you need to clear the selections


document.addEventListener("DOMContentLoaded", () => {
  attachCustomerIdValidation()

})