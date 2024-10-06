let selectedType = null;
let campaignDetails = null;
let productDetail = null;


window.onload = function () {
  const defaultShowForm = (document.querySelector('input[name="customerType"]:checked'));
  if (defaultShowForm) {
    showForm(defaultShowForm)
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
  if (selectedType === "home") {
    [ncdinfoContainer, properateForm, insuredListAuto, insuredListAh].forEach(
      (container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      }
    );
  } else if (selectedType === "auto") {
    [ncdinfoContainer, properateForm, insuredListHome, insuredListAh].forEach(
      (container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      }
    );

    isPolicyHolderDrivingRow.style.display = "table-row";
  } else if (selectedType === "ah") {
    [ncdinfoContainer, properateForm, insuredListHome, insuredListAuto, planInfoContainer].forEach(
      (container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      }
    );
  }

  if (selectedType === "home") {
    insuredListHome.style.display = "block";
  } else if (selectedType === "auto") {
    ncdinfoContainer.style.display = "block";
    insuredListAuto.style.display = "block";
  } else if (selectedType === "ah") {
    insuredListAh.style.display = "block";
    planInfoContainer.style.display = "none"
  }
};
const toggleNcdLevel = () => {
  const ncdLevel = document.getElementById("ncdLevel").value;
  const noClaimExperienceRow = document.getElementById("noClaimExperienceRow");
  const haveExperienceRow = document.getElementById("haveExperienceRow");
  if (ncdLevel < 10) {
    noClaimExperienceRow.style.display = "";
    haveExperienceRow.style.display = "none";
  } else if (ncdLevel >= 10) {
    noClaimExperienceRow.style.display = "none";
    haveExperienceRow.style.display = "";
  }
};
const toggleNcdNoExperience = () => {
  const ncdNoExperience = document.getElementById("ncdNoExperience").value;
  const displayStyle = ncdNoExperience == "4" ? "block" : "none";
  document.getElementById("otherExperience").style.display = displayStyle;
};
const toggleClaimExperience = (selectedOption) => {
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


  const currentDate = moment().utc().startOf('day');
console.log("campaignDetails",campaignDetails)
  const policyDetail = {
    policyId: policyid ? policyid : "",
    productId: formData.get("select-product"),
    distributionChannel: 10,
    producerCode: calllistDetail[productDetail?.udf_field_producer_code]||"",
    // producerCode:"0002466000",
    // propDate:currentDate.format('YYYY-MM-DDTHH:mm:ss[Z]'),
    propDate:"",
    policyEffDate: formData.get("PolicyEffectiveDate")
      ? transformDate(formData.get("PolicyEffectiveDate"))
      : "",
    // campaignCode: campaignDetailsFromAPI?.campaign_uniqueid,
    campaignCode: "",
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
  } else if (formType === "ah") {
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
    // organizationPolicyHolderInfo: {
    //   natureOfBusiness: formData.get("natureOfBusiness"),
    //   companyName: formData.get("companyName"),
    //   companyRegNo: formData.get("companyRegNo"),
    //   companyRegDate: formData.get("companyRegDate"),
    // },
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
        declaredSI: formData.get("insured_auto_vehicle_declaredSI") || "",
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

    const paymentDetails = [{
      paymentMode: Number(formData.get('Payment_Mode')),
      paymentFrequency: Number(formData.get('Payment_Frequency')),
    }]
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
  console.log(planDetail);
  insuredObject.planInfo = planDetail;

  insuredList.push(insuredObject);
  const fullForm = {

    ...policyDetail,
    policyHolderInfo,
    insuredList,
    ...paymentDetail
  };
  return fullForm;
}
function getCoverList() {
  const coverList = [];
  const coverRows = document.querySelectorAll("#coverListBody .cover-row");

  coverRows.forEach((row) => {
    const coverSelect = row.querySelector(".planCoverList");
    const coverId = coverSelect ? coverSelect.value : "";

    const coverCodeElement = row.querySelector(".planCoverCode");
    const limitAmountElement = row.querySelector(".planCoverLimitAmount");
    const coverNameElement = row.querySelector(".coverName");
    const selectedFlagInput = row.querySelector(".selectedFlagInput");

    const coverCode = coverCodeElement
      ? coverCodeElement.innerText.trim()
      : "N/A";
    const limitAmount = limitAmountElement
      ? limitAmountElement.innerText.trim()
      : "0";
    const coverName = coverNameElement
      ? coverNameElement.innerText.trim()
      : "N/A";
    const selectedFlag = selectedFlagInput ? selectedFlagInput.value : "false";

    if (coverId) {
      coverList.push({
        id: coverId,
        code: coverCode,
        limitAmount: limitAmount
          ? parseFloat(limitAmount.replace(/,/g, ""))
          : 0, // Convert to float
        name: coverName,
        selectedFlag: selectedFlag === "true",
      });
    }
  });

  return coverList;
}

function getPlanDetail() {
  const formData = new FormData(document.querySelector("form")); // Assuming the form element is available
  const planListData = planData?.insuredList[0];
  console.log("planListData", planListData);
  const PlanDetail = {
    planId: planListData
      ? planListData?.planList[formData.get("planId")]?.planId
      : 0,
    planPoi: formData.get("planPoi"),
    planDescription: planListData
      ? planListData?.planList[formData.get("planId")]?.planDescription
      : "",
    coverList: getCoverList(),
  };

  return PlanDetail;
}

const handleValidateForm = () => {
  console.log("handleValidateForm");
  document
    .getElementById("application")
    .addEventListener("submit", async function (event) {
      event.preventDefault();
      console.log("Form submission triggered");

      // Create an instance of FormData from the form element
      const form = event.target;
      const formData = new FormData(form);

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

      if (!isValid) {
        alert("Please fill in all required fields.");
        return;
      }


      const requestBody = handleForm();
      console.log("requestBody", requestBody)
      const submitButton = document.querySelector("#btnEditForm");
      const shouldRecalculate = submitButton.getAttribute("data-recalculate") === "true";
      if (quotationData?.policyId && responsePayment?.result === "SUCCESS") {
        const paymentDetails = [
          {
            batchNo: responsePayment.batch_no,
            orderNo: responsePayment?.payment_order_id,
            paymentMode: quotationData?.payment_mode,
            merchantId: responsePayment.merchant,
            cardExpiryMonth: responsePayment.card_expiry_month,
            cardExpiryYear: responsePayment.card_expiry_year,
            paymentDate: new Date(responsePayment.time_of_lastupdate).toISOString(),
            paymentFrequency: quotationData.payment_frequency,
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
          policyEffDate: quotationData.policyEffDate ? moment(quotationData.policyEffDate).toISOString() : new Date().toISOString(),
          policyHolderInfo: quotationData?.policyHolderInfo,
        
          remarksC: quotationData.remarksC || "",
          efulfillmentFlag: quotationData.efulfillmentFlag || "1",
          paymentDetails
      };
        console.log("policyRequest:", policyRequest)
        
        await fetchPolicy(policyRequest);
       
      } else if(shouldRecalculate){
        const removePolicyId = {...requestBody,policyId:""}
        await fetchQuotation(removePolicyId);
        console.log("fetch Recalculate")

      }else{
        await fetchQuotation(requestBody);
        console.log("fetch quotation")
      }
    });
};


//handlePayment
document.addEventListener('DOMContentLoaded', function () {
  const paymentContainer = document.getElementById('payment-container');
  const submitButton = document.getElementById('btnPayment');

  if (!paymentContainer) {
    console.error('The payment container was not found');
    return;
  }

  // Function to get the data from the div elements
  function getFormDataPayment() {
    const selectElements = paymentContainer.querySelectorAll('select');
    const inputElements = paymentContainer.querySelectorAll('input');
    const formData = {};

    selectElements.forEach(select => {
      formData[select.name] = select.value;
    });

    inputElements.forEach(input => {
      if (input.type === 'radio' && input.checked) {
        formData[input.name] = input.value;
      } else if (input.type !== 'radio') {
        formData[input.name] = input.value;
      }
    });

    const [expMonth, expYear] = formData['payment_expiryDate'] ? formData['payment_expiryDate'].split('/').map(val => val.trim()) : ['', ''];

    return {
      apiOperation: "PAY",
      order: {
        amount: parseFloat(quotationData?.premiumPayable),
        currency: "SGD"
      },
      sourceOfFunds: {
        type: "CARD",
        provided: {
          card: {
            // number: "5123456789012346",
            number: formData['payment_cardNumber'],
            expiry: {
              month: expMonth,
              year: expYear
            }
            // securityCode: Number(formData['payment_securityCode'])
          }
        }
      }
    };
  }

  // function validateFields() {
  //   const paymentMode = document.querySelector('select[name="Payment_Mode"]').value;
  //   const paymentFrequency = document.querySelector('input[name="Payment_Frequency"]:checked');
  //   const cardType = document.querySelector('select[name="Payment_CardType"]').value;
  //   const cardNumber = document.querySelector('input[name="payment_cardNumber"]').value;
  //   const expiryDate = document.querySelector('input[name="payment_expiryDate"]').value;
  //   // const securityCode = document.querySelector('input[name="payment_securityCode"]').value;

  //   if (!paymentMode || !paymentFrequency || !cardType || !cardNumber || !expiryDate ) {
  //     window.alert('Please fill out all required fields.');
  //     return false;
  //   }

  //   return true;
  // }
  // if (submitButton) {
  //   submitButton.addEventListener('click', async function () {
  //     paymentContainer.removeAttribute('hidden');
  //     if (validateFields()) {
  //       const requestBody = getFormDataPayment();
  //       try {
  //         await fetchPayment(requestBody);
  //       } catch (error) {
  //         console.error("Failed to fetch payment data:", error);
  //         window.alert("Failed to fetch payment data. Please try again.");
  //       }
  //     }

  //   });
  // } else {
  //   console.error('The submit button was not found');
  // }


});
//initial

document.addEventListener("DOMContentLoaded", () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  selectedType = urlParams.get("formType");
  handleTypeConfirmQuote();
  getCampaignDetails()

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
  // manualSetDefaultValueForm();
  // manualSetInsuredPerson()
  // manualSetInsuredVehicleList();

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
  return `${month}/${day}/${year}`;
}
//datetoISO
const transformDate = (dateString) => {
  const date = moment.parseZone(dateString); // Keeps the original timezone information
  return date.utc().format('YYYY-MM-DDTHH:mm:ss[Z]');
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
