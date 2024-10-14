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
function handlePaymentModeChange(value) {
  if (value === "1001") {
    console.log("Credit Card Lump sum selected");
    // Add any additional logic for this option
  } else if (value === "124") {
    console.log("Recurring Credit Card selected");
    // Add any additional logic for this option
  } else {
    console.log("No valid option selected");
  }
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
const handleRetrieveQuote = async () => {
  const objectRetrieve = {
    "channelType": "10",
    "idNo": quotationData?.customer_id,
    "policyNo": quotationData?.quoteNo
  };

  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let is_firsttime = url.searchParams.get('is_firsttime');

  if (is_firsttime === "1") {
    handlePaymentGateway(quotationData?.premiumPayable, quotationData?.payment_mode);
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

    await jQuery.agent.updateRetrieveQuote(data, id, transformedData);

    const isPremiumPayableMatching =
      parseFloat(data?.premiumPayable) === parseFloat(quotationData?.premiumPayable);

    const isPaymentModeMatching =
      data?.paymentDetails[0]?.paymentMode === quotationData?.payment_mode;

    if (!isPremiumPayableMatching) {
      alert("Premium Payable does not match. It has changed to " + data?.premiumPayable + " " + data?.currency);
    }
    if (!isPaymentModeMatching) {
      alert("Payment Mode has changed.");
    }
    handlePaymentGateway(data?.premiumPayable, data?.paymentDetails[0]?.paymentMode);
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
    policyHolderInfo: {
      customerType: data.policyHolderInfo?.customerType || quotationData?.policyHolderInfo?.customerType || "0",
      individualPolicyHolderInfo: {
        courtesyTitle: data.policyHolderInfo?.individualPolicyHolderInfo?.courtesyTitle || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.courtesyTitle||"",
        fullName: data.policyHolderInfo?.individualPolicyHolderInfo?.fullName || quotationData?.fullname || "",
        residentStatus: data.policyHolderInfo?.individualPolicyHolderInfo?.residentStatus || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.residentStatus || "",
        customerIdType: data.policyHolderInfo?.individualPolicyHolderInfo?.customerIdType || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.customerIdType || "0",
        customerIdNo: data.policyHolderInfo?.individualPolicyHolderInfo?.customerIdNo || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.customerIdNo || "",
        nationality: data.policyHolderInfo?.individualPolicyHolderInfo?.nationality || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.nationality || "",
        gender: data.policyHolderInfo?.individualPolicyHolderInfo?.gender || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.gender || "",
        dateOfBirth: data.policyHolderInfo?.individualPolicyHolderInfo?.dateOfBirth ? retrieveTransformDate(data.policyHolderInfo?.individualPolicyHolderInfo?.dateOfBirth) : "",
        maritalStatus: data.policyHolderInfo?.individualPolicyHolderInfo?.maritalStatus || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.maritalStatus || "",
        occupation: data.policyHolderInfo?.individualPolicyHolderInfo?.occupation || quotationData?.policyHolderInfo?.individualPolicyHolderInfo?.occupation || "0"
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
                  name: cover.name || null
                }))
                : (quotationInsured.personInfo?.planInfo?.coverList || []).map(cover => ({
                  id: cover.id || "",
                  code: cover.code || null,
                  name: cover.name || null
                }))
            }
          }
        };
      } else if (formType === "home") {
        return {
            "addressInfo": {
              "dwellingType": insured?.addressInfo?.dwellingType|| quotationInsured?.addressInfo?.dwellingType||"",
              "flatType": insured?.addressInfo?.flatType||quotationInsured?.addressInfo?.flatType||"",
              "ownerOccupiedType":insured?.addressInfo?.ownedOrNot||quotationInsured?.addressInfo?.ownerOccupiedType||"",
              "floorOccupied": insured?.addressInfo?.floorOccupied||quotationInsured?.addressInfo?.floorOccupied||"",
              "constructionType": insured?.addressInfo?.constructionType||quotationInsured?.addressInfo?.constructionType||"941",
              "yearBuilt": insured?.addressInfo?.yearBuilt||quotationInsured?.addressInfo?.yearBuilt||"",
              "insuredBlockNo": insured?.addressInfo?.insuredBlockNo||quotationInsured?.addressInfo?.insuredBlockNo||"",
              "insuredStreetName": insured?.addressInfo?.insuredStreetName||quotationInsured?.addressInfo?.insuredStreetName||"",
              "insuredUnitNo": insured?.addressInfo?.insuredUnitNo||quotationInsured?.addressInfo?.insuredUnitNo||"",
              "insuredBuildingName": insured?.addressInfo?.insuredBuildingName||quotationInsured?.addressInfo?.insuredBuildingName||"",
              "insuredPostCode": insured?.addressInfo?.insuredPostCode||quotationInsured?.addressInfo?.insuredPostCode||""
              // "smokeDetectorAvailable": insured?.addressInfo?.smokeDetectorAvailable||quotationInsured?.addressInfo?.smokeDetectorAvailable||"1",
              // "autoSprinklerAvailable":insured?.addressInfo?.autoSprinklerAvailable||quotationInsured?.addressInfo?.autoSprinklerAvailable||"1",
              // "securitySystemAvailable":insured?.addressInfo?.securitySystemAvailable||quotationInsured?.addressInfo?.securitySystemAvailable||"1"
            },
            "planInfo": {
              "planId": insured?.planList[0]?.planId||quotationInsured?.planInfo?.planId||"",
              "planPoi": insured?.planList[0]?.planPoi||calllistDetail?.udf6 ||quotationInsured?.planInfo?.planPoi||"",
              "planDescription": insured?.planList[0]?.planName||quotationInsured?.planInfo?.planDescription||""
              // "coverList":quotationInsured?.planInfo?.coverList.length>0 ? [
              //   {
              //     "id": quotationInsured?.planInfo?.coverList[0]?.id||"",
              //     "code": quotationInsured?.planInfo?.coverList[0]?.code||"",
              //     "selectedFlag": quotationInsured?.planInfo?.coverList[0]?.selectedFlag||true
              //   }
              // ]:[]
            }
          }
      }
    }),
    paymentDetails: {
      paymentMode: data.paymentDetails[0]?.paymentMode || quotationData?.payment_mode || 124,
      paymentFrequency: data.paymentDetails[0]?.paymentFrequency || quotationData?.payment_frequency || 2,
    }

  };

  return transformedData;
};
const retrieveTransformDate = (dateString) => {

  const date = moment(dateString, "DD/MM/YYYY", true); // 'true' for strict parsing

  if (date.isValid()) {
    return date.utc().format('YYYY-MM-DDTHH:mm:ss[Z]');
  } else {
    return "Invalid date"; // Indicate that the date is invalid
  }
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

document.addEventListener("DOMContentLoaded", () => {
  fetchAgentDetail()
  document.getElementById("paymentModeSelect").addEventListener("change", function(event) {
    handlePaymentModeChange(event.target.value);
    const selectedProductId= document.getElementById("select-product")
    const paymentModeSelect= document.getElementById("paymentModeSelect")
    if(selectedProductId.value&&paymentModeSelect.value){
      populatePlansNormal(selectedProductId.value,null,paymentModeSelect.value)
    }
  });
});