let planData = null;
let responsePayment=null;
let quotationData=null;
let selectProduct=null;
const token = "eyJraWQiOiItNlk1TWVEaDVxNUotRGJkdTAyQ1BueWRRdkY1TW9TRFBpaHlFTFhUUWZRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULkItRUxDZmVWYmNwY3dOYUNhbi02cldZdUZhaVUyZDFUTGxnS0wydDgzbWciLCJpc3MiOiJodHRwczovL2RldmF1dGgxLmN1c3RvbWVycGx0Zm0uYWlnLmNvbS9vYXV0aDIvYXVzbWdtYnllU28yRUh1SnMxZDYiLCJhdWQiOiJDSUFNX0FQUFMiLCJpYXQiOjE3MjQzOTMxMDUsImV4cCI6MTcyNDQwMDMwNSwiY2lkIjoiMG9hZnRjdnh6ZWVDbTByazExZDciLCJzY3AiOlsiU0dFd2F5UGFydG5lcnNfSVIiXSwic3ViIjoiMG9hZnRjdnh6ZWVDbTByazExZDcifQ.EM7Bynpmg7ixlUspPANei3T4qGt7XYvKVVDKecKQlDX-6IjwkBwD2e2F6O5pzh7kX9Ry_ElfeblqaqX9o78djFSzqBNhKTY14VNDikj1AE5qflC0-MaUbTRbFpS2aCYo4tZLHeHF86Kyp3QdiqJQ7RAL07l9Vu4l5eBNHTvxPRbMuiDQvJDClpI0UTvgCNJB56k5P2DrrwHL2gVu5cFlt1pMPsx4Fi3G0JqcoYAXdDxYuGKV3OWZEu5wzhwzhvpDrxT7wWnijLOGF99CO6QD0HNrB1QTblU57HsMMSfdggXTNGUoGPd31dJSghg_cJ5nyKeao3qMpbyH2yqoxGshnw"
function fetchPremiumAH(requestBody,index) {
    document.body.classList.add('loading');
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
        populatePlanSelectAH(planData.insuredList[0].planList,index);
        return planData;
      } else {
        console.error("Invalid API response:", data);
      }
    })
    .catch((error) => console.error("Error fetching plan data:", error))
    .finally(() => {
        // Remove 'loading' class from body after fetch is complete
        document.body.classList.remove('loading');
    });
}
function fetchPremium(requestBody) {
  document.body.classList.add('loading');
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
      return planData;
    } else {
      console.error("Invalid API response:", data);
    }
  })
  .catch((error) => console.error("Error fetching plan data:", error))
  .finally(() => {
      // Remove 'loading' class from body after fetch is complete
      document.body.classList.remove('loading');
  });
}
async function fetchQuotation(requestBody) {
    document.body.classList.add('loading');
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
      await jQuery.agent.insertQuotationData(requestBody, data); 

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
  } finally {
    document.body.classList.remove('loading');
  }
}
async function fetchPolicy(requestBody) {
  console.log("Fetching Policy data...");
  document.body.classList.add('loading');
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
    if (data?.statusCode === "N02") {
        await jQuery.agent.insertPolicyData(policyid, data?.policyNo); 
      window.alert(data?.statusMessage || "Successfully!");
    } else {
      window.alert("Something Went Wrong!");
    }

    return data; 
  } catch (error) {
    console.error("Error fetching quotation data:", error);
    // Optionally, you can alert the user about the error
    window.alert("Failed to fetch quotation data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  } finally {
    document.body.classList.remove('loading');
  }
}

const handleRequestBody = () => {
  const formData = new FormData(document.getElementById("application"));
  const requestBodyHome = {
    propDate: new Date(),
    productId: formData.get("select-product"),
    distributionChannel: 10,
    producerCode: "0000064000",
    applicationReceivedDate: "",
    policyEffDate: formData.get("PolicyEffectiveDate")
    ? transformDate(formData.get("PolicyEffectiveDate"))
    : "",
    policyExpDate:formData.get("PolicyExpiryDate")
    ? transformDate(formData.get("PolicyExpiryDate"))
    : "",
   
    insuredList: [
      {
        addressInfo: {
          ownerOccupiedType: formData.get("insured_home_ownerOccupiedType"),
        },
      },
    ],
  };
  const requestBodyAuto = {
    productId: formData.get("select-product"),
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
            // occupation: "18",
              occupation: formData.get("insured_auto_driverInfo_occupation") || "",
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
    propDate: new Date(),
    // productId: formData.get("select-product"),
    productId: 600000060,
    
    distributionChannel: "10",
    producerCode: "0000064000",
    applicationReceivedDate: "",
    policyEffDate: "",
    policyExpDate: "",
    insuredList: [
      {
        addressInfo: {
          ownerOccupiedType: "62",
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
function validateAndSubmitFormCallPremium(index) {
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
function callPremiumAH(index) {
  const apiBody = handleRequestBody();
  if (apiBody) {
    fetchPremiumAH(apiBody,index);
  }
}
async function fetchPayment(requestBody) {
    console.log("Fetching payment data...");
    document.body.classList.add('loading');
    const host ="ap-gateway.mastercard.com";
    const merchantId = "TEST97498471";
    const orderId= quotationData?.quoteNo;
    const apiUrl = `https://${host}/api/rest/version/llaatteesstt/merchant/${merchantId}/order/${orderId}/transaction/1`;

    // Basic Auth credentials
    const username = 'merchant.'+merchantId;  // Replace with your actual username
    const password = '8fb334a463b16d4e4d19e3f7639edfd4';  // Replace with your actual password
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
          responsePayment=data
          await jQuery.agent.insertPaymentLog(requestBody, data);
            window.alert("Successfully!");

        } else {
            window.alert("Something Went Wrong!");
        }

        return data; // Return data for further processing
    } catch (error) {
        console.error("Error fetching payment data:", error);
        window.alert("Failed to fetch payment data. Please try again.");
        throw error; // Re-throw the error to be caught by the caller
    } finally{
      document.body.classList.remove('loading');
    }
}



