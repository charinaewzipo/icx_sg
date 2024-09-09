<script>
    
    function createListAhSection(index) {

    return `
    <table id="table-form-${index}" class="table-ah" name="table-form-${index}">
        	<tbody>
            <tr>
                <td colspan="6">
                    <h2>Person ${index}</h2>
                </td>
            </tr>
            <tr>
                <td>Insured First Name: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredFirstName_${index}" maxlength="60" required /></td>
                <th style="width:50px">&nbsp;</th>
                <td>Insured Last Name:</td>
                <td><input type="text" name="insured_ah_insuredLastName_${index}" maxlength="60" /></td>
            </tr>
            <tr>
                <td>Insured Resident Status: <span style="color:red">*</span></td>
                <td>
                   <select name="insured_ah_insuredResidentStatus_${index}" required>
                    <option value="">
                      <-- Please select an option -->
                    </option>
                    <?php
                    $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredResidentStatus'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                        $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>

                  </select>
                </td>
                <th style="width:50px">&nbsp;</th>
                <td>Insured Type: <span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_insuredIdType_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                       <?php
                        $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredIdType'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResuut = mysqli_fetch_array($objQuery)) {
                            $data[] = $objResuut;
                        ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insured ID Number: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredIdNumber_${index}" maxlength="60" required /></td>
                <th style="width:50px">&nbsp;</th>
                <td>Insured Gender: <span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_insuredGender_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                      <?php
                        $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredGender'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResuut = mysqli_fetch_array($objQuery)) {
                            $data[] = $objResuut;
                        ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insured Date Of Birth: <span style="color:red">*</span></td>
                <td><input type="text" id="datepicker-${index}" name="insured_ah_insuredDateOfBirth_${index}" maxlength="60" required /></td>
                <th style="width:50px">&nbsp;</th>
                <td>Insured Marital Status: <span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_insuredMaritalStatus_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                        <?php
                        $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'insuredMaritalStatus'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResuut = mysqli_fetch_array($objQuery)) {
                            $data[] = $objResuut;
                        ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insured Occupation: <span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_insuredOccupation_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                        <?php
                        $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PA Occupation'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResuut = mysqli_fetch_array($objQuery)) {
                            $data[] = $objResuut;
                        ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                        }

                    ?>
                    </select>
                </td>
                <th style="width:50px">&nbsp;</th>
                <td>Relation To Policy Holder:<span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_relationToPolicyholder_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                 <?php
                    $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PH Relation'";
                    $objQuery = mysqli_query($Conn, $strSQL);
                    while ($objResuut = mysqli_fetch_array($objQuery)) {
                        $data[] = $objResuut;
                    ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                    }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insured Campaign Code: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredCampaignCode_${index}" maxlength="60" required /></td>
                <th style="width:50px">&nbsp;</th>
            </tr>
            <tr>
                <td>Nature Of Business: <span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_natureOfBusiness_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                     <?php
                        $strSQL = "SELECT name, id, description
FROM tubtim.t_aig_sg_lov 
where name='PA Nature of Business'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResuut = mysqli_fetch_array($objQuery)) {
                            $data[] = $objResuut;
                        ?>
                      <option value="<?php echo $objResuut["id"]; ?>">
                        <?php echo $objResuut["description"]; ?>
                      </option>
                    <?php
                        }

                    ?>
                    </select>
                </td>
                <th style="width:50px">&nbsp;</th>
                <td>
                    <button type="button" class="button seePlan" id="btnPaymentOnline${index}" onclick="fetchPlanData(${index})">See plan</button>
                </td>
            </tr>
        </tbody>
        
      
        <tbody>
          <tr>
              <td>
                <h1>Plan Info</h1>
              </td>
            </tr>
       
            <tr>
                <td style="white-space:nowrap">Plan Id : <span style="color:red">*</span> </td>
                <td>
                   <select id="planSelect${index}" name="planId${index}" required onchange="handlePlanChange(this, ${index})">
    <option value="">
        <-- Please select an option -->
    </option>
    
</select>

                </td>
                <th style="width:50px"></th>
                <td style="white-space: nowrap;">Plan Poi :</td>
                <td colspan="2">
                    <input type="text" id="planPoiSelect${index}" name="planPoi${index}" readonly>
                </td>
            </tr>
            <tr>
                <td>Cover List</td>
                <td></td>
            </tr>
            <tbody id="coverListBody${index}">
                <tr class="cover-row">
                    <td style="padding:0 30px">Cover Name: <span style="color:red">*</span> </td>
                    <td>
                        <select name="plan_cover_list_${index}[]" class="planCoverList" style="max-width: 216px;" required>
                            <option value="">
                                <-- Please select an option -->
                            </option>
                        </select>
                    </td>
                <td></td>
                <td>Limit Amount:</td>
                <td>
                <input type="text" class="planCoverLimitAmount${index}" id="planCoverLimitAmount${index}" readonly>
                  
                </td>
                 
          
            </tbody>
                 </tr>
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="float:inline-end">
                    <button type="button" class="button add-cover" onclick="addCoverRowIndex(${index})" style="margin: 5px 0;">Add Cover</button>
                </td>
            </tr>
        </tbody>
    </table>
    <hr style="margin:10px 0px">
    `;
}

