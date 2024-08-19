document.addEventListener("DOMContentLoaded", () => {
    window.removeCoverRow = function (button) {
      const row = button.closest('tr');
      const coverListBody = document.getElementById("coverListBody");
  
      if (coverListBody.querySelectorAll('.cover-row').length > 1) {
        row.remove();
      } else {
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
            coverOptions +=
              `<option value="${coverId}">${cover.name}</option>`;
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
        </td>
        <td>
          <button type="button" class="removeCoverBtn" onclick="removeCoverRow(this)">Remove</button>
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
        const coverSelects = document.querySelectorAll('#coverListBody .cover-row .planCoverList');
        const selectedValues = Array.from(coverSelects).map(select => select.value).filter(value => value);
      
        coverSelects.forEach(select => {
          const options = select.querySelectorAll('option');
          options.forEach(option => {
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
        planCoverLists.forEach(select => populateCoverOptions(select));
      }
    });
  
    // Event listener for changes to any cover dropdowns
    document.getElementById("coverListBody").addEventListener("change", function (event) {
      const target = event.target;
      if (target.classList.contains("planCoverList")) {
        const coverId = target.value;
        if (coverId) {
          const coverDetails = getCoverDetails(coverId);
          console.log("coverDetails", coverDetails);
  
          if (coverDetails) {
            const row = target.closest('tr');
            const planCoverCode = row.querySelector(".planCoverCode");
            const planCoverLimitAmount = row.querySelector(".planCoverLimitAmount");
            const selectedFlagInput = row.querySelector(".selectedFlagInput");
  
            // Update cover code and limit amount
            planCoverCode.innerHTML = coverDetails.code || 'N/A';
            planCoverLimitAmount.innerHTML = coverDetails.limitAmount
              ? `${parseFloat(coverDetails.limitAmount).toLocaleString()}`
              : '0';
  
              selectedFlagInput.value = coverDetails.selectedFlag;
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
    