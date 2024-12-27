let premiumBaseAmount = 0;
let selectedPlan;
function checkRetrieveCampaignAuto(data) {
  const currentUrl = new URL(window.location.href);
  const formType = currentUrl.searchParams.get('formType');
  console.log("checkRetrieveCampaignAuto:", data);
  console.log("campaignDetailsFromAPI:", campaignDetailsFromAPI);
  // Proceed only if the formType is "auto" and id is not set
  if (!id && formType === "auto") {
    setTimeout(() => {
      // Check conditions for handling retrieve auto
      if (checkShouldRetrieve()) {
        handleRetrieveAuto(data);
      }
    }, 2000);
  }
}
function checkShouldRetrieve() {
  console.log("checkShouldRetrieve:");

  const quoteNoField = productDetail?.udf_field_quote_no || null;

  const quoteNo = quoteNoField ? calllistDetail?.[quoteNoField] : null;

  const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";

  return quoteNo || isRenewal;
}

async function handleRetrieveAuto(callListData) {
  const quoteNoField = productDetail?.udf_field_quote_no || "";
  const vehicleNoField = productDetail?.udf_field_vehicle_no || "";
  const enginNoField = productDetail?.udf_field_engin_no || "";
  const DOBField = productDetail?.udf_field_DOB || "";
  console.log("DOBField:", DOBField)

  const idNo = callListData?.personal_id || callListData?.passport_no || "";
  const policyNo = calllistDetail[quoteNoField] || "";
  const regNo = policyNo ? "" : calllistDetail[vehicleNoField] || "";
  const dob = idNo ? "": calllistDetail[DOBField] ? transformDate(isoToFormattedDate(calllistDetail[DOBField])):"" 
  const engineNo = calllistDetail[DOBField] ? "" : calllistDetail[enginNoField] || "";


  const objectRetrieve = {
    channelType: "10",
    idNo,
    policyNo,
    regNo,
    engineNo,
    dob
  };


  const responseRetrieve = await fetchRetrieveQuote(objectRetrieve);
  console.log("responseRetrieve:", responseRetrieve);
  if (!responseRetrieve) {
    alert("Quote Retrieval List Operation failed");
    setTimeout(() => {
      window.close();
    }, 2000)
    return;
  }

  const { statusCode, quoteList, statusMessage } = responseRetrieve;
  alert(statusMessage);
  if (statusCode !== "P00") {
    // policy issuance
    setTimeout(() => {
      window.close();
    }, 2000)
    return
  }
  if (quoteList && quoteList.length > 0) {
    let data = quoteList?.[0]?.Policy;
    console.log("data:", data);

    await getProductDetail(data?.productId);
    let transformedData = transformQuoteData(data, quotationData);
    console.log("transformedData", transformedData);
    const responseId = await jQuery.agent.insertRetrieveQuote(data, transformedData, campaignDetails, objectRetrieve);
    let currentUrl = window.location.href;
    const url = new URL(currentUrl);
    if (url.searchParams.has('id')) {
      url.searchParams.set('id', responseId);
    } else {
      url.searchParams.append('id', responseId);
    }
    if (url.searchParams.has('is_firsttime')) {
      url.searchParams.set('is_firsttime', '1');
    } else {
      url.searchParams.append('is_firsttime', '1');
    }
    window.location.href = url.toString();
  } else {
    alert("The quoteList has no data")
    setTimeout(() => {
      window.close();
    }, 2000)

  }

}

