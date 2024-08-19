let selectedType = null;
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
function handleCategoryCampaign() {
  const typeSelect = document.getElementById("select-type");
  const categorySelect = document.getElementById("category-select");
  const campaignSelect = document.getElementById("campaign-select");
  const campaignCode = document.getElementById("campaign-code");
  const categoryCampaignDiv = document.getElementById("category-campaign");
  const subPlanDiv = document.getElementById("sub-plan-select");

  const optionsData = {
    home: {
      "new-business": [
        {
          value: "EPHCI",
          text: "EPHCI",
          code: 600001,
        },
        {
          value: "Homes Essential",
          text: "Homes Essential",
          code: 600002,
        },
        {
          value: "Homes Advantage Package",
          text: "Homes Advantage Package",
          code: 600003,
        },
      ],
      renewal: [
        {
          value: "EPHCI",
          text: "EPHCI",
          code: 600005,
        },
        {
          value: "Homes Essential",
          text: "Homes Essential",
          code: 600004,
        },
        {
          value: "Homes Advantage Package",
          text: "Homes Advantage Package",
          code: 600006,
        },
        {
          value: "PHPP",
          text: "PHPP",
          code: 600007,
        },
      ],
    },
    auto: {
      "new-business": [
        {
          value: "ASP",
          text: "ASP",
          code: 600101,
        },
        {
          value: "CAHP",
          text: "CAHP",
          code: 600102,
        },
        {
          value: "CCIP",
          text: "CCIP",
          code: 600103,
        },
      ],
      pom: [
        {
          value: "DHI",
          text: "DHI",
          code: 600201,
        },
        {
          value: "Max PA",
          text: "Max PA",
          code: 600202,
        },
      ],
    },
  };

  const urlParams = new URLSearchParams(window.location.search);
  const selectedType = urlParams.get("formType");

  if (selectedType) {
    typeSelect.value = selectedType;
    handleTypeChange(selectedType);
  }

  typeSelect.addEventListener("change", function () {
    handleTypeChange(this.value);
  });

  categorySelect.addEventListener("change", function () {
    const selectedCategory = this.value;
    if (selectedCategory) {
      subPlanDiv.style.display = "block";
      campaignSelect.innerHTML =
        '<option value=""><-- Please select a campaign --></option>';
      optionsData[typeSelect.value][selectedCategory].forEach((campaign) => {
        const option = document.createElement("option");
        option.value = campaign.code;
        option.textContent = campaign.text;
        campaignSelect.appendChild(option);
      });
    } else {
      subPlanDiv.style.display = "none";
    }
    campaignSelect.addEventListener("change", function () {
      campaignCode.value = this.value;
    });
  });

  function handleTypeChange(selectedType) {
    categoryCampaignDiv.style.display = selectedType ? "block" : "none";
    categorySelect.innerHTML =
      '<option value=""><-- Please select a category --></option>';
    campaignSelect.innerHTML =
      '<option value=""><-- Please select a campaign --></option>';
    subPlanDiv.style.display = "none";

    if (selectedType) {
      Object.keys(optionsData[selectedType]).forEach((category) => {
        const option = document.createElement("option");
        option.value = category;
        option.textContent = category.replace(/-/g, " ");
        categorySelect.appendChild(option);
      });
    }
  }
}

function clearPlanInfo() {
  planData = null;
  var planSelect = document.getElementById("planSelect");
  var planPoiSelect = document.getElementById("planPoiSelect");
  var planCoverList = document.getElementById("planCoverList");
  var planCoverCode = document.getElementById("planCoverCode");
  var planCoverLimitAmount = document.getElementById("planCoverLimitAmount");
  planSelect.innerHTML =
    '<option value=""> <-- Please select an option --> </option>';
  planPoiSelect.value = null;
  planCoverList.innerHTML =
    '<option value=""> <-- Please select an option --> </option>';
  planCoverCode.innerHTML = null;
  planCoverLimitAmount.innerHTML = null;
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
      clearPlanInfo();
    });
  });
  handleTypeConfirmQuote();
};

