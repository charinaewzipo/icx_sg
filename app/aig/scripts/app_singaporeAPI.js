let planData = null;
const token =
  "eyJraWQiOiItNlk1TWVEaDVxNUotRGJkdTAyQ1BueWRRdkY1TW9TRFBpaHlFTFhUUWZRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULjZxbDQxeTIyMnlGdms3UUFteGV4b043SWdnSWJyRTlVWDk1V19KRzJLX0UiLCJpc3MiOiJodHRwczovL2RldmF1dGgxLmN1c3RvbWVycGx0Zm0uYWlnLmNvbS9vYXV0aDIvYXVzbWdtYnllU28yRUh1SnMxZDYiLCJhdWQiOiJDSUFNX0FQUFMiLCJpYXQiOjE3MjM5OTMxNzksImV4cCI6MTcyNDAwMDM3OSwiY2lkIjoiMG9hZnRjdnh6ZWVDbTByazExZDciLCJzY3AiOlsiU0dFd2F5UGFydG5lcnNfSVIiXSwic3ViIjoiMG9hZnRjdnh6ZWVDbTByazExZDcifQ.Zl_SQ3_F_1hqg4U7lsMy2ZY0gFUugFnKpMGxhWapnGcDlg7WmLpGowrm9ZQkvC_N-KVgKR0_OcnHvviKfNjAmzbtVvoPDy8IGgpw3vWQ4UFTz37iedNTT7od3R_cG7_hKxThMU5mBkdZvMjUaDKOmDURm8ZB-hzAOBvpAkPpvAriCXuUpce22cAvJ2uAJBt-oqmjet6fgD6qtsIxaBrftlWu1vX_N_KOdhWd4b_Mdj8RfAyqg-wabpf2TGCjczRMODw-krtXKIt1-dyt8fc7UEJ4NmCHk-eiPLsG4IXUVJyy1MaeuQUOptg9Qpm0tcJq-1yRhIDTdxNXcmREH9Ttxw";

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("planSelect").addEventListener("change", function () {
    var planId = this.value;
    var planPoiSelect = document.getElementById("planPoiSelect");
    var planCoverList = document.getElementById("planCoverList");
    const planListData = planData.insuredList[0];
    planCoverList.innerHTML =
      '<option value=""> <-- Please select an option --> </option>';
    if (planId && planListData.planList[planId]) {
      var plan = planListData.planList[planId];
      if (plan.planPoi) {
        planPoiSelect.value = plan.planPoi;
      }
      if (plan.coverList) {
        var coverOptions =
          '<option value=""> <-- Please select an option --> </option>';
        for (const coverId in plan.coverList) {
          if (plan.coverList.hasOwnProperty(coverId)) {
            const cover = plan.coverList[coverId];
            coverOptions +=
              '<option value="' + coverId + '">' + cover.name + "</option>";
          }
        }
        planCoverList.innerHTML = coverOptions;
      }
    }
  });
  document
    .getElementById("planCoverList")
    .addEventListener("change", function () {
      var coverId = this.value;
      if (coverId) {
        const coverDetails = getCoverDetails(coverId);
        console.log("coverDetails", coverDetails);
        if (coverDetails) {
          const planCoverCode = document.getElementById("planCoverCode");
          const planCoverLimitAmount = document.getElementById(
            "planCoverLimitAmount"
          );
          planCoverCode.innerHTML = `${coverDetails.code}`;
          planCoverLimitAmount.innerHTML = coverDetails.limitAmount
            ? `${parseFloat(coverDetails.limitAmount).toLocaleString()}`
            : 0;

          const valueToSelect = coverDetails.selectedFlag ? "Yes" : "No";

          const radioButton = document.querySelector(
            `input[name="plan_selected_flag"][value="${valueToSelect}"]`
          );

          if (radioButton) {
            radioButton.checked = true;
          }
        } else {
          console.warn("No details found for Cover ID:", coverId);
        }
      }
    });
});

