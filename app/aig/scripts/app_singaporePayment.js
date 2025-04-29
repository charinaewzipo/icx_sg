let agentDetail = null
function handlePaymentFrequencyChange(radio) {
  console.log("handlePaymentFrequencyChange");

  const paymentFrequency = radio.value;
  const paymentModeSelect = document.querySelector('select[name="Payment_Mode"]');
  // paymentModeSelect.value = "";
  const options = paymentModeSelect.options;
  for (let i = 0; i < options.length; i++) {
    const option = options[i];

    if (paymentFrequency === '2' && option.value === '1001') {
      option.hidden = true;
    } else {
      option.hidden = false;
    }
  }

  setPlanPoiValue(paymentFrequency);
}


// Attach the event listener to the payment mode select element

function setPlanPoiValue(paymentFrequency) {
  const planPoi = document.querySelector('select[name="planPoi1"]');

  if (paymentFrequency === '1') { // Annual
    planPoi.value = "12";
  } else if (paymentFrequency === '2') { // Monthly
    planPoi.value = "1";
  } else {
    planPoi.value = "";
  }

  console.log("planPoi value set to:", planPoi.value);
}

function fetchAgentDetail() {
  document.body.classList.add('loading');
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let agent_id = url.searchParams.get('agent_id');
  console.log("agent_id:", agent_id)
  fetch('../scripts/get_agent_data.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
      agent_id: agent_id
    })
  })
    .then(response => response.text())
    .then(data => {
      const result = JSON.parse(data)
      console.log("result:", result)
      agentDetail = result[0]

    })
    .catch(error => console.error('Error fetching cover list:', error))
    .finally(() => {
      document.body.classList.remove('loading');
    });
}



function fetchPaymentOption(paymentMode, paymentFrequency) {
  if (!paymentMode || !paymentFrequency) return;

  const url = `../scripts/get_payment_option.php?payment_mode=${paymentMode}&payment_frequency=${paymentFrequency}`;
  document.body.classList.add('loading');

  fetch(url)
    .then(response => response.json())
    .then(data => {
      const cardTypeSelect = document.querySelector('select[name="Payment_CardType"]');

      cardTypeSelect.innerHTML = `   <option value="">
                      <-- Please select an option -->
                    </option>`;

      data.forEach(item => {
        const cardOption = document.createElement('option');
        cardOption.value = item.id;
        cardOption.textContent = item.payment_mode_card_name;
        cardTypeSelect.appendChild(cardOption);
      });
      console.log("data:", data)
    })
    .catch(error => {
      console.error('Error fetching payment data:', error);
    })
    .finally(() => {
      document.body.classList.remove('loading');
    });
}

