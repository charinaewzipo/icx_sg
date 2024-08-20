document.addEventListener("DOMContentLoaded", () => {
  window.removeCoverRow = function (button) {
    const row = button.closest("tr");
    const coverListBody = document.getElementById("coverListBody");

    if (coverListBody.querySelectorAll(".cover-row").length > 1) {
      row.remove();
    } else {
      alert("At least one cover row must remain.");
      console.warn("At least one cover row must remain.");
    }
  };

  // Function to populate cover options in a dropdown
  function populateCoverOptions(selectElement) {
    const planId = document.getElementById("planSelect").value;
    const planListData = planData.insuredList[0];
    const plan = planListData.planList[planId];

    if (plan && plan.coverList) {
      let coverOptions =
        '<option value=""> <-- Please select an option --> </option>';
      for (const coverId in plan.coverList) {
        if (plan.coverList.hasOwnProperty(coverId)) {
          const cover = plan.coverList[coverId];
          coverOptions += `<option value="${coverId}">${cover.name}</option>`;
        }
      }
      selectElement.innerHTML = coverOptions;
    } else {
      selectElement.innerHTML =
        '<option value=""> <-- Please select an option --> </option>';
    }
  }

  // Function to add a new cover row
  window.addCoverRow = function () {
    const coverListBody = document.getElementById("coverListBody");
    const newRow = document.createElement("tr");
    newRow.classList.add("cover-row");

    // Create a new row with a dropdown for cover list and populate it
    newRow.innerHTML = `
        <td style="padding:0px 30px">Cover Name: <span style="color:red">*</span> </td>
        <td>
          <select name="plan_cover_list[]" class="planCoverList" required>
            <!-- Options will be populated by JavaScript -->
          </select>
        </td>
        <td style="padding-left:20px">Cover Code: <span style="color:red">*</span> </td>
        <td style="width:70px">
          <p class="planCoverCode"></p>
        </td>
        <td>Limit Amount:</td>
        <td>
          <p class="planCoverLimitAmount"></p>
          <input type="hidden" class="selectedFlagInput" value="">
          <p class="coverName" hidden ></p>
        </td>
        <td>
          <button style="color:#65558F; background-Color:white; border:1px solid white; cursor:pointer" type="button" class="removeCoverBtn" onclick="removeCoverRow(this)">Remove</button>
        </td>
      `;

    if (document.getElementById("planSelect").value !== "") {
      coverListBody.appendChild(newRow);

      // Populate the cover options for the new dropdown
      const newCoverSelect = newRow.querySelector(".planCoverList");
      populateCoverOptions(newCoverSelect);

      disableSelectedOptions();
    } else {
      alert("Please select a plan first.");
    }
  };
  function disableSelectedOptions() {
    const coverSelects = document.querySelectorAll(
      "#coverListBody .cover-row .planCoverList"
    );
    const selectedValues = Array.from(coverSelects)
      .map((select) => select.value)
      .filter((value) => value);

    coverSelects.forEach((select) => {
      const options = select.querySelectorAll("option");
      options.forEach((option) => {
        if (selectedValues.includes(option.value) && option.value !== "") {
          option.disabled = true;
        } else {
          option.disabled = false;
        }
      });
    });
  }

  // Event listener for changes to the planSelect dropdown
  document.getElementById("planSelect").addEventListener("change", function () {
    const planId = this.value;
    const planPoiSelect = document.getElementById("planPoiSelect");
    const planCoverLists = document.querySelectorAll(".planCoverList");
    const planListData = planData.insuredList[0];

    // Update the Plan POI field
    if (planId && planListData.planList[planId]) {
      const plan = planListData.planList[planId];
      if (plan.planPoi) {
        planPoiSelect.value = plan.planPoi;
      }

      // Update cover options for all cover dropdowns
      planCoverLists.forEach((select) => populateCoverOptions(select));
    }
  });

  // Event listener for changes to any cover dropdowns
  document
    .getElementById("coverListBody")
    .addEventListener("change", function (event) {
      const target = event.target;
      if (target.classList.contains("planCoverList")) {
        const coverId = target.value;
        if (coverId) {
          const coverDetails = getCoverDetails(coverId); // You should define this function
          console.log("coverDetails", coverDetails);

          if (coverDetails) {
            const row = target.closest("tr");

            const planCoverCode = row.querySelector(".planCoverCode");
            const planCoverLimitAmount = row.querySelector(
              ".planCoverLimitAmount"
            );
            const selectedFlagInput = row.querySelector(".selectedFlagInput");
            const coverName = row.querySelector(".coverName");

            // Ensure each element exists before attempting to access its properties
            if (planCoverCode) {
              planCoverCode.innerHTML = coverDetails?.code || "N/A";
            } else {
              console.warn("planCoverCode element not found in the row.");
            }

            if (planCoverLimitAmount) {
              planCoverLimitAmount.innerHTML = coverDetails?.limitAmount
                ? `${parseFloat(coverDetails?.limitAmount).toLocaleString()}`
                : "0";
            } else {
              console.warn(
                "planCoverLimitAmount element not found in the row."
              );
            }

            if (selectedFlagInput) {
              selectedFlagInput.value = coverDetails?.selectedFlag;
            } else {
              console.warn("selectedFlagInput element not found in the row.");
            }

            if (coverName) {
              coverName.innerHTML = coverDetails?.name;
            } else {
              console.warn("coverName element not found in the row.");
            }
          } else {
            console.warn("No details found for Cover ID:", coverId);
          }
        }
      }
    });
});
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
    if (planList.hasOwnProperty(planId)) {
      const plan = planList[planId];
      const coverList = plan.coverList;
      if (coverList && coverList.hasOwnProperty(coverId)) {
        return coverList[coverId];
      }
    }
  }
  return null;
}

