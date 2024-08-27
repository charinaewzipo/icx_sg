<script>
    function createListAhSection(index) {
        return `
    <table id="table-form-${index}" class="table-ah" name="table-form-${index}">
        <thead>
            <!-- Add any required table headers here -->
        </thead>
        <tbody>
            <tr>
                <td colspan="6">
                    <h2>Person ${index}</h2>
                </td>
            </tr>
            <tr>
                <td>Insured Firstname: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredFirstName_${index}" maxlength="60" required /></td>
                <th style="width:50px">&nbsp;</th>
                <td>Insured Lastname:</td>
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
                <td>Relation To Policyholder:<span style="color:red">*</span></td>
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
                    <button type="button" class="button seePlan" id="btnPaymentOnline${index}" onclick="callPremiumAH(${index})">See plan</button>
                </td>
            </tr>
        </tbody>


    
        <thead>
            <tr>
                <td>
                    <h1>Plan Info</h1>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="white-space:nowrap">Plan Id : <span style="color:red">*</span> </td>
                <td>
                    <select id="planSelect${index}" name="planId${index}" required>
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
                    <td style="padding:0px 30px">Cover Name: <span style="color:red">*</span> </td>
                    <td>
                        <select name="plan_cover_list_${index}[]" class="planCoverList" style="max-width: 216px;" required>
                            <option value="">
                                <-- Please select an option -->
                            </option>
                        </select>
                    </td>
                    <td></td>
                    <td>
                        <button style="color:#65558F; background-Color:white; border:1px solid white; cursor:pointer;" type="button" class="removeCoverBtn" onclick="removeCoverRowIndex(this, ${index})">Remove</button>
                    </td>
                </tr>
            </tbody>
            <tr>
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
        addPlanInfoSections(2);
        attachPlanSelectEventListeners()
        attachCoverSelectEventListeners()

        function attachPlanSelectEventListeners() {
            const planSelectElements = document.querySelectorAll('[id^="planSelect"]');

            planSelectElements.forEach(selectElement => {
                // Attach event listener to each planSelect element
                selectElement.addEventListener('change', function(event) {
                    const index = this.id.replace('planSelect', ''); // Extract the index from the ID
                    handlePlanSelectChange(event, index);
                });
            });
        }

        function attachCoverSelectEventListeners() {
            // Select all cover select elements
            const coverSelectElements = document.querySelectorAll('.planCoverList');
            coverSelectElements.forEach((selectElement, index) => {
                // Attach event listener to each cover select element
                selectElement.addEventListener('change', function(event) {
                    console.log("change", index + 1)
                    handleCoverSelectChange(event, index + 1); // Pass the 1-based index to the handler
                });
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

                // Update cover options for all cover dropdowns within the same index
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

        window.addCoverRowIndex = function(index) {
            const coverListBody = document.getElementById(`coverListBody${index}`);
            const planSelect = document.getElementById(`planSelect${index}`);

            if (!planSelect || planSelect.value === "") {
                alert("Please select a plan first.");
                return;
            }

            const planId = planSelect.value;
            const planListData = planData.insuredList[0]; // Assuming insuredList[0] contains the plan data
            const plan = planListData.planList[planId];

            if (!plan || !plan.coverList) {
                alert("No covers available for the selected plan.");
                return;
            }

            const newRow = document.createElement("tr");
            newRow.classList.add("cover-row");

            // Create a new row with a dropdown for cover list and populate it
            newRow.innerHTML = `
            <td style="padding:0px 30px">Cover Name: <span style="color:red">*</span> </td>
            <td>
                <select name="plan_cover_list_${index}[]" class="planCoverList" required>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </td>
            <td></td>
              <td>
                        <button style="color:#65558F; background-Color:white; border:1px solid white; cursor:pointer;" type="button" class="removeCoverBtn" onclick="removeCoverRowIndex(this,${index})">Remove</button>
                    </td>
           
        `;

            coverListBody.appendChild(newRow);

            const newCoverSelect = newRow.querySelector(".planCoverList");
            populateCoverOptionsAH(newCoverSelect, plan.coverList);
            disableSelectedOptionsAH(index);
        };
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
        const planId = selectedOption ? selectedOption.getAttribute('data-plan-id') || '' : '';
        const planDescription = selectedOption ? selectedOption.getAttribute('data-plan-description') || '' : '';
            const planInfo = {
                planId: "1838000064",
                planDescription:planDescription,
                planPoi: 12
                // planId: planId,
                // planDescription:planDescription,
                // planPoi: section.querySelector('[name^="planPoi"]').value || ''
            };

            const covers = [];
            const coverRows = section.querySelectorAll('.planCoverList');
            coverRows.forEach((coverSelect) => {
                const selectedOption = coverSelect.querySelector('option:checked');
                if (selectedOption) {
                    covers.push({
                        id: selectedOption.value || '',
                        code: selectedOption.getAttribute('data-cover-code') || null,
                        name: selectedOption.getAttribute('data-cover-name') || null,
                        limitAmount: selectedOption.getAttribute('data-cover-amount') || null
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
                insuredDateOfBirth: section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value? transformDate(section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value) : '',
                insuredMaritalStatus: section.querySelector('[name^="insured_ah_insuredMaritalStatus_"]').value || '',
                insuredOccupation: section.querySelector('[name^="insured_ah_insuredOccupation_"]').value || '',
                insuredCampaignCode: section.querySelector('[name^="insured_ah_insuredCampaignCode_"]').value || '',
                relationToPolicyholder: section.querySelector('[name^="insured_ah_relationToPolicyholder_"]').value || '',
                natureOfBusiness: section.querySelector('[name^="insured_ah_natureOfBusiness_"]').value || '',
                planInfo:{
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
</script>