const handlePaymentValidateFormHome = () => {
  const form = document.getElementById("application");
  const formData = new FormData(form);
  let isValid = true;

  const fields = form.querySelectorAll("input:not([name='PolicyEffectiveDate']):not([name='dateOfBirth']), select, textarea,button:not(#btnSaveForm)");

  fields.forEach((field) => {
    if (
      field.style.display !== "none" && // Ensure the field is visible
      field.required &&                  // Only check required fields
      !formData.get(field.name)          // Verify value from FormData
    ) {
      console.log(`Error: ${field.name} is empty`);
      isValid = false;
      field.classList.add("error-border");
    } else {
      field.classList.remove("error-border");
    }
  });

  if (!isValid) {
    alert("Please Edit and fill in all required fields.");
    handleEditQuote()
  }

  return isValid;
};
const handlePaymentValidateFormAuto = () => {
  const form = document.getElementById("application");
  const formData = new FormData(form);
  let isValid = true;

  const fields = form.querySelectorAll("input:not([name='PolicyEffectiveDate']):not([name='dateOfBirth']):not([name='insured_auto_driverInfo_driverDOB']):not([name='insured_auto_driverInfo_claimInfo_dateOfLoss']), select, textarea,button:not(#btnSaveForm)");

  fields.forEach((field) => {
    if (
      field.style.display !== "none" && // Ensure the field is visible
      field.required &&                  // Only check required fields
      !formData.get(field.name)          // Verify value from FormData
    ) {
      console.log(`Error: ${field.name} is empty`);
      isValid = false;
      field.classList.add("error-border");
    } else {
      field.classList.remove("error-border");
    }
  });

  if (!isValid) {
    alert("Please Edit and fill in all required fields.");
    handleEditQuote()
  }

  return isValid;
};
const handleRetrieveQuote = async () => {
  const objectRetrieve = {
    "channelType": "10",
    "idNo": quotationData?.customer_id,
    "policyNo": quotationData?.quoteNo
  };

  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let is_firsttime = url.searchParams.get('is_firsttime');
  let formType = url.searchParams.get('formType');
  const paymentModeValue = document.getElementById("paymentModeSelect").value
  if (formType === "auto") {
    if (!handlePaymentValidateFormAuto()) {
      return
    }
  }
  if (!paymentModeValue) {
    alert("Payment Mode has no value");
    return;
  }
  if (formType === "home") {
    if (!handlePaymentValidateFormHome()) {
      return
    }
  }

  if (is_firsttime === "1") {
    if (formType === "auto" && Number(paymentModeValue) === 122) {
      handlePaymentGatewayIPP(quotationData?.premiumPayable)
      return
    }
    handlePaymentGateway(quotationData?.premiumPayable, Number(paymentModeValue));

  } else {
    const responseRetrieve = await fetchRetrieveQuote(objectRetrieve);
    console.log("responseRetrieve:", responseRetrieve);
    console.log("quotationData:", quotationData);

    if (!responseRetrieve) {
      alert("Quote Retrieval List Operation failed");
      return;
    }

    const { statusCode, quoteList, statusMessage } = responseRetrieve;
    if (statusCode !== "P00") {
      alert(statusMessage);
      return;
    }

    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);
    const transformedData = transformQuoteData(data, quotationData);
    console.log("transformedData", transformedData);
    const getPlanPoi = quoteList?.[0]?.Policy
    await jQuery.agent.updateRetrieveQuote(data, id, transformedData, objectRetrieve);
    const isPremiumPayableMatching =
      parseFloat(data?.premiumPayable) === parseFloat(quotationData?.premiumPayable);

    const isPaymentModeMatching =
      Number(data?.paymentDetails[0]?.paymentMode) === Number(paymentModeValue);

    if (!isPremiumPayableMatching) {
      alert("Premium Payable does not match. It has changed to " + data?.premiumPayable + " " + data?.currency);
    }
    if (!isPaymentModeMatching) {
      alert("Payment Mode has changed.");
    }

    if (formType === "auto" && Number(paymentModeValue) === 122) {
      handlePaymentGatewayIPP(data?.premiumPayable)
      return
    }
    handlePaymentGateway(data?.premiumPayable, data?.paymentDetails[0]?.paymentMode || Number(paymentModeValue));
  }


};
const handlePaymentGatewayIPP = async (premiumPayable) => {
  let bank = null;
  let countMonth = null;
  const cardTypeValue = document.getElementById("cardType").value
  if (Number(cardTypeValue) === 3) {
    bank = "uob";
    countMonth = 6;
  } else if (Number(cardTypeValue) === 6) {
    bank = "dbs";
    countMonth = 6;
  } else if (Number(cardTypeValue) === 4) {
    bank = "uob";
    countMonth = 12;
  }
  else if (Number(cardTypeValue) === 7) {
    bank = "dbs";
    countMonth = 12;
  }
  console.log("bank", bank)
  console.log("countMonth", countMonth)
  if (premiumPayable) {
    // const url = `payment.php?amount=${premiumPayable}&is_recurring=${isRecurring}&quoteNo=${quotationData?.quoteNo}`;
    const url = `payment_2c2p.php?amount=${premiumPayable}&quoteNo=${quotationData?.quoteNo}&bank=${bank}&ipp=${countMonth}`;

    // Open a new window for payment
    const childWindow = window.open(url, 'childWindow', 'width=600,height=480');

    handleSecurePause();


    const checkWindowClosed = setInterval(() => {
      if (childWindow.closed) {
        clearInterval(checkWindowClosed);
        handleUnsecurePause();
      }
    }, 1000);

  } else {
    console.log("No price", premiumPayable);
  }
};
const handlePaymentGateway = async (premiumPayable, paymentMode) => {
  // Retrieve Quote
  const isRecurring = paymentMode === 124 ? 1 : 0;

  if (premiumPayable) {
    const url = `payment.php?amount=${premiumPayable}&is_recurring=${isRecurring}&quoteNo=${quotationData?.quoteNo}`;

    // Open a new window for payment
    const childWindow = window.open(url, 'childWindow', 'width=600,height=480');

    handleSecurePause();


    const checkWindowClosed = setInterval(() => {
      if (childWindow.closed) {
        clearInterval(checkWindowClosed);
        handleUnsecurePause();
      }
    }, 1000);

  } else {
    console.log("No price", premiumPayable);
  }
};


function showAlert(message) {
  alert(message);
  setTimeout(() => {
    window.location.reload();
  }, 2000)
}