const manualSetDefaultValueForm = () => {
  console.log("manual run");
  const ncdInfo = {
    ncdLevel: 0,
    previousInsurer: "NCD0033",
    previousPolicyNo: "prev123",
    noClaimExperienceOther: "1",
  };

  const individualPolicyHolderInfo = {
    customerType: "1",
    individualPolicyHolderInfo: {
      courtesyTitle: "38",
      fullName: "charin aewzipo",
      residentStatus: "1",
      customerIdType: "6",
      customerIdNo: "19222000012",
      nationality: "6",
      gender: "F",
      dateOfBirth: "1996-08-07T17:00:00.000Z",
      maritalStatus: "S",
      occupation: "17",
      isPolicyHolderDriving: "2",
    },
    contactInfo: {
      postCode: "079120",
      unitNo: "",
      blockNo: "78",
      streetName: "Shenton Way",
      buildingName: "",
      emailId: "charin.eawi@gmail.com",
      mobileNo: "0950924619",
    },
    organizationPolicyHolderInfo: {
      natureOfBusiness: "",
      companyName: "",
      companyRegNo: "",
      companyRegDate: "",
    },
  };

  // Set form fields based on the object data

  document.querySelector('select[name="Ncd_Level"]').value = ncdInfo.ncdLevel;
  document.querySelector('select[name="NoClaimExperience"]').value =
    ncdInfo.noClaimExperienceOther;

  document.querySelector('select[name="courtesyTitle"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.courtesyTitle;
  document.querySelector('input[name="firstName"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.fullName.split(
      " "
    )[0];
  document.querySelector('input[name="lastName"]').value =
    individualPolicyHolderInfo.individualPolicyHolderInfo.fullName.split(
      " "
    )[1];
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
    individualPolicyHolderInfo.individualPolicyHolderInfo.dateOfBirth.split(
      "T"
    )[0];
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
    "08/30/2024";
  document.querySelector('input[name="PolicyExpiryDate"]').value = "12/31/2024";
  document.querySelector('input[name="campaignCode"]').value = "";

  // Set radio buttons for 'isPolicyHolderDriving'
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
};
const manualSetDefaultValueFormInsuredList = () => {
  console.log("manual");
  const insuredData = [
    {
      vehicleInfo: {
        make: "BMW",
        model: "52966",
        vehicleRegYear: "2017",
        regNo: "SKE7499S",
        insuringWithCOE: "2",
        ageConditionBasis: "1",
        offPeakCar: "1",
        vehicleUsage: "222",
        mileageCondition: "1838000062",
        engineNo: "E7230005683A",
        chassisNo: "C7230005683A",
        mileageDeclaration: "123",
        hirePurchaseCompany: "14",
        declaredSI: 250000,
      },
      driverInfo: [
        {
          driverType: "5",
          driverDOB: "1991-05-18T16:00:00.000Z",
          driverGender: "M",
          driverMaritalStatus: "S",
          drivingExperience: "4",
          occupation: "17",
          claimExperience: "Y",
          claimInfo: [
            {
              dateOfLoss: "2024-08-14T17:00:00.000Z",
              lossDescription: "Own damage",
              claimNature: "2",
              claimsAmount: 1200.5,
              status: 3,
              insuredLiability: 2,
            },
          ],
          driverName: "test Auto",
          driverIdNumber: "S9499999F",
          driverIdType: "9",
          driverResidentStatus: "1",
          driverNationality: "6",
        },
      ],
      planInfo: {
        planId: "1839000145",
        planPoi: 12,
        coverList: [],
      },
    },
  ];

  // Populate the form fields with data
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
    'input[name="insured_auto_vehicle_insuringWithCOE"][value="' +
      vehicleInfo.insuringWithCOE +
      '"]'
  ).checked = true;
  document.querySelector(
    'select[name="insured_auto_vehicle_ageConditionBasis"]'
  ).value = vehicleInfo.ageConditionBasis;
  document.querySelector(
    'input[name="insured_auto_vehicle_offPeakCar"][value="' +
      vehicleInfo.offPeakCar +
      '"]'
  ).checked = true;
  document.querySelector(
    'input[name="insured_auto_vehicle_vehicleUsage"]'
  ).value = vehicleInfo.vehicleUsage;
  document.querySelector(
    'select[name="insured_auto_vehicle_mileageCondition"]'
  ).value = vehicleInfo.mileageCondition;
  document.querySelector('input[name="insured_auto_vehicle_engineNo"]').value =
    vehicleInfo.engineNo;
  document.querySelector('input[name="insured_auto_vehicle_chassisNo"]').value =
    vehicleInfo.chassisNo;
  document.querySelector(
    'input[name="insured_auto_vehicle_mileageDeclaration"]'
  ).value = vehicleInfo.mileageDeclaration;
  document.querySelector(
    'input[name="insured_auto_vehicle_hirePurchaseCompany"]'
  ).value = vehicleInfo.hirePurchaseCompany;
  document.querySelector(
    'input[name="insured_auto_vehicle_declaredSI"]'
  ).value = vehicleInfo.declaredSI;

  const driverInfo = insuredData[0].driverInfo[0];
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
  ).value = driverInfo.driverDOB.split("T")[0]; // Extract date
  document.querySelector(
    'select[name="insured_auto_driverInfo_driverGender"]'
  ).value = driverInfo.driverGender;
  document.querySelector(
    'input[name="insured_auto_driverInfo_driverNationality"]'
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
    'input[name="insured_auto_driverInfo_claimExperience"][value="' +
      driverInfo.claimExperience +
      '"]'
  ).checked = true;

  (document.querySelector(
    'input[name="insured_auto_driverInfo_claimInfo_dateOfLoss"]'
  ).value = driverInfo.claimInfo[0].dateOfLoss.split("T")[0]),
    (document.querySelector(
      'input[name="insured_auto_driverInfo_claimInfo_lossDescription"]'
    ).value = driverInfo.claimInfo[0].lossDescription),
    (document.querySelector(
      'select[name="insured_auto_driverInfo_claimInfo_claimNature"]'
    ).value = driverInfo.claimInfo[0].claimNature),
    (document.querySelector(
      'input[name="insured_auto_driverInfo_claimInfo_claimAmount"]'
    ).value = driverInfo.claimInfo[0].claimsAmount),
    (document.querySelector(
      'select[name="insured_auto_driverInfo_claimInfo_claimStatus"]'
    ).value = driverInfo.claimInfo[0].status);
  document.querySelector(
    'select[name="insured_auto_driverInfo_claimInfo_insuredLiability"]'
  ).value = driverInfo.claimInfo[0].insuredLiability;
};