function populatePlanAutoPremium(planList) {
  const planSelect = document.getElementById('planSelect');
  const planPoiSelect = document.getElementById('planPoiSelect');
  planSelect.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';
  if (checkShouldRetrieve()) {
    //hide ncd gears
    const ncdLevel_gears_display=document.getElementById("ncdLevel_gears_display");
    const ncdLevel_gears=document.getElementById("ncdLevel_gears");
    const additionalInfo=document.getElementById("additional-info");
    ncdLevel_gears_display.style.display = "none";
    ncdLevel_gears.style.display = "none";
    const isRenewal = campaignDetailsFromAPI?.incident_type === "Renewal";
    if(isRenewal){
      additionalInfo.hidden=false
    }
    

    const plan = planList
    const option = document.createElement('option');
    option.value = plan.planId;
    option.textContent = `${plan.planName} (${plan?.planPoi})`;
    option.dataset.planPoi = plan.planPoi;
    option.dataset.netPremium = plan.netPremium;
    planSelect.appendChild(option);
    selectedPlan=planList
    populateCoverListAutoPremium();
  } else {
    for (const key in planList) {
      if (planList.hasOwnProperty(key)) {
        const plan = planList[key];
        const option = document.createElement('option');
        option.value = plan.planId;
        option.textContent = `${plan.planDescription} (${plan?.planPoi})`;
        option.dataset.planPoi = plan.planPoi;
        option.dataset.netPremium = plan.netPremium;
        planSelect.appendChild(option);
      }
    }
  }
  

  // Update planPoiSelect when an option is selected
  planSelect.addEventListener('change', function () {
    document.getElementById('excess-section').hidden=false;
    const coverListDisplay = document.getElementById("coverListDisplay");
    const addCoverDisplay = document.getElementById("addCoverDisplay");
    const selectedOption = planSelect.options[planSelect.selectedIndex];
    const planPoi = selectedOption.dataset.planPoi || '';
    const premiumAmount = selectedOption.dataset.netPremium || '';
    premiumBaseAmount = parseFloat(premiumAmount)
    const selectedPlanId = selectedOption.value;
    console.log("selectedPlanId:", selectedPlanId)
    planPoiSelect.value = planPoi;

    const premiumAmountInput = document.getElementById('premium-amount');
    const premiumAmountInputWithGST = document.getElementById("premium-amount-with-gst");
    if (premiumAmountInput) {
      premiumAmountInput.value = premiumBaseAmount ? `${premiumBaseAmount.toFixed(2)} (SGD)` : '';
      premiumAmountInputWithGST.value = premiumBaseAmount ? `${(premiumBaseAmount * 1.09).toFixed(2)} (SGD)` : '';
    }


    // Find the plan in planList by planId
    for (const key in planList) {
      if (planList[key].planId === parseInt(selectedPlanId)) {
        selectedPlan = planList[key];
        break;
      }
    }

    if (selectedPlan) {
      console.log("selectedPlan:", selectedPlan)
      console.log("selectedPlan?.planDescription:", selectedPlan?.planDescription)

      coverListDisplay.hidden = false
      addCoverDisplay.hidden = false
      planPoiSelect.value = selectedPlan.planPoi;
      populateCoverListAutoPremium();
      handlePopulateExcessFromAPI(selectedPlan)
    }
  });
}

