<?php
// Include the settings file to access global variables
include_once '../../../app/function/settings.php'; // Update with the correct path to settings.php
?>
<script>
let responsePayment = null;
let quotationData = null;
let selectProduct = null;
let selectPlanPremium=null;
let selectCoverPremium=null;
let calllistDetail = null;
let campaignDetailsFromAPI=null;

var token = null;


async function fetchPremium(requestBody) {
  document.body.classList.add('loading');
  const apiUrl = '<?php echo $GLOBALS["aig_api_premium_url"]; ?>';

  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    const data = await response.json();
    console.log("responseData", data);

    if (
      data &&
      data.Policy &&
      data.Policy.insuredList &&
      data.Policy.insuredList[0]
    ) {
      await populatePlanAutoPremium(data.Policy.insuredList[0].planList);
    } else {
      window.alert(`Error statusCode: ${data?.Policy?.statusCode}\nstatusMessage: ${data?.Policy?.statusMessage}`);
      console.error("Invalid API response:", data);
    }
  } catch (error) {
    console.error("Error fetching plan data:", error);
  } finally {
    // Remove 'loading' class from body after fetch is complete
    document.body.classList.remove('loading');
  }
}

async function fetchQuotation(requestBody) {
  document.body.classList.add('loading');
  console.log("Fetching Quotation data...");
  const apiUrl = '<?php echo $GLOBALS["aig_api_create_quote_url"]; ?>';

  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    const data = await response.json();
    console.log("data", data);

    let currentUrl = window.location.href;
    const url = new URL(currentUrl);

    if (url.searchParams.has('is_firsttime')) {
      url.searchParams.set('is_firsttime', '1');
    } else {
      url.searchParams.append('is_firsttime', '1');
    }

    requestBody = handleForm();

    // Insert Quotation Data regardless of statusCode
    if (id != null && id !== "") {
      await jQuery.agent.updateQuoteData(requestBody, data, id);
    } else {
      const responseId = await jQuery.agent.insertQuotationData(requestBody, data, campaignDetails);
      if (url.searchParams.has('id')) {
        url.searchParams.set('id', responseId);
      } else {
        url.searchParams.append('id', responseId);
      }
    }

    // Handle different status codes
    if (data?.statusCode === "S03") {
      window.alert(data?.statusMessage || "Successfully!");
      window.location.href = url.toString();
    } else {
      window.alert(`Error statusCode: ${data?.statusCode||data?.Policy?.statusCode}\nstatusMessage: ${data?.statusMessage||data?.Policy?.statusMessage}`);
      window.location.href = url.toString();
    }

    return data; // Return data for further processing

  } catch (error) {
    console.error("Error fetching quotation data:", error);
    window.alert("Failed to fetch quotation data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  } finally {
    document.body.classList.remove('loading');
  }
}

async function fetchPolicy(requestBody) {
  console.log("Fetching Policy data...");
  document.body.classList.add('loading');
  const apiUrl = '<?php echo $GLOBALS["aig_api_create_policy_url"]; ?>';

  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    const data = await response.json();
    console.log("data", data);

    // Update policyNo if present, regardless of statusCode


    // Check for specific statusCode N02 and alert accordingly
    if (data?.statusCode === "N02" || data?.statusCode === "P00") {
      if (data?.statusCode === "P00") {
        window.alert(`Policy ${data?.statusMessage} issued successfully`);
      } else {
        window.alert(data?.statusMessage || "Successfully!");
      }
      if (data?.policyNo) {
      await jQuery.agent.updatePolicyNo(policyid, data?.policyNo,requestBody,data);
    }
      window.location.reload();
    } else {
      window.alert(`Error statusCode: ${data?.statusCode||data?.Policy?.statusCode}\nstatusMessage: ${data?.statusMessage||data?.Policy?.statusMessage}`);
    }

    return data;
  } catch (error) {
    console.error("Error fetching quotation data:", error);
    window.alert("Failed to fetch quotation data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  } finally {
    document.body.classList.remove('loading');
  }
}


