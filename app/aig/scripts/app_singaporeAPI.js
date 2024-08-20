let planData = null;
const token = "eyJraWQiOiItNlk1TWVEaDVxNUotRGJkdTAyQ1BueWRRdkY1TW9TRFBpaHlFTFhUUWZRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULmlITVprV0VZeDVLVTU1M0F2LXJYX3FyQjQ0UV8yMm16SjhuaVByZUxVY0EiLCJpc3MiOiJodHRwczovL2RldmF1dGgxLmN1c3RvbWVycGx0Zm0uYWlnLmNvbS9vYXV0aDIvYXVzbWdtYnllU28yRUh1SnMxZDYiLCJhdWQiOiJDSUFNX0FQUFMiLCJpYXQiOjE3MjQxMzM0MDYsImV4cCI6MTcyNDE0MDYwNiwiY2lkIjoiMG9hZnRjdnh6ZWVDbTByazExZDciLCJzY3AiOlsiU0dFd2F5UGFydG5lcnNfSVIiXSwic3ViIjoiMG9hZnRjdnh6ZWVDbTByazExZDcifQ.a5Y68NlX8Txvzv4TL0TAUcIqlbHUK_-AyRysMBHDchLaZeeldZ5PQw7fqN4RxWeuMxamlE1Baq6-hOaAG452s9Z_BzMH_T2SWxWyPeDOfJoyyvMDQ2HPBJ8qkyB-6zd1k6cW9VdA7sSOXm367tkM_E-MCSwUD1XOXVmEX5yO6zI6k26sEsQ6QGGoR995f_L6H9WhIGuMPCsG5KINc1a2Y4jLLkwdY_gv_qdrIw6pQ3Ovicz9Fc8j8KYwYB3eYPp3EkIVoDCqHGLpIiloU3NBeW54gMXfij9mUnUAI4LZpO1aZ5FqCCaU1xuBRNu8-di99mCNQkWfsi6tuS6bkjvkJQ"
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

        //addplan to db
        // jQuery.agent
        //   .insertPremiumData(planData.insuredList[0].planList["1"])
        //   .then((response) => {
        //     if (response?.result == "success") {
        //       console.log("Response:", response);
        //     }
        //   })
        //   .catch((error) => {
        //     console.log("Error occurred:", error);
        //   });

          clearPlanInfo()
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
  const formElement = document.getElementById("application");
  const formData = new FormData(formElement);
  const requiredFields = handleRequiredField();
  let allFieldsFilled = true;

  // Remove previous error styles
  requiredFields.forEach((field) => {
    const inputElement = formElement.querySelector(`[name="${field}"]`);
    if (inputElement) {
      inputElement.classList.remove("error-border");
    }
  });

  requiredFields.forEach((field) => {
    const value = formData.get(field);
    const inputElement = formElement.querySelector(`[name="${field}"]`);

    if (value === null || value.trim() === "" || value === "") {
      allFieldsFilled = false;
      console.log(`Field "${field}" is required.`);
      if (inputElement) {
        inputElement.classList.add("error-border");
      }
    }
  });

  if (!allFieldsFilled) {
    console.log("Please fill in all required fields.");
    window.alert("Please fill in all required fields.");
    return;
  }

  const apiBody = handleRequestBody();
  if (apiBody) {
    fetchPremium(apiBody);
  }
}
async function fetchPayment(requestBody) {
    console.log("Fetching payment data...");
    const host ="ap-gateway.mastercard.com";
    const merchantId = "TEST97454671";
    const orderId= "777624035";
    const apiUrl = `https://${host}/api/rest/version/llaatteesstt/merchant/${merchantId}/order/${orderId}/transaction/1`;

    // Basic Auth credentials
    const username = 'merchant.'+merchantId;  // Replace with your actual username
    const password = '43e8e5dd31377e6cefe7f33f714246d3';  // Replace with your actual password
    const credentials = btoa(`${username}:${password}`); // Base64 encode credentials

    try {
        const response = await fetch(apiUrl, {
            method: "PUT",
            headers: {
                'Authorization': `Basic ${credentials}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestBody),
        });

        if (!response.ok) {
            // Log response body for debugging
            const errorText = await response.text();
            throw new Error(`HTTP error! Status: ${response.status}, Body: ${errorText}`);
        }

        const data = await response.json();
        console.log("data", data);

        if (data?.result === "SUCCESS") {
            window.alert("Successfully!");
        } else {
            window.alert("Something Went Wrong!");
        }

        return data; // Return data for further processing
    } catch (error) {
        console.error("Error fetching payment data:", error);
        window.alert("Failed to fetch payment data. Please try again.");
        throw error; // Re-throw the error to be caught by the caller
    }
}

//handlePayment
document.addEventListener('DOMContentLoaded', function() {
    const paymentContainer = document.getElementById('payment-container');
    const submitButton = document.getElementById('btnPayment');

    if (!paymentContainer) {
        console.error('The payment container was not found');
        return;
    }

    // Function to get the data from the div elements
    function getFormData() {
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
                amount: "100.00",
                currency: "SGD"
            },
            sourceOfFunds: {
                type: "CARD",
                provided: {
                    card: {
                        number: "5123456789012346",
                        // number: formData['payment_cardNumber'],
                        expiry: {
                            month: expMonth,
                            year: expYear
                        },
                        securityCode: Number(formData['payment_securityCode'])
                    }
                }
            }
        };
    }

    function validateFields() {
        const paymentMode = document.querySelector('select[name="Payment_Mode"]').value;
        const paymentFrequency = document.querySelector('input[name="Payment_Frequency"]:checked');
        const cardType = document.querySelector('select[name="Payment_CardType"]').value;
        const cardNumber = document.querySelector('input[name="payment_cardNumber"]').value;
        const expiryDate = document.querySelector('input[name="payment_expiryDate"]').value;
        const securityCode = document.querySelector('input[name="payment_securityCode"]').value;

        if (!paymentMode || !paymentFrequency || !cardType || !cardNumber || !expiryDate || !securityCode) {
            window.alert('Please fill out all required fields.');
            return false;
        }

        return true;
    }
    // Event listener for the button click
    if (submitButton) {
        submitButton.addEventListener('click', async function() {
            paymentContainer.removeAttribute('hidden');
            if (validateFields()){
                const requestBody = getFormData();
                try {
                    await fetchPayment(requestBody);
                } catch (error) {
                    console.error("Failed to fetch payment data:", error);
                    window.alert("Failed to fetch payment data. Please try again.");
                }
            }
            
        });
    } else {
        console.error('The submit button was not found');
    }
});