function handlePlanChange(selectElement, index) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const planPoi = selectedOption.getAttribute('data-poi');
    const planId = selectElement.value;
    const insuredDob = document.getElementById(`datepicker-${index}`).value;
    if (planPoi) {
        document.getElementById(`planPoiSelect${index}`).value = planPoi;
    }
    if (planId) {
        fetchCoverList(planId,planPoi,insuredDob, index);
    }
}

function fetchCoverList(planId, planPoi,insuredDob,index) {
    fetch('../scripts/get_plan_covers.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ plan_id: planId,plan_poi:planPoi,insuredDateOfBirth:insuredDob })
    })
    .then(response => response.text())
    .then(data => {
        const selectElement = document.querySelector(`#coverListBody${index} select.planCoverList`);
        selectElement.innerHTML = data;
        
        // Add event listener to update the limit amount field
        selectElement.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const limitInput = document.querySelector(`#planCoverLimitAmount${index}`);
            
            if (selectedOption) {
                const netPremium = selectedOption.getAttribute('data-netpremium');
                limitInput.value = netPremium ? netPremium : '';
            }
        });
    })
    .catch(error => console.error('Error fetching cover list:', error));
}
// function handleCoverChange(selectElement, index) {
//     const selectedOption = selectElement.options[selectElement.selectedIndex];
//     const selectedNetPremium = selectedOption.getAttribute('data-netpremium');
//     const relatedElement = document.querySelector(`#planCoverLimitAmount${index}`);
    