function populateCoverListAutoPremium() {
  console.log("populateCoverListAutoPremium:")
  console.log("selectedPlan?.coverList:", selectedPlan?.coverList)
  const coverListBody = document.getElementById('coverListBody');
  coverListBody.innerHTML = ''; // Clear previous covers
  if (selectedPlan?.coverList) {
    // Initially add one cover row
    addCoverRow(selectedPlan?.coverList);

    document.getElementById("addCover").addEventListener('click', () => {
      const rowCount = coverListBody.getElementsByClassName('cover-row').length;

      if (rowCount < 10) {
        addCoverRow(selectedPlan?.coverList);
      } else {
        alert('You cannot add more than 10 cover rows.');
      }
    });

  }

}
// Function to add a new row for each cover option
function addCoverRow(coverList, setCoverData) {

  const coverListBody = document.getElementById('coverListBody');

  const allSelects = coverListBody.querySelectorAll('select');
  if (!setCoverData) {
    for (const selectElement of allSelects) {
      if (!selectElement.value) {
        return; // ไม่อนุญาตให้เพิ่มแถวใหม่
      }
    }
  }


  // Create a new row
  const row = document.createElement('tr');
  row.className = 'cover-row';

  // Cover Label Cell
  const labelCell = document.createElement('td');
  labelCell.style.padding = '0 40px';
  labelCell.textContent = 'Cover Name: ';
  row.appendChild(labelCell);

  // Cover Dropdown Cell
  const selectCell = document.createElement('td');
  const tdCell = document.createElement('td');
  const selectElement = document.createElement('select');
  selectElement.className = 'planCoverList';
  selectElement.style.maxWidth = '216px';

  // Add the default option
  const defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.textContent = '<-- Please select an option -->';
  defaultOption.disabled = true;
  defaultOption.selected = true;
  selectElement.appendChild(defaultOption);

  // Populate dropdown with cover options
  if(checkShouldRetrieve()){
    for (const key in coverList) {
      if (coverList.hasOwnProperty(key) ) {
        const cover = coverList[key];
        const option = document.createElement('option');
        option.value = cover.id;
        option.textContent = cover.name;
        option.dataset.premium = cover.premium; // Store premium in the option's dataset
        option.dataset.code = cover.code; // Store premium in the option's dataset
        option.dataset.excess=cover?.standardExcess||""
        selectElement.appendChild(option);
      }
    }
  }else{
    for (const key in coverList) {
      if (coverList.hasOwnProperty(key) && coverList[key]?.autoAttached === false) {
        const cover = coverList[key];
        const option = document.createElement('option');
        option.value = cover.id;
        option.textContent = cover.name;
        option.dataset.premium = cover.premium; // Store premium in the option's dataset
        option.dataset.code = cover.code; // Store premium in the option's dataset
        option.dataset.excess=cover?.standardExcess||""
        selectElement.appendChild(option);
      }
    }
  }
  
  const thCellCell = document.createElement('th');
  // Premium Display Cell
  const premiumCell = document.createElement('td');
  const premiumDisplay = document.createElement('span');
  premiumDisplay.className = 'premium-display';
  premiumDisplay.textContent = ''; // Initial premium display is empty



  // Append the dropdown cell
  selectCell.appendChild(selectElement);
  row.appendChild(selectCell);
  row.appendChild(thCellCell)
  row.appendChild(tdCell);
  premiumCell.appendChild(premiumDisplay);
  row.appendChild(premiumCell);

  // row.appendChild(buyUpOrDownCell);


  selectElement.addEventListener('change', function () {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const quoteNoField = document.getElementById('policyid-input')
    if (quoteNoField && quoteNoField.value) {
      premiumDisplay.textContent = ''

    } else {

      premiumDisplay.textContent = selectedOption.dataset.premium
        ? `Amount: ${selectedOption.dataset.premium} (SGD)`
        : '';
      calculatePremiumSummary(); // Recalculate the total premium after selection
    }
  });

  // Remove Button
  const removeCell = document.createElement("td");
  const removeButton = document.createElement("button");
  removeButton.textContent = "Remove";
  removeButton.type = "button";
  removeButton.className = "button draft-button";
  removeButton.style.float = "right";

  removeButton.onclick = function () {
    if (coverListBody.children.length === 1) {
      selectElement.value = ""
      selectElement.dispatchEvent(new Event('change'));
      updateDisabledOptions()
      return;
    }
    coverListBody.removeChild(row);
    calculatePremiumSummary();
    updateDisabledOptions()
  };

  removeCell.appendChild(removeButton);
  row.appendChild(removeCell);
  coverListBody.appendChild(row);

  if (setCoverData) {
    selectElement.value = setCoverData.id;
    selectElement.dispatchEvent(new Event('change'));
  }
  // Update disabled options initially
  updateDisabledOptions(); // Ensure options are disabled when needed
}