const transformQuoteData = (data, quotationData) => {
  console.log("data:", data)
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');

  const transformedData = {
    policyId: data.policyId || quotationData?.policyId || "",
    productId: data.productId || quotationData?.productId || "",
    producerCode: data.producerCode || quotationData?.producerCode || "",
    propDate: data.propDate ? retrieveTransformDate(data.propDate) : "",
    policyEffDate: data.policyEffDate ? retrieveTransformDate(data.policyEffDate) : "",
    policyExpDate: data.policyExpDate ? retrieveTransformDate(data.policyExpDate) : "",
    campaignCode: calllistDetail[productDetail?.udf_field_promo_code] || "",
    policyHolderInfo: {
      customerType: data.policyHolderInfo?.customerType || quotationData?.policyHolderInfo?.customerType || "0",
      individualPolicyHolderInfo: {
        courtesyTitle: data.policyHolderInfo?.individualPolicyHolderInfo?.courtesyTitle || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.courtesyTitle || "",
        fullName: data.policyHolderInfo?.individualPolicyHolderInfo?.fullName || quotationData?.fullname || "",
        residentStatus: data.policyHolderInfo?.individualPolicyHolderInfo?.residentStatus || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.residentStatus || "",
        customerIdType: data.policyHolderInfo?.individualPolicyHolderInfo?.customerIdType || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.customerIdType || "0",
        customerIdNo: data.policyHolderInfo?.individualPolicyHolderInfo?.customerIdNo || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.customerIdNo || "",
        nationality: data.policyHolderInfo?.individualPolicyHolderInfo?.nationality || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.nationality || "",
        gender: data.policyHolderInfo?.individualPolicyHolderInfo?.gender || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.gender || "",
        dateOfBirth: data.policyHolderInfo?.individualPolicyHolderInfo?.dateOfBirth ? retrieveTransformDate(data.policyHolderInfo?.individualPolicyHolderInfo?.dateOfBirth) : "",
        maritalStatus: data.policyHolderInfo?.individualPolicyHolderInfo?.maritalStatus || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.maritalStatus || "",
        occupation: data.policyHolderInfo?.individualPolicyHolderInfo?.occupation || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.occupation || "0",
        isPolicyHolderDriving: data?.policyHolderInfo?.individualPolicyHolderInfo?.isPolicyHolderDriving || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.isPolicyHolderDriving||"1"
    
      },
      contactInfo: {
        postCode: data.policyHolderInfo?.contactInfo?.postCode || quotationData?.policyHolderInfo?.contactInfo?.postCode || "",
        unitNo: data.policyHolderInfo?.contactInfo?.unitNo || quotationData?.policyHolderInfo?.contactInfo?.unitNo || "",
        blockNo: data.policyHolderInfo?.contactInfo?.blockNo || quotationData?.policyHolderInfo?.contactInfo?.blockNo || "",
        streetName: data.policyHolderInfo?.contactInfo?.streetName || quotationData?.policyHolderInfo?.contactInfo?.streetName || "",
        buildingName: data.policyHolderInfo?.contactInfo?.buildingName || quotationData?.policyHolderInfo?.contactInfo?.buildingName || "",
        emailId: data.policyHolderInfo?.contactInfo?.emailId || quotationData?.policyHolderInfo?.contactInfo?.emailId || "",
        mobileNo: data.policyHolderInfo?.contactInfo?.mobileNo || quotationData?.policyHolderInfo?.contactInfo?.mobileNo || ""
      }
    },
    insuredList: (data.insuredList || []).map((insured, index) => {
      console.log("insured:", insured)
      // Access the corresponding entry in quotationData using the same index
      const quotationInsured = (quotationData?.insuredList || [])[index] || {};
      console.log("quotationInsured:", quotationInsured)

      if (formType === "ah") {
        return {
          personInfo: {
            insuredFirstName: insured.personInfo?.insuredFirstName || quotationInsured.personInfo?.insuredFirstName || "",
            insuredFullName: insured.personInfo?.insuredFullName || quotationInsured.personInfo?.insuredFullName || "",
            insuredResidentStatus: insured.personInfo?.insuredResidentStatus || quotationInsured.personInfo?.insuredResidentStatus || "",
            insuredIdType: insured.personInfo?.insuredIdType || quotationInsured.personInfo?.insuredIdType || "0",
            insuredIdNumber: insured.insuredUniqueIdentifier || quotationInsured.insuredUniqueIdentifier || "",
            insuredGender: insured.personInfo?.insuredGender || quotationInsured.personInfo?.insuredGender || "",
            insuredDateOfBirth: insured.personInfo?.insuredDateOfBirth
              ? retrieveTransformDate(insured.personInfo?.insuredDateOfBirth) : ""
            ,
            insuredMaritalStatus: insured.personInfo?.insuredMaritalStatus || quotationInsured.personInfo?.insuredMaritalStatus || "",
            insuredOccupation: insured.personInfo?.insuredOccupation || quotationInsured.personInfo?.insuredOccupation || "0",
            insuredCampaignCode: insured.personInfo?.insuredCampaignCode || quotationInsured.personInfo?.insuredCampaignCode || "",
            relationToPolicyholder: insured.personInfo?.relationToPolicyholder || quotationInsured.personInfo?.relationToPolicyholder,
            planInfo: {
              planId: (insured.planList[0]?.planId || quotationInsured.personInfo?.planInfo?.planId || ""),
              planDescription: (insured.planList[0]?.planName || quotationInsured.personInfo?.planInfo?.planDescription || ""),
              planPoi: (insured.planList[0]?.planPoi || quotationInsured.personInfo?.planInfo?.planPoi || ""), // Assuming this is constant
              coverList: (insured.planList[0]?.coverList ? Object.values(insured.planList[0].coverList) : []).length > 0
                ? Object.values(insured.planList[0].coverList).map(cover => ({
                  id: cover.id || "",
                  code: cover.code || null,
                  name: cover.name || null,
                  selectedFlag: true
                }))
                : (quotationInsured.personInfo?.planInfo?.coverList || []).map(cover => ({
                  id: cover.id || "",
                  code: cover.code || null,
                  name: cover.name || null,
                  selectedFlag: true
                }))
            }
          }
        };
      } else if (formType === "home") {
        return {
          "addressInfo": {
            "dwellingType": insured?.addressInfo?.dwellingType || quotationInsured?.addressInfo?.dwellingType || "",
            "flatType": insured?.addressInfo?.flatType || quotationInsured?.addressInfo?.flatType || "",
            "ownerOccupiedType": insured?.addressInfo?.ownedOrNot || quotationInsured?.addressInfo?.ownerOccupiedType || "",
            "floorOccupied": insured?.addressInfo?.floorOccupied || quotationInsured?.addressInfo?.floorOccupied || "",
            "constructionType": insured?.addressInfo?.constructionType || quotationInsured?.addressInfo?.constructionType || "941",
            "yearBuilt": insured?.addressInfo?.yearBuilt || quotationInsured?.addressInfo?.yearBuilt || "",
            "insuredBlockNo": insured?.addressInfo?.insuredBlockNo || quotationInsured?.addressInfo?.insuredBlockNo || "",
            "insuredStreetName": insured?.addressInfo?.insuredStreetName || quotationInsured?.addressInfo?.insuredStreetName || "",
            "insuredUnitNo": insured?.addressInfo?.insuredUnitNo || quotationInsured?.addressInfo?.insuredUnitNo || "",
            "insuredBuildingName": insured?.addressInfo?.insuredBuildingName || quotationInsured?.addressInfo?.insuredBuildingName || "",
            "insuredPostCode": insured?.addressInfo?.insuredPostCode || quotationInsured?.addressInfo?.insuredPostCode || ""
            },
          "planInfo": {
            "planId": insured?.planList[0]?.planId || quotationInsured?.planInfo?.planId || "",
            "planPoi": insured?.planList[0]?.planPoi || quotationInsured?.planInfo?.planPoi || "",
            "planDescription": insured?.planList[0]?.planName || quotationInsured?.planInfo?.planDescription || "",
            "planCode": insured?.planList[0]?.planCode || ""
            
          }
        }
      } else if (formType === "auto") {
        return {
          "vehicleInfo": {
            "make": insured?.vehicleInfo?.make || quotationInsured?.vehicleInfo?.make || "",
            "model": insured?.vehicleInfo?.model || quotationInsured?.vehicleInfo?.model || "",
            "vehicleRegYear": insured?.vehicleInfo?.vehicleRegYear || quotationInsured?.vehicleInfo?.vehicleRegYear || "",
            "regNo": insured?.vehicleInfo?.regNo || quotationInsured?.vehicleInfo?.regNo || "",
            "insuringWithCOE": insured?.vehicleInfo?.insuringWithCOE || quotationInsured?.vehicleInfo?.insuringWithCOE || "",
            "ageConditionBasis": insured?.vehicleInfo?.ageConditionBasis || quotationInsured?.vehicleInfo?.ageConditionBasis || "",
            "offPeakCar": insured?.vehicleInfo?.offPeakCar || quotationInsured?.vehicleInfo?.offPeakCar || "",
            "vehicleUsage": insured?.vehicleInfo?.vehicleUsage || quotationInsured?.vehicleInfo?.vehicleUsage || "",
            "mileageCondition": insured?.vehicleInfo?.mileageCondition || quotationInsured?.vehicleInfo?.mileageCondition || "",
            "engineNo": insured?.vehicleInfo?.engineNo || quotationInsured?.vehicleInfo?.engineNo || "",
            "chassisNo": insured?.vehicleInfo?.chassisNo || quotationInsured?.vehicleInfo?.chassisNo || "",
            "mileageDeclaration": insured?.vehicleInfo?.mileageDeclaration || quotationInsured?.vehicleInfo?.mileageDeclaration || "",
            "hirePurchaseCompany": insured?.vehicleInfo?.hirePurchaseCompany || quotationInsured?.vehicleInfo?.hirePurchaseCompany || ""

          },
          "driverInfo": [
            {
              "driverType": insured?.driverInfo?.[0]?.driverType || quotationInsured?.driverInfo?.[0]?.driverType || "",
              "driverDOB": insured?.driverInfo?.[0]?.driverDOB
                ? retrieveTransformDate(insured?.driverInfo?.[0]?.driverDOB)
                : retrieveTransformDate(quotationInsured?.driverInfo?.[0]?.driverDOB) || "",
              "driverGender": insured?.driverInfo?.[0]?.driverGender || quotationInsured?.driverInfo?.[0]?.driverGender || "",
              "driverMaritalStatus": insured?.driverInfo?.[0]?.driverMaritalStatus || quotationInsured?.driverInfo?.[0]?.driverMaritalStatus || "",
              "drivingExperience": insured?.driverInfo?.[0]?.drivingExperience || quotationInsured?.driverInfo?.[0]?.drivingExperience || "",
              "occupation": insured?.driverInfo?.[0]?.occupation || quotationInsured?.driverInfo?.[0]?.occupation || "",
              "claimExperience": insured?.driverInfo?.[0]?.claimExperience || quotationInsured?.driverInfo?.[0]?.claimExperience || "",
              "claimInfo": Array.isArray(insured?.driverInfo?.[0]?.claimInfo) && insured?.driverInfo?.[0]?.claimInfo.length > 0
                ? insured?.driverInfo?.[0]?.claimInfo.map(claim => ({
                  claimNature: claim.claimNature || "",
                  claimsAmount: claim.claimsAmount || "",
                  dateOfLoss: claim.dateOfLoss ? retrieveTransformDate(claim.dateOfLoss) : "",
                  insuredLiability: claim.insuredLiability || "",
                  lossDescription: claim.lossDescription || "",
                  status: claim.status || ""
                }))
                : Array.isArray(quotationInsured?.driverInfo?.[0]?.claimInfo)
                  ? quotationInsured.driverInfo[0].claimInfo.map(claim => ({
                    claimNature: claim.claimNature || "",
                    claimsAmount: claim.claimsAmount || "",
                    dateOfLoss: claim.dateOfLoss ? retrieveTransformDate(claim.dateOfLoss) : "",
                    insuredLiability: claim.insuredLiability || "",
                    lossDescription: claim.lossDescription || "",
                    status: claim.status || ""
                  }))
                  : [],
              "driverName": insured?.driverInfo?.[0]?.driverName || quotationInsured?.driverInfo?.[0]?.driverName || "",
              "driverIdNumber": insured?.driverInfo?.[0]?.driverIdNumber || quotationInsured?.driverInfo?.[0]?.driverIdNumber || "",
              "driverIdType": insured?.driverInfo?.[0]?.driverIdType || quotationInsured?.driverInfo?.[0]?.driverIdType || "",
              "driverResidentStatus": insured?.driverInfo?.[0]?.driverResidentStatus || quotationInsured?.driverInfo?.[0]?.driverResidentStatus || "",
              "driverNationality": insured?.driverInfo?.[0]?.driverNationality || quotationInsured?.driverInfo?.[0]?.driverNationality || ""
            }
          ],
          "planInfo": {
            "planId": insured?.planList?.[0]?.planId || quotationInsured?.planList?.[0]?.planId || "",
            "planPoi": insured?.planList?.[0]?.planPoi || quotationInsured?.planList?.[0]?.planPoi || "",
            "planCode": insured?.planList?.[0]?.planCode || quotationInsured?.planList?.[0]?.planCode || "",
            "coverList": (insured.planList[0]?.coverList ? Object.values(insured.planList[0].coverList) : []).length > 0
              ? Object.values(insured.planList[0].coverList).map(cover => (
                {
                id: cover.id || "",
                code: cover.code || null,
                name: cover.name || null,
                selectedFlag: cover?.selectedFlag !== undefined ? cover?.selectedFlag : true,
                buyUpOrbuyDownExcess:cover?.buyUpOrbuyDownExcess||null,
                autoAttached:cover?.autoAttached||null,
                optionalFlag:cover?.optionalFlag||null,
                premium:cover?.premium||null

              }))
              : (quotationInsured.personInfo?.planInfo?.coverList || []).map(cover => ({
                id: cover.id || "",
                code: cover.code || null,
                name: cover.name || null,
                selectedFlag: cover?.selectedFlag !== undefined ? cover?.selectedFlag : true,
                buyUpOrbuyDownExcess:cover?.buyUpOrbuyDownExcess||null,
                autoAttached:cover?.autoAttached||null,
                optionalFlag:cover?.optionalFlag||null,
                premium:cover?.premium||null
              }))

          }
        };
      }
    }),
    paymentDetails: {
      paymentMode: data.paymentDetails[0]?.paymentMode || quotationData?.payment_mode || "",
      paymentFrequency: data.paymentDetails[0]?.paymentFrequency || quotationData?.payment_frequency || "",
    }

  };  
  if (formType === "auto") {
    console.log("transformedData",transformedData)
    return {
      ...transformedData, ncdInfo: {
        ncdLevel: data?.ncdInfo?.ncdLevel || quotationData?.ncdInfo?.ncdLevel || 0,
        previousInsurer: data?.ncdInfo?.previousInsurer || quotationData?.ncdInfo?.previousInsurer || "",
        previousPolicyNo: data?.ncdInfo?.previousPolicyNo || quotationData?.ncdInfo?.previousPolicyNo || "",
        noClaimExperience: data?.ncdInfo?.noClaimExperience || quotationData?.ncdInfo?.noClaimExperience || "",
        noClaimExperienceOther: data?.ncdInfo?.noClaimExperienceOther || quotationData?.ncdInfo?.noClaimExperienceOther || ""
      },campaignInfoList:getCampaignInfoList(),campaignCode:""
     
    }
  }
  return transformedData;
};
const retrieveTransformDate = (dateString) => {
  const [day, month, year] = dateString.split('/').map(Number);

  if (!day || !month || !year || month > 12 || day > 31) {
    return "Invalid date";
  }

  const date = new Date(Date.UTC(year, month - 1, day));

  if (isNaN(date.getTime())) {
    return "Invalid date";
  }

  return date.toISOString();
};