function fetchPremium(requestBody) {
  console.log("Fetching plan data...");
  const apiUrl =
    "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/premium-calculation";
  fetch(apiUrl, {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
      "Content-Type": "application/json",
    },
    body: JSON.stringify(requestBody),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("responseData", data);
      if (
        data &&
        data.Policy &&
        data.Policy.insuredList &&
        data.Policy.insuredList[0]
      ) {
        planData = data.Policy;
        populatePlanSelect(planData.insuredList[0].planList);
        // Update this according to your actual data structure
        return planData;
      } else {
        console.error("Invalid API response:", data);
      }
    })
    .catch((error) => console.error("Error fetching plan data:", error));
}
async function fetchQuotation(requestBody) {
  console.log("Fetching Quotation data...");
  const apiUrl =
    "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/v3/confirm-quotation";

  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    // Check if response is OK
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const data = await response.json();
    console.log("data", data);

    // Alert based on statusCode
    if (data?.statusCode === "S03") {
      window.alert(data?.statusMessage || "Successfully!");
    } else {
      window.alert("Something Went Wrong!");
    }

    return data; // Return data for further processing
  } catch (error) {
    console.error("Error fetching quotation data:", error);
    // Optionally, you can alert the user about the error
    window.alert("Failed to fetch quotation data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  }
}
async function fetchPolicy(requestBody) {
  console.log("Fetching Policy data...");
  const apiUrl =
    "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/issue-policy";

  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    // Check if response is OK
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const data = await response.json();
    console.log("data", data);

    // Alert based on statusCode
    if (data?.statusCode === "S03") {
      window.alert(data?.statusMessage || "Successfully!");
    } else {
      window.alert("Something Went Wrong!");
    }

    return data; // Return data for further processing
  } catch (error) {
    console.error("Error fetching quotation data:", error);
    // Optionally, you can alert the user about the error
    window.alert("Failed to fetch quotation data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  }
}

const handleRequestBody = () => {
  const formData = new FormData(document.getElementById("application"));
  const requestBodyHome = {
    propDate: "2024-07-26T18:25:43.511Z",
    productId: "600000060",
    distributionChannel: 10,
    producerCode: "0000064000",
    applicationReceivedDate: "",
    // policyEffDate: formData.get("PolicyEffectiveDate"),
    // policyExpDate: formData.get("PolicyExpiryDate"),
    policyEffDate: new Date(),
    policyExpDate: new Date(),
    insuredList: [
      {
        addressInfo: {
          ownerOccupiedType: formData.get("insured_home_ownerOccupiedType"),
        },
      },
    ],
  };
  const requestBodyAuto = {
    productId: 600000080,
    distributionChannel: 10,
    policyEffDate: formData.get("PolicyEffectiveDate")
      ? transformDate(formData.get("PolicyEffectiveDate"))
      : "",
    ncdInfo: {
      ncdLevel: Number(formData.get("Ncd_Level")),
    },
    policyHolderInfo: {
      customerType: formData.get("customerType"),
      individualPolicyHolderInfo: {
        isPolicyHolderDriving: formData.get("isPolicyHolderDriving"),
      },
    },
    insuredList: [
      {
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
        },
        driverInfo: [
          {
            driverType:
              formData.get("insured_auto_driverInfo_driverType") || "",
            driverDOB: formData.get("insured_auto_driverInfo_driverDOB")
              ? transformDate(formData.get("insured_auto_driverInfo_driverDOB"))
              : "",
            driverGender:
              formData.get("insured_auto_driverInfo_driverGender") || "",
            driverMaritalStatus:
              formData.get("insured_auto_driverInfo_maritalStatus") || "",
            drivingExperience:
              formData.get("insured_auto_driverInfo_drivingExperience") || "",
            occupation: "18",
            //   occupation: formData.get("insured_auto_driverInfo_occupation") || "",
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
          },
        ],
      },
    ],
    producerCode: "0002466000",
    campaignCode: "",
  };
  //   const requestBodyAuto = {
  //     productId: 600000080,
  //     distributionChannel: 10,
  //     policyEffDate: "2024-08-10T00:00:00.000Z",
  //     ncdInfo: {
  //       ncdLevel: 1,
  //     },
  //     policyHolderInfo: {
  //       customerType: "0",
  //       individualPolicyHolderInfo: {
  //         isPolicyHolderDriving: "2",
  //       },
  //     },
  //   insuredList: [
  //     {
  //       vehicleInfo: {
  //         make: "BMW",
  //         model: "52966",
  //         vehicleRegYear: "2016",
  //         regNo: "SKE7499S",
  //         insuringWithCOE: "2",
  //         ageConditionBasis: "2",
  //         offPeakCar: "1",
  //         mileageCondition: "1838000061",
  //       },
  //   driverInfo: [
  //     {
  //       driverType: "5",
  //       driverDOB: "1991-11-01T16:00:00.000Z",
  //       driverGender: "M",
  //       driverMaritalStatus: "M",
  //       drivingExperience: "11",
  //       occupation: "18",
  //       claimExperience: "N",
  //       claimInfo: [
  //         {
  //           dateOfLoss: "2024-07-25T00:00:00.000Z",
  //           lossDescription: "Own Damage",
  //           claimNature: "1",
  //           claimsAmount: 1200.5,
  //           status: 3,
  //           insuredLiability: 1,
  //         },
  //       ],
  //     },
  //   ],
  //     },
  //   ],
  //     producerCode: "0002466000",
  //     campaignCode: "",
  //   };
  const requestBodyAh = {
    propDate: "2024-07-26T18:25:43.511Z",
    productId: "600000060",
    distributionChannel: 10,
    producerCode: "0000064000",
    applicationReceivedDate: "",
    policyEffDate: formData.get("PolicyEffectiveDate"),
    policyExpDate: formData.get("PolicyExpiryDate"),
    insuredList: [
      {
        addressInfo: {
          ownerOccupiedType: formData.get("insured_home_ownerOccupiedType"),
        },
      },
    ],
  };

  switch (selectedType) {
    case "home":
      return requestBodyHome;
    case "auto":
      return requestBodyAuto;
    case "ah":
      return requestBodyAh;
    default:
      console.error("Unknown selected type:", selectedType);
      return null;
  }
};
const handleRequiredField = () => {
  const requiredFieldsTypeHome = [
    "PolicyEffectiveDate",
    "PolicyExpiryDate",
    "insured_home_ownerOccupiedType",
  ];
  const requiredFieldsTypeAuto = [
    "PolicyEffectiveDate",
    "Ncd_Level",
    "customerType",
    "isPolicyHolderDriving",
    "insured_auto_vehicle_make",
    "insured_auto_vehicle_model",
    "insured_auto_vehicle_vehicleRegYear",
    "insured_auto_vehicle_regNo",
    "insured_auto_vehicle_ageConditionBasis",
    "insured_auto_vehicle_offPeakCar",
    "insured_auto_vehicle_mileageCondition",
    "insured_auto_driverInfo_driverType",
    "insured_auto_driverInfo_driverDOB",
    "insured_auto_driverInfo_driverGender",
    "insured_auto_driverInfo_maritalStatus",
    "insured_auto_driverInfo_drivingExperience",
    "insured_auto_driverInfo_occupation",
    "insured_auto_driverInfo_claimExperience",
  ];
  const requiredFieldsTypeAh = [
    "PolicyEffectiveDate",
    "Ncd_Level",
    "customerType",
    "isPolicyHolderDriving",
  ];

  switch (selectedType) {
    case "home":
      return requiredFieldsTypeHome;
    case "auto":
      return requiredFieldsTypeAuto;
    case "ah":
      return requiredFieldsTypeAh;
    default:
      console.error("Unknown selected type:", selectedType);
      return [];
  }
};

//see plan
function validateAndSubmitFormCallPremium() {
  const formData = new FormData(document.getElementById("application"));
  const requiredFields = handleRequiredField();
  let allFieldsFilled = true;

  requiredFields.forEach((field) => {
    const value = formData.get(field);
    console.log(`"${field} :"${value}"`);
    if (value === null || value.trim() === "" || value === "") {
      allFieldsFilled = false;
      console.log(`Field "${field}" is required.`);
    }
  });

  if (!allFieldsFilled) {
    console.log("Please fill in all required fields.");
    window.alert("Please fill in all required fields.");
    return;
  }

  const apiBody = handleRequestBody();
  console.log("apiBody", apiBody);
  if (apiBody) {
    fetchPremium(apiBody);
  }
}

function populatePlanSelect(planList) {
  const planSelect = document.getElementById("planSelect");
  let planListOptions =
    '<option value=""> <-- Please select an option --> </option>';

  for (const planId in planList) {
    if (planList.hasOwnProperty(planId)) {
      const plan = planList[planId];
      planListOptions += `<option value="${planId}">${plan.planDescription} (${plan.planPoi})</option>`;
    }
  }

  planSelect.innerHTML = planListOptions;
}

function getCoverDetails(coverId) {
  const planList = planData.insuredList[0].planList;
  for (const planId in planList) {
    const plan = planList[planId];
    const coverList = plan.coverList;
    if (coverList.hasOwnProperty(coverId)) {
      return coverList[coverId];
    }
  }
  return null;
}