function calculatePremiumSummary() {
  console.log("premiumBaseAmount:", premiumBaseAmount);

  const premiumAmountInput = document.getElementById("premium-amount");
  const premiumAmountInputWithGST = document.getElementById("premium-amount-with-gst");
  let premiumTotal = premiumBaseAmount;  // Start with the base amount

  const planCoverLists = document.querySelectorAll('.planCoverList');

  // Loop through each select element
  planCoverLists.forEach(function (selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];

    // If an option is selected and it is not disabled
    if (selectedOption.value !== "" && !selectedOption.disabled) {
      // Add the 'data-premium' value of the selected option to the total premium
      premiumTotal += parseFloat(selectedOption.getAttribute('data-premium')) || 0;
    }
  });

  // Update the total premium in the premium amount input field
  if (premiumAmountInput) {
    premiumAmountInput.value = premiumTotal ? `${premiumTotal.toFixed(2)} (SGD)` : '';
    premiumAmountInputWithGST.value = premiumTotal ? `${(premiumTotal * 1.09).toFixed(2)} (SGD)` : '';
  }

  console.log("Total Premium:", premiumTotal);
  console.log("Total premiumAmountInputWithGST:", premiumAmountInputWithGST.value);
}
// Function to disable selected options in all dropdowns
function updateDisabledOptions() {
  console.log("updateDisabledOptions:")
  const selectedValues = Array.from(document.querySelectorAll('.planCoverList'))
    .map(select => select.value)
    .filter(value => value); // Collect selected values only

  document.querySelectorAll('.planCoverList').forEach(select => {
    Array.from(select.options).forEach(option => {
      const shouldDisable = selectedValues.includes(option.value) && option.value !== select.value;
      //handle loyal home cover and enhance loyalty
      if (selectedValues.includes('600000720') && option.value === '1838000221') {
        option.disabled = true;
      } else if (selectedValues.includes('1838000221') && option.value === '600000720') {
        option.disabled = true;
      }
      // handle LOU1800,LOU1500
       else if (selectedValues.includes('1762000072') && option.value === '1762000062') {
        option.disabled = true;
      } else if (selectedValues.includes('1762000062') && option.value === '1762000072') {
        option.disabled = true;
      }
      else {
        option.disabled = shouldDisable;
      }
    });
  });
}


const handleKeepChangeButton = () => {
  const userConfirmed = window.confirm("Are you sure you want to proceed with recalculation?");

  if (userConfirmed) {
    if (window.opener && !window.opener.closed) {
      window.alert("Fetching Recalculate...");
      window.close();
      window.opener.showAlert('Fetch Recalculate successfully!');
    }
  }
}
const handleCloseButton = () => { window.close() }

const handleChangePaymodeAutomaticRenewal = () => {
  const automaticRenewalFlag = document.getElementById('automaticRenewalFlag');
  const paymentModeSelect = document.getElementById('paymentModeSelect');
  paymentModeSelect.addEventListener('change', function () {
    if (Number(paymentModeSelect.value) === 124) {
      automaticRenewalFlag.value = "Yes"
    } else {
      automaticRenewalFlag.value = "No"
    }
  })
}
function handleChangeIsPolicyHolderDriving(checkbox) {
  const yesCheckbox = document.getElementById('isPolicyHolderDrivingYes');
  const noCheckbox = document.getElementById('isPolicyHolderDrivingNo');

  // Policyholder information fields
  const firstName = document.getElementsByName('firstName')[0];
  const gender = document.getElementsByName('gender')[0];
  const nationality = document.getElementsByName('nationality')[0];
  const dateOfBirth = document.getElementsByName('dateOfBirth')[0];
  const maritalStatus = document.getElementsByName('maritalStatus')[0];
  const residentStatus = document.getElementsByName('residentStatus')[0];
  const customerIdType = document.getElementsByName('customerIdType')[0];
  const customerIdNo = document.getElementsByName('customerIdNo')[0];

  // Driver information fields
  const driverNameField = document.getElementsByName('insured_auto_driverInfo_driverName')[0];
  const driverResidentStatus = document.getElementsByName('insured_auto_driverInfo_driverResidentStatus')[0];
  const driverIdType = document.getElementsByName('insured_auto_driverInfo_driverIdType')[0];
  const driverIdNumber = document.getElementsByName('insured_auto_driverInfo_driverIdNumber')[0];
  const driverDOB = document.getElementsByName('insured_auto_driverInfo_driverDOB')[0];
  const driverGender = document.getElementsByName('insured_auto_driverInfo_driverGender')[0];
  const driverNationality = document.getElementsByName('insured_auto_driverInfo_driverNationality')[0];
  const driverMaritalStatus = document.getElementsByName('insured_auto_driverInfo_maritalStatus')[0];

  if (checkbox === yesCheckbox && yesCheckbox.checked) {
    const confirmChange = window.confirm("Do you want to use the Individual Policy Holder Info in the Driver Info section?");

    if (confirmChange) {
      noCheckbox.checked = false;

      // Copy values from policyholder fields to driver fields
      driverNameField.value = firstName.value || "";
      driverGender.value = gender.value || "";
      driverNationality.value = nationality.value || "";
      driverDOB.value = dateOfBirth.value || "";
      if (driverDOB.value) {
        const { age } = calculateAge(driverDOB.value);
        document.getElementById('ageDriver').value = age;
      }
      driverMaritalStatus.value = maritalStatus.value || "";
      driverResidentStatus.value = residentStatus.value || "";
      driverIdType.value = customerIdType.value || "";
      driverIdNumber.value = customerIdNo.value || "";

      console.log("Policy Holder Driving: Yes, Driver information updated.");
    } else {
      yesCheckbox.checked = false;
      noCheckbox.checked = true;
    }

  } else if (checkbox === noCheckbox && noCheckbox.checked) {
    yesCheckbox.checked = false;

    // Reset driver fields to empty
    driverNameField.value = "";
    driverGender.value = "";
    driverNationality.value = "";
    driverDOB.value = "";
    driverMaritalStatus.value = "";
    driverResidentStatus.value = "";
    driverIdType.value = "";
    driverIdNumber.value = "";

    console.log("Policy Holder Driving: No, Driver information reset.");
  } else {
    console.log("Policy Holder Driving: None selected");
  }
}


