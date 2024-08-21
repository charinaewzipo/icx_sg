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

  // If 'policyid' exists
  if (policyid) {
    const addCoverButton = document.querySelector(".add-cover");
    const seePlanButton = document.querySelector(".seePlan");

    // Show the payment container
    paymentContainer.removeAttribute("hidden");

    // Hide the 'add cover' button if it exists
    if (addCoverButton) {
      addCoverButton.setAttribute("hidden", "true");
    }
    
    // Hide the 'see plan' button if it exists
    if (seePlanButton) {
      seePlanButton.setAttribute("hidden", "true");
    }

    // Disable all input and select elements outside the payment container
    const formElements = document.querySelectorAll(
      "input:not(#payment-container input), select:not(#payment-container select)"
    );
    formElements.forEach((element) => {
      if (element.tagName.toLowerCase() === "input") {
        element.readOnly = true;
        element.style.backgroundColor = "#e9ecef";
        element.style.border = "1px solid rgb(118, 118, 118)";
      } else if (element.tagName.toLowerCase() === "select") {
        // Disable select elements visually (workaround for readonly)
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
          quotationData = response?.data;
          // Set default values in the form based on the quotation data
          setDefaultValueForm(response?.data);
        }
      })
      .catch((error) => {
        console.error("Error occurred:", error);
      });
  }
});