$(function () {
  $.ajaxSetup({
    url: "../Application/app_process.php"
  })
});
let intervalId;
let min = 0;
let sec = 0;
const handleSecurePause = () => {
  let voiceid = localStorage.getItem("voiceid");
  let lastInteraction = localStorage.getItem("lastInteraction");
  localStorage.setItem("securepause", true);
  $.ajax({
    'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'PAUSED', 'agentid': agentDetail?.genesysid },
    'dataType': 'html',
    'type': 'POST',
    'success': function (data) {
      let response = eval('(' + data + ')');
      console.log("response:", response)
      if (response.result) {
        if (response.data.recordingState == "PAUSED") {
          displayPauseTime();
        }
        console.log('Recording state1 ' + response.data.recordingState);
        // alert('Recording state1 ' + response.data.recordingState);
      } else {
        console.log('Recording state2 ' + response.data);
      }
    }
  });
}
const handleUnsecurePause = () => {
  let voiceid = localStorage.getItem("voiceid");
  let lastInteraction = localStorage.getItem("lastInteraction");
  $.ajax({
    'data': { 'action': 'geneRecordingState', 'voiceid': voiceid, 'lastInteraction': lastInteraction, 'state': 'ACTIVE', 'agentid': agentDetail?.genesysid },
    'dataType': 'html',
    'type': 'POST',
    'success': function (data) {
      let response = eval('(' + data + ')');
      if (response.result) {
        localStorage.removeItem("securepause");
        clearPauseTime();
        console.log('Recording state1 ' + response.data.recordingState);
      } else {
        localStorage.removeItem("securepause");
        clearPauseTime();
        console.log('Recording state2 ' + response.data);
      }
    }
  });
}
function displayPauseTime() {
  if (intervalId == null) {
    min = 0;
    sec = 0;
    intervalId = setInterval(pauseTimer, 1000);
    //console.log("intervalId",intervalId);
  }
}
function pauseTimer() {
  window.focus();
  sec++;
  if (sec >= 60) {
    sec = 0;
    min++;
  }
}
function clearPauseTime() {
  // document.title = "Application Form";
  // document.getElementById("pauseDisplay").innerHTML = "";
  clearInterval(intervalId);
  intervalId = null;
}