function validateDriverExperience() {
  const drivingExperienceInput = document.getElementById("drivingExperience");

  drivingExperienceInput.addEventListener("change", function () {
    const drivingExperience = drivingExperienceInput.value;

    // Validate if the input is numeric and greater than 0
    if (!drivingExperience || isNaN(drivingExperience) || Number(drivingExperience) <= 0) {
      window.alert("Driving experience must be a numeric value greater than 0.");
      drivingExperienceInput.value = ""; // Optional: Clear the input field
    }
  });
}

function validateCustomerIdNumberAuto() {
  const idTypeSelect = document.querySelector(`select[name="insured_auto_driverInfo_driverIdType"]`);
  const idNumberInput = document.querySelector(`input[name="insured_auto_driverInfo_driverIdNumber"]`);

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
function attachCustomerIdValidationAuto() {
  const idTypeSelect = document.querySelector(`select[name="insured_auto_driverInfo_driverIdType"]`);
  const idNumberInput = document.querySelector(`input[name="insured_auto_driverInfo_driverIdNumber"]`);

  if (idTypeSelect && idNumberInput) {
    idTypeSelect.addEventListener('change', validateCustomerIdNumberAuto);
    idNumberInput.addEventListener('input', validateCustomerIdNumberAuto);
  }
}
function setupFormListeners() {
  const formFieldNames = [
    "select-product",
    "PolicyEffectiveDate",
    "Ncd_Level",
    "customerType",
    "isPolicyHolderDriving",
    "insured_auto_vehicle_make",
    "insured_auto_vehicle_model",
    "insured_auto_vehicle_vehicleRegYear",
    "insured_auto_vehicle_regNo",
    "insured_auto_vehicle_insuringWithCOE",
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
    "insured_auto_driverInfo_claimInfo_dateOfLoss",
    "insured_auto_driverInfo_claimInfo_lossDescription",
    "insured_auto_driverInfo_claimInfo_claimNature",
    "insured_auto_driverInfo_claimInfo_claimAmount",
    "insured_auto_driverInfo_claimInfo_claimStatus",
    "insured_auto_driverInfo_claimInfo_insuredLiability",
  ];
  
  const quoteNoField = document.getElementById('policyid-input')
  
    formFieldNames.forEach(fieldName => {
      const elements = document.getElementsByName(fieldName);
      elements.forEach(element => {
        element.addEventListener("change", () => {
          console.log(`${fieldName} changed`);
          if (quoteNoField && quoteNoField.value) {
          }else{
            resetPlanSelect();
          }
        });
      });
    });
  
  
}

// Function to reset the planSelect dropdown
function resetPlanSelect() {
  const planSelect = document.getElementById('planSelect');
  const planPoiSelect = document.getElementById('planPoiSelect');
  const premiumAmount = document.getElementById('premium-amount');
  if (planSelect) {
    console.log("Resetting planSelect dropdown");
    const defaultOption = planSelect.querySelector('option[value=""]');
    planSelect.innerHTML = '';

    // Re-add only the default option
    if (defaultOption) {
      planSelect.appendChild(defaultOption);
    }

    planSelect.value = '';
    planPoiSelect.value = '';
    premiumAmount.value = '';
  }
  createElementCover()
  const premiumAmountInput = document.getElementById('premium-amount');
  const premiumAmountInputWithGST = document.getElementById("premium-amount-with-gst");
  premiumAmountInput.value = '';
  premiumAmountInputWithGST.value = '';
}
const createElementCover = () => {
  const coverListBody = document.getElementById('coverListBody');
  coverListBody.innerHTML = ''; // Clear previous covers
  // Create a new row
  const row = document.createElement('tr');
  row.className = 'cover-row';

  // Cover Label Cell
  const labelCell = document.createElement('td');
  labelCell.style.padding = '0 40px';
  labelCell.textContent = 'Cover Name: ';
  row.appendChild(labelCell);

  // Cover Dropdown Cell
  const selectCell = document.createElement('td');
  const tdCell = document.createElement('td');
  const selectElement = document.createElement('select');
  selectElement.className = 'planCoverList';
  selectElement.style.maxWidth = '216px';

  // Add the default option
  const defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.textContent = '<-- Please select an option -->';
  defaultOption.disabled = true;
  defaultOption.selected = true;
  selectElement.appendChild(defaultOption);
  selectCell.appendChild(selectElement);
  row.appendChild(selectCell);
  row.appendChild(tdCell);
  coverListBody.appendChild(row);
}

async function fetchGetModel(makeValue) {
  if (!makeValue) return;

  const url = `../scripts/get_model_auto.php?makeValue=${makeValue}`;
  document.body.classList.add('loading');

  try {
    // Await the fetch response
    const response = await fetch(url);
    const data = await response.json();
    console.log("data:", data)

    // Ensure the select element exists
    const ModelSelect = document.querySelector('select[name="insured_auto_vehicle_model"]');
    if (!ModelSelect) {
      console.error("Dropdown not found!");
      return;
    }

    // Clear existing options
    ModelSelect.innerHTML = `
      <option value="">
        <-- Please select an option -->
      </option>
    `;

    // Populate new options from the fetched data
    if (data && Array.isArray(data) && data?.length > 0) {
      data.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.description;
        ModelSelect.appendChild(option);
        ModelSelect.required = true;
      });
    } else {
      // Display a message when no data is available
      const option = document.createElement('option');
      option.value = "";
      option.textContent = "No options available";
      option.disabled = true;
      ModelSelect.appendChild(option);
      ModelSelect.required = false;
    }
  } catch (error) {
    console.error('Error fetching plans:', error);
  } finally {
    document.body.classList.remove('loading');
  }
}
const handleAutoMakeChange = () => {
  const makeSelect = document.querySelector('select[name="insured_auto_vehicle_make"]');
  makeSelect.addEventListener('change', async () => {
    await fetchGetModel(makeSelect.value)
  })
}
let promoCodeCount = 0; // เริ่มต้นที่ 1 เพราะมีแถวแรกอยู่แล้วใน HTML
const maxPromoCodes = 3; // จำนวนสูงสุดที่อนุญาต

