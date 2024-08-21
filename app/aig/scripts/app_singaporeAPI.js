let planData = null;
let responsePayment=null;
let quotationData=null;
const token = "eyJraWQiOiItNlk1TWVEaDVxNUotRGJkdTAyQ1BueWRRdkY1TW9TRFBpaHlFTFhUUWZRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULmNueHZKdnpFRFJYMzZqUF9lNk5fcWM0TEdISWt2U2hQZk9nOTNPQ1c4UTAiLCJpc3MiOiJodHRwczovL2RldmF1dGgxLmN1c3RvbWVycGx0Zm0uYWlnLmNvbS9vYXV0aDIvYXVzbWdtYnllU28yRUh1SnMxZDYiLCJhdWQiOiJDSUFNX0FQUFMiLCJpYXQiOjE3MjQyMjg5OTAsImV4cCI6MTcyNDIzNjE5MCwiY2lkIjoiMG9hZnRjdnh6ZWVDbTByazExZDciLCJzY3AiOlsiU0dFd2F5UGFydG5lcnNfSVIiXSwic3ViIjoiMG9hZnRjdnh6ZWVDbTByazExZDcifQ.P7M2hiOZO280i3I_xNgE5XX9_u2Q0c9IjzRLaEJ2ushcUn2nFMAGNwFgVQ-stSKVaqQrnGQ5EHOTRI-oF7JpqdUsrMlzM-KonTtCR2F9_wNGOf3nTn-vn8XJvH-2TK1zYk5bL8sulKU5K3kvNJxHC-u93b6TtA2rkBQaX6cbZao_rIkHRmiFbZmND9la1LgZyuWisJVJ9zVhd0YO4zJ7SQVzHs7jN8R1PcXlM4GdKSNsIcBNDJ8iN7t_fC06W6RH6Cudy77f4JjsT4kZDzfKuLJ0j65jJ_gu15Msdh2job742O4QHP8jwKJaPn0x2tZ6-wtoD_ZO76nEg9RFwHF1iw"
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
            window.alert("Successfully!");
            responsePayment=data

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