//     if (relatedElement) {
//         relatedElement.value = selectedNetPremium; 
//     } 
// }

    function addPlanInfoSections(count) {
        const insuredContainer = document.getElementById('insured-list-ah');
        insuredContainer.innerHTML = '';
        for (let i = 1; i <= count; i++) {
            const insuredSectionHTML = createListAhSection(i);
            insuredContainer.innerHTML += insuredSectionHTML;
        }
    }

    // Add 3 Plan Info sections when the page loads
    document.addEventListener('DOMContentLoaded', () => {
       

        const queryString = window.location.search;
         const urlParams = new URLSearchParams(queryString);
         checkParamsId = urlParams.get("id");
        if(!checkParamsId){
            fetchCallingList()
        }
      
        fetchCampaignDetail()
        addPlanInfoSections(2);
        attachPlanSelectEventListeners()
        setTimeout(() => {
            // attachCoverSelectEventListeners()
        }, 2000)




        
        function attachPlanSelectEventListeners() {
            const planSelectElements = document.querySelectorAll('[id^="planSelect"]');

            planSelectElements.forEach(selectElement => {
                selectElement.addEventListener('change', function(event) {
                    const index = this.id.replace('planSelect', ''); 
                    // handlePlanSelectChange(event, index);
                });
            });
        }

   function attachCoverSelectEventListeners() {
    const coverSelectElements = document.querySelectorAll('.planCoverList');

    coverSelectElements.forEach((selectElement, index) => {
        if (quotationData) {
            const coversList = quotationData?.insuredList[index]?.personInfo?.planInfo?.covers;
            if (coversList) {
                populateCoverOptionsAHAutomatic(selectElement, coversList, 0);

                // Create additional rows for the remaining covers
                for (let i = 1; i < coversList.length; i++) {
                    createAndPopulateRow(index + 1, coversList, i);
                }
            }
        }
    });
}



        function handlePlanSelectChange(event, index) {
            const planId = event.target.value;
            const planPoiSelect = document.getElementById(`planPoiSelect${index}`);
            const planCoverLists = document.querySelectorAll(`#coverListBody${index} .planCoverList`);
            const planListData = planData.insuredList[0];
            console.log("index", index)
            console.log("planListData.planList[planId]", planListData.planList[planId])
            // Update the Plan POI field
            if (planId && planListData.planList[planId]) {
                const plan = planListData.planList[planId];
                if (plan.planPoi) {
                    planPoiSelect.value = plan.planPoi;
                }

                planCoverLists.forEach((select) => populateCoverOptionsAH(select, plan.coverList));
            }
        }

        function populateCoverOptionsAH(select, coverList) {
            console.log("coverList", coverList);

            // Clear existing options
            select.innerHTML = '<option value=""> <-- Please select an option --> </option>';

            // Populate new options based on coverList
            if (coverList) {
                for (const coverId in coverList) {
                    if (coverList.hasOwnProperty(coverId)) {
                        const cover = coverList[coverId];
                        select.innerHTML += `
                        <option 
                            value="${coverId}" 
                            data-cover-code="${cover.code}" 
                            data-cover-name="${cover.name}" 
                            data-cover-amount="${cover.limitAmount}" 
                            data-cover-selectedFlag="${cover.selectedFlag}">
                            ${cover.name}
                        </option>`;
                    }
                }
            }
        }

        function handleCoverSelectChange(event, index) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            const coverCode = selectedOption.getAttribute('data-cover-code');
            const coverName = selectedOption.getAttribute('data-cover-name');
            const coverAmount = selectedOption.getAttribute('data-cover-amount');
            const selectedFlag = selectedOption.getAttribute('data-cover-selectedFlag');

            // Find the relevant elements based on the index
            const coverCodeElement = document.querySelector(`#coverCode_${index}`);
            const coverAmountElement = document.querySelector(`#coverLimitAmount_${index}`);
            const selectedFlagInput = document.querySelector(`#selectedFlagInput_${index}`);
            const coverNameElement = document.querySelector(`#coverName_${index}`);

            // Update the elements with the selected option's data
            if (coverCodeElement) {
                coverCodeElement.textContent = coverCode;
            }
            if (coverAmountElement) {
                coverAmountElement.textContent = coverAmount;
            }
            if (selectedFlagInput) {
                selectedFlagInput.value = selectedFlag;
            }
            if (coverNameElement) {
                coverNameElement.textContent = coverName;
                coverNameElement.hidden = true; // or adjust visibility as needed
            }
        }

        window.removeCoverRowIndex = function(button, index) {
            const row = button.closest("tr");
            const coverListBody = document.getElementById(`coverListBody${index}`);

            if (coverListBody.querySelectorAll(".cover-row").length > 1) {
                row.remove();
                disableSelectedOptionsAH(index); // Update options after removing a row
            } else {
                alert("At least one cover row must remain.");
                console.warn("At least one cover row must remain.");
            }
        };

        // A set to keep track of selected option values
const selectedOptionValues = new Set();

window.addCoverRowIndex = function(index) {
    const coverListBody = document.getElementById(`coverListBody${index}`);

    const newRow = document.createElement("tr");
    newRow.classList.add("cover-row");

    newRow.innerHTML = `
        <td style="padding:0 30px">Cover Name: <span style="color:red">*</span> </td>
        <td>
            <select name="plan_cover_list_${index}[]" class="planCoverList" style="max-width: 216px;" >
                <option value="">
                    &lt;-- Please select an option --&gt;
                </option>
                <!-- Options will be populated here -->
            </select>
        </td>
        <td></td>
        <td>Limit Amount:</td>
        <td>
            <input type="text" class="planCoverLimitAmount${index}" id="planCoverLimitAmount${index}" readonly>
        </td>
        <td>
            <button style="color:#65558F; background-Color:white; border:1px solid white; cursor:pointer;" type="button" class="removeCoverBtn" onclick="removeCoverRowIndex(this, ${index})">Remove</button>
        </td>
    `;

    coverListBody.appendChild(newRow);

    const newCoverSelect = newRow.querySelector(".planCoverList");
    populateCoverOptionsAH(newCoverSelect, index);
    
    // Add event listener to update the limit amount field
    newCoverSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const limitInput = newRow.querySelector(`.planCoverLimitAmount${index}`);
        
        if (selectedOption) {
            const netPremium = selectedOption.getAttribute('data-netpremium');
            limitInput.value = netPremium ? netPremium : '';
        }
        
        // Update the set with the newly selected option
        selectedOptionValues.add(selectedOption.value);
    });
};

