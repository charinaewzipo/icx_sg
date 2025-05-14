
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
  
  document.getElementById("promocode-input").value=data?.campaignCode||""
  
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
    if(campaignDetailsFromAPI?.incident_type==="Renewal" && quotationData?.type==="home") {
     console.log("campaignDetailsFromAPI?.incident_type:", campaignDetailsFromAPI?.incident_type)
     let paymentModee= Number(planInfo?.planPoi)===12 ? 124:1001
     document.getElementById("paymentModeSelect").value=paymentModee;
      populatePlansNormal(dbData?.productId,planInfo,paymentModee)
    }

};
function IsCoverInCoverList(coverList, cover) {
  return Object.values(coverList).some(
    existingCover => existingCover.id === cover.id && existingCover.code === cover.code
  );
}
const setDefaultPlanInfoAuto = async (insuredData,dbData) => {
    console.log("insuredData:", insuredData)
    const planInfo = insuredData ? insuredData[0]?.planInfo : {};
    console.log("planInfo:", planInfo)
    const planSelect = document.getElementById('planSelect');
    const planPoiSelect = document.getElementById('planPoiSelect');
    const premiumAmountInput = document.getElementById('premium-amount');
    if (dbData&&planInfo?.planId) {
          let apiBody = handlePremiumRequestBody();
          console.log("apiBody:", apiBody)

          //เช็คว่าหากมีquoteNoแล้ว ไม่ให้ใช้getpremium ไปใช้ในdatabaseแทน
          if(dbData?.quoteNo){
            const responsePremium = JSON.parse(dbData?.response_premium_calculation_json);
            await populatePlanAutoPremium(responsePremium);
          }else{
            await fetchPremium(apiBody);
          }
          for (const option of planSelect.options) {
            if (Number(option.value) === Number(planInfo.planId)) {
                option.selected = true;  // Select the matching option
                planPoiSelect.value = option.dataset.planPoi || ''; 
                premiumAmountInput.value = `${option.dataset.netPremium}(SGD)` || '';  // Update planPoiSelect
                break;
            }
        }
        planSelect.dispatchEvent(new Event('change'));
        if(planInfo?.coverList){
          const coverListBody = document.getElementById('coverListBody');
          coverListBody.innerHTML = '';
          console.log("let selectedPlan;",selectedPlan)
          if(checkAllValuesSelectedFlagFalse(planInfo?.coverList)){
            addCoverRow(selectedPlan?.coverList)
          }else{
            Object.values(planInfo?.coverList).map(cover=>{
              console.log("cover",cover)
              const quoteNoFieldForm=document.getElementById('policyid-input')
              if(quoteNoFieldForm && quoteNoFieldForm.value&&cover?.optionalFlag===true){
                addCoverRow(selectedPlan?.coverList, cover); 
              }
              else if (!(quoteNoFieldForm && quoteNoFieldForm.value)&&cover?.selectedFlag===true) {
                addCoverRow(selectedPlan?.coverList, cover); 
              }
              
            })
          }

          const filterBuyUpDown = Object.values(planInfo?.coverList).filter(i=>Number(i.id)===600000162)[0];
          const buyUpDownField = document.getElementById('insured_auto_buy_up_down')
          if(buyUpDownField){
            buyUpDownField.value=filterBuyUpDown?.buyUpOrbuyDownExcess||""
            buyUpDownField.dispatchEvent(new Event('change'))
          }
          
        }
    }
    

};
const checkAllValuesSelectedFlagFalse = (coverList) => {
  return Object.values(coverList).every((cover) => cover?.selectedFlag === false);
};