const handleCardTypeIPP = () => {
  const paymentMode = document.getElementById("paymentModeSelect")
  const cardTypeDisplay = document.getElementById("cardTypeDisplay")
  const cardTypeSelect = document.getElementById("cardType");
  //IPP
  if (Number(paymentMode.value) === 122) {
    cardTypeDisplay.style.display = "table-row";
    cardTypeSelect.setAttribute("required", "required"); // ทำให้ required
  } else {
    cardTypeDisplay.style.display = "none"
    cardTypeSelect.removeAttribute("required"); // ยกเลิก required
    cardTypeSelect.value = ""; // รีเซ็ตค่า
  }
}

const handleSecureFlow = () => {
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  const quoteNo=document.getElementById("policyid-input").value
  const payment_amount=document.getElementById("payment_amount").value
  const paymentModeValue = document.getElementById("paymentModeSelect").value
  const voiceId = localStorage.getItem('voiceid');
  const isRecurring = paymentModeValue === 124 ? 1 : 0;
  const params = new URLSearchParams({
    voice_id: voiceId,
    quote_no: quoteNo,
    amount: Number(payment_amount.replace("(SGD)","")),
    is_recurring: isRecurring,
    payment_frequency: paymentModeValue
  });

 
  if(!voiceId) return window.alert("Please Make Call")
  if (formType === "auto") {
    if (!handlePaymentValidateFormAuto()) {
      return
    }
  }
  if (!paymentModeValue) {
    alert("Payment Mode has no value");
    return;
  }
  if (formType === "home") {
    if (!handlePaymentValidateFormHome()) {
      return
    }
  }
  window.open(
    `payment_secureflow_mastercard.php?${params.toString()}`,
    'PaymentWindow',
    'width=800,height=600'
  );
};
const handleCheckTokenSecureFlow = (paymentResponse) => {
  const secureflowPaymentbutton = document.getElementById("secure_flow");
  const btnPaymentMasterCard = document.getElementById("btnPayment");
  const payment_secure_flow = document.getElementById("payment_secure_flow");
  const btnEditForm = document.getElementById("btnEditForm");
  
  console.log("paymentResponse:", paymentResponse);

  if (paymentResponse?.result === "success") {
    secureflowPaymentbutton.disabled = true;
    secureflowPaymentbutton.style.opacity = 0.65;

    btnPaymentMasterCard.disabled = true;
    btnPaymentMasterCard.style.opacity = 0.65;
    
    btnEditForm.disabled = true;
    btnEditForm.style.opacity = 0.65;

    payment_secure_flow.style.display = "inline";
    payment_secure_flow.style.opacity = 1;
  }
};

