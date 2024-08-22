let policyid = null;

document.addEventListener("DOMContentLoaded", function() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const paymentContainer = document.getElementById("payment-container");
  
  // Retrieve 'policyid' from the URL parameters
  policyid = urlParams.get("policyid");
  console.log("policyid:", policyid);

  // If 'policyid' is not found, remove 'required' attribute from inputs and selects in the payment container
  if (!policyid) {
    paymentContainer.querySelectorAll("input, select").forEach((field) => {
      field.removeAttribute("required");
    });
  }
  if (policyid) {
    const addCoverButton = document.querySelector(".add-cover");
    const seePlanButton = document.querySelector(".seePlan");
    paymentContainer.removeAttribute("hidden");

    if (addCoverButton) {
      addCoverButton.setAttribute("hidden", "true");
    }
    
    if (seePlanButton) {
      seePlanButton.setAttribute("hidden", "true");
    }
    const formElements = document.querySelectorAll(
      "input:not(#payment-container input), select:not(#payment-container select)"
    );
    formElements.forEach((element) => {
      if (element.tagName.toLowerCase() === "input") {
        if (element.type === "radio") {
          // Style and disable radio buttons
          element.style.pointerEvents = "none";
          element.style.opacity = "0.5"; // Visual indication of being disabled
        } else {
          // Style and disable other input types
          element.readOnly = true;
          element.style.backgroundColor = "#e9ecef";
          element.style.border = "1px solid rgb(118, 118, 118)";
        }
      } else if (element.tagName.toLowerCase() === "select") {
        // Style and disable select elements
        element.style.pointerEvents = "none";
        element.style.backgroundColor = "#e9ecef";
        element.style.color = "#6c757d";
      }
    });
    $("#datepicker, #datepicker2, #datepicker3, #datepicker4, #datepicker5, #datepicker6").each(function() {
      $(this).attr("readonly", true).on('focus', function(event) {
        event.preventDefault(); // Prevent datepicker from opening
      });
    });
  
  
    // Fetch the quotation data with the policy ID
    jQuery.agent
      .getQuotationWithId(policyid)
      .then((response) => {
        if (response?.result == "success") {
          console.log("Response:", response);
          setDefaultValueForm(response?.data);
          const extractData= extractQuotationData(response?.data);
          quotationData = extractData;
          console.log("quotationData",quotationData)
        }
      })
      .catch((error) => {
        console.error("Error occurred:", error);
      });
  }

});
function extractQuotationData(data) {
  try {
    // Parse JSON strings if they are strings
    if (data.ncdInfo && typeof data.ncdInfo === 'string') {
      try {
        data.ncdInfo = JSON.parse(data.ncdInfo);
      } catch (e) {
        console.error("Error parsing ncdInfo:", e);
        data.ncdInfo = {}; // Default to an empty object if parsing fails
      }
    }
    
    if (data.policyHolderInfo && typeof data.policyHolderInfo === 'string') {
      try {
        data.policyHolderInfo = JSON.parse(data.policyHolderInfo);
      } catch (e) {
        console.error("Error parsing policyHolderInfo:", e);
        data.policyHolderInfo = {}; // Default to an empty object if parsing fails
      }
    }
    
    if (data.insuredList && typeof data.insuredList === 'string') {
      try {
        data.insuredList = JSON.parse(data.insuredList);
      } catch (e) {
        console.error("Error parsing insuredList:", e);
        data.insuredList = []; // Default to an empty array if parsing fails
      }
    }

    return data;
  } catch (error) {
    console.error("Error extracting quotation data:", error);
    return null;
  }
}