// Function to populate options and disable already selected options
function populateCoverOptionsAH(selectElement, index) {
    const options = [
        { value: "58", netPremium: "20.28", name: "Plan 1" },
        { value: "59", netPremium: "31.15", name: "Plan 2" },
        { value: "60", netPremium: "43.72", name: "Plan 3" }
    ];

    selectElement.innerHTML = `
        <option value="">
            &lt;-- Please select an option --&gt;
        </option>
    `;

    options.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option.value;
        optionElement.textContent = option.name;
        optionElement.setAttribute('data-netpremium', option.netPremium);

        // Disable options that are already selected
        if (selectedOptionValues.has(option.value)) {
            optionElement.disabled = true;
        }

        selectElement.appendChild(optionElement);
    });
}

        function populateCoverOptionsAHAutomatic(selectElement, coversList, coverIndex) {
    if (!coversList || coversList.length === 0) {
        console.error('Covers list is empty or undefined');
        return;
    }

    coversList.forEach((cover, index) => {
        console.log("cover:", cover)
        const option = document.createElement('option');
        option.value = cover.id;
        option.textContent = cover.name||"<-- Please select an option --> ";
        
        // Automatically select the option that matches the coverIndex
        // if (index === coverIndex) {
        //     option.selected = true;
        // }

        // Append the option to the select element
        selectElement.appendChild(option);
    });
}

