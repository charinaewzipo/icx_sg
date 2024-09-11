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
                <td>Insured Full Name: <span style="color:red">*</span></td>
                <td><input type="text" name="insured_ah_insuredFirstName_${index}" maxlength="60" required /></td>
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
                <td>Insured ID Type: <span style="color:red">*</span></td>
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
                <td>Insured Date Of Birth: <span style="color:red">*</span></td>
                <td><input type="text" id="datepicker-${index}" name="insured_ah_insuredDateOfBirth_${index}" maxlength="60" required /></td>
                <th style="width:50px">&nbsp;</th>
               <td>Age :</td>   
              <td>
                <input type="text" id="ageInsuredPerson_${index}" name="ageInsuredPerson_${index}" maxlength="4" readonly  style="max-width:50px">  years old
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
                   <select id="planSelect${index}" name="planId${index}" required >
    <option value="">
        <-- Please select an option -->
    </option>
<option value="1838000060" hidden>Standard - Basic</option>
    <option value="1838000061" hidden>Standard - Comprehensive</option>
    <option value="1838000062" hidden>Preferred - Basic</option>
    <option value="1838000063" hidden>Preferred - Comprehensive</option>
    <option value="1838000064" hidden>Deluxe - Basic</option>
    <option value="1838000065" hidden>Deluxe - Comprehensive</option>
    <option value="1838000066" hidden>Prestige - Basic</option>
    <option value="1838000067" hidden>Prestige - Comprehensive</option>
    <option value="1839000100" hidden>Personal Accident Direct</option>
    <option value="1838000103" hidden>Basic</option>
    <option value="1838000104" hidden>Comprehensive</option>
    <option value="1762000023" hidden>Plan 1</option>
    <option value="1762000025" hidden>Plan 2</option>
    <option value="1762000027" hidden>Plan 3</option>
