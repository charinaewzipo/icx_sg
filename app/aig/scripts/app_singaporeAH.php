<script>
    let select_product = null

    function createListAhSection(index) {
        const isRequired = index === 1; // Set to `true` if you want `required` only for index 1, otherwise `false`
        const showAsterisk = index === 1 ? '<span style="color:red">*</span>' : ''; // Only show the asterisk for index 1

        return `
        <table id="table-form-${index}" class="table-ah" name="table-form-${index}">
            <tbody>
                <tr>
                    <td colspan="6">
                        <h2>Person ${index}</h2>
                    </td>
                </tr>
                <tr>
                    <td>Insured Full Name: ${showAsterisk}</td>
                    <td><input type="text" name="insured_ah_insuredFirstName_${index}" maxlength="60" ${isRequired ? 'required' : ''} /></td>
                    <th style="width:50px">&nbsp;</th>
                    <td>Insured Gender: ${showAsterisk}</td>
                    <td>
                        <select name="insured_ah_insuredGender_${index}" ${isRequired ? 'required' : ''}>
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
                  <td style="${index === 2 ? 'padding-right:10px;' : ''}">Insured Resident Status: ${showAsterisk}</td>
                    <td>
                        <select name="insured_ah_insuredResidentStatus_${index}" ${isRequired ? 'required' : ''}>
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
                    <td>Insured ID Type: ${showAsterisk}</td>
                    <td>
                        <select name="insured_ah_insuredIdType_${index}" ${isRequired ? 'required' : ''}>
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
                    <td>Insured ID Number: ${showAsterisk}</td>
                    <td><input type="text" name="insured_ah_insuredIdNumber_${index}" maxlength="20" ${isRequired ? 'required' : ''} /></td>
                    <th style="width:50px">&nbsp;</th>
                    <td>Insured Marital Status: ${showAsterisk}</td>
                    <td>
                        <select name="insured_ah_insuredMaritalStatus_${index}" ${isRequired ? 'required' : ''}>
                            <option value=""> <-- Please select an option --></option>
                            <?php
                            $strSQL = "SELECT * FROM t_aig_sg_lov where name = 'Marital Status'";
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
                    <td>Insured Date Of Birth: ${showAsterisk}</td>
                    <td><input type="text" id="datepicker-${index}" name="insured_ah_insuredDateOfBirth_${index}" maxlength="60" ${isRequired ? 'required' : ''} /></td>
                    <th style="width:50px">&nbsp;</th>
                    <td>Age :</td>   
                    <td>
                        <input type="text" id="ageInsuredPerson_${index}" name="ageInsuredPerson_${index}" maxlength="4" readonly  style="max-width:50px">  years old
                    </td>
                </tr>
                <tr>
                    <td>Insured Occupation: ${showAsterisk}</td>
                    <td>
                        <select name="insured_ah_insuredOccupation_${index}" ${isRequired ? 'required' : ''}>
                            <option value=""> <-- Please select an option --></option>
                            <?php
                            $strSQL = "SELECT name, id, description
                                FROM t_aig_sg_lov 
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
                    <td style="${index === 2 ? 'padding-right:10px;' : ''}">Relation To Policy Holder:${showAsterisk}</td>
                    <td>
                        <select name="insured_ah_relationToPolicyholder_${index}" ${isRequired ? 'required' : ''}>
                            <option value=""> <-- Please select an option --></option>
                            <?php
                            $strSQL = "SELECT name, id, description
                                FROM t_aig_sg_lov 
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
            </tbody>
            <tbody ${index === 2 ? 'style="display: none;"' : ''}>
                <tr>
                    <td>
                        <h1>Plan Info</h1>
                    </td>
                </tr>
                <tr>
                    <td style="white-space:nowrap">Plan Name : ${showAsterisk}</td>
                    <td>
                        <select id="planSelect${index}" name="planId${index}" ${index===1 ? 'required' : ''}>
                            <option value="">
                                <-- Please select an option -->
                            </option>
                        </select>
                    </td>
                    <th style="width:50px"></th>
                  <td style="white-space: nowrap; " >Plan Poi : ${showAsterisk}</td>
                <td colspan="2">
                    <select id="planPoiSelect${index}" disabled name="planPoi${index}" ${isRequired ? 'required' : ''} ${index === 2 ? 'style="display: none;"' : ''}>
                        <option value="">
                            <-- Please select an option -->
                        </option>
                        <option value="1">1</option>
                        <option value="12">12</option>
                    </select>
                </td>
                </tr>
                <tr>
                    <td>Cover List</td>
                    <td></td>
                </tr>
                <tbody id="coverListBody${index}" ${index === 2 ? 'style="display: none;"' : ''}>
                    <tr class="cover-row">
                        <td style="padding:0 30px">Cover Name: </td>
                        <td>
                            <select name="plan_cover_list_${index}[]" id="plan_cover_list_${index}" class="planCoverList" style="max-width: 216px;">
                                <option value="">
                                    <-- Please select an option -->
                                </option>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </tbody>
            
           
        </table>
        <br>
        <hr>
    `;
    }

    function createListAhSectionChild(index, data) {
    const firstName = data?.insuredFirstName || '';
    const lastName = data?.insuredLastName || '';
    const gender = data?.insuredGender || '';
    const idType = data?.insuredIdType || '';
    const idNumber = data?.insuredIdNumber || '';
    const occupation = data?.insuredOccupation || '';
    const dob = data?.insuredDateOfBirth ? isoToFormattedDate(data.insuredDateOfBirth) : '';
    const age = data?.age || '';

    return `
    <table id="table-form-${index}" class="table-ah" name="table-form-${index}">
        <tbody>
            <tr>
                <td colspan="6">
                    <h2>Child ${index-2}</h2>
                </td>
            </tr>
            <tr>
                <td>Insured Full Name: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredFirstName_${index}" maxlength="60" value="${firstName}" required /></td>
                <th style="width:50px">&nbsp;</th>
                <td>Insured Gender: <span style="color:red">*</span></td>
                <td>
                    <select id="genderDropdown_${index}" name="insured_ah_insuredGender_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                        <?php
                        // Gender options
                        $strSQL = "SELECT * FROM t_aig_sg_lov WHERE name = 'insuredGender'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $selected = ($objResult["id"] == "${gender}") ? 'selected' : '';
                            echo "<option value='" . $objResult["id"] . "' $selected>" . $objResult["description"] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insured ID Type:<span style="color:red">*</span></td>
                <td>
                    <select id="idTypeDropdown_${index}" name="insured_ah_insuredIdType_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                        <?php
                        // ID Type options
                        $strSQL = "SELECT * FROM t_aig_sg_lov WHERE name = 'insuredIdType'";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $selected = ($objResult["id"] == "${idType}") ? 'selected' : '';
                            echo "<option value='" . $objResult["id"] . "' $selected>" . $objResult["description"] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <th></th>
                <td>Insured ID Number: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredIdNumber_${index}" maxlength="20" value="${idNumber}" required /></td>
            </tr>
            <tr>
                <td>Insured Occupation: <span style="color:red">*</span></td>
                <td>
                    <select id="occupationDropdown_${index}" name="insured_ah_insuredOccupation_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                        
                        <?php
                        // Occupation options
                        $strSQL = "SELECT name, id, description, source
FROM t_aig_sg_lov 
WHERE name = 'PA Occupation'
AND (id = '147' OR id = '323');";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $selected = ($objResult["id"] == "${occupation}") ? 'selected' : '';
                            echo "<option value='" . $objResult["id"] . "' $selected>" . $objResult["description"] . "</option>";
                        }
                        ?>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insured Date Of Birth: <span style="color:red">*</span></td>
                <td><input type="text" id="datepicker-${index}" name="insured_ah_insuredDateOfBirth_${index}" maxlength="60" value="${dob}" required /></td>
                <th style="width:50px">&nbsp;</th>
                <td>Age :</td>
                <td>
                    <input type="text" id="ageInsuredPerson_${index}" name="ageInsuredPerson_${index}" maxlength="10" value="${age}" readonly>
                </td>
                <td style="padding-left:50px">
                    <button type="button" class="delete-child draft-button" data-index="${index}" style="float:right; padding:5px;cursor:pointer;border-radius:5px">Delete</button>
                </td>
            </tr>
            <tr style="display:none">
                <td>Relation To Policy Holder: <span style="color:red">*</span></td>
                <td>
                    <select name="insured_ah_relationToPolicyholder_${index}" required>
                        <option value=""> <-- Please select an option --></option>
                        <?php
                        // Relation to policy holder, fixed value
                        $strSQL = "SELECT name, id, description FROM t_aig_sg_lov WHERE name='PH Relation' AND id=2";
                        $objQuery = mysqli_query($Conn, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $isSelected = ($objResult["id"] == 2) ? 'selected' : '';
                            echo "<option value='" . $objResult["id"] . "' $isSelected>" . $objResult["description"] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    `;
}




    async function addInsuredSections(count) {
        const insuredContainer = document.getElementById('insured-list-ah');
        insuredContainer.innerHTML = '';
        for (let i = 1; i <= count; i++) {
            const insuredSectionHTML = createListAhSection(i);
            insuredContainer.innerHTML += insuredSectionHTML;
        }
        for (let i = 1; i <= count; i++) {
            initializeDatepicker(i);
        }
        for (let i = 1; i <= count; i++) {
            attachInsuredIdValidation(i)
        }
    }

    function initializeDatepicker(index) {
        $(`#datepicker-${index}`).datepicker({
            yearRange: "c-80:c+20",
            maxDate: new Date(),
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            changeYear: true,
            showAnim: "slideDown",
            onSelect: function(dateText) {
                displayDateInsured(dateText, index)
            }
        });
    }

    function collectFormData() {
        const insuredList = [];
        const formSections = document.querySelectorAll('table[id^="table-form-"]');
        let tempPlan = {};

        formSections.forEach((section, index) => {
            console.log("index:", index);

            // Validate certain fields if index === 1
            if (index === 1) {
                const insuredFirstName = section.querySelector('[name^="insured_ah_insuredFirstName_"]')?.value || '';
                const insuredFullName = section.querySelector('[name^="insured_ah_insuredFirstName_"]')?.value || '';
                const insuredResidentStatus = section.querySelector('[name^="insured_ah_insuredResidentStatus_"]')?.value || '';
                const insuredIdType = section.querySelector('[name^="insured_ah_insuredIdType_"]')?.value || '';
                const insuredIdNumber = section.querySelector('[name^="insured_ah_insuredIdNumber_"]')?.value || '';
                const insuredGender = section.querySelector('[name^="insured_ah_insuredGender_"]')?.value || '';
                const insuredDateOfBirth = section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]')?.value ?
                    transformDate(section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]')?.value) : '';
                const insuredMaritalStatus = section.querySelector('[name^="insured_ah_insuredMaritalStatus_"]')?.value || '';
                const insuredOccupation = section.querySelector('[name^="insured_ah_insuredOccupation_"]')?.value || '';

                // Check if any of these values are missing
                if (!insuredFirstName || !insuredFullName || !insuredResidentStatus || !insuredIdType ||
                    !insuredIdNumber || !insuredGender || !insuredDateOfBirth || !insuredMaritalStatus || !insuredOccupation) {
                    console.log("Skipping section at index 1 due to missing information.");
                    return; // Skip the rest of the iteration if required fields are missing
                }
            }

            const planSelect = section.querySelector('[name^="planId"]');
            const selectedOption = planSelect ? planSelect.options[planSelect.selectedIndex] : null;
            const planId = selectedOption ? selectedOption.value || '' : '';
            const planDescription = selectedOption ? selectedOption.getAttribute('data-desc') || '' : '';

            const planInfo = {
                planId: planId,
                planDescription: planDescription,
                planPoi: section.querySelector('[name^="planPoi"]')?.value || ''
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
                    });
                }
            });

            // Save tempPlan from the first section (index 0)
            if (index === 0) {
                tempPlan = {
                    ...planInfo,
                    covers: covers
                };
            }

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const campaign_id = urlParams.get("campaign_id");
            const personInfo = {
                insuredFirstName: section.querySelector('[name^="insured_ah_insuredFirstName_"]')?.value || '',
                insuredFullName: section.querySelector('[name^="insured_ah_insuredFirstName_"]')?.value || '',
                insuredResidentStatus: section.querySelector('[name^="insured_ah_insuredResidentStatus_"]')?.value || '',
                insuredIdType: section.querySelector('[name^="insured_ah_insuredIdType_"]')?.value || '',
                insuredIdNumber: section.querySelector('[name^="insured_ah_insuredIdNumber_"]')?.value || '',
                insuredGender: section.querySelector('[name^="insured_ah_insuredGender_"]')?.value || '',
                insuredDateOfBirth: section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]')?.value ?
                    transformDate(section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]')?.value) : '',
                insuredMaritalStatus: section.querySelector('[name^="insured_ah_insuredMaritalStatus_"]')?.value || '',
                insuredOccupation: section.querySelector('[name^="insured_ah_insuredOccupation_"]')?.value || '',
                insuredCampaignCode: productDetail?.insure_campaign_code || '',
                relationToPolicyholder: section.querySelector('[name^="insured_ah_relationToPolicyholder_"]')?.value || '',
                planInfo: {
                    ...tempPlan
                }
            };

            const insuredData = {
                personInfo: personInfo
            };

            insuredList.push(insuredData);
        });

        console.log("insuredList", insuredList);
        return insuredList;
    }



    function calculateAge(dob) {
        const dobDate = new Date(dob);
        const today = new Date();

        if (isNaN(dobDate.getTime())) {
            console.error('Invalid Date:', dob);
            return {
                age: '',
                days: ''
            }; // Return empty if invalid date
        }

        let age = today.getFullYear() - dobDate.getFullYear();
        let days = Math.floor((today - dobDate) / (1000 * 60 * 60 * 24)); // Total days difference

        const monthDiff = today.getMonth() - dobDate.getMonth();

        // Adjust the age if the current month is before the birth month, or it's the birth month but the current date is before the birth date
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }

        // Adjust the days to consider the exact age in days
        const lastBirthday = new Date(today.getFullYear(), dobDate.getMonth(), dobDate.getDate());
        if (lastBirthday > today) {
            lastBirthday.setFullYear(lastBirthday.getFullYear() - 1);
        }
        days = Math.floor((today - lastBirthday) / (1000 * 60 * 60 * 24));

        return {
            age,
            days
        };
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

    function fetchCallingList() {
        document.body.classList.add('loading');
        const callListId = <?php echo json_encode($_GET["calllist_id"]); ?>;
        console.log("callListId:", callListId)
        fetch('../scripts/get_callList_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    calllist_id: callListId
                })
            })
            .then(response => response.text())
            .then(data => {
                const result = JSON.parse(data)
                
                if (Array.isArray(result) && result.length > 0 && !id) {
                    manualSetDefaultValueFormCallingList(result[0]);
                }
                calllistDetail=result[0]
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
                body: new URLSearchParams({
                    campaign_id: campaign_id
                })
            })
            .then(response => response.text())
            .then(data => {
                // campaignDetailsFromAPI=
                const result =JSON.parse(data)
                console.log("result:", result)
                // console.log("selectedType",selectedType)
                if (Array.isArray(result) && result.length > 0) {
                    // selectedType =result[0].cp_type  // Assuming you want the first item
                campaignDetailsFromAPI=result[0];

                } 

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
            option.textContent = `${plan.plan_desc}`;
            option.setAttribute('data-poi', plan.plan_poi);
            option.setAttribute('data-desc', plan.plan_desc);

            selectElement.appendChild(option);
        });
    }
    async function handleProductChange(selectElement) {
        console.log("handleProductChange:")
        const selectedProductId = selectElement.value;
        select_product = selectedProductId
        const responseProduct = await getProductDetail(selectedProductId);

        if (responseProduct) {
            await addInsuredSections(responseProduct?.number_of_person_insured || 2)

            //handle ProductId setValue from API but not change PlanPoi
            const defaultRadio = document.querySelector('input[name="Payment_Frequency"]:checked');
            if (!id || !quotationData?.quoteNo) {
                handlePaymentFrequencyChange(defaultRadio);
            }
        }
        const planSelectElements = document.querySelectorAll('[id^="planSelect"]');
        planSelectElements.forEach((selectElement, index) => {
            if (index === 0) { // Populate only the first one (index 0)
                populatePlans(selectedProductId, index + 1); // Adjust index to be 1-based if needed
                populateCovers(selectedProductId, index + 1); // Adjust index to be 1-based if needed
            }
        });
        if (!id) {
            setDefaultRemarksC(responseProduct)
        }


    }

    function populatePlans(productId, index) {
        if (!productId) return;

        const url = `../scripts/get_plan.php?product_id=${productId}`;
        document.body.classList.add('loading');

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const planSelect = document.getElementById('planSelect' + index);

                // Debugging
                if (!planSelect) {
                    console.error(`No element found with ID: planSelect${index}`);
                    return;
                }

                // Clear previous options
                planSelect.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';

                // Handle no plans case
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.textContent = 'No plans available';
                    option.disabled = true;
                    planSelect.appendChild(option);
                    return;
                }

                // Populate the dropdown with new options
                data.forEach(plan => {
                    const option = document.createElement('option');
                    option.value = plan.plan_code; // Use plan_code as value
                    option.textContent = plan.plan_name; // Display plan_name
                    option.setAttribute('data-desc', plan.plan_name);
                    planSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching plans:', error))
            .finally(() => {
                document.body.classList.remove('loading');
            });
    }

    function populateCovers(productId, index) {
        if (!productId) return;

        const url = `../scripts/get_cover.php?product_id=${productId}`;
        document.body.classList.add('loading');

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const plan_cover_list_ = document.getElementById('plan_cover_list_' + index);

                // Debugging
                if (!plan_cover_list_) {
                    console.error(`No element found with ID: plan_cover_list_${index}`);
                    return;
                }

                // Clear previous options
                plan_cover_list_.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';

                // Handle no plans case
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.textContent = 'No covers available';
                    option.disabled = true;
                    plan_cover_list_.appendChild(option);
                    return;
                }

                // Populate the dropdown with new options
                data.forEach(cover => {
                    const option = document.createElement('option');
                    option.value = cover.cover_id;
                    option.textContent = cover.cover_name;
                    option.setAttribute('data-cover-code', cover.cover_code);
                    option.setAttribute('data-cover-name', cover.cover_name);
                    plan_cover_list_.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching plans:', error))
            .finally(() => {
                document.body.classList.remove('loading');
            });
    }


    function validateInsuredIdNumber(index) {
        const idTypeSelect = document.querySelector(`select[name="insured_ah_insuredIdType_${index}"]`);
        const idNumberInput = document.querySelector(`input[name="insured_ah_insuredIdNumber_${index}"]`);

        if (!idTypeSelect || !idNumberInput) return; // Ensure the elements exist

        const idType = idTypeSelect.value;
        const idNumber = idNumberInput.value;

        // Regular expression for the pattern: letter-7 digits-letter
        const idPattern = /^[A-Za-z]\d{7}[A-Za-z]$/;

        if (idType === '9' || idType === '10' || idType === '6') { // NRIC, FIN, or Birth Certificate
            if (!idPattern.test(idNumber)) {
                console.log("Invalid ID number");
                idNumberInput.setCustomValidity("Invalid format. ID should be in the format: letter-7 digits-letter.");
            } else {
                idNumberInput.setCustomValidity(""); // Clear custom error if valid
            }
        } else {
            idNumberInput.setCustomValidity(""); // Clear custom error for other types
        }
        idNumberInput.reportValidity();
    }

    // Attach event listeners dynamically for insured's ID
    function attachInsuredIdValidation(index) {
        const idTypeSelect = document.querySelector(`select[name="insured_ah_insuredIdType_${index}"]`);
        const idNumberInput = document.querySelector(`input[name="insured_ah_insuredIdNumber_${index}"]`);

        if (idTypeSelect && idNumberInput) {
            idTypeSelect.addEventListener('change', () => validateInsuredIdNumber(index));
            idNumberInput.addEventListener('input', () => validateInsuredIdNumber(index));
        }
    }



    //child start at index=3
    let indexCounter = 3

    function addChildInsured() {
        const addButton = document.getElementById('add-insured-child');
        addButton.addEventListener('click', () => {
            console.log("indexCounter:", indexCounter)
            const insuredContainer = document.getElementById('insured-list-ah');
            if (indexCounter <= 7) {

                const currentIndex = indexCounter;

                insuredContainer.insertAdjacentHTML('beforeend', createListAhSectionChild(currentIndex));

                indexCounter++;


                //handleForm
                $("#datepicker-" + currentIndex).datepicker({
                    yearRange: "c-80:c+20",
                    maxDate: new Date(),
                    dateFormat: 'mm/dd/yy',
                    changeMonth: true,
                    changeYear: true,
                    showAnim: "slideDown",
                    onSelect: function(dateText) {
                        console.log("currentIndex:", currentIndex);
                        displayDateInsuredChild(dateText, currentIndex);
                    }
                });
                attachInsuredIdValidation(currentIndex)






                if (indexCounter > 6) {
                    addButton.style.display = 'none';
                }
            }
        });
    }



    function deleteChildInsured() {
        const insuredContainer = document.getElementById('insured-list-ah');

        insuredContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-child')) {
                const index = event.target.getAttribute('data-index');
                const tableToRemove = document.getElementById(`table-form-${index}`);
                if (tableToRemove) {
                    tableToRemove.remove();
                    // Adjust the indexCounter and button visibility if necessary
                    indexCounter--;
                    if (indexCounter < 4) {
                        document.getElementById('add-insured-child').style.display = 'block';
                    }
                }
            }
        });
    }


    const displayDateInsuredChild = (dateText, index) => {
        const {
            age,
            days
        } = calculateAge(dateText);
        console.log("days:", days);
        console.log("index", index);

        const occupationValue = document.querySelector(`select[name="insured_ah_insuredOccupation_${index}"]`);

        if (!productDetail) {
            alert("Please select a product");
            $(`#datepicker-${index}`).val(''); // Clear the datepicker input
            $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
            return;
        }

        // Handle minimum age (0 years old and more than 15 days)
        if (age === 0 && days < 15) {
            alert(`Child must be at least 15 days old.`);
            $(`#datepicker-${index}`).val(''); // Clear the datepicker input
            $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
            return;
        }

        // Check if the occupation indicates a student
        if (occupationValue && occupationValue.value === '147') {
            console.log("student");
            if (age > 25) {
                alert(`Child must be less than or equal to 25 years old.`);
                $(`#datepicker-${index}`).val(''); // Clear the datepicker input
                $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
                return;
            }
        }

        // Handle maximum age (based on productDetail)
        if (age > productDetail?.max_age_child) {
            alert(`Child must be less than or equal to ${productDetail?.max_age_child} years old.`);
            $(`#datepicker-${index}`).val(''); // Clear the datepicker input
            $(`#ageInsuredPerson_${index}`).val(''); // Clear the age input field
            return;
        }

        // If age and days are valid, set the age value
        $(`#ageInsuredPerson_${index}`).val(`${days} day - ${age} years old`);
    };


    document.addEventListener('DOMContentLoaded', () => {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        checkParamsId = urlParams.get("id");
        fetchCallingList()
        fetchCampaignDetail()

        addInsuredSections(2)
        addChildInsured()
        deleteChildInsured()


    });
    const fillInsuredSectionChild = (insuredData) => {
        const filterchild = insuredData.filter(i => i?.personInfo?.relationToPolicyholder === "2");
        let indexCounterChild = 3;
        filterchild.forEach((child, childIndex) => {
            const currentIndex = indexCounterChild;


            const insuredContainer = document.getElementById('insured-list-ah');
            const childSectionHTML = createListAhSectionChild(currentIndex, child.personInfo);
            insuredContainer.insertAdjacentHTML('beforeend', childSectionHTML);
    
            document.getElementById(`genderDropdown_${currentIndex}`).value = child?.personInfo?.insuredGender;
            document.getElementById(`idTypeDropdown_${currentIndex}`).value = child?.personInfo?.insuredIdType;
            document.getElementById(`occupationDropdown_${currentIndex}`).value = child?.personInfo?.insuredOccupation;
            const {
            age,
            days
        } = calculateAge(child?.personInfo?.insuredDateOfBirth);
            document.getElementById(`ageInsuredPerson_${currentIndex}`).value = `${days} day - ${age} years old`;

            indexCounterChild++;

            // Handle datepicker for each new child section
            $("#datepicker-" + currentIndex).datepicker({
                yearRange: "c-80:c+20",
                maxDate: new Date(),
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown",
                onSelect: function(dateText) {
                    console.log("currentIndex:", currentIndex);
                    displayDateInsuredChild(dateText, currentIndex);
                }
            });

            attachInsuredIdValidation(currentIndex); // Attach validation to the new section

            if (indexCounterChild > 6) {
                document.getElementById('add-insured-child').style.display = 'none';
            }
        });
    }
</script>