async function fetchRetrieveQuote(requestBody) {
  console.log("Fetching Policy data...");
  document.body.classList.add('loading');
  const apiUrl = '<?php echo $GLOBALS["aig_api_retrieve_quote_url"]; ?>';
  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });


    const data = await response.json();
    console.log("data", data);
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
async function fetchRecalculateQuote(requestBody) {
  console.log("Fetching Recalculate data...");
  document.body.classList.add('loading');
  const apiUrl = '<?php echo $GLOBALS["aig_api_recalculate_quote_url"]; ?>';

  try {
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    const data = await response.json();
    console.log("data", data);

    // Check for specific statusCode N02 and alert accordingly
    if (data?.statusCode === "S03") {
      await jQuery.agent.updateRecalQuoteData(requestBody, data, id);
      window.alert(data?.statusMessage || "Successfully!");
      window.location.reload();
    } else {
      await jQuery.agent.updateRecalQuoteDataFailed(requestBody, data, id);
      window.alert(`Error statusCode: ${data?.statusCode||data?.Policy?.statusCode}\nstatusMessage: ${data?.statusMessage||data?.Policy?.statusMessage}`);
      window.location.reload();
    }

    return data;
  } catch (error) {
    console.error("Error fetching quotation data:", error);
    window.alert("Failed to fetch quotation data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  } finally {
    document.body.classList.remove('loading');
  }
}

const handlePremiumRequestBody = () => {
  const formData = new FormData(document.getElementById("application"));
  let producerCode = "";

if (productDetail && productDetail?.udf_field_producer_code &&calllistDetail) {
    const code = productDetail.udf_field_producer_code;
    producerCode = calllistDetail[code] || "";
}

// Example usage
if (!producerCode) {
    window.location.reload(); // Reload if producerCode is empty
}

  const requestBodyHome = {
    propDate: new Date(),
    productId: formData.get("select-product"),
    distributionChannel: 10,
    // producerCode:productDetail ? calllistDetail[productDetail?.udf_field_producer_code]:"",
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
    producerCode: producerCode,
    campaignCode: "",
  };
 


  switch (selectedType) {
    case "home":
      return requestBodyHome;
    case "auto":
      return requestBodyAuto;

    default:
      console.error("Unknown selected type:", selectedType);
      return null;
  }
};
const handleRequiredField = () => {
  const requiredFieldsTypeHome = [
    "select-product",
    "insured_home_ownerOccupiedType",
  ];
  const requiredFieldsTypeAuto = [
    "select-product",
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
    "select-product",
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
  const apiBody = handlePremiumRequestBody();
  if (apiBody) {
    fetchPremium(apiBody);
  }
}

async function fetchPayment(requestBody) {
  console.log("Fetching payment data...");
  document.body.classList.add('loading');
  const host = "ap-gateway.mastercard.com";
  const merchantId = "TEST97498471";
  const orderId = quotationData?.quoteNo;
  const apiUrl = `https://${host}/api/rest/version/llaatteesstt/merchant/${merchantId}/order/${orderId}/transaction/1`;

  // Basic Auth credentials
  const username = 'merchant.' + merchantId;  // Replace with your actual username
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



    const data = await response.json();
    const formData = new FormData(document.getElementById("application"));
    const objectPayment = {
      paymentMode: Number(formData.get('Payment_Mode')),
      paymentFrequency: Number(formData.get('Payment_Frequency')),
      cardType: formData.get('Payment_CardType'),
    }
    await jQuery.agent.insertPaymentLog(requestBody, data, policyid || null, objectPayment);
    if (data?.result === "SUCCESS") {
      window.alert(data?.result);
      window.location.reload();

    } else if (data?.result === "ERROR" && data?.error) {
      const { cause, explanation, field, validationType } = data.error;
      window.alert(`Error: ${cause}\nExplanation: ${explanation}`);
    }
    else {
      window.alert("Something Went Wrong!");
    }

    return data; // Return data for further processing
  } catch (error) {

    console.error("Error fetching payment data:", error);
    window.alert("Failed to fetch payment data. Please try again.");
    throw error; // Re-throw the error to be caught by the caller
  } finally {
    document.body.classList.remove('loading');
  }
}

async function getProductDetail(productId) {
  console.log("productId:", productId);
  if (!productId) return;

  const url = `../scripts/get_product.php?product_id=${productId}&campaign_id=${campaignDetails?.campaign_id}`;
  document.body.classList.add('loading');

  try {
    const response = await fetch(url);
    const data = await response.json();

    if (data.length > 0) {
      productDetail = data[0];
      handleAddChildButtonVisibility(data[0]); // Process product details
      return data[0];
    } else {
      console.warn("No product data found");
      return null; // Ensure a return value is provided even when no data is found
    }
  } catch (error) {
    console.error('Error fetching product details:', error);
    return null; // Return null in case of error
  } finally {
    document.body.classList.remove('loading');
  }
}
document.addEventListener("DOMContentLoaded", function () {
  token = localStorage.getItem('accessToken')
  console.log("token:", token)
})
</script>