// ฟังก์ชันสำหรับการเพิ่มแถว Promo Code
function addPromoCode(defaultValue = "") {
  console.log("promoCodeCount:", promoCodeCount)

  // ตรวจสอบว่ามี Promo Code ครบ 4 ตัวหรือยัง
  if (promoCodeCount >= maxPromoCodes) {
    alert("You can only add up to 3 promo codes.");
    return;
  }

  promoCodeCount++;

  // หา tbody ของตาราง
  const promoTableBody = document.querySelector("#promo-table tbody");

  // สร้างแถวใหม่
  const newPromoCodeRow = document.createElement("tr");
  newPromoCodeRow.id = `promocode-row-${promoCodeCount}`;

  // สร้างเซลล์สำหรับป้ายชื่อ Promo Code
  const labelCell = document.createElement("td");
  labelCell.style.whiteSpace = "nowrap";
  labelCell.style.width = "162px";
  labelCell.textContent = "Promo Code:";

  // สร้างเซลล์สำหรับ input
  const promoCodeCell = document.createElement("td");
  const promoCodeInput = document.createElement("input");
  promoCodeInput.id = `promocode-input-${promoCodeCount}`;
  promoCodeInput.name = "campaignCode[]";
  promoCodeInput.type = "text";
  promoCodeInput.style.width = "130px";
  promoCodeInput.value = defaultValue;
  promoCodeInput.readOnly = defaultValue ? true : false

  promoCodeCell.appendChild(promoCodeInput);

  // สร้างเซลล์สำหรับปุ่ม Remove
  const removeButtonCell = document.createElement("td");
  const removeButton = document.createElement("button");
  removeButton.type = "button";
  removeButton.textContent = "Remove";
  removeButton.className = "button draft-button";

  removeButton.setAttribute("data-row-id", promoCodeCount);
  removeButton.onclick = function () {
    const rowId = this.getAttribute("data-row-id");
    removePromoCode(rowId);
  };
  removeButtonCell.appendChild(removeButton);

  // ใส่เซลล์ทั้งหมดลงในแถวใหม่
  newPromoCodeRow.appendChild(labelCell);
  newPromoCodeRow.appendChild(promoCodeCell);
  newPromoCodeRow.appendChild(removeButtonCell);

  // เพิ่มแถวใหม่ลงใน tbody ของตาราง
  promoTableBody.appendChild(newPromoCodeRow);
}