function createAndPopulateRow(index, coversList, coverIndex) {
    let coverListBody = document.getElementById(`coverListBody${index}`);
    
    if (!coverListBody) {
        // Create the container if it doesn't exist
        coverListBody = document.createElement('table');
        coverListBody.id = `coverListBody${index}`;
        document.body.appendChild(coverListBody); // Append to body or any specific container
    }

    const newRow = document.createElement('tr');
    newRow.classList.add('cover-row');

    newRow.innerHTML = `
        <td style="padding:0px 30px">Cover Name: <span style="color:red">*</span> </td>
        <td>
            <select name="plan_cover_list_${index}[]" class="planCoverList" required style="max-width: 216px; pointer-events: none; background-color: rgb(233, 236, 239); color: rgb(108, 117, 125);>
                <!-- Options will be populated by JavaScript -->
            </select>
        </td>
        <td></td>
        <td>
            <button style="color:#65558F; background-color:white; border:1px solid white;" type="button" class="removeCoverBtn" >Remove</button>
        </td>
    `;

    coverListBody.appendChild(newRow);

    const selectElement = newRow.querySelector('.planCoverList');
    if (selectElement) {
        populateCoverOptionsAHAutomatic(selectElement, coversList, coverIndex);
    } else {
        console.error(`Select element not found in the new row for index ${index}`);
    }
}
 

    });

    function disableSelectedOptionsAH(index) {
        const coverSelects = document.querySelectorAll(`#coverListBody${index} .cover-row .planCoverList`);
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

    function populatePlanSelectAH(planList, index) {
        const planSelect = document.getElementById(`planSelect${index}`);
        let planListOptions = '<option value=""> <-- Please select an option --> </option>';

        for (const planId in planList) {
            if (planList.hasOwnProperty(planId)) {
                const plan = planList[planId];
                planListOptions += `<option value="${planId}" data-plan-id=${plan.planId} data-plan-description="${plan.planDescription}">${plan.planDescription} (${plan.planPoi})</option>`;
            }
        }

        planSelect.innerHTML = planListOptions;
    }

    function getCoverDetailsAH(coverId, index) {
        const planList = planData.insuredList[0].planList;
        const planSelect = document.getElementById(`planSelect${index}`);
        const selectedPlanId = planSelect.value;

        if (selectedPlanId) {
            const plan = planList[selectedPlanId];
            const coverList = plan.coverList;

            if (coverList && coverList.hasOwnProperty(coverId)) {
                return coverList[coverId];
            }
        }
        return null;
    }

    function collectFormData() {
        const insuredList = [];
        const formSections = document.querySelectorAll('table[id^="table-form-"]');

        formSections.forEach((section) => {
            const planSelect = section.querySelector('[name^="planId"]');
            const selectedOption = planSelect ? planSelect.options[planSelect.selectedIndex] : null;
            // const planId = selectedOption ? selectedOption.getAttribute('data-plan-id') || '' : '';
            const planId = selectedOption ? selectedOption.value || '' : '';
            const planDescription = selectedOption ? selectedOption.getAttribute('data-desc') || '' : '';
            const planInfo = {
                planId: planId,
                planDescription:planDescription,
                planPoi: section.querySelector('[name^="planPoi"]').value || ''
            };

            const covers = [];
            const coverRows = section.querySelectorAll('.planCoverList');
            coverRows.forEach((coverSelect) => {
                const selectedOption = coverSelect.querySelector('option:checked');
                if (selectedOption) {
                    covers.push({
                        id: selectedOption.value || '',
                        // code: selectedOption.getAttribute('data-cover-code') || null,
                        name: selectedOption.getAttribute('data-name')||null ,
                        limitAmount: selectedOption.getAttribute('data-netpremium') || null
                    });
                }
            });

            const personInfo = {
                insuredFirstName: section.querySelector('[name^="insured_ah_insuredFirstName_"]').value || '',
                insuredLastName: section.querySelector('[name^="insured_ah_insuredLastName_"]').value || '',
                insuredFullName: (section.querySelector('[name^="insured_ah_insuredFirstName_"]').value || '') + ' ' + (section.querySelector('[name^="insured_ah_insuredLastName_"]').value || ''),
                insuredResidentStatus: section.querySelector('[name^="insured_ah_insuredResidentStatus_"]').value || '',
                insuredIdType: section.querySelector('[name^="insured_ah_insuredIdType_"]').value || '',
                insuredIdNumber: section.querySelector('[name^="insured_ah_insuredIdNumber_"]').value || '',
                insuredGender: section.querySelector('[name^="insured_ah_insuredGender_"]').value || '',
                insuredDateOfBirth: section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value ? transformDate(section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value) : '',
                insuredMaritalStatus: section.querySelector('[name^="insured_ah_insuredMaritalStatus_"]').value || '',
                insuredOccupation: section.querySelector('[name^="insured_ah_insuredOccupation_"]').value || '',
                insuredCampaignCode: section.querySelector('[name^="insured_ah_insuredCampaignCode_"]').value || '',
                relationToPolicyholder: section.querySelector('[name^="insured_ah_relationToPolicyholder_"]').value || '',
                natureOfBusiness: section.querySelector('[name^="insured_ah_natureOfBusiness_"]').value || '',
                planInfo: {
                    ...planInfo,
                    covers: covers
                }
            };


            const insuredData = {
                personInfo: personInfo,

            };

            insuredList.push(insuredData);
        });


        return insuredList;
    }


    function calculateAge(dob) {
    const dobDate = new Date(dob);
    const today = new Date();
    const age = today.getFullYear() - dobDate.getFullYear();
    const monthDiff = today.getMonth() - dobDate.getMonth();
    
    // If the month difference is negative or the current month is before the birth month, subtract 1 year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
        age--;
    }

    return age;
}
function resetPlanData(index) {
    const planDropdown = document.querySelector(`select[name="plan_cover_list_${index}[]"]`);
    if (planDropdown) {
        planDropdown.innerHTML = "<option value=''> <-- Please select an option --></option>";
    }

    const coverLimitAmountInput = document.querySelector(`.planCoverLimitAmount${index}`);
    if (coverLimitAmountInput) {
        coverLimitAmountInput.value = '';
    }

    const planPoiInput = document.getElementById(`planPoiSelect${index}`);
    if (planPoiInput) {
        planPoiInput.value = '';
    }
}
function fetchPlanData(index) {
    resetPlanData(index);
    const insuredDobElement = document.getElementById(`datepicker-${index}`);
    const insuredDob = insuredDobElement ? insuredDobElement.value : '';
    if(!insuredDob){
        window.alert("Please provide the Insured Date Of Birth.");
        return;
    }
    const age = calculateAge(insuredDob);

if (age > 69) {
    window.alert("Age must be 69 or less.");
    return;
}
    const url = '../scripts/get_plan_data.php';
    document.body.classList.add('loading');

fetch(url)
    .then(response => response.json())
    .then(data => {
        populatePlanDropdown(data, index);
    })
    .catch(error => {
        console.error('Error fetching plan data:', error);
    })
    .finally(() => {
        document.body.classList.remove('loading');
    });
     
}