const handlePaymentSecureFlow =async () => {
  console.log("paymentResponseSecureFlow", paymentResponseSecureFlow);
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let is_firsttime = url.searchParams.get('is_firsttime');
  const quoteNo = document.getElementById("policyid-input")?.value?.trim();
  const rawAmount = document.getElementById("payment_amount")?.value?.replace("(SGD)", "").trim();
  const paymentModeValue = document.getElementById("paymentModeSelect")?.value;
  const voice_id = paymentResponseSecureFlow?.payment_order_id;
  const tokenId = paymentResponseSecureFlow?.payment_token_id;

  const amount = parseFloat(rawAmount);
  const textresposne = paymentResponseSecureFlow?.response_json;
  const response = JSON.parse(textresposne);
  console.log(" response:", response)

  const cardNumber = response?.sourceOfFunds?.provided?.card?.number || '-';
  const brand = response?.sourceOfFunds?.provided?.card?.brand || '-';
  const expiry = response?.sourceOfFunds?.provided?.card?.expiry || '-';
  const result = response?.result || '-';
  // Validation for required fields
  if (!quoteNo || isNaN(amount) || !paymentModeValue || !tokenId) {
    console.log("❌ Validation failed before payment:");
    console.log("quoteNo:", quoteNo);
    console.log("amount:", amount, "isNaN(amount):", isNaN(amount));
    console.log("paymentModeValue:", paymentModeValue);
    console.log("tokenId:", tokenId);

    alert("กรุณากรอกข้อมูลให้ครบถ้วนก่อนชำระเงิน");
    return;
  }

  const isRecurring = paymentModeValue === "124" ? 1 : 0;



  let payload = {
    quote_no: quoteNo,
    voice_id,
    amount,
    tokenId,
    is_recurring: isRecurring,
    payment_frequency: paymentModeValue,
    brand:brand
  };
  let confirmMessage =   `Please confirm the following payment details:\n\n` +
  `Payment Token Result: ${result}\n` +
  `Card: ${cardNumber}\n` +
  `Brand: ${brand}\n` +
  `Amount: ${amount}(SGD)\n` 

  if (is_firsttime === "1") {
    const userConfirmed = window.confirm(confirmMessage);
    if (!userConfirmed) return;
    callPaySecureflow(payload)
  } else {
    const objectRetrieve = {
      "channelType": "10",
      "idNo": quotationData?.customer_id,
      "policyNo": quotationData?.quoteNo
    };
    const responseRetrieve = await fetchRetrieveQuote(objectRetrieve);
    console.log("responseRetrieve:", responseRetrieve);
    console.log("quotationData:", quotationData);

    if (!responseRetrieve) {
      alert("Quote Retrieval List Operation failed");
      return;
    }

    const { statusCode, quoteList, statusMessage } = responseRetrieve;
    if (statusCode !== "P00") {
      alert(statusMessage);
      return;
    }

    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);
    const transformedData = transformQuoteData(data, quotationData);
    console.log("transformedData", transformedData);
    await jQuery.agent.updateRetrieveQuote(data, id, transformedData, objectRetrieve);
    const isPremiumPayableMatching =
      parseFloat(data?.premiumPayable) === parseFloat(quotationData?.premiumPayable);

    const isPaymentModeMatching =
      Number(data?.paymentDetails[0]?.paymentMode) === Number(paymentModeValue);

    if (!isPremiumPayableMatching) {
      alert("Premium Payable does not match. It has changed to " + data?.premiumPayable + " " + data?.currency);
    }
    if (!isPaymentModeMatching) {
      alert("Payment Mode has changed.");
    }
    payload={...payload,amount:data?.premiumPayable}
    confirmMessage= `Please confirm the following payment details:\n\n` +
    `Payment Token Result: ${result}\n` +
    `Card: ${cardNumber}\n` +
    `Brand: ${brand}\n` +
    `Amount: ${payload.amount}(SGD)\n`
    const userConfirmed = window.confirm(confirmMessage);
    if (!userConfirmed) return;
    callPaySecureflow(payload)
    
  }


};
const callPaySecureflow=async(payload)=>{
  document.body.classList.add('loading');
  fetch('pay_secureflow_mastercard.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(response => response.text())
  .then(responseText => {
    console.log("Raw Response:", responseText);

    try {
      const cleanedResponse = responseText.trim();
      const jsonResponse = JSON.parse(cleanedResponse);
      console.log("JSON Response:", jsonResponse);

      if (jsonResponse.success) {
        alert('Payment successfully!');
        window.location.reload();
      } else {
        alert(`Payment failed! Error details:  ${jsonResponse?.message ? JSON.stringify(jsonResponse.message, null, 2) : ""}`);
        // alert(`Payment failed! Error , Please try again`);
        console.warn('Payment error response:', jsonResponse);
      }
    } catch (error) {
      console.error("Error parsing JSON:", error);
      alert('Error occurred during payment process. Please check the response from the server.');
    }
  })
  .catch(err => {
    console.error('Fetch error:', err);
    alert('Error occurred during payment process.');
  }).finally(()=> document.body.classList.remove('loading'))
}


const handleDisplaySecureFlow=()=>{
  const defaultPaymentDisplay=document.getElementById("default-payment-display");
  const alternatePaymentDisplay=document.getElementById("alternate-payment-display");
  const paymentModeSelect = document.getElementById("paymentModeSelect")
  const checkboxOpt=document.getElementById("payment_checkbox")
  const paymentComment=document.getElementById("payment_comment")
  const interval = setInterval(()=>{
    if(paymentModeSelect&&paymentModeSelect.value!=""){
      clearInterval(interval)
      if(Number(paymentModeSelect.value)===122){
        defaultPaymentDisplay.style.display="none"
        alternatePaymentDisplay.style.display="table-row"
      }else if(quotationData?.is_secureflow_not_use==="1"){
        checkboxOpt.checked=true;
        handleCheckbox()
        paymentComment.value=quotationData?.secureflow_comment||"";
        alternatePaymentDisplay.style.display="table-row"
        defaultPaymentDisplay.style.display="table-row"

      }else{
        defaultPaymentDisplay.style.display="table-row"
        alternatePaymentDisplay.style.display="none"
      }
    }
  },300) 
}
const handleCheckbox=()=>{
  const checkbox = document.getElementById("payment_checkbox");
    const commentInput = document.getElementById("payment_comment");

    checkbox.addEventListener("change", () => {
      commentInput.disabled = !checkbox.checked;
      if (!checkbox.checked) {
        commentInput.value = ""; 
      }
    });
}
document.addEventListener("DOMContentLoaded", () => {
  fetchAgentDetail()


  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  if (formType === "home") {

    document.getElementById("paymentModeSelect").addEventListener("change", function (event) {
      const selectedProductId = document.getElementById("select-product")
      const paymentModeSelect = document.getElementById("paymentModeSelect")
      if (selectedProductId.value && paymentModeSelect.value) {
        populatePlansNormal(selectedProductId.value, null, paymentModeSelect.value)
      }
    });
    
  }

  //paymentSecureflow
  handleCheckbox()
  document.getElementById("paymentModeSelect").addEventListener("change", handleDisplaySecureFlow);
  setTimeout(() => {
    handleDisplaySecureFlow()
  }, 1000);
  document.getElementById('payment_secure_flow').addEventListener('click', function () {
    handlePaymentSecureFlow()
  });
});