// ฟังก์ชันสำหรับการลบแถว Promo Code
function removePromoCode(rowNumber) {
  const rowToRemove = document.getElementById(`promocode-row-${rowNumber}`);
  const inputToClear = document.getElementById(`promocode-input-${rowNumber}`);
  if (rowToRemove && promoCodeCount > 1) {
    rowToRemove.remove(); // ลบแถว
    promoCodeCount--;
  } else {
    inputToClear.value = ''
    inputToClear.readOnly = false
    inputToClear.style.backgroundColor = 'white'
    inputToClear.style.opacity = '1'

    alert("No promo code rows left");
  }
}

function handleMileageCondition() {
  const mileageCondition = document.querySelector('select[name="insured_auto_vehicle_mileageCondition"]');
  const mileageDeclaration = document.querySelector('input[name="insured_auto_vehicle_mileageDeclaration"]');
  const mileageDeclarationLabel = document.getElementById('mileageDeclaration-label');

  function updateMileageCondition() {
    if (mileageCondition.value === '1838000062') {
      mileageDeclaration.required = false;
      mileageDeclaration.value = '';
      mileageDeclaration.disabled = true;
      const span = mileageDeclarationLabel.querySelector('span');
      if (span) {
        span.remove();
      }
    } else {
      mileageDeclaration.required = true;
      mileageDeclaration.disabled = false;

      if (!mileageDeclarationLabel.querySelector('span')) {
        const requiredIndicator = document.createElement('span');
        requiredIndicator.style.color = 'red';
        requiredIndicator.textContent = '*';
        mileageDeclarationLabel.appendChild(requiredIndicator);
      }
    }
  }

  // เพิ่ม Event Listener
  mileageCondition.addEventListener('change', updateMileageCondition);

  // เรียกใช้ทันทีสำหรับค่าเริ่มต้น
  updateMileageCondition();
}
function initializePromoCodeTable(ArrayPromoCodeField) {
  console.log("ArrayPromoCodeField:", ArrayPromoCodeField)
  let allValuesAreNull = true;
  console.log("campaignDetailsFromAPI:", campaignDetailsFromAPI)
  if ((campaignDetailsFromAPI?.incident_type === "Renewal")) {
    ArrayPromoCodeField.forEach((field, index) => {
      const defaultValue = calllistDetail[field] || "";
      const ArrayDataDefaultValue = defaultValue.split(',')
      console.log("ArrayDataDefaultValue:", ArrayDataDefaultValue)
      ArrayDataDefaultValue.forEach((field) => {
        addPromoCode(field);
        allValuesAreNull = false;
      })

    });
  } else {
    ArrayPromoCodeField.forEach((field, index) => {
      const defaultValue = calllistDetail[field] || "";
      console.log("defaultValue:", defaultValue)
      if (defaultValue) {
        addPromoCode(defaultValue);
        allValuesAreNull = false;
      }
    });
  }

  if (allValuesAreNull) {
    addPromoCode()
  }
}
function handleChangeEffectiveDate() {
  const effectiveDateInput = $("#datepicker5");
  const expiryDateInput = $("#datepicker6");

  effectiveDateInput.on("change", function () {
    const effectiveDateValue = effectiveDateInput.val();

    if (effectiveDateValue) {
      const [day, month, year] = effectiveDateValue.split("/");
      const effectiveDate = new Date(`${year}-${month}-${day}`);
      
      // วันที่ 1 ปีหลังจาก effectiveDate
      const minDate = new Date(effectiveDate);
      minDate.setFullYear(minDate.getFullYear() + 1);
      minDate.setDate(minDate.getDate() - 1); // เพิ่ม 1 วัน

      // วันที่ 1 ปี 6 เดือนหลังจาก effectiveDate
      const maxDate = new Date(effectiveDate);
      maxDate.setFullYear(maxDate.getFullYear() + 1);
      maxDate.setMonth(maxDate.getMonth() + 6);

      // ตั้งค่า minDate และ maxDate สำหรับ expiryDateInput
      expiryDateInput.datepicker("option", "minDate", minDate);
      expiryDateInput.datepicker("option", "maxDate", maxDate);

      // ตั้งค่าเริ่มต้นให้ expiryDateInput เป็น minDate
      expiryDateInput.datepicker("setDate", minDate);
    }
  });
}