const setDefaultValueForm = async (dbData) => {
  console.log("setDefaultValueForm")
  console.log("dbData:", dbData)
  const ncdInfo = JSON.parse(dbData.ncdInfo);
  console.log("ncdInfo:", ncdInfo)
  const individualPolicyHolderInfo = JSON.parse(dbData.policyHolderInfo);
  const insuredData = JSON.parse(dbData.insuredList);
  console.log("insuredData:", insuredData)
  const selectProductElement = document.querySelector('select[name="select-product"]');

  if (dbData?.type === "ah"||dbData?.type==="auto") {
  selectProductElement.value = dbData?.productId || "";

    if (!dbData?.quoteNo) {
      if (selectProductElement.value) {
        handleProductChange(selectProductElement);
      }
    }
  }
  else if (dbData?.type === "home") {
    const planCode = insuredData[0]?.planInfo?.planCode || "";
    console.log("planCode:", planCode);
    
    const options = selectProductElement.querySelectorAll('option');
    let matchingOptionIndex = -1;
  
    // Find the matching option's index based on planCode and data-plan_group
    options.forEach((option, index) => {
      const planGroup = option.getAttribute('data-plan_group');
      if (planCode.startsWith(planGroup)) {
        matchingOptionIndex = index;
      }
    });
  
    if (matchingOptionIndex !== -1) {
      // Set the matching option using its index
      selectProductElement.selectedIndex = matchingOptionIndex;
      
      // Optionally log to ensure the correct one is selected
      console.log("Matching option found and selected:", options[matchingOptionIndex]);
    } else {
      console.error("No matching option found for planCode:", planCode);
    }
  
    // Continue with fetching dwelling type and flat type
    await fetchGetDwelling(dbData?.productId);
    await fetchGetFlatType(insuredData[0]?.addressInfo?.dwellingType);
  }
  
  document.querySelector('input[id="policyid-input"]').value = dbData?.quoteNo || "";
  if (dbData?.type == "auto") {
    const vehicleInfo = insuredData[0].vehicleInfo
    const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";
    const nameModel = isRenewal ? 'RNModel':'Model'
    await fetchGetModel(vehicleInfo.make,nameModel);
    document.querySelector('select[name="Ncd_Level"]').value = ncdInfo?.ncdLevel;
    document.querySelector('select[name="NoClaimExperience"]').value = ncdInfo?.noClaimExperience || "";
    const haveExPreviousInsurer = document.querySelector('select[name="haveEx-PreviousInsurer"]');
    const haveExPreviousPolicyNo = document.querySelector('input[name="haveEx-PreviousPolicyNo"]');

    toggleNcdLevel()
    if (ncdInfo?.noClaimExperience === "4") {
      toggleNcdNoExperience();
      const otherExperienceSelect = document.querySelector('input[name="otherExperience"]');
      if (otherExperienceSelect) {
        otherExperienceSelect.value = ncdInfo?.noClaimExperienceOther || "";
      }

    }
    if (haveExPreviousInsurer) {
      console.log("haveExPreviousInsurer:")
      haveExPreviousInsurer.value = ncdInfo?.previousInsurer || "";
    }
    if (haveExPreviousPolicyNo) {
      console.log("haveExPreviousPolicyNo:")
      haveExPreviousPolicyNo.value = ncdInfo?.previousPolicyNo || "";
    }
  }

  document.querySelector('textarea[name="RemarkCInput"]').value = dbData?.remarksC || "";



  // Payment Frequency
  const paymentFrequencyAnnual = document.querySelector('#paymentFrequencyAnnual');
  const paymentFrequencyMonthly = document.querySelector('#paymentFrequencyMonthly');
  if (dbData?.payment_frequency === 1) {
    paymentFrequencyAnnual.checked = true;
    paymentFrequencyAnnual.dispatchEvent(new Event('change'));
  } else if (dbData?.payment_frequency === 2) {
    paymentFrequencyMonthly.checked = true;
    paymentFrequencyMonthly.dispatchEvent(new Event('change'));
  }
  
  document.querySelector('select[name="Payment_Mode"]').value = dbData?.payment_mode || "";
  if(dbData?.type=="auto"){
    document.querySelector('select[name="Payment_Mode"]').dispatchEvent(new Event('change'));
  }
  const emailFulfillmentYes = document.querySelector('#emailFulfillmentYes');
  const emailFulfillmentNo = document.querySelector('#emailFulfillmentNo');

  if (Number(dbData?.efulfillmentFlag) === 1) {
    emailFulfillmentYes.checked = true;
  } else if (Number(dbData?.efulfillmentFlag) === 2) {
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
    if (dbData?.type === "auto") {
      const effectiveDateInput = $("#datepicker5")[0]; // ใช้ [0] เพื่อเข้าถึง DOM element ของ jQuery
      effectiveDateInput.dispatchEvent(new Event('change'));
    }
    
  document.querySelector('input[name="PolicyExpiryDate"]').value = dbData.policyExpDate ?
    isoToFormattedDate(dbData.policyExpDate) : ""


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
    case "auto":
      return await setInsuredVehicleList(insuredData),
        await setDefaultPlanInfoAuto(insuredData, dbData),
        populateAdditionalInfo(dbData),
        checkTextareaContentBox(),
        populateExcessSectionOther(),
        await populateObjectHandlingVouchers(dbData),
        populateAdditionInfoInternalClaimHistory(),
        setCampaignCodeAuto(dbData);
    case "ah":
      return setInsuredPerson(insuredData, dbData);
    default:

      return null
  }

};
const handleAlertNCDLevelDifferent=()=>{
  if(!responsePayment&&quotationData?.type==="auto"&& !checkShouldRetrieve()){
    if(Number(quotationData?.ncdInfo?.ncdLevel)!==Number(quotationData?.ncdLevelGEARS)){
      window.alert("AIG will be writing to your existing insurer to verify your NCD. We will contact you via mail should there be any discrepancy in the NCD and we will recover the premium difference, if any.")
    }
  }
}
const setCampaignCodeAuto = (dbData) => {
  document.querySelector('textarea[name="commentHistory"]').value = dbData?.quoteVersionMemo || "";
  document.querySelector('select[name="Ncd_Level_gears"]').value = dbData?.ncdLevelGEARS || "";
  document.querySelector('select[name="cardType"]').value = dbData?.cardType || "";

  let campaignInfoList = [];
  try {
    campaignInfoList = JSON.parse(dbData?.campaignInfoList) || [];
  } catch (error) {
    console.error("Invalid campaignInfoList JSON:", error);
  }

  let getCampaignCodeFromAnyResponse = null;
  try {
    getCampaignCodeFromAnyResponse = dbData?.response_recalculate_json
      ? JSON.parse(dbData.response_recalculate_json)
      : dbData?.response_quote_json
      ? JSON.parse(dbData.response_quote_json)
      : null;
  } catch (error) {
    console.error("Invalid response JSON:", error);
  }
  console.log("campaignInfoList:", campaignInfoList);

  console.log("getCampaignCodeFromAnyResponse:", getCampaignCodeFromAnyResponse);

  if (
    getCampaignCodeFromAnyResponse?.campaignAndDiscountList &&
    Array.isArray(getCampaignCodeFromAnyResponse.campaignAndDiscountList)
  ) {
    const matchingCampaigns = campaignInfoList.filter(campaign =>
      getCampaignCodeFromAnyResponse?.campaignAndDiscountList?.some(
        item => item?.code === campaign?.campaignCode
      )
    );
    console.log("matchingCampaigns:", matchingCampaigns)
    campaignInfoList=matchingCampaigns;
  }

  document.getElementById("add-code-display").style.display = "";

    
  console.log("objectHandlingVoucherDetails",objectHandlingVoucherDetails)
  if (Array.isArray(campaignInfoList) && campaignInfoList.length > 0) {
    const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";

    if (isRenewal) {
      const isArrayVoucherDetails = Array.isArray(objectHandlingVoucherDetails);

      // แยกแคมเปญที่ไม่ใช่ object handling voucher
      const filteredCampaigns = campaignInfoList.filter(campaign =>
        !(isArrayVoucherDetails && objectHandlingVoucherDetails.some(voucher =>
          voucher?.promo_code === campaign?.campaignCode
        ))
      );
      filteredCampaigns.forEach(c => addPromoCode(c?.campaignCode));
      
      // หาแคมเปญที่ตรงกับ object handling voucher
      const matchedVoucherCampaign = isArrayVoucherDetails
        ? campaignInfoList.find(campaign =>
            objectHandlingVoucherDetails.some(voucher =>
              voucher?.promo_code === campaign?.campaignCode
            )
          )
        : null;
      
      const voucherElement = document.querySelector(`select[name="insured_auto_objecthandlingvouchers"]`);
      if (voucherElement) {
        voucherElement.value = matchedVoucherCampaign?.campaignCode || "";
      }
      

    } else {
    campaignInfoList.forEach(c => addPromoCode(c?.campaignCode));
    }

    
    
  } else {
    addPromoCode();
  }
};
const calculatePremiumFromCampaignCode = (dbData) => {
  const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";
  if (!isRenewal) return
  let getCampaignCodeFromRecalculate = null;
  try {
    getCampaignCodeFromRecalculate = dbData?.response_recalculate_json
      ? JSON.parse(dbData.response_recalculate_json)
      : null
  } catch (error) {
    console.error("Invalid response JSON:", error);
  }
  console.log("getCampaignCodeFromRecalculate?.campaignAndDiscountList", getCampaignCodeFromRecalculate?.campaignAndDiscountList)

  const campaignList = getCampaignCodeFromRecalculate?.campaignAndDiscountList;

  if (Array.isArray(campaignList) && campaignList.length > 0) {
    const filterCampaignIncludePremium = campaignList.filter(
      i => i?.type === 2 && i?.includedInPremium === true
    );

    const totalDiscount = filterCampaignIncludePremium.reduce((sum, item) => {
      return sum + (Number(item.amount) || 0);
    }, 0);
    console.log("totalDiscount",totalDiscount)
    // รับค่า input และ div สำหรับแสดงส่วนลด
    const paymentInput = document.getElementById("payment_amount");
    const discountSummary = document.getElementById("discount_summary");
      const originalAmount = Number(dbData?.premiumPayable) || 0; 
      const finalAmount = (originalAmount - totalDiscount).toFixed(2);

      console.log("originalAmount",originalAmount)
      console.log("finalAmount",finalAmount)
      paymentInput.value = `${finalAmount} (SGD)`; // ตั้งค่าคืนพร้อมหน่วย
    

    // แสดงรายการลดใน HTML
    if (discountSummary) {
      discountSummary.innerHTML = ""; // Clear previous content
    
      if (filterCampaignIncludePremium.length > 0) {
        const list = document.createElement("ul");
        list.style.margin = "0";
        list.style.paddingLeft = "20px";
        const liOrigin = document.createElement("li");
        liOrigin.textContent=`Original Amount: ${originalAmount.toFixed(2)} (SGD)`
        list.appendChild(liOrigin);
        filterCampaignIncludePremium.forEach(item => {
          const li = document.createElement("li");
          const amount = Number(item.amount);
          if (!isNaN(amount)) {
            li.textContent = `Discount from ${item.code}: ${amount.toFixed(2)} (SGD)`;
            list.appendChild(li);
          }
        });
    
        if (list.childElementCount > 0) {
          discountSummary.appendChild(list);
        } else {
          discountSummary.textContent = "No valid discounts included in the premium.";
        }
      } else {
        discountSummary.textContent = "No discounts included in the premium.";
      }
    }
    
  }
}
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

};
const setInsuredVehicleList = async(insuredData) => {
  console.log("setInsuredList vehicle")
  if (!insuredData || insuredData.length === 0) return;
  const vehicleInfo = insuredData[0].vehicleInfo;
  const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";
  const nameValue = isRenewal ? 'RNBrand':'brand'
  await fetchGetMake(nameValue)
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
  if(vehicleInfo.mileageCondition){
    handleMileageCondition()
  }
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
  ).value = driverInfo.driverDOB ? isoToFormattedDate(driverInfo.driverDOB):"";
  if (driverInfo.driverDOB) {
    const { age } = calculateAge(driverInfo.driverDOB);
    document.getElementById('ageDriver').value = age;
  }
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


  const claimExperienceElement = document.querySelector('select[name="insured_auto_driverInfo_claimExperience"]');
  if (claimExperienceElement) {
    claimExperienceElement.value = driverInfo.claimExperience;
    toggleClaimExperience(claimExperienceElement);
  }

  


  if (claimExperienceElement && claimExperienceElement.value==="Y") {
    const claimInfo = driverInfo.claimInfo && driverInfo.claimInfo[0] ? driverInfo.claimInfo[0] : {};

    const setValue = (selector, value) => {
      const element = document.querySelector(selector);
      if (element) {
        element.value = value || '';
      }
    };

    setValue('input[name="insured_auto_driverInfo_claimInfo_dateOfLoss"]', claimInfo.dateOfLoss ? isoToFormattedDate(claimInfo.dateOfLoss) : '');
    setValue('input[name="insured_auto_driverInfo_claimInfo_lossDescription"]', claimInfo.lossDescription);
    setValue('select[name="insured_auto_driverInfo_claimInfo_claimNature"]', claimInfo.claimNature);
    setValue('input[name="insured_auto_driverInfo_claimInfo_claimAmount"]', claimInfo.claimsAmount);
    setValue('select[name="insured_auto_driverInfo_claimInfo_claimStatus"]', String(claimInfo.status));
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