const handleTypeConfirmQuote = () => {
  const ncdinfoContainer = document.getElementById("ncd-info-container");
  const remarkC = document.getElementById("remark-c-contanier");
  const remarkCInput = document.getElementById("remark-c-input");
  const insuredListHome = document.getElementById("insured-list-home");
  const insuredListAuto = document.getElementById("insured-list-auto");
  const insuredListAh = document.getElementById("insured-list-ah");
  const properateForm = document.getElementById("properateForm");
  const ncdNoExperience = document.getElementById(
    "insured_auto_driverInfo_claimExperience"
  );
  const claimInfo = document.getElementById("claim-info");
  ncdinfoContainer.style.display = "none";
  remarkC.style.display = "none";
  remarkCInput.style.display = "none";
  insuredListHome.style.display = "none";
  insuredListAuto.style.display = "none";
  insuredListAh.style.display = "none";

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
    if (ncdNoExperience === "N") {
      claimInfo.forEach((container) => {
        container.querySelectorAll("input, select").forEach((field) => {
          field.removeAttribute("required");
        });
      });
    }
  } else if (selectedType === "ah") {
    [ncdinfoContainer, properateForm, insuredListHome, insuredListAuto].forEach(
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
    remarkC.style.display = "table-cell";
    remarkCInput.style.display = "table-cell";
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
  const displayStyle = ncdNoExperience == "0" ? "block" : "none";
  document.getElementById("otherExperience").style.display = displayStyle;
};
const toggleClaimExperience = (selectedOption) => {
  const ncdNoExperience = document.getElementById("claim-info");
  const displayStyle = selectedOption.value == "Y" ? "block" : "none";
  ncdNoExperience.style.display = displayStyle;
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

const clearForm = () => {
  document
    .getElementById("btnClearForm")
    .addEventListener("click", function () {
      console.log("clear");
      const form = document.getElementById("application");
      form.reset(); // This resets all form fields to their default values
      form.querySelectorAll("[required]").forEach((field) => {
        field.style.borderColor = ""; // Reset the border color if any fields were highlighted
      });
    });
};
function handleForm() {
  const formType = getTypeSelectForm();
  const customerType = getTypeCustomerType();
  console.log("customerType", customerType);
  const formData = new FormData(document.getElementById("application"));
  let insuredList = [];
  ////////////////handlePocicyDetail form
  const policyDetail = {
    policyId: policyid ? policyid:"",
    productId: 600000080,
    distributionChannel: 10,
    producerCode: "0002466000",
    propDate: "",
    policyEffDate: formData.get("PolicyEffectiveDate")
      ? transformDate(formData.get("PolicyEffectiveDate"))
      : "",
    policyExpDate: formData.get("PolicyExpiryDate")
      ? transformDate(formData.get("PolicyExpiryDate"))
      : "",
    campaignCode: formData.get("campaignCode"),
  };
  if (formType === "auto") {
    policyDetail.ncdInfo = {
      ncdLevel: 0,
      previousInsurer: "NCD0033",
      previousPolicyNo: "prev123",
      noClaimExperienceOther: "",
    };
    // policyDetail.ncdInfo = {};
    // policyDetail.ncdInfo.ncdLevel = Number(formData.get("Ncd_Level"));
    // policyDetail.ncdInfo.previousInsurer = formData.get(
    //   "haveEx-PreviousInsurer"
    // );
    // policyDetail.ncdInfo.previousPolicyNo = formData.get(
    //   "haveEx-PreviousPolicyNo"
    // );
    // policyDetail.ncdInfo.noClaimExperience = formData.get("NoClaimExperience");
    // policyDetail.ncdInfo.noClaimExperienceOther =
    //   formData.get("otherExperience");
  } else if (formType === "ah") {
    policyDetail.remarkC = formData.get("RemarkCInput");
  }

  ////////////////handlePolicyholder form

  const fullName = formData.get("firstName") + " " + formData.get("lastName");
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
    organizationPolicyHolderInfo: {
      natureOfBusiness: formData.get("natureOfBusiness"),
      companyName: formData.get("companyName"),
      companyRegNo: formData.get("companyRegNo"),
      companyRegDate: formData.get("companyRegDate"),
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
          // occupation: formData.get("insured_auto_driverInfo_occupation") || "",
          occupation: "18",
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

    //   vehicleInfo: {
    //     make: "TOYOTA",
    //     model: "53523",
    //     vehicleRegYear: "2024",
    //     regNo: "SKE7499S",
    //     insuringWithCOE: "2",
    //     ageConditionBasis: "1",
    //     offPeakCar: "1",
    //     mileageCondition: "1838000062",
    //     engineNo: "E7230005683A",
    //     chassisNo: "C7230005683A",
    //     mileageDeclaration: "",
    //     hirePurchaseCompany: "14",
    //   },
    //   driverInfo: [
    //     {
    //       driverType: "5",
    //       driverDOB: "1991-05-18T16:00:00.000Z",
    //       driverGender: "M",
    //       driverMaritalStatus: "S",
    //       drivingExperience: "4",
    //       occupation: "18",
    //       claimExperience: "N",
    //       claimInfo:
    //         formData.get("insured_auto_driverInfo_claimExperience") === "Y"
    //           ? [
    //               {
    //                 dateOfLoss: formData.get(
    //                   "insured_auto_driverInfo_claimInfo_dateOfLoss"
    //                 )
    //                   ? transformDate(
    //                       formData.get(
    //                         "insured_auto_driverInfo_claimInfo_dateOfLoss"
    //                       )
    //                     )
    //                   : "",
    //                 lossDescription:
    //                   formData.get(
    //                     "insured_auto_driverInfo_claimInfo_lossDescription"
    //                   ) || "",
    //                 claimNature:
    //                   formData.get(
    //                     "insured_auto_driverInfo_claimInfo_claimNature"
    //                   ) || "",
    //                 claimsAmount:
    //                   parseFloat(
    //                     formData.get(
    //                       "insured_auto_driverInfo_claimInfo_claimAmount"
    //                     )
    //                   ) || 0,
    //                 status:
    //                   parseInt(
    //                     formData.get(
    //                       "insured_auto_driverInfo_claimInfo_claimStatus"
    //                     ),
    //                     10
    //                   ) || 0,
    //                 insuredLiability:
    //                   parseInt(
    //                     formData.get(
    //                       "insured_auto_driverInfo_claimInfo_insuredLiability"
    //                     ),
    //                     10
    //                   ) || 0,
    //               },
    //             ]
    //           : [],
    //       driverName: "test Auto",
    //       driverIdNumber: "S9499999F",
    //       driverIdType: "9",
    //       driverResidentStatus: "1",
    //       driverNationality: "6",
    //     },
    //   ],
    //   planInfo: {
    //     planId: "1839000041",
    //     planPoi: 12,
    //     coverList: [],
    //   },
    // };
  } else if (formType === "ah") {
    insuredObject.personInfo = {};
    const insuredFullName =
      formData.get("insured_ah_insuredFirstName") +
      " " +
      formData.get("insured_ah_insuredLastName");
    insuredObject.personInfo.insuredFullName = insuredFullName;
    for (const [name, value] of formData.entries()) {
      if (name.includes("insured_ah_")) {
        insuredObject.personInfo[name.replace("insured_ah_", "")] = value;
      }
    }
  }

  insuredObject.planInfo = {};
  const planListData = planData?.insuredList[0];

  const PlanDetail = {
    planId: planListData
      ? planListData.planList[formData.get("planId")]?.planId
      : 0,
    planPoi: formData.get("planPoi"),
  };
  insuredObject.planInfo = PlanDetail;
  

  insuredList.push(insuredObject);
  const fullForm = {
    ...policyDetail,
    policyHolderInfo,
    insuredList,
  };
  return fullForm;
}

const handleValidateForm = () => {
   document
  .getElementById("application")
  .addEventListener("submit", async function (event) {
    event.preventDefault();
    console.log("Form submission triggered");
    console.log("form", handleForm());

    let isValid = true;
    document.querySelectorAll("input, select").forEach(function (field) {
      if (field.style.display !== "none" && field.required && !field.value) {
        console.log(`Error: ${field.name} is empty`);
        isValid = false;
        field.classList.add("error"); // Optionally add an error class to highlight the field
        field.style.borderColor = "red"; // Highlight the field with a red border
      } else {
        field.classList.remove("error");
        field.style.borderColor = ""; // Remove the red border if the field is valid
      }
    });

    if (!isValid) {
      alert("Please fill in all required fields.");
      return;
    }
    try {
      const requestBody = handleForm();
      if(policyid){
console.log("policyid",policyid)
const paymentDetail = [
  {
    // Payment_Mode: formData.get('Payment_Mode'),
    // Payment_Frequency: formData.get('Payment_Frequency'),
    // Payment_CardType: formData.get('Payment_CardType'),
    batchNo: "IP08072022",
    orderNo: "7240000603",
    paymentMode: 1001,
    merchantId: "TEST97454572",
    cardType: "1",
    cardExpiryYear: "31",
    paymentDate: "2024-08-06T00:00:00Z",
    paymentFrequency: 1,
    cardExpiryMonth: "5",
    paymentAmount: 12000,
    cardNumber: "450875xxxxxx1019",
    currency: "SGD",
  },
];
const body = {...requestBody,paymentDetail}
console.log("body",body)
const responseData = await fetchPolicy(requestBody);

if(responseData?.statusCode=="N02"){

  await jQuery.agent.DBInsertPolicyData(policyid, responseData); // Ensure it completes
}

      }else{
       
        const responseData = await fetchQuotation(requestBody);
        await jQuery.agent.DBInsertQuotationData(requestBody, responseData); // Ensure it completes
      }



      
    } catch (error) {
      console.error("Error fetching quotation or inserting data:", error);
    }
  });

};

//initial
window.onload = function () {
  showForm(document.querySelector('input[name="CustomerType"]:checked'));
};
document.addEventListener("DOMContentLoaded", () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  selectedType = urlParams.get("formType");
  handleTypeConfirmQuote();
  handleCategoryCampaign();
});
document.addEventListener("DOMContentLoaded", clearForm);
document.addEventListener("DOMContentLoaded", () => {
  handleSelectType();
  handleValidateForm();
  // setDefaultValueForm();
});


const setDefaultValueForm = (dbData) => {
  const ncdInfo = JSON.parse(dbData.ncdInfo);
  const individualPolicyHolderInfo = JSON.parse(dbData.policyHolderInfo);
  const insuredData = JSON.parse(dbData.insuredList);

  document.querySelector('select[name="Ncd_Level"]').value = ncdInfo.ncdLevel;
  document.querySelector('select[name="NoClaimExperience"]').value = ncdInfo.noClaimExperienceOther || '';

  // Set Individual Policy Holder Info fields
  document.querySelector('select[name="courtesyTitle"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.courtesyTitle;
  document.querySelector('input[name="firstName"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.fullName.split(" ")[0];
  document.querySelector('input[name="lastName"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.fullName.split(" ")[1];
  document.querySelector('select[name="residentStatus"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.residentStatus;
  document.querySelector('select[name="customerIdType"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.customerIdType;
  document.querySelector('input[name="customerIdNo"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.customerIdNo;
  document.querySelector('input[name="nationality"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.nationality;
  document.querySelector('select[name="gender"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.gender;
  document.querySelector('input[name="dateOfBirth"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.dateOfBirth.split("T")[0];
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
  document.querySelector('input[name="PolicyEffectiveDate"]').value =
    dbData.policyEffDate.split(" ")[0];
  document.querySelector('input[name="PolicyExpiryDate"]').value =
    dbData.policyExpDate.split(" ")[0];
  document.querySelector('input[name="campaignCode"]').value =
    dbData.campaignCode;

  const drivingYes = document.querySelector("#isPolicyHolderDrivingYes");
  const drivingNo = document.querySelector("#isPolicyHolderDrivingNo");
  if (individualPolicyHolderInfo.individualPolicyHolderInfo.isPolicyHolderDriving === "2") {
    drivingYes.checked = true;
  } else {
    drivingNo.checked = true;
  }

  setDefaultValueFormInsuredList(insuredData);
};

const setDefaultValueFormInsuredList = (insuredData) => {
  if (!insuredData || insuredData.length === 0) return;

  const vehicleInfo = insuredData[0].vehicleInfo;
  document.querySelector('select[name="insured_auto_vehicle_make"]').value = vehicleInfo.make;
  document.querySelector('select[name="insured_auto_vehicle_model"]').value = vehicleInfo.model;
  document.querySelector('select[name="insured_auto_vehicle_vehicleRegYear"]').value = vehicleInfo.vehicleRegYear;
  document.querySelector('input[name="insured_auto_vehicle_regNo"]').value = vehicleInfo.regNo;
  document.querySelector(`input[name="insured_auto_vehicle_insuringWithCOE"][value="${vehicleInfo.insuringWithCOE}"]`).checked = true;
  document.querySelector('select[name="insured_auto_vehicle_ageConditionBasis"]').value = vehicleInfo.ageConditionBasis;
  document.querySelector(`input[name="insured_auto_vehicle_offPeakCar"][value="${vehicleInfo.offPeakCar}"]`).checked = true;
  document.querySelector('select[name="insured_auto_vehicle_mileageCondition"]').value = vehicleInfo.mileageCondition;
  document.querySelector('input[name="insured_auto_vehicle_engineNo"]').value = vehicleInfo.engineNo;
  document.querySelector('input[name="insured_auto_vehicle_chassisNo"]').value = vehicleInfo.chassisNo;
  document.querySelector('input[name="insured_auto_vehicle_mileageDeclaration"]').value = vehicleInfo.mileageDeclaration || '';
  document.querySelector('input[name="insured_auto_vehicle_hirePurchaseCompany"]').value = vehicleInfo.hirePurchaseCompany;
  document.querySelector('input[name="insured_auto_vehicle_declaredSI"]').value = vehicleInfo.declaredSI;

  const driverInfo = insuredData[0].driverInfo[0];
  document.querySelector('select[name="insured_auto_driverInfo_driverType"]').value = driverInfo.driverType;
  document.querySelector('input[name="insured_auto_driverInfo_driverName"]').value = driverInfo.driverName;
  document.querySelector('input[name="insured_auto_driverInfo_driverIdNumber"]').value = driverInfo.driverIdNumber;
  document.querySelector('select[name="insured_auto_driverInfo_driverIdType"]').value = driverInfo.driverIdType;
  document.querySelector('select[name="insured_auto_driverInfo_driverResidentStatus"]').value = driverInfo.driverResidentStatus;
  document.querySelector('input[name="insured_auto_driverInfo_driverDOB"]').value = driverInfo.driverDOB.split("T")[0];
  document.querySelector('select[name="insured_auto_driverInfo_driverGender"]').value = driverInfo.driverGender;
  document.querySelector('input[name="insured_auto_driverInfo_driverNationality"]').value = driverInfo.driverNationality;
  document.querySelector('select[name="insured_auto_driverInfo_maritalStatus"]').value = driverInfo.driverMaritalStatus;
  document.querySelector('input[name="insured_auto_driverInfo_drivingExperience"]').value = driverInfo.drivingExperience;
  document.querySelector('select[name="insured_auto_driverInfo_occupation"]').value = driverInfo.occupation;
  document.querySelector(`input[name="insured_auto_driverInfo_claimExperience"][value="${driverInfo.claimExperience}"]`).checked = true;

  const claimInfo = driverInfo.claimInfo[0];
  document.querySelector('input[name="insured_auto_driverInfo_claimInfo_dateOfLoss"]').value = claimInfo.dateOfLoss.split("T")[0];
  document.querySelector('input[name="insured_auto_driverInfo_claimInfo_lossDescription"]').value = claimInfo.lossDescription;
  document.querySelector('select[name="insured_auto_driverInfo_claimInfo_claimNature"]').value = claimInfo.claimNature;
  document.querySelector('input[name="insured_auto_driverInfo_claimInfo_claimAmount"]').value = claimInfo.claimsAmount;
  document.querySelector('select[name="insured_auto_driverInfo_claimInfo_claimStatus"]').value = claimInfo.status;
  document.querySelector('select[name="insured_auto_driverInfo_claimInfo_insuredLiability"]').value = claimInfo.insuredLiability;
};






const transformDate = (dateString) => {
  return new Date(dateString).toISOString();
};