function calculateDenominationsExcess(amount) {
  const result = [];
  let current = amount;

  // เพิ่มค่าที่ลดทีละ 50 ไปจนถึง 0
  while (current >= 0) {
    result.push(current);
    current -= 50;
  }

  // // เพิ่มค่าที่ต่ำกว่า 0 ทีละ 50
  // current = -50;
  // while (current >= -amount) {
  //   result.push(current);
  //   current -= 50;
  // }

  return result;
}


function handlePopulateExcessFromAPI(selectedPlan) {
  console.log("selectedPlan:", selectedPlan);
  const extractExcessData = selectedPlan?.coverList?.['1'];
  console.log("extractExcessData:", extractExcessData);

  if (extractExcessData) {
    // Set default values only if elements exist
    const standardExcessField = document.getElementById('insured_auto_standard_excess');
    const buyUpDownField = document.getElementById('insured_auto_buy_up_down');
    const uwExcessField = document.getElementById('insured_auto_uw_excess');
    const finalExcessField = document.getElementById('insured_auto_final_excess');
    if (standardExcessField) {
      standardExcessField.value = extractExcessData?.standardExcess || 0;
    } 
    if (buyUpDownField) {
      const arrayExcessRange = calculateDenominationsExcess(extractExcessData?.standardExcess)
      console.log("arrayExcessRange:", arrayExcessRange)
      buyUpDownField.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';
      Array.isArray(arrayExcessRange)&&arrayExcessRange.forEach(item=>{
        const option = document.createElement('option');
        option.value = item;
        option.textContent = item;
        buyUpDownField.appendChild(option)
      })
    }
    if (uwExcessField) {
      uwExcessField.value = extractExcessData?.uwExcess || 0;
    } 

  
    buyUpDownField.addEventListener('change', function () {
      if (standardExcessField && uwExcessField&&buyUpDownField.value) {
        const sumValue =
          Number(standardExcessField.value) +
          Number(buyUpDownField.value) +
          Number(uwExcessField.value);
        finalExcessField.value = sumValue;
      }else{
        finalExcessField.value=''
      }
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  let currentUrl = window.location.href;
  const url = new URL(currentUrl);
  let formType = url.searchParams.get('formType');
  console.log("Form type:", formType);
  if (formType === "auto") {
    attachCustomerIdValidationAuto();
    setupFormListeners();
    handleAutoMakeChange()
    handleChangePaymodeAutomaticRenewal()
    validateDriverExperience()
    handleMileageCondition()
    handleChangeEffectiveDate()
    document.getElementById("paymentModeSelect").addEventListener('change', function () {
      handleCardTypeIPP()
    })
  }
});