</select>

                </td>
                <th style="width:50px"></th>
                <td style="white-space: nowrap;">Plan Poi :</td>
                <td colspan="2">
                <select id="planPoiSelect${index}" name="planPoi${index}">
                <option value="">
        <-- Please select an option -->
    </option>
     <option value="1">
       1
    </option>
     <option value="12">
       12
    </option>
                </select>
                </td>
            </tr>
            <tr>
                <td>Cover List</td>
                <td></td>
            </tr>
            <tbody id="coverListBody${index}">
                <tr class="cover-row">
                    <td style="padding:0 30px">Cover Name: </td>
                    <td>
                        <select name="plan_cover_list_${index}[]" id="plan_cover_list_${index}" class="planCoverList" style="max-width: 216px;" >
                            <option value="">
                                <-- Please select an option -->
                            </option>
                        </select>
                    </td>
                <td></td>
                
                 
          
            </tbody>
                 </tr>
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
               
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
            fetchCoverList(planId, planPoi, insuredDob, index);
        }
    }


   

    function addPlanInfoSections(count) {
        const insuredContainer = document.getElementById('insured-list-ah');
        insuredContainer.innerHTML = '';
        for (let i = 1; i <= count; i++) {
            const insuredSectionHTML = createListAhSection(i);
            insuredContainer.innerHTML += insuredSectionHTML;
        }
        for (let i = 1; i <= count; i++) {
            initializeDatepicker(i);
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
                const age = calculateAge(dateText);
                $(`#ageInsuredPerson_${index}`).val(age);
            }
        });
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
                planDescription: planDescription,
                planPoi: section.querySelector('[name^="planPoi"]').value || ''
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

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const campaign_id = urlParams.get("campaign_id");
            const personInfo = {

                insuredFirstName: section.querySelector('[name^="insured_ah_insuredFirstName_"]').value || '',
                // insuredLastName: section.querySelector('[name^="insured_ah_insuredLastName_"]').value || '',
                insuredFullName: (section.querySelector('[name^="insured_ah_insuredFirstName_"]').value || ''),
                // insuredFullName: (section.querySelector('[name^="insured_ah_insuredFirstName_"]').value || '') + ' ' + (section.querySelector('[name^="insured_ah_insuredLastName_"]').value || ''),
                insuredResidentStatus: section.querySelector('[name^="insured_ah_insuredResidentStatus_"]').value || '',
                insuredIdType: section.querySelector('[name^="insured_ah_insuredIdType_"]').value || '',
                insuredIdNumber: section.querySelector('[name^="insured_ah_insuredIdNumber_"]').value || '',
                insuredGender: section.querySelector('[name^="insured_ah_insuredGender_"]').value || '',
                insuredDateOfBirth: section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value ? transformDate(section.querySelector('[name^="insured_ah_insuredDateOfBirth_"]').value) : '',
                insuredMaritalStatus: section.querySelector('[name^="insured_ah_insuredMaritalStatus_"]').value || '',
                insuredOccupation: section.querySelector('[name^="insured_ah_insuredOccupation_"]').value || '',
                insuredCampaignCode: campaign_id || '',
                // insuredCampaignCode: section.querySelector('[name^="insured_ah_insuredCampaignCode_"]').value || '',
                relationToPolicyholder: section.querySelector('[name^="insured_ah_relationToPolicyholder_"]').value || '',
                // natureOfBusiness: section.querySelector('[name^="insured_ah_natureOfBusiness_"]').value || '',
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

        if (isNaN(dobDate.getTime())) {
            console.error('Invalid Date:', dob);
            return ''; // Return empty if invalid date
        }

        let age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();

        // Adjust the age if the current month is before the birth month, or it's the birth month but the current date is before the birth date
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
                if (Array.isArray(result) && result.length > 0 && id === null) {
                    manualSetDefaultValueFormCallingList(result[0]); // Assuming you want the first item
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
                body: new URLSearchParams({
                    campaign_id: campaign_id
                })
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
            option.textContent = `${plan.plan_desc}`;
            option.setAttribute('data-poi', plan.plan_poi);
            option.setAttribute('data-desc', plan.plan_desc);

            selectElement.appendChild(option);
        });
    }

    function handlePaymentFrequencyChange(radio) {
        const paymentFrequency = radio.value;
        const paymentMode = document.querySelector('select[name="Payment_Mode"]').value;
        fetchPaymentOption(paymentMode, paymentFrequency);
    }

    function handlePaymentModeChange(select) {
        const paymentMode = select.value;
        const paymentFrequency = document.querySelector('input[name="Payment_Frequency"]:checked').value;
        fetchPaymentOption(paymentMode, paymentFrequency);
    }

    function fetchPaymentOption(paymentMode, paymentFrequency) {
        if (!paymentMode || !paymentFrequency) return;

        const url = `../scripts/get_payment_option.php?payment_mode=${paymentMode}&payment_frequency=${paymentFrequency}`;
        document.body.classList.add('loading');

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const cardTypeSelect = document.querySelector('select[name="Payment_CardType"]');

                cardTypeSelect.innerHTML = '';

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

    function handleProductChange(selectElement) {
        const selectedProductId = selectElement.value;
        const planSelectElements = document.querySelectorAll('[id^="planSelect"]');
        planSelectElements.forEach((selectElement, index) => {
            populatePlans(selectedProductId, index + 1);
            populateCovers(selectedProductId, index + 1);
        });
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
                console.log('Element:', planSelect);
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
                console.log('Element:', plan_cover_list_);
                if (!plan_cover_list_) {
                    console.error(`No element found with ID: plan_cover_list_${index}`);
                    return;
                }

                // Clear previous options
                plan_cover_list_.innerHTML = '<option value="">&lt;-- Please select an option --&gt;</option>';

                // Handle no plans case
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.textContent = 'No plans available';
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

    document.addEventListener('DOMContentLoaded', () => {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        checkParamsId = urlParams.get("id");
        if (!checkParamsId) {
            fetchCallingList()
        }
        fetchCampaignDetail()
        addPlanInfoSections(2)
    });
</script>