function fetchCallingList() {
    document.body.classList.add('loading');
    const callListId = <?php echo json_encode($_GET["calllist_id"]); ?>;
    console.log("callListId:", callListId)
    fetch('../scripts/get_callList_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({calllist_id:callListId })
    })
    .then(response => response.text())
    .then(data => {
        const result =JSON.parse(data)
        if (Array.isArray(result) && result.length > 0 && id === null) {
            manualSetDefaultValueFormCallingList(result[0]);  // Assuming you want the first item
        } 

    })
    .catch(error => console.error('Error fetching cover list:', error))
    .finally(() => {
        document.body.classList.remove('loading');
    });
}
function fetchCampaignDetail() {
    document.body.classList.add('loading');
    const campaign_id = <?php echo json_encode($_GET["campaign_id"]); ?>;
    fetch('../scripts/get_campaign_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({campaign_id:campaign_id })
    })
    .then(response => response.text())
    .then(data => {
        // const result =JSON.parse(data)
        // console.log("selectedType",selectedType)
        // if (Array.isArray(result) && result.length > 0) {
        //     // selectedType =result[0].cp_type  // Assuming you want the first item
        //     console.log("result[0].cp_type:", result[0].cp_type)
        // } 

        // console.log("data:", data)
    })
    .catch(error => console.error('Error fetching cover list:', error))
    .finally(() => {
        document.body.classList.remove('loading');
    });
}
function populatePlanDropdown(data, index) {
    const selectElement = document.getElementById(`planSelect${index}`);
    
    // Clear existing options
    selectElement.innerHTML = '<option value=""><-- Please select an option --></option>';

    // Populate the dropdown with the fetched data
    data.forEach(plan => {
        const option = document.createElement('option');
        option.value = plan.plan_id;
        option.textContent = `${plan.plan_desc} (${plan.plan_poi})`;
        option.setAttribute('data-poi', plan.plan_poi);
        option.setAttribute('data-desc', plan.plan_desc);

        selectElement.appendChild(option);
